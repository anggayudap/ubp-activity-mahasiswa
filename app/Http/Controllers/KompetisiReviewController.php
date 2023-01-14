<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\Dosen;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Kompetisi;
use App\Models\KompetisiParticipant;
use Illuminate\Support\Facades\Crypt;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Database\Eloquent\Builder;
use App\Models\KompetisiParticipantMember;
use App\Models\KompetisiParticipantReview;

class KompetisiReviewController extends Controller
{
    public function review_list(Request $request)
    {
        if ($request->ajax()) {
            $data = KompetisiParticipant::select(['id', 'kompetisi_id', 'created_at', 'nama_skema', 'nama_dosen_pembimbing', 'status', 'is_editable'])
                ->with(['kompetisi', 'member'])
                ->where('status', 'in_review')
                ->where('id_dosen_penilai', session('user.id'));

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
                        <a href="' .
                        route('kompetisi.review', $row->id) .
                        '" class="dropdown-item"><i data-feather="edit"></i> Input Review</a></div>
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

        $data['heading'] = 'Review Kompetisi';
        $data['datasource'] = 'kompetisi.review.list';

        return view('kompetisi.index_history_participant', compact('data'));
    }

    public function review($id)
    {
        $dosens = Dosen::select('id', 'nip', 'nama')->get();
        $reviews = Review::select('id', 'teks_review')
            ->where('aktif', '1')
            ->get();

        $output = KompetisiParticipant::with(['kompetisi', 'member', 'review'])
            ->where('id', $id)
            ->first();


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

        foreach ($reviews as $data_review) {
            $additional['review'][] = [
                'id' => $data_review->id,
                'text' => $data_review->teks_review,
            ];
        }
        return view('kompetisi.form_review', compact('output', 'additional'));
    }

    public function submit_review(Request $request)
    {
        $validated = $request->validate(
            [
                'participant_id' => 'required',
                'skor' => 'sometimes|array',
                'catatan' => 'nullable',
            ]);

        // update skor value
        foreach($request->skor as $id => $value_skor) {
            KompetisiParticipantReview::where('id', $id)->update(['skor_review' => $value_skor]);
        }

        
        $update_param = [
            'note_reject' => null,
            'is_editable' => 0,
            'status' => 'reviewed',
        ];

        if($request->catatan) {
            $update_param['catatan'] = 'Catatan dosen penilai: ' . $request->catatan;
        }

        $update = KompetisiParticipant::where('id', $request->participant_id)->update($update_param);

        if ($update) {
            Alert::success('Berhasil!', 'Data review berhasil dinilai!');
            return redirect(route('kompetisi.review.list'));
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
