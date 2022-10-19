<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class ReportProposalController extends Controller
{
    protected $spreadsheet;

    public function __construct() {
        $this->spreadsheet = new Spreadsheet();
    }

    public function index() {
        $data['data_mahasiswa'] = User::role('mahasiswa')->select('name', 'user_id')->get();
        // $data = true;
        // dd($data);

        return view('report.proposal.index', compact('data'));
    }
}
