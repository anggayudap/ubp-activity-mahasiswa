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

class KompetisiResultController extends Controller
{
    public function result_list(Request $request)
    {
        if ($request->ajax()) {
            $data = KompetisiParticipant::select(['id', 'kompetisi_id', 'created_at', 'nama_skema', 'nama_dosen_pembimbing', 'status', 'is_editable'])
                ->with(['kompetisi', 'member'])
                ->where('status', 'reviewed');

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
                        route('kompetisi.result', $row->id) .
                        '" class="dropdown-item"><i data-feather="edit"></i> Input Penilaian Akhir</a></div>
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

        $data['heading'] = 'Penilaian Akhir Kompetisi';
        $data['datasource'] = 'kompetisi.result.list';

        return view('kompetisi.index_participant', compact('data'));
    }

    public function result($id)
    {
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

       
        return view('kompetisi.result.form', compact('output', 'additional'));
    }

    public function submit_result(Request $request)
    {
        $validated = $request->validate(
            [
                'participant_id' => 'required',
                'keputusan' => 'required|in:lolos,tidak_lolos',
                'catatan' => 'sometimes',
            ]);

                
        $update_param = [
            'note_reject' => null,
            'catatan' => $request->catatan,
            'is_editable' => 0,
            'status' => 'completed',
        ];

        $update = KompetisiParticipant::where('id', $request->participant_id)->update($update_param);

        if ($update) {
            Alert::success('Berhasil!', 'Data kompetisi selesai dinilai!');
            return redirect(route('kompetisi.result.list'));
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
