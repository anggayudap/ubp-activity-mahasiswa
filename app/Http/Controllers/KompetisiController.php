<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\Prodi;
use App\Models\Skema;
use App\Models\Kompetisi;
use Illuminate\Http\Request;
use App\Models\KompetisiSkema;
use App\Http\Controllers\Controller;
use App\Models\KompetisiParticipant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use RealRashid\SweetAlert\Facades\Alert;

class KompetisiController extends Controller
{
    public function index(Request $request)
    {
        return redirect()->route('dashboard');
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {
            $data = Kompetisi::with(['participant'])->select(['id', 'nama_kompetisi', 'list_prodi', 'tanggal_mulai_pendaftaran', 'tanggal_akhir_pendaftaran', 'aktif']);

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('tanggal_pendaftaran', function ($row) {
                    return get_indo_date($row->tanggal_mulai_pendaftaran) . ' s/d ' . get_indo_date($row->tanggal_akhir_pendaftaran);
                })
                ->addColumn('jumlah_pendaftar', function ($row) {
                    return $row->participant->count();
                })
                ->addColumn('action', function ($row) {
                    $current_date = strtotime(date('Y-m-d'));
                    $end_date = strtotime($row->tanggal_akhir_pendaftaran);

                    $btn =
                        '<div class="dropdown">
                        <a class="btn btn-sm btn-icon px-0" data-toggle="dropdown" aria-expanded="false"><i data-feather="menu"></i></a>
                        <div class="dropdown-menu dropdown-menu-right" style="">
                        <a href="' .
                        route('kompetisi.tracking', $row->id) .
                        '" class="dropdown-item"><i data-feather="search"></i> Detail & Tracking</a>';
                    if ($current_date <= $end_date) {
                        $btn .=
                            '<a href="' .
                            route('kompetisi.edit', Crypt::encrypt($row->id)) .
                            '" class="dropdown-item"><i data-feather="edit"></i> Edit</a>
                            <form action="' .
                            route('kompetisi.destroy', [$row->id]) .
                            '" method="POST" id="form-delete-' .
                            $row->id .
                            '" style="display: inline">
                            ' .
                            csrf_field() .
                            '
                            ' .
                            method_field('DELETE') .
                            '
                            <a href="#" onclick="submit_delete(' .
                            $row->id .
                            ')" class="dropdown-item"><i data-feather="trash-2"></i> Delete</a>
                            </form>';
                    }

                    $btn .= '</div>
                        </div>';

                    return $btn;
                })
                ->editColumn('list_prodi', function (Kompetisi $data) {
                    $id_prodis = json_decode($data->list_prodi, true);
                    $data_prodi = Prodi::select('nama_prodi')
                        ->whereIn('id', $id_prodis)
                        ->get();
                    $list_prodi = '';

                    foreach ($data_prodi as $prodi) {
                        $list_prodi .= '<li>' . $prodi->nama_prodi . '</li>';
                    }

                    return '<ul>' . $list_prodi . '</ul>';
                })
                ->editColumn('aktif', function (Kompetisi $data) {
                    return trans('serba.status_' . $data->aktif);
                })
                ->rawColumns(['list_prodi', 'action', 'aktif'])
                ->removeColumn('id')
                ->make(true);
        }

        $data['heading'] = 'List Kompetisi';
        $data['datasource'] = 'kompetisi.list';

        return view('kompetisi.index', compact('data'));
    }

