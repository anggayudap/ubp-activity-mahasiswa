<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\Dosen;
use App\Models\Prodi;
use App\Models\Skema;
use App\Models\Kompetisi;
use App\Models\Mahasiswa;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\KompetisiSkema;
use App\Http\Controllers\Controller;
use App\Models\KompetisiParticipant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Database\Eloquent\Builder;
use App\Models\KompetisiParticipantMember;

class KompetisiRegisterController extends Controller
{
    public function register(Request $request)
    {
        if ($request->ajax()) {
            $current_date = date('Y-m-d');
            $data = Kompetisi::select(['id', 'nama_kompetisi', 'list_prodi', 'tanggal_mulai_pendaftaran', 'tanggal_akhir_pendaftaran', 'aktif'])
                ->with(['skema'])
                ->where('aktif', '=', '1')
                ->where('tanggal_mulai_pendaftaran', '<=', $current_date)
                ->where('tanggal_akhir_pendaftaran', '>=', $current_date);

            // filtering id prodi for mahasiswa
            $user_session = session('user');
            if ($user_session['role'] == 'mahasiswa') {
                $data_prodi = Prodi::where('kode_prodi', $user_session['prodi'])->first();
                $data->where('list_prodi', 'LIKE', '%"' . $data_prodi->id . '"%');
            }

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('skema', function ($row) {
                    $list_skema = '';
                    if ($row->skema) {
                        foreach ($row->skema as $data_skema) {
                            $list_skema .= '<li>' . $data_skema->nama_skema . '</li>';
                        }
                    }
                    return '<ul>' . $list_skema . '</ul>';
                })
                ->addColumn('action', function ($row) {
                    $btn =
                        '<div class="dropdown">
                        <a class="btn btn-sm btn-icon px-0" data-toggle="dropdown" aria-expanded="false"><i data-feather="more-vertical"></i></a>
                        <div class="dropdown-menu dropdown-menu-right" style="">
                        <a href="' .
                        route('kompetisi.register.preview', Crypt::encrypt($row->id)) .
                        '" class="dropdown-item"><i data-feather="file-text"></i> Detail</a>';
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
                ->editColumn('tanggal_akhir_pendaftaran', function ($row) {
                    return get_indo_date($row->tanggal_akhir_pendaftaran);
                })
                ->rawColumns(['list_prodi', 'skema', 'action'])
                ->removeColumn('id')
                ->make(true);
        }

        $data['heading'] = 'Registrasi Kompetisi';
        $data['datasource'] = 'kompetisi.register';

        return view('kompetisi.register.index', compact('data'));
    }

    public function preview($id)
    {
        $data['kompetisi'] = Kompetisi::with(['skema'])->findOrFail(Crypt::decrypt($id));
        $selected_prodi = json_decode($data['kompetisi']->list_prodi, true);

        $data['prodi'] = Prodi::select('id', 'nama_prodi', 'kode_prodi')
            ->whereIn('id', $selected_prodi)
            ->get();
        $data['list_penilaian'] = json_decode($data['kompetisi']->list_penilaian, true);

        $data['has_registered'] = false;

        // checking history registered for mahasiswa
        $user_session = session('user');
        if ($user_session['role'] == 'mahasiswa') {
            $nim_mahasiswa = $user_session['id'];
            $history = Kompetisi::whereHas('participant.member', function ($query) use ($nim_mahasiswa) {
                $query->where('nim', '=', $nim_mahasiswa);
            })
                ->with(['participant.member'])
                ->where('id', Crypt::decrypt($id));
            if ($history->first()) {
                $data['has_registered'] = true;
            }
        }

        return view('kompetisi.register.detail', compact('data'));
    }

    public function register_form(Request $request, $id)
    {
        $data = Kompetisi::with(['skema'])->findOrFail(Crypt::decrypt($id));
        $mahasiswas = Mahasiswa::select('id', 'nim', 'nama_mahasiswa')->get();
        $dosens = Dosen::select('id', 'nip', 'nama')->get();

        foreach ($mahasiswas as $data_mahasiswa) {
            $additional['mahasiswa'][] = [
                'id' => $data_mahasiswa->nim,
                'text' => '(' . $data_mahasiswa->nim . ') ' . $data_mahasiswa->nama_mahasiswa,
            ];
        }

        foreach ($dosens as $data_dosen) {
            $additional['dosen'][] = [
                'id' => $data_dosen->id,
                'text' => $data_dosen->nama,
            ];
        }

        $additional['is_update'] = false;

        return view('kompetisi.register.form', compact('data','additional'));
    }

    public function edit($id) {
        $data = Kompetisi::with(['skema', 'participant' => function($q) use ($id) {
            $q->where('id', Crypt::decrypt($id))->with(['member']);
        }])
        ->whereHas('participant', function ($query) use ($id){
            return $query->where('id', Crypt::decrypt($id));
        })
        ->first();

        $mahasiswas = Mahasiswa::select('id', 'nim', 'nama_mahasiswa')->get();
        $dosens = Dosen::select('id', 'nip', 'nama')->get();

        foreach ($mahasiswas as $data_mahasiswa) {
            $additional['mahasiswa'][] = [
                'id' => $data_mahasiswa->nim,
                'text' => '(' . $data_mahasiswa->nim . ') ' . $data_mahasiswa->nama_mahasiswa,
            ];
        }

        foreach ($dosens as $data_dosen) {
            $additional['dosen'][] = [
                'id' => $data_dosen->id,
                'text' => $data_dosen->nama,
            ];
        }

        $additional['is_update'] = true;

        return view('kompetisi.register.form', compact('data','additional'));
    }

    public function register_submit(Request $request)
    {
        $validated = $request->validate([
            'kompetisi_id' => 'required',
            'method' => 'required|in:update,create',
            'judul' => 'required',
            'tahun' => 'required|integer|digits:4',
            'skema' => 'required',
            'dosen_pembimbing' => 'required',
            'ketua' => 'required',
            'anggota' => 'required|array',
            'file_kompetisi' => 'required|file|max:5220|mimes:pdf,zip',
        ]);

        $data_skema = Skema::where('nama_skema', $request->skema)->first();

        $file_participant_path = null;

        if ($request->file('file_kompetisi')) {
            $file_participant_path = $this->upload_file($request->file('file_kompetisi'), 'file_kompetisi');
        }

        $data_dosen_pembimbing = Dosen::where('id', $request->dosen_pembimbing)->first();
        
        $param = [
            'kompetisi_id' => $request->kompetisi_id,
            'id_dosen_pembimbing' => $data_dosen_pembimbing->id,
            'nip_dosen_pembimbing' => $data_dosen_pembimbing->nip,
            'nidn_dosen_pembimbing' => $data_dosen_pembimbing->nidn,
            'nama_dosen_pembimbing' => $data_dosen_pembimbing->nama,
            'email_dosen_pembimbing' => $data_dosen_pembimbing->email,
            'prodi_dosen_pembimbing' => $data_dosen_pembimbing->prodi,
            'judul' => $request->judul,
            'tahun' => $request->tahun,
            'nama_skema' => $data_skema->nama_skema,
            'deskripsi_skema' => $data_skema->deskripsi_skema,
            'is_editable' => 1,
        ];

        if($request->method == 'create') {
            $param['file_upload'] = $file_participant_path;
            $param['user_created'] = session('user.user_id');
            $kompetisi_participant = KompetisiParticipant::create($param);
            $kompetisi_participant_id = $kompetisi_participant->id;


        } else if($request->method == 'update') {
            $old_data = KompetisiParticipant::where('id', $request->participant_id);

            if($file_participant_path) {
                // unlink the old file path
                $prev_file = public_path($old_data->first()->file_upload);
                if (file_exists($prev_file)) {
                    unlink($prev_file);
                }
                $param['file_upload'] = $file_participant_path;
            }
            $param['user_updated'] = session('user.user_id');
            $param['status'] = 'pending';
            $old_data->update($param);
            $kompetisi_participant_id = $request->participant_id;
        }


        // index 0 = ketua
        // index 1-2-3-dst = anggota
        $member = $request->anggota;
        array_unshift($member, $request->ketua);

        $data_mahasiswa_member = Mahasiswa::whereIn('nim', $member)->get();

        // clear member data
        KompetisiParticipantMember::where('participant_id', $kompetisi_participant_id)->delete();
        foreach ($data_mahasiswa_member as $data_mahasiswa) {
            $param_member[] = [
                'participant_id' => $kompetisi_participant_id,
                'nim' => $data_mahasiswa->nim,
                'nama_mahasiswa' => $data_mahasiswa->nama_mahasiswa,
                'prodi' => $data_mahasiswa->prodi,
                'status_keanggotaan' => $data_mahasiswa->nim == $request->ketua ? 'ketua' : 'anggota',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
        }

        $post = KompetisiParticipantMember::insert($param_member);

        if ($post) {
            Alert::success('Berhasil!', 'Registrasi Kompetisi berhasil!');
            return redirect(route('kompetisi.history'));
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    'error' => 'Some problem occurred, please try again',
                ]);
        }
    }

    public function history(Request $request)
    {
        if ($request->ajax()) {
            $nim_user = session('user.id');
            $data = KompetisiParticipant::select(['id', 'kompetisi_id', 'created_at', 'nama_skema', 'nama_dosen_pembimbing', 'status', 'is_editable'])
                ->with(['kompetisi', 'member'])
                ->whereHas('member', function (Builder $query) use ($nim_user) {
                    $query->where('nim', $nim_user);
                })
                ->orWhere('user_created', session('user.user_id'));

            return Datatables::of($data)
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
                ->addColumn('action', function ($row) {
                    // handling editbale for ketua
                    foreach ($row->member as $member) {
                        if ($member->status_keanggotaan == 'ketua') {
                            $nim_ketua = $member->nim;
                        }
                    }
                    $nim_user = session('user.id');

                    $btn =
                        '<div class="dropdown">
                        <a class="btn btn-sm btn-icon px-0" data-toggle="dropdown" aria-expanded="false"><i data-feather="more-vertical"></i></a>
                        <div class="dropdown-menu dropdown-menu-right" style="">
                        <a href="#" data-toggle="modal" data-target="#xlarge" onclick="javascript:detail(' .
                        $row->id .
                        ');" class="dropdown-item"><i data-feather="file-text"></i> Detail</a>';
                    if ($row->is_editable && ($nim_ketua == $nim_user)) {
                        $btn .=
                            '<a href="' .
                            route('kompetisi.participant.edit', Crypt::encrypt($row->id)) .
                            '" class="dropdown-item"><i data-feather="edit"></i> Edit</a>
                            <form action="' .
                            route('kompetisi.participant.destroy', [$row->id]) .
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
                ->editColumn('created_at', function (KompetisiParticipant $data) {
                    return get_indo_date($data->created_at);
                })
                ->editColumn('status', function (KompetisiParticipant $data) {
                    return trans('serba.' . $data->status);
                })
                ->rawColumns(['action', 'status'])
                ->removeColumn('id')
                ->make(true);
        }

        $data['heading'] = 'History Registrasi Kompetisi';
        $data['datasource'] = 'kompetisi.history';

        return view('kompetisi.index_participant', compact('data'));
    }

    public function detail($id)
    {
        $output = KompetisiParticipant::with(['kompetisi', 'member'])
            ->where('id', $id)
            ->first();

        $additional['is_pdf'] = false;

        $file_name = $output->file_upload;
        $str_pieces = explode('.', $file_name);
        $extensions = end($str_pieces);

        
        if ($extensions == 'pdf') {
            $additional['is_pdf'] = true;
        }
        
        return view('kompetisi.modal.modal_detail', compact('output', 'additional'));
    }

    public function destroy($id)
    {
        $model = KompetisiParticipant::findOrFail($id);
        $model->delete();

        if ($model) {
            Alert::success('Berhasil!', 'Data registrasi kompetisi berhasil dihapus!');
            return redirect(route('kompetisi.history'));
        } else {
            Alert::error('Gagal!', 'Data registrasi kompetisi tidak dapat dihapus!');
            return redirect(route('kompetisi.history'));
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
