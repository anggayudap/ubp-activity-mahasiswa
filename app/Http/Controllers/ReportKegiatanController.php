<?php

namespace App\Http\Controllers;

use App\Models\Prodi;
use App\Models\Periode;
use App\Models\Kegiatan;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use App\Models\KlasifikasiKegiatan;
use App\Http\Controllers\Controller;

class ReportKegiatanController extends Controller
{
    public function index()
    {
        $data = [];
        $fetch_mahasiswa = Mahasiswa::all();
        $data['fetch_prodi'] = Prodi::all();
        $data['fetch_klasifikasi'] = KlasifikasiKegiatan::all();
        $data['fetch_periode'] = Periode::all();

        if ($fetch_mahasiswa->count() > 0) {
            foreach ($fetch_mahasiswa as $mahasiswa) {
                $data['mahasiswa'][$mahasiswa->nim] = $mahasiswa->nim . ' - ' . $mahasiswa->nama_mahasiswa;
            }
        }

        return view('report.kegiatan.index', compact('data'));
    }

    public function submit(Request $request)
    {
        $validated = $request->validate([
            'nim' => 'required',
            'prodi' => 'nullable',
            'klasifikasi' => 'nullable',
            'periode' => 'nullable',
            'tahun_periode' => 'required',
            'status' => 'array|required',
        ]);

        // dd($request);

        $query = Kegiatan::with(['periode', 'klasifikasi', 'prodi_mahasiswa'])
            ->whereIn('status', $request->status)
            ->where('tahun_periode', $request->tahun_periode);
        if ($request->nim != 'all') {
            $query->where('nim', $request->nim);
        }
        if ($request->prodi != 'all') {
            $query->where('prodi', $request->prodi);
        }
        if ($request->klasifikasi != 'all') {
            $query->where('klasifikasi_id', $request->klasifikasi);
        }
        if ($request->periode != 'all') {
            $query->where('periode_id', $request->periode);
        }

        // dd($query->get());
        $output['result'] = $query->get();
        // dd($output);
        return view('report.kegiatan.table', compact('output'));
    }
}
