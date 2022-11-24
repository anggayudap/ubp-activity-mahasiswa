<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Prodi;
use App\Models\Proposal;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class ReportProposalController extends Controller
{
    protected $spreadsheet;

    public function __construct()
    {
        $this->spreadsheet = new Spreadsheet();
    }

    public function index()
    {
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
            'prodi' => 'required',
            'status' => 'array|required',
        ]);

        // param dari status
        // wait_fakultas, wait_kemahasiswaan, reject, completed

        $query = Proposal::with(['prodi_mahasiswa']);

        if ($request->nim != 'all') {
            $query->where('nim', $request->nim);
        }
        if ($request->prodi != 'all') {
            $query->where('prodi', $request->prodi);
        }
        if (in_array('completed', $request->status)) {
            $query->where('current_status', 'completed');
        }
        if (in_array('reject', $request->status)) {
            $query->where('current_status', 'reject');
        }
        if (in_array('wait_fakultas', $request->status)) {
            $query->where('next_approval', 'fakultas');
        }
        if (in_array('wait_kemahasiswaan', $request->status)) {
            $query->where('next_approval', 'kemahasiswaan');
        }

        $output['result'] = $query->get();

        return view('report.proposal.table', compact('output'));
    }
}
