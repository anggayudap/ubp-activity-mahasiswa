<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\Dosen;
use App\Models\Skema;
use App\Models\Review;
use App\Models\Kompetisi;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Models\KompetisiParticipant;
use Illuminate\Support\Facades\Crypt;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Database\Eloquent\Builder;
use App\Models\KompetisiParticipantMember;
use App\Models\KompetisiParticipantReview;

class KompetisiApprovalController extends Controller
{
    public function approval_list(Request $request)
    {
        if ($request->ajax()) {
            $data = KompetisiParticipant::select(['id', 'kompetisi_id', 'created_at', 'nama_skema', 'nama_dosen_pembimbing', 'status', 'is_editable'])
                ->with(['kompetisi', 'member'])
                ->where('status', 'pending');

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
                        <a class="btn btn-sm btn-icon px-0" data-toggle="dropdown" aria-expanded="false"><i data-feather="menu"></i></a>
                        <div class="dropdown-menu dropdown-menu-right" style="">
                        <a href="' .
                        route('kompetisi.approval', $row->id) .
                        '" class="dropdown-item"><i data-feather="check"></i> Approval Kompetisi</a></div>
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

        $data['heading'] = 'Approval Registrasi Kompetisi';
        $data['datasource'] = 'kompetisi.approval.list';

        return view('kompetisi.index_participant', compact('data'));
    }

    public function approval($id)
    {
        $dosens = Dosen::select('id', 'nip', 'nama')->get();

        $output = KompetisiParticipant::with(['kompetisi', 'member'])
            ->where('id', $id)
            ->first();

        if(in_array($output->status, ['completed', 'reject'])) {
            return redirect()->route('dashboard')->withErrors(['Error : perintah tidak valid. Kompetisi tidak bisa diupdate.']);
        }

        $additional['is_pdf'] = false;

        $file_name = $output->file_upload;
        $str_pieces = explode('.', $file_name);
        $extensions = end($str_pieces);

        if ($extensions == 'pdf') {
            $additional['is_pdf'] = true;
        }

        $additional['dosen'][] = [
            'id' => null,
            'text' => 'Silahkan input Nama Dosen Pembimbing',
        ];
        foreach ($dosens as $data_dosen) {
            $additional['dosen'][] = [
                'id' => $data_dosen->id,
                'text' => $data_dosen->nama,
            ];
        }

        $list_reviews = Skema::where('nama_skema',$output->nama_skema)->with(['assigned_review.review'])->first();
        $additional['review'] = null;
        
        if($list_reviews->assigned_review->count() > 0){
            $additional['review'] = $list_reviews->assigned_review;
        }
        
        return view('kompetisi.approval.form', compact('output', 'additional'));
    }

    public function submit_approval(Request $request)
    {
        $validated = $request->validate(
            [
                'participant_id' => 'required',
                'dosen_penilai' => 'sometimes',
                'approval' => 'required|in:approve,reject',
                'note' => 'sometimes|required|string',
            ],
            [
                'note.sometimes' => 'note is required when approval is reject',
                'dosen_penilai.sometimes' => 'dosen_penilai is required when approval is approve',
            ],
            [
                'note' => 'required_if:approval,reject',
                'dosen_penilai' => 'required_if:approval,approve',
            ],
        );

        $kompetisi_participant = KompetisiParticipant::with(['kompetisi'])
            ->where('id', $request->participant_id)
            ->first();

        $kompetisi_end_date = strtotime($kompetisi_participant->kompetisi->tanggal_akhir_pendaftaran);
        $current_date = strtotime(date('Y-m-d'));



        // dd($kompetisi_end_date . ' :: ' . $current_date);

        $update_param = [
            'tanggal_approval' => Carbon::now(),
            'user_approval' => session('user.user_id'),
            'nama_approval' => session('user.nama'),
        ];

        if ($request->approval == 'reject') {
            // jika tanggal sekarang melewati tanggal akhir pendaftaran
            if ($kompetisi_end_date < $current_date) {
                $update_param['status'] = 'completed';
                $update_param['keputusan'] = 'tidak_lolos';
                $update_param['note_reject'] = $request->note ?? '-';
                $update_param['is_editable'] = 0;
                $update_param['catatan'] = 'Registrasi Kompetisi telah direject dan melewati tanggal pendaftaran Kompetisi.';
            } else {
                $update_param['status'] = 'reject';
                $update_param['note_reject'] = $request->note ?? '-';
                $update_param['is_editable'] = 1;
            }
        } else {
            // handling untuk re-plotting review
            KompetisiParticipantReview::where('participant_id', $request->participant_id)->delete();
            // store kompetisi participants review
            $review_param = [];
            $skema = Skema::where('nama_skema',$kompetisi_participant->nama_skema)->with(['assigned_review.review'])->first();
            foreach($skema->assigned_review as $data_review) {
                $review_param[] = [
                    'participant_id' => $request->participant_id,
                    'review_id' => $data_review->review->id,
                    'teks_review' => $data_review->review->teks_review,
                    'created_at' => Carbon::now(),
                ];
            }
            KompetisiParticipantReview::insert($review_param);
            // END store kompetisi participants review


            $data_dosen = Dosen::where('id', $request->dosen_penilai)->first();
            $update_param['id_dosen_penilai'] = $data_dosen->id_sipt;
            $update_param['nip_dosen_penilai'] = $data_dosen->nip;
            $update_param['nidn_dosen_penilai'] = $data_dosen->nidn;
            $update_param['nama_dosen_penilai'] = $data_dosen->nama;
            $update_param['email_dosen_penilai'] = $data_dosen->email;
            $update_param['prodi_dosen_penilai'] = $data_dosen->prodi;

            $update_param['status'] = 'in_review';
            $update_param['is_editable'] = 0;
        }

        $update = KompetisiParticipant::where('id', $request->participant_id)->update($update_param);

        if ($update) {
            Alert::success('Berhasil!', 'Data registrasi berhasil di ' . $request->approval . '!');
            return redirect(route('kompetisi.approval.list'));
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    'error' => 'Some problem occurred, please try again',
                ]);
        }
    }
}
