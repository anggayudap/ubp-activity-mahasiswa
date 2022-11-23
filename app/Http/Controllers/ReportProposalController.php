<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Prodi;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class ReportProposalController extends Controller
{
    protected $spreadsheet;

    public function __construct() {
        $this->spreadsheet = new Spreadsheet();
    }

    public function index() {
        $fetch_mahasiswa = Mahasiswa::select('id', 'nim', 'nama_mahasiswa')->get();
        $data['fetch_prodi'] = Prodi::all();

        if ($fetch_mahasiswa->count() > 0) {
            $collection = collect($fetch_mahasiswa);
            $data['mahasiswa'] = $collection->keyBy('nim')->all();
        }

        return view('report.proposal.index', compact('data'));
    }

    public function submit(Request $request)
    {
        $validated = $request->validate([
            'nim' => 'required',
            'prodi' => 'nullable',
            'status' => 'array|required',
        ]);
        $output = true;

        // $query = Proposal::with(['periode', 'klasifikasi', 'prodi_mahasiswa'])
        //     ->whereIn('status', $request->status)
        //     ->where('tahun_periode', $request->tahun_periode);
        // if ($request->nim != 'all') {
        //     $query->where('nim', $request->nim);
        // }
        // if ($request->prodi != 'all') {
        //     $query->where('prodi', $request->prodi);
        // }
        // if ($request->klasifikasi != 'all') {
        //     $query->where('klasifikasi_id', $request->klasifikasi);
        // }
        // if ($request->periode != 'all') {
        //     $query->where('periode_id', $request->periode);
        // }

        // $output['result'] = $query->get();

        return view('report.proposal.table', compact('output'));
    }
}