    public function create()
    {
        $data['prodi'] = Prodi::select('id', 'nama_prodi', 'kode_prodi')->get();
        $data['skema'] = Skema::select('id', 'nama_skema', 'deskripsi_skema')
            ->where('aktif', '1')
            ->get();

        return view('kompetisi.form', compact('data'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kompetisi' => 'required',
            'deskripsi_kompetisi' => 'nullable',
            'list_prodi' => 'array|required',
            'skema' => 'array|required',
            'tanggal_mulai_pendaftaran' => 'required|date',
            'tanggal_akhir_pendaftaran' => 'required|date',
            'aktif' => 'required|in:1,0',
        ]);

        $list_penilaian = [
            'start' => 0,
            'end' => 100,
        ];

        $post = Kompetisi::create([
            'nama_kompetisi' => $request->nama_kompetisi,
            'deskripsi_kompetisi' => $request->deskripsi_kompetisi,
            'list_prodi' => json_encode($request->list_prodi),
            'tanggal_mulai_pendaftaran' => $request->tanggal_mulai_pendaftaran,
            'tanggal_akhir_pendaftaran' => $request->tanggal_akhir_pendaftaran,
            'list_penilaian' => json_encode($list_penilaian),
            'aktif' => $request->aktif,
            'user_id_created' => session('user.user_id'),
            'user_name_created' => session('user.nama'),
        ]);

        foreach ($request->skema as $id_skema) {
            $data_skema = Skema::select('nama_skema')
                ->where('id', $id_skema)
                ->first();
            KompetisiSkema::create([
                'kompetisi_id' => $post->id,
                'skema_id' => $id_skema,
                'nama_skema' => $data_skema->nama_skema,
            ]);
        }

        if ($post) {
            Alert::success('Berhasil!', 'Data kompetisi berhasil dibuat!');
            return redirect(route('kompetisi.list'));
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    'error' => 'Some problem occurred, please try again',
                ]);
        }
    }

    public function tracking(Request $request, $id)
    {
        if ($request->ajax()) {
            $data = KompetisiParticipant::select(['id', 'kompetisi_id', 'created_at', 'nama_skema', 'nama_dosen_pembimbing', 'status', 'is_editable'])
                ->with(['kompetisi', 'member'])
                ->where('kompetisi_id', $id);

            return Datatables::of($data)
                ->addColumn('action', function ($row) {
                    $btn =
                        '<div class="dropdown">
                    <a class="btn btn-sm btn-icon px-0" data-toggle="dropdown" aria-expanded="false"><i data-feather="menu"></i></a>
                    <div class="dropdown-menu dropdown-menu-right" style="">
                    <a href="#" data-toggle="modal" data-target="#xlarge" onclick="javascript:detail(' .
                        $row->id .
                        ');" class="dropdown-item"><i data-feather="file-text"></i> Detail</a>';
                        
                    if (in_array($row->status, ['pending', 'in_review', 'reviewed'])) {
                        $btn .= '<a href="' . route('kompetisi.approval', $row->id) . '" class="dropdown-item"><i data-feather="corner-up-left"></i> Plotting Ulang</a>';
                    }

                    $btn .= '</div>
                    </div>';

                    return $btn;
                })
                ->addColumn('nama_ketua', function ($row) {
                    foreach ($row->member as $member) {
                        if ($member->status_keanggotaan == 'ketua') {
                            return $member->nama_mahasiswa;
                        }
                    }
                    return 'ketua tidak ditemukan';
                })
                ->addColumn('jumlah_anggota', function ($row) {
                    $count = 0;
                    foreach ($row->member as $member) {
                        if ($member->status_keanggotaan == 'anggota') {
                            $count++;
                        }
                    }
                    return $count;
                })
                ->addColumn('prodi_ketua', function ($row) {
                    foreach ($row->member as $member) {
                        if ($member->status_keanggotaan == 'ketua') {
                            $data_prodi = Prodi::select('id', 'nama_prodi')
                                ->where('kode_prodi', $member->prodi)
                                ->first();

                            return $data_prodi ? $data_prodi->nama_prodi : '-';
                        }
                    }
                    return 'prodi ketua tidak ditemukan';
                })
                ->editColumn('created_at', function (KompetisiParticipant $data) {
                    return get_indo_date($data->created_at);
                })
                ->editColumn('status', function (KompetisiParticipant $data) {
                    return trans('serba.' . $data->status);
                })
                ->rawColumns(['action', 'status'])
                ->removeColumn('id')
                ->make(true);
        } else {
            $data_master = Kompetisi::with(['skema'])->where('id', $id);
            $data['kompetisi'] = $data_master->first();
            $selected_prodi = json_decode($data['kompetisi']->list_prodi, true);

            $data['prodi'] = Prodi::select('id', 'nama_prodi', 'kode_prodi')
                ->whereIn('id', $selected_prodi)
                ->get();
        }

        return view('kompetisi.detail', compact('data'));
    }

    public function edit($id)
    {
        $data['kompetisi'] = Kompetisi::with(['skema'])->findOrFail(Crypt::decrypt($id));
        $data['prodi'] = Prodi::select('id', 'nama_prodi', 'kode_prodi')->get();
        $data['skema'] = Skema::select('id', 'nama_skema', 'deskripsi_skema')
            ->where('aktif', '1')
            ->get();

        $data['selected_skema'] = [];
        $data['selected_prodi'] = json_decode($data['kompetisi']->list_prodi, true);
        $data['list_penilaian'] = json_decode($data['kompetisi']->list_penilaian, true);

        foreach ($data['kompetisi']->skema as $kompetisi_skema) {
            $data['selected_skema'][] = $kompetisi_skema->skema_id;
        }

        return view('kompetisi.form', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_kompetisi' => 'required',
            'deskripsi_kompetisi' => 'nullable',
            'list_prodi' => 'array|required',
            'skema' => 'array|required',
            'tanggal_mulai_pendaftaran' => 'required|date',
            'tanggal_akhir_pendaftaran' => 'required|date',
            'aktif' => 'required|in:1,0',
        ]);

        $list_penilaian = [
            'start' => $request->nilai_awal,
            'end' => $request->nilai_akhir,
        ];

        $update_params = [
            'nama_kompetisi' => $request->nama_kompetisi,
            'deskripsi_kompetisi' => $request->deskripsi_kompetisi,
            'list_prodi' => json_encode($request->list_prodi),
            'tanggal_mulai_pendaftaran' => $request->tanggal_mulai_pendaftaran,
            'tanggal_akhir_pendaftaran' => $request->tanggal_akhir_pendaftaran,
            'aktif' => $request->aktif,
            'user_id_created' => session('user.user_id'),
            'user_name_created' => session('user.nama'),
        ];

        $kompetisi = Kompetisi::findOrFail($id);
        $kompetisi->update($update_params);

        // first delete
        KompetisiSkema::where('kompetisi_id', $kompetisi->id)->delete();
        // then input new
        foreach ($request->skema as $id_skema) {
            $data_skema = Skema::select('nama_skema')
                ->where('id', $id_skema)
                ->first();
            KompetisiSkema::create([
                'kompetisi_id' => $kompetisi->id,
                'skema_id' => $id_skema,
                'nama_skema' => $data_skema->nama_skema,
            ]);
        }

        if ($kompetisi) {
            Alert::success('Berhasil!', 'Data kompetisi berhasil diupdate!');
            return redirect(route('kompetisi.list'));
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    'error' => 'Some problem occurred, please try again',
                ]);
        }
    }

    public function destroy($id)
    {
        $model = Kompetisi::findOrFail($id);
        $model->delete();

        if ($model) {
            Alert::success('Berhasil!', 'Data kompetisi berhasil dihapus!');
            return redirect(route('kompetisi.list'));
        } else {
            Alert::error('Gagal!', 'Data kompetisi tidak dapat dihapus!');
            return redirect(route('kompetisi.list'));
        }
    }
}
