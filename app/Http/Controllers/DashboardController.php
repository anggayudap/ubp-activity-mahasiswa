<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use App\Models\KompetisiParticipant;
use App\Models\Proposal;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $result = [];
        $user = Auth::user();

        if ($user->hasRole('mahasiswa')) {
            $result['proposal'] = Proposal::where('nim', session('user.id'))->get();

            $result['kegiatan'] = Kegiatan::where('nim', session('user.id'))->get();

            $result['kompetisi'] = KompetisiParticipant::select(['id', 'kompetisi_id', 'created_at', 'nama_skema', 'nama_dosen_pembimbing', 'status', 'is_editable'])
            ->with(['member'])
            ->whereHas('member', function (Builder $query) {
                $query->where('nim', session('user.id'));
            })->get();
            
        } else {
            if ($user->hasRole('dosen')) {
                $result['kompetisi_review_dosen'] = KompetisiParticipant::where('status', 'in_review')
                ->where('id_dosen_penilai', session('user.id'))->get();
            }
            if ($user->hasRole('dpm')) {
                $result['proposal_dosen'] = Proposal::where('prodi', session('user.prodi'))->get();
                $result['kegiatan_dosen'] = Kegiatan::where('prodi', session('user.prodi'))->get();
            }
            if ($user->hasRole('kemahasiswaan')) {
                $result['proposal_kemahasiswaan'] = Proposal::all();
                $result['kegiatan_kemahasiswaan'] = Kegiatan::all();
            }
        }

        return view('dashboard.index', compact('result'));
    }
}
