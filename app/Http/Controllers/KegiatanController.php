<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use App\Models\KlasifikasiKegiatan;
use App\Models\Periode;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class KegiatanController extends Controller
{
    public function list(Request $request)
    {
        if ($request->ajax()) {
            $data = Kegiatan::select(['id', 'nama_kegiatan', 'nama_mahasiswa', 'klasifikasi_id', 'status', 'approval']);

            $user = Auth::user();
            if (!$user->hasRole('kemahasiswaan')) {
                // if role == dosen only
                $data->where('prodi', session('user.prodi'));
            }

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    // dd($row);
                    $btn =
                        '<div class="dropdown">
                        <a class="btn btn-sm btn-icon px-0" data-toggle="dropdown" aria-expanded="false"><i data-feather="more-vertical"></i></a>
                        <div class="dropdown-menu dropdown-menu-right" style="">
                        <a href="#" data-toggle="modal" data-target="#xlarge" onclick="javascript:detail(' .
                        $row->id .
                        ');" class="dropdown-item"><i data-feather="file-text"></i> Detail</a>';
                    if ($row->status == 'review') {
                        $btn .= '<form action="' . route('kegiatan.destroy', [$row->id]) . '" method="POST" id="form-delete-' . $row->id . '" style="display: inline">' . csrf_field() . method_field('DELETE') . ' <a href="#" onclick="submit_delete(' . $row->id . ')" class="dropdown-item"><i data-feather="trash-2"></i> Delete</a> </form>';
                    }
                    $btn .= '</div>
                        </div>';
                    return $btn;
                })
                ->editColumn('klasifikasi_id', function (Kegiatan $kegiatan) {
                    return $kegiatan->klasifikasi->name_kegiatan;
                })
                ->editColumn('status', function (Kegiatan $kegiatan) {
                    return trans('serba.' . $kegiatan->status);
                })
                ->editColumn('approval', function (Kegiatan $kegiatan) {
                    if ($kegiatan->approval) {
                        return trans('serba.' . $kegiatan->approval);
                    }

                    return 'Belum Dinilai';
                })
                ->rawColumns(['status', 'approval', 'action'])
                ->removeColumn('id')
                ->make(true);
        }

        $data['heading'] = 'List Kegiatan Mahasiswa';
        $data['datasource'] = 'kegiatan.list';

        return view('kegiatan.index', compact('data'));
    }

    public function history(Request $request)
    {
        if ($request->ajax()) {
            $data = Kegiatan::select(['id', 'nama_kegiatan', 'nama_mahasiswa', 'klasifikasi_id', 'status', 'approval']);

            // if role == mahasiswa
            $data->where('nim', session('user.id'));

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    // dd($row);
                    $btn =
                        '<div class="dropdown">
                        <a class="btn btn-sm btn-icon px-0" data-toggle="dropdown" aria-expanded="false"><i data-feather="more-vertical"></i></a>
                        <div class="dropdown-menu dropdown-menu-right" style="">
                        <a href="#" data-toggle="modal" data-target="#xlarge" onclick="javascript:detail(' .
                        $row->id .
                        ');" class="dropdown-item"><i data-feather="file-text"></i> Detail</a>';
                    if ($row->status == 'review') {
                        $btn .=
                            '<a href="' .
                            route('kegiatan.edit', Crypt::encrypt($row->id)) .
                            '" class="dropdown-item"><i data-feather="edit"></i> Edit</a>
                                <form action="' .
                            route('kegiatan.destroy', [$row->id]) .
                            '" method="POST" id="form-delete-' .
                            $row->id .
                            '" style="display: inline"> ' .
                            csrf_field() .
                            method_field('DELETE') .
                            '<a href="#" onclick="submit_delete(' .
                            $row->id .
                            ')" class="dropdown-item"><i data-feather="trash-2"></i> Delete</a> </form>';
                    }
                    $btn .= '</div>
                        </div>';
                    return $btn;
                })
                ->editColumn('klasifikasi_id', function (Kegiatan $kegiatan) {
                    return $kegiatan->klasifikasi->name_kegiatan;
                })
                ->editColumn('status', function (Kegiatan $kegiatan) {
                    return trans('serba.' . $kegiatan->status);
                })
                ->editColumn('approval', function (Kegiatan $kegiatan) {
                    if ($kegiatan->approval) {
                        return trans('serba.' . $kegiatan->approval);
                    }

                    return 'Belum Dinilai';
                })
                ->rawColumns(['status', 'approval', 'action'])
                ->removeColumn('id')
                ->make(true);
        }

        $data['heading'] = 'History Kegiatan Mahasiswa';
        $data['datasource'] = 'kegiatan.history';

        return view('kegiatan.index', compact('data'));
    }

    public function create()
    {
        $klasifikasi = KlasifikasiKegiatan::all();
        $data['klasifikasi'] = $klasifikasi->groupBy('group_kegiatan');
        $data['periode'] = Periode::all();

        return view('kegiatan.form', compact('data'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kegiatan' => 'required',
            'tanggal_mulai' => 'required',
            'tanggal_akhir' => 'required',
            'klasifikasi_id' => 'required',
            'cakupan' => 'required',
            'prestasi' => 'nullable',
            'keterangan' => 'required',
            'url_event' => 'required|url',
            'surat_tugas' => 'required|mimes:pdf,png,jpg,jpeg|max:5120',
            'foto_kegiatan' => 'required|mimes:pdf,png,jpg,jpeg|max:5120',
            'bukti_kegiatan' => 'required|mimes:pdf,png,jpg,jpeg|max:5120',
        ]);

        // dd($request);
        $surat_tugas_path = null;
        $foto_kegiatan_path = null;
        $bukti_kegiatan_path = null;

        if ($request->file('surat_tugas')) {
            $surat_tugas_path = $this->upload_file($request->file('surat_tugas'), 'surat_tugas');
        }

        if ($request->file('foto_kegiatan')) {
            $foto_kegiatan_path = $this->upload_file($request->file('foto_kegiatan'), 'foto_kegiatan');
        }

        if ($request->file('bukti_kegiatan')) {
            $bukti_kegiatan_path = $this->upload_file($request->file('bukti_kegiatan'), 'bukti_kegiatan');
        }

        $post = Kegiatan::create([
            'nim' => session('user.id'),
            'nama_mahasiswa' => session('user.nama'),
            'prodi' => session('user.prodi'),
            'tahun_periode' => date('Y'),
            'nama_kegiatan' => $request->nama_kegiatan,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_akhir' => $request->tanggal_akhir,
            'klasifikasi_id' => $request->klasifikasi_id,
            'cakupan' => $request->cakupan,
            'prestasi' => $request->prestasi,
            'url_event' => $request->url_event,
            'surat_tugas' => $surat_tugas_path,
            'foto_kegiatan' => $foto_kegiatan_path,
            'bukti_kegiatan' => $bukti_kegiatan_path,
            'keterangan' => $request->keterangan,
            'status' => 'review',
            'approval' => null,
        ]);

        if ($post) {
            Alert::success('Berhasil!', 'Data kegiatan mahasiswa berhasil dibuat!');
            return redirect(route('kegiatan.history'));
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    'error' => 'Some problem occurred, please try again',
                ]);
        }
    }

    public function detail($id)
    {
        $output['kegiatan'] = Kegiatan::where('id', $id)
            ->with(['klasifikasi', 'periode', 'prodi_mahasiswa'])
            ->first();

        // update status if role dosen or kemahasiswaan
        $user = Auth::user();
        if ($user->hasAnyRole(['kemahasiswaan', 'dosen']) && $output['kegiatan']->status != 'completed') {
            $param = false;
            if ($user->hasRole('kemahasiswaan')) {
                $param = ['status' => 'checked_kemahasiswaan'];
            } elseif ($user->hasRole('dosen')) {
                if ($output['kegiatan']->status == 'review') {
                    $param = ['status' => 'checked_dosen'];
                }
            }

            if ($param) {
                $output['kegiatan']->update($param);
            }
        }

        $checking_files = ['surat_tugas', 'bukti_kegiatan', 'foto_kegiatan'];
        foreach ($checking_files as $document) {
            $output['is_pdf'][$document] = false;

            $file_name = $output['kegiatan']->$document;
            $str_pieces = explode('.', $file_name);
            $extensions = end($str_pieces);

            if ($extensions == 'pdf') {
                $output['is_pdf'][$document] = true;
            }
        }

        return view('kegiatan.modal_detail', compact('output'));
    }

    public function edit($id)
    {
        $klasifikasi = KlasifikasiKegiatan::all();

        $data['kegiatan'] = Kegiatan::findOrFail(Crypt::decrypt($id));
        $data['klasifikasi'] = $klasifikasi->groupBy('group_kegiatan');
        $data['periode'] = Periode::all();

        // dd($data);
        return view('kegiatan.form', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nama_kegiatan' => 'required',
            'tanggal_mulai' => 'required',
            'tanggal_akhir' => 'required',
            'klasifikasi_id' => 'required',
            'cakupan' => 'required',
            'prestasi' => 'nullable',
            'keterangan' => 'required',
            'url_event' => 'required|url',
            'surat_tugas' => 'nullable|mimes:pdf,png,jpg,jpeg|max:5120',
            'foto_kegiatan' => 'nullable|mimes:pdf,png,jpg,jpeg|max:5120',
            'bukti_kegiatan' => 'nullable|mimes:pdf,png,jpg,jpeg|max:5120',
        ]);

        $kegiatan = Kegiatan::findOrFail($id);
        $surat_tugas_path = null;
        $foto_kegiatan_path = null;
        $bukti_kegiatan_path = null;

        if ($request->file('surat_tugas')) {
            $surat_tugas_path = $this->upload_file($request->file('surat_tugas'), 'surat_tugas');

            // delete previous file
            $prev_file = public_path($kegiatan->surat_tugas);
            if (file_exists($prev_file)) {
                unlink($prev_file);
            }
        }

        if ($request->file('foto_kegiatan')) {
            $foto_kegiatan_path = $this->upload_file($request->file('foto_kegiatan'), 'foto_kegiatan');

            // delete previous file
            $prev_file = public_path($kegiatan->foto_kegiatan);
            if (file_exists($prev_file)) {
                unlink($prev_file);
            }
        }

        if ($request->file('bukti_kegiatan')) {
            $bukti_kegiatan_path = $this->upload_file($request->file('bukti_kegiatan'), 'bukti_kegiatan');

            // delete previous file
            $prev_file = public_path($kegiatan->bukti_kegiatan);
            if (file_exists($prev_file)) {
                unlink($prev_file);
            }
        }

        $update_params = [
            'tahun_periode' => date('Y'),
            'nama_kegiatan' => $request->nama_kegiatan,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_akhir' => $request->tanggal_akhir,
            'klasifikasi_id' => $request->klasifikasi_id,
            'cakupan' => $request->cakupan,
            'url_event' => $request->url_event,
            'keterangan' => $request->keterangan,
        ];

        if ($surat_tugas_path) {
            $update_params['surat_tugas'] = $surat_tugas_path;
        }

        if ($foto_kegiatan_path) {
            $update_params['foto_kegiatan'] = $foto_kegiatan_path;
        }

        if ($bukti_kegiatan_path) {
            $update_params['bukti_kegiatan'] = $bukti_kegiatan_path;
        }

        $kegiatan->update($update_params);

        if ($kegiatan) {
            Alert::success('Berhasil!', 'Data kegiatan mahasiswa berhasil diupdate!');
            return redirect(route('kegiatan.history'));
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
        $klasifikasi = Kegiatan::findOrFail($id);
        $klasifikasi->delete();

        $surat_tugas = public_path($klasifikasi->surat_tugas);
        if (file_exists($surat_tugas)) {
            unlink($surat_tugas);
        }

        $foto_kegiatan = public_path($klasifikasi->foto_kegiatan);
        if (file_exists($foto_kegiatan)) {
            unlink($foto_kegiatan);
        }

        $bukti_kegiatan = public_path($klasifikasi->bukti_kegiatan);
        if (file_exists($bukti_kegiatan)) {
            unlink($bukti_kegiatan);
        }

        if ($klasifikasi) {
            Alert::success('Berhasil!', 'Data kegiatan mahasiswa berhasil dihapus!');
            return redirect(route('kegiatan.history'));
        } else {
            Alert::error('Gagal!', 'Data kegiatan mahasiswa tidak dapat dihapus!');
            return redirect(route('kegiatan.history'));
        }
    }

    public function decision(Request $request)
    {
        if ($request->ajax()) {
            $kegiatan = Kegiatan::findOrFail($request->id);

            $timestamp_tanggal_akhir = strtotime($kegiatan->tanggal_akhir);
            $month = date('n', $timestamp_tanggal_akhir);

            $periodes = Periode::all();
            $periode_id = null;
            foreach ($periodes as $periode) {
                foreach (json_decode($periode->range_bulan) as $month_number) {
                    if ($month == $month_number) {
                        $periode_id = $periode->id;
                        break;
                    }
                }
            }

            $kegiatan->update([
                'periode_id' => $periode_id,
                'status' => 'completed',
                'approval' => $request->decision,
                'kemahasiswaan_user_id' => session('user.user_id'),
                'kemahasiswaan_user_name' => session('user.nama'),
            ]);

            if ($kegiatan) {
                return response()->json(['success' => true, 'message' => 'Approval berhasil disimpan', 'redirect' => route('kegiatan.list')]);
            } else {
                return response()->json(['success' => true, 'message' => 'Terjadi error. Harap hub. administrator anda.']);
            }
        }
    }

    private function upload_file($request_file, $prefix)
    {
        $file = $request_file;

        $random_string = Str::random(7);
        $filename = date('YmdHi') . '-' . $random_string . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('upload/' . $prefix), $filename);
        $file_path = 'upload/' . $prefix . '/' . $filename;

        return $file_path;
    }
}
