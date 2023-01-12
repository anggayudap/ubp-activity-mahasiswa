<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\Kegiatan;
use App\Models\Proposal;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use RealRashid\SweetAlert\Facades\Alert;

class ProposalController extends Controller
{
    public function index(Request $request) {
        return redirect()->route('dashboard');
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {
            $data = Proposal::select(['id', 'date', 'judul_proposal', 'nama_mahasiswa', 'ketua_pelaksana', 'next_approval', 'is_editable', 'current_status', 'laporan_rejected_kemahasiswaan', 'prodi'])->with(['prodi_mahasiswa']);
            $user = Auth::user();

            // dd($data);

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
                    if ($proposal->laporan_rejected_kemahasiswaan) {
                        return trans('serba.reject_laporan');
                    } elseif ($proposal->current_status == 'reject') {
                        return trans('serba.reject');
                    } elseif ($proposal->current_status == 'completed') {
                        return trans('serba.' . $proposal->current_status);
                    }
                    return trans('serba.' . $proposal->current_status) . trans('serba.' . $proposal->next_approval);
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
            $data = Proposal::select(['id', 'date', 'judul_proposal', 'nama_mahasiswa', 'ketua_pelaksana', 'next_approval', 'is_editable', 'current_status', 'laporan_rejected_kemahasiswaan', 'prodi'])
                ->with(['prodi_mahasiswa'])
                ->where('nim', session('user.id'));
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
                    if (in_array($row->current_status, ['upload_laporan', 'laporan_diupload']) || $row->laporan_rejected_kemahasiswaan == '1') {
                        $btn .= '<a href="#" data-toggle="modal" data-target="#xlarge-upload-laporan" onclick="upload_laporan(' . $row->id . ')" class="dropdown-item"><i data-feather="upload"></i> Upload Laporan</a>';
                    }
                    $btn .= '</div>
                        </div>';

                    return $btn;
                })
                ->editColumn('next_approval', function (Proposal $proposal) {
                    if ($proposal->laporan_rejected_kemahasiswaan) {
                        return trans('serba.reject_laporan');
                    } elseif ($proposal->current_status == 'reject') {
                        return trans('serba.reject');
                    } elseif ($proposal->current_status == 'completed') {
                        return trans('serba.' . $proposal->current_status);
                    }
                    return trans('serba.' . $proposal->current_status) . trans('serba.' . $proposal->next_approval);
                })
                ->rawColumns(['action', 'next_approval'])
                ->removeColumn('id')
                ->make(true);
        }

        $data['heading'] = 'History Proposal Kegiatan';
        $data['datasource'] = 'proposal.history';

        return view('proposal.index', compact('data'));
    }

    public function approval_fakultas(Request $request)
    {
        if ($request->ajax()) {
            $data = Proposal::select(['id', 'date', 'judul_proposal', 'nama_mahasiswa', 'ketua_pelaksana', 'next_approval', 'is_editable', 'current_status', 'laporan_rejected_kemahasiswaan', 'prodi'])
                ->with(['prodi_mahasiswa'])
                // ->where('prodi', session('user.prodi')) /** prodi equals with prodi user */
                ->where('current_status', 'pending')
                ->where('next_approval', 'fakultas');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn =
                        '<div class="dropdown">
                        <a class="btn btn-sm btn-icon px-0" data-toggle="dropdown" aria-expanded="false"><i data-feather="more-vertical"></i></a>
                        <div class="dropdown-menu dropdown-menu-right" style="">
                        <a href="#" data-toggle="modal" data-target="#approval-modal" onclick="javascript:approval(' .
                        $row->id .
                        ');" class="dropdown-item"><i data-feather="check"></i> Approval Fakultas</a>';

                    $btn .= '</div>
                        </div>';

                    return $btn;
                })
                ->editColumn('next_approval', function (Proposal $proposal) {
                    if ($proposal->laporan_rejected_kemahasiswaan) {
                        return trans('serba.reject_laporan');
                    } elseif ($proposal->current_status == 'reject') {
                        return trans('serba.reject');
                    }
                    return trans('serba.' . $proposal->next_approval);
                })
                ->rawColumns(['action', 'next_approval'])
                ->removeColumn('id')
                ->make(true);
        }

        $data['heading'] = 'Approval Fakultas';
        $data['datasource'] = 'proposal.approval_fakultas';
        $data['approval'] = 'fakultas';

        return view('proposal.index', compact('data'));
    }
    public function approval_kemahasiswaan(Request $request)
    {
        if ($request->ajax()) {
            $data = Proposal::select(['id', 'date', 'judul_proposal', 'nama_mahasiswa', 'ketua_pelaksana', 'next_approval', 'is_editable', 'current_status', 'laporan_rejected_kemahasiswaan', 'prodi'])
                ->with(['prodi_mahasiswa'])
                ->where('current_status', 'pending')
                ->where('next_approval', 'kemahasiswaan');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn =
                        '<div class="dropdown">
                        <a class="btn btn-sm btn-icon px-0" data-toggle="dropdown" aria-expanded="false"><i data-feather="more-vertical"></i></a>
                        <div class="dropdown-menu dropdown-menu-right" style="">
                        <a href="#" data-toggle="modal" data-target="#approval-modal" onclick="javascript:approval(' .
                        $row->id .
                        ');" class="dropdown-item"><i data-feather="check"></i> Approval Kemahasiswaan</a>';

                    $btn .= '</div>
                        </div>';

                    return $btn;
                })
                ->editColumn('next_approval', function (Proposal $proposal) {
                    if ($proposal->laporan_rejected_kemahasiswaan) {
                        return trans('serba.reject_laporan');
                    } elseif ($proposal->current_status == 'reject') {
                        return trans('serba.reject');
                    }
                    return trans('serba.' . $proposal->next_approval);
                })
                ->rawColumns(['action', 'next_approval'])
                ->removeColumn('id')
                ->make(true);
        }

        $data['heading'] = 'Approval Kemahasiswaan';
        $data['datasource'] = 'proposal.approval_kemahasiswaan';
        $data['approval'] = 'kemahasiswaan';

        return view('proposal.index', compact('data'));
    }

    public function approval_laporan(Request $request)
    {
        if ($request->ajax()) {
            $data = Proposal::select(['id', 'date', 'judul_proposal', 'nama_mahasiswa', 'ketua_pelaksana', 'next_approval', 'is_editable', 'current_status', 'laporan_rejected_kemahasiswaan', 'prodi'])
                ->with(['prodi_mahasiswa'])
                ->where('current_status', 'laporan_diupload')
                ->where('next_approval', 'kemahasiswaan')
                ->whereNotNull('file_laporan');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn =
                        '<div class="dropdown">
                        <a class="btn btn-sm btn-icon px-0" data-toggle="dropdown" aria-expanded="false"><i data-feather="more-vertical"></i></a>
                        <div class="dropdown-menu dropdown-menu-right" style="">
                        <a href="#" data-toggle="modal" data-target="#approval-modal" onclick="javascript:approval(' .
                        $row->id .
                        ');" class="dropdown-item"><i data-feather="check"></i> Approval Laporan</a>';

                    $btn .= '</div>
                        </div>';

                    return $btn;
                })
                ->editColumn('next_approval', function (Proposal $proposal) {
                    if ($proposal->laporan_rejected_kemahasiswaan) {
                        return trans('serba.reject_laporan');
                    } elseif ($proposal->current_status == 'reject') {
                        return trans('serba.reject');
                    }
                    return trans('serba.' . $proposal->next_approval);
                })
                ->rawColumns(['action', 'next_approval'])
                ->removeColumn('id')
                ->make(true);
        }

        $data['heading'] = 'Approval Laporan';
        $data['datasource'] = 'proposal.approval_laporan';
        $data['approval'] = 'laporan';

        return view('proposal.index', compact('data'));
    }

    public function reject(Request $request)
    {
        if ($request->ajax()) {
            $proposal = Proposal::findOrFail($request->id);
            $param = [];

            if ($request->type == 'fakultas') {
                $param = [
                    'current_status' => 'reject',
                    'rejected_fakultas' => '1',
                    'is_editable' => '1',
                    'reject_note' => $request->note,
                ];
            } elseif ($request->type == 'kemahasiswaan') {
                $param = [
                    'current_status' => 'reject',
                    'rejected_kemahasiswaan' => '1',
                    'is_editable' => '1',
                    'reject_note' => $request->note,
                ];
            }

            // update to table
            $proposal->update($param);

            if ($proposal) {
                return response()->json(['success' => true, 'message' => 'Proposal berhasil di reject', 'redirect' => route('proposal.list')]);
            } else {
                return response()->json(['success' => true, 'message' => 'Terjadi error saat reject. Harap hub. administrator anda.']);
            }
        }

        return response()->json(['success' => true, 'message' => 'Terjadi error. Harap hub. administrator anda.']);
    }

    public function submit_laporan(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required',
            'file_laporan' => 'required|file|max:5120',
        ]);

        $laporan_proposal_path = null;

        if ($request->file('file_laporan')) {
            $laporan_proposal_path = $this->upload_file($request->file('file_laporan'), 'file_laporan');
        }

        $post = Proposal::where('id', $request->id);

        // delete prev file if exists
        // dd($post);
        $proposal = $post->first();
        if ($proposal->file_laporan) {
            $prev_file = public_path($proposal->file_laporan);
            if (file_exists($prev_file)) {
                unlink($prev_file);
            }
        }

        $post->update([
            'file_laporan' => $laporan_proposal_path,
            'laporan_uploaded' => date('Y-m-d H:i:s'),
            'laporan_rejected_kemahasiswaan' => 0,
            'laporan_kemahasiswaan_approval_date' => null,
            'laporan_kemahasiswaan_user_id' => null,
            'laporan_kemahasiswaan_user_name' => null,
            'current_status' => 'laporan_diupload',
        ]);

        if ($post) {
            Alert::success('Berhasil!', 'Laporan berhasil di upload!');
            return redirect(route('proposal.history'));
        } else {
            Alert::error('Gagal!', 'Laporan tidak dapat di upload!');
            return redirect(route('proposal.history'));
        }
    }
    public function submit_approval(Request $request)
    {
        if ($request->ajax()) {
            $proposal = Proposal::findOrFail($request->data['proposal_id']);
            $param = [];

            if ($request->approval == 'fakultas') {
                if ($request->type == 'approve') {
                    $param = [
                        'fakultas_user_id' => session('user.user_id'),
                        'fakultas_user_name' => session('user.nama'),
                        'next_approval' => 'kemahasiswaan',
                        'current_status' => 'pending',
                        'fakultas_approval_date' => date('Y-m-d H:i:s'),
                        'rejected_fakultas' => '0',
                        'is_editable' => '0',
                        'reject_note' => null,
                    ];
                } elseif ($request->type == 'reject') {
                    $param = [
                        'current_status' => 'reject',
                        'rejected_fakultas' => '1',
                        'is_editable' => '1',
                        'reject_note' => $request->note,
                    ];
                }
            } elseif ($request->approval == 'kemahasiswaan') {
                if ($request->type == 'approve') {
                    $param = [
                        'kemahasiswaan_user_id' => session('user.user_id'),
                        'kemahasiswaan_user_name' => session('user.nama'),
                        'next_approval' => 'kemahasiswaan',
                        'current_status' => 'upload_laporan',
                        'kemahasiswaan_approval_date' => date('Y-m-d H:i:s'),
                        'rejected_kemahasiswaan' => '0',
                        'is_editable' => '0',
                        'reject_note' => null,
                        'laporan_deadline' => date('Y-m-d', strtotime($proposal->tanggal_akhir . '+10 days')),
                    ];
                } elseif ($request->type == 'reject') {
                    $param = [
                        'current_status' => 'reject',
                        'rejected_kemahasiswaan' => '1',
                        'is_editable' => '1',
                        'reject_note' => $request->note,
                    ];
                }
            } elseif ($request->approval == 'laporan') {
                if ($request->type == 'approve') {
                    $param = [
                        'laporan_kemahasiswaan_user_id' => session('user.user_id'),
                        'laporan_kemahasiswaan_user_name' => session('user.nama'),
                        'next_approval' => 'completed',
                        'current_status' => 'completed',
                        'laporan_kemahasiswaan_approval_date' => date('Y-m-d H:i:s'),
                        'laporan_rejected_kemahasiswaan' => '0',
                        'is_editable' => '0',
                        'reject_note' => null,
                    ];
                } elseif ($request->type == 'reject') {
                    $param = [
                        'current_status' => 'reject',
                        'laporan_rejected_kemahasiswaan' => '1',
                        'is_editable' => '0',
                        'reject_note' => $request->note,
                    ];
                }
            }

            // update input oleh dpm/kemahasiswaan saat approve proposal
            $param['date'] = $request->data['date'];
            $param['judul_proposal'] = $request->data['judul_proposal'];
            $param['ketua_pelaksana'] = $request->data['ketua_pelaksana'];
            $param['anggaran_pengajuan'] = $request->data['anggaran_pengajuan'];

            // update to table
            $proposal->update($param);

            if ($proposal) {
                return response()->json(['success' => true, 'message' => 'Proposal berhasil di approve', 'redirect' => route('proposal.list')]);
            } else {
                return response()->json(['success' => true, 'message' => 'Terjadi error saat approve. Harap hub. administrator anda.']);
            }
        }

        return response()->json(['success' => true, 'message' => 'Terjadi error. Harap hub. administrator anda.']);
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
            'tanggal_mulai' => 'required',
            'tanggal_akhir' => 'required',
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
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_akhir' => $request->tanggal_akhir,
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
        $output = $this->fetch_detail_proposal($id);

        return view('proposal.modal_detail', compact('output'));
    }

    public function upload_laporan($id)
    {
        $output = $this->fetch_detail_proposal($id);

        return view('proposal.modal_upload_laporan', compact('output'));
    }

    public function approval($id)
    {
        $output = $this->fetch_detail_proposal($id);

        return view('proposal.modal_approval', compact('output'));
    }

    private function fetch_detail_proposal($id)
    {
        $output['proposal'] = Proposal::where('id', $id)
            ->with(['prodi_mahasiswa'])
            ->first();

        if ($output['proposal']->file_proposal) {
            $output['is_pdf']['file_proposal'] = false;

            $file_name = $output['proposal']->file_proposal;
            $str_pieces = explode('.', $file_name);
            $extensions = end($str_pieces);

            if ($extensions == 'pdf') {
                $output['is_pdf']['file_proposal'] = true;
            }
        }

        if ($output['proposal']->file_laporan) {
            $output['is_pdf']['file_laporan'] = false;

            $file_name = $output['proposal']->file_laporan;
            $str_pieces = explode('.', $file_name);
            $extensions = end($str_pieces);

            if ($extensions == 'pdf') {
                $output['is_pdf']['file_laporan'] = true;
            }
        }

        return $output;
    }

    public function edit($id)
    {
        $data['proposal'] = Proposal::findOrFail(Crypt::decrypt($id));

        return view('proposal.form', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'date' => 'required',
            'judul_proposal' => 'required',
            'ketua_pelaksana' => 'required',
            'anggaran_pengajuan' => 'required|numeric',
            'file_proposal' => 'nullable|file|max:5120',
            'tanggal_mulai' => 'required',
            'tanggal_akhir' => 'required',
        ]);

        $proposal = Proposal::findOrFail($id);
        $file_proposal_path = null;

        if ($request->file('file_proposal')) {
            $file_proposal_path = $this->upload_file($request->file('file_proposal'), 'file_proposal');
        }

        $update_params = [
            'nim' => session('user.id'),
            'nama_mahasiswa' => session('user.nama'),
            'prodi' => session('user.prodi'),
            'date' => $request->date,
            'judul_proposal' => $request->judul_proposal,
            'ketua_pelaksana' => $request->ketua_pelaksana,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_akhir' => $request->tanggal_akhir,
            'anggaran_pengajuan' => $request->anggaran_pengajuan,
            'current_status' => 'pending',
        ];

        if ($file_proposal_path) {
            $update_params['file_proposal'] = $file_proposal_path;
        }

        $proposal->update($update_params);

        if ($proposal) {
            Alert::success('Berhasil!', 'Data proposal berhasil diupdate!');
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
