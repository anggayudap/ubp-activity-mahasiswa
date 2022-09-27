<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Kegiatan;
use App\Models\Proposal;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class ProposalController extends Controller
{
    public function list(Request $request)
    {
        if ($request->ajax()) {
            $data = Proposal::select(['id', 'date', 'judul_proposal', 'nama_mahasiswa', 'ketua_pelaksana', 'next_approval']);
            $user = Auth::user();

            if (!$user->hasRole('kemahasiswaan')) {
                // if role only dosen
                $data->where('prodi', session('user.prodi'));
            }

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn =
                        '<div class="dropdown">
                        <a class="btn btn-sm btn-icon px-0" data-toggle="dropdown" aria-expanded="false"><i data-feather="more-vertical"></i></a>
                        <div class="dropdown-menu dropdown-menu-right" style="">
                        <a href="#" data-toggle="modal" data-target="#xlarge" onclick="javascript:detail(' .
                        $row->id .
                        ');" class="dropdown-item"><i data-feather="file-text"></i> Detail</a>';
                    if ($row->is_editable) {
                        $btn .=
                            '<a href="' .
                            route('proposal.edit', Crypt::encrypt($row->id)) .
                            '" class="dropdown-item"><i data-feather="edit"></i> Edit</a>
                            <form action="' .
                            route('proposal.destroy', [$row->id]) .
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
                ->editColumn('next_approval', function (Proposal $proposal) {
                    return trans('serba.' . $proposal->next_approval);
                })
                ->rawColumns(['action', 'next_approval'])
                ->removeColumn('id')
                ->make(true);
        }

        $data['heading'] = 'List Proposal Kegiatan';
        $data['datasource'] = 'proposal.list';

        return view('proposal.index', compact('data'));
    }

    public function history(Request $request)
    {
        if ($request->ajax()) {
            $data = Proposal::select(['id', 'date', 'judul_proposal', 'nama_mahasiswa', 'ketua_pelaksana', 'next_approval'])->where('nim', session('user.id'));
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn =
                        '<div class="dropdown">
                        <a class="btn btn-sm btn-icon px-0" data-toggle="dropdown" aria-expanded="false"><i data-feather="more-vertical"></i></a>
                        <div class="dropdown-menu dropdown-menu-right" style="">
                        <a href="#" data-toggle="modal" data-target="#xlarge" onclick="javascript:detail(' .
                        $row->id .
                        ');" class="dropdown-item"><i data-feather="file-text"></i> Detail</a>';
                    if ($row->is_editable) {
                        $btn .=
                            '<a href="' .
                            route('proposal.edit', Crypt::encrypt($row->id)) .
                            '" class="dropdown-item"><i data-feather="edit"></i> Edit</a>
                            <form action="' .
                            route('proposal.destroy', [$row->id]) .
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
                ->editColumn('next_approval', function (Proposal $proposal) {
                    return trans('serba.' . $proposal->next_approval);
                })
                ->rawColumns(['action', 'next_approval'])
                ->removeColumn('id')
                ->make(true);
        }

        $data['heading'] = 'History Proposal Kegiatan';
        $data['datasource'] = 'proposal.history';

        return view('proposal.index', compact('data'));
    }

    public function approval_kemahasiswaan()
    {
    }
    public function approval_fakultas()
    {
    }

    public function create()
    {
        return view('proposal.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required',
            'judul_proposal' => 'required',
            'ketua_pelaksana' => 'required',
            'anggaran_pengajuan' => 'required|numeric',
            'file_proposal' => 'required|file|max:5120',
        ]);

        $file_proposal_path = null;

        if ($request->file('file_proposal')) {
            $file_proposal_path = $this->upload_file($request->file('file_proposal'), 'file_proposal');
        }

        $post = Proposal::create([
            'nim' => session('user.id'),
            'nama_mahasiswa' => session('user.nama'),
            'prodi' => session('user.prodi'),
            'date' => $request->date,
            'judul_proposal' => $request->judul_proposal,
            'ketua_pelaksana' => $request->ketua_pelaksana,
            'anggaran_pengajuan' => $request->anggaran_pengajuan,
            'file_proposal' => $file_proposal_path,
            'current_status' => 'pending',
            'next_approval' => 'fakultas',
            'is_editable' => '0',
        ]);

        if ($post) {
            Alert::success('Berhasil!', 'Data proposal kegiatan berhasil dibuat!');
            return redirect(route('proposal.history'));
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
        $output['proposal'] = Proposal::where('id', $id)->first();
        // dd($output);
        // $checking_files = array('surat_tugas', 'bukti_kegiatan', 'foto_kegiatan');
        // foreach ($checking_files as $document) {
        //     $output['is_pdf'][$document] = false;

        //     $file_name = $output['kegiatan']->$document;
        //     $str_pieces = explode(".", $file_name);
        //     $extensions = end($str_pieces);

        //     if ($extensions == 'pdf') {
        //         $output['is_pdf'][$document] = true;
        //     }
        // }

        $output['is_pdf']['file_proposal'] = false;

            $file_name = $output['proposal']->file_proposal;
            $str_pieces = explode('.', $file_name);
            $extensions = end($str_pieces);

            if ($extensions == 'pdf') {
                $output['is_pdf']['file_proposal'] = true;
            }

        return view('proposal.modal_detail', compact('output'));
    }

    public function edit($id)
    {
        $data['proposal'] = Proposal::findOrFail(Crypt::decrypt($id));

        return view('proposal.form', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'periode_id' => 'required',
            'nama_kegiatan' => 'required',
            'tanggal_mulai' => 'required',
            'tanggal_akhir' => 'required',
            'klasifikasi_id' => 'required',
            'keterangan' => 'required',
            'url_event' => 'required|url',
            'surat_tugas' => 'nullable|file|max:5120',
            'foto_kegiatan' => 'nullable|file|max:5120',
            'bukti_kegiatan' => 'nullable|file|max:5120',
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
            'periode_id' => $request->periode_id,
            'tahun_periode' => date('Y'),
            'nama_kegiatan' => $request->nama_kegiatan,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_akhir' => $request->tanggal_akhir,
            'klasifikasi_id' => $request->klasifikasi_id,
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
            Alert::success('Berhasil!', 'Data klasifikasi kegiatan berhasil diupdate!');
            return redirect(route('proposal.history'));
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
        $proposal = Proposal::findOrFail($id);
        $proposal->delete();

        $prev_file = public_path($proposal->file_proposal);
        if (file_exists($prev_file)) {
            unlink($prev_file);
        }

        if ($proposal) {
            Alert::success('Berhasil!', 'Data proposal kegiatan berhasil dihapus!');
            return redirect(route('proposal.history'));
        } else {
            Alert::error('Gagal!', 'Data proposal kegiatan tidak dapat dihapus!');
            return redirect(route('proposal.history'));
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
