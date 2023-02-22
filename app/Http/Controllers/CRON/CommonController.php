<?php

namespace App\Http\Controllers\CRON;

use App\Http\Controllers\Controller;
use App\Models\KompetisiParticipant;
use Illuminate\Http\Request;

class CommonController extends Controller
{
    public function update_nidn_kompetisi_participant()
    {
        $pembimbing_state = KompetisiParticipant::with(['dosen_pembimbing', 'dosen_penilai'])
            ->where('nidn_dosen_pembimbing', null)
            ->get();
        $count = 0;
        if ($pembimbing_state->count() > 0) {
            foreach ($pembimbing_state as $data_kompetensi) {
                $data_kompetensi->nidn_dosen_pembimbing = $data_kompetensi->dosen_pembimbing->nidn;
                $data_kompetensi->nidn_dosen_penilai = $data_kompetensi->dosen_penilai->nidn;
                $data_kompetensi->save();
                $count++;
            }
        }

        return 'berhasil ! ' . $count . ' data kompetisi berhasil di update.';
    }
}
