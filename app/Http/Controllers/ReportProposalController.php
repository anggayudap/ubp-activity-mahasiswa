<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Prodi;
use App\Models\Proposal;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PhpOffice\PhpSpreadsheet\IOFactory;
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
        $param_status = [];
        $param_nextapproval = [];

        $query = Proposal::with(['prodi_mahasiswa']);

        if ($request->nim != 'all') {
            $query->where('nim', $request->nim);
        }
        if ($request->prodi != 'all') {
            $query->where('prodi', $request->prodi);
        }
        if (in_array('completed', $request->status)) {
            $param_status[] = 'completed';
        }
        if (in_array('reject', $request->status)) {
            $param_status[] = 'reject';
        }
        if (in_array('upload_laporan', $request->status)) {
            $param_status[] = 'upload_laporan';
        }
        if (in_array('wait_fakultas', $request->status)) {
            $param_nextapproval[] = 'fakultas';
        }
        if (in_array('wait_kemahasiswaan', $request->status)) {
            $param_nextapproval[] = 'kemahasiswaan';
        }

        $query->whereIn('current_status', $param_status)->orWhereIn('next_approval', $param_nextapproval);

        $output['result'] = $query
            ->groupBy('id')
            ->orderBy('date', 'ASC')
            ->get();

        if ($request->submit == 'view') {
            return view('report.proposal.table', compact('output'));
        } elseif ($request->submit == 'export') {
            $this->spreadsheet->setActiveSheetIndex(0);
            $sheet = $this->spreadsheet->getActiveSheet();

            $sheet->setCellValue('A1', 'Report' . ' :: ' . 'Detail Proposal');
            $sheet->setCellValue('A2', 'Prodi' . ' :: ' . $request->prodi);
            $header = ['NO', 'NIM', 'NAMA MAHASISWA', 'PRODI', 'TANGGAL PROPOSAL', 'JUDUL PROPOSAL', 'KETUA PELAKSANA', 'TANGGAL KEGIATAN', 'ANGGARAN PENGAJUAN', 'STATUS', 'TANGGAL APPROVAL FAKULTAS', 'NAMA APPROVAL FAKULTAS', 'TANGGAL APPROVAL KEMAHASISWAAN', 'NAMA APPROVAL KEMAHASISWAAN', 'TANGGAL APPROVAL LAPORAN', 'NAMA APPROVAL LAPORAN', 'NOTE REJECT'];
            for ($i = 1; $i <= 17; $i++) {
                $sheet->setCellValueByColumnAndRow($i, 3, $header[$i - 1]);
            }

            $row = 4;

            if ($output['result']) {
                $number = 1;
                foreach ($output['result'] as $proposal) {
                    $sheet->fromArray([$number, $proposal->nim, $proposal->nama_mahasiswa, $proposal->prodi_mahasiswa->nama_prodi ?? $proposal->prodi, get_date($proposal->date), $proposal->judul_proposal, $proposal->ketua_pelaksana, get_date($proposal->tanggal_mulai) . ' s/d ' . get_date($proposal->tanggal_akhir), rupiah($proposal->anggaran_pengajuan), $proposal->current_status, get_date_time($proposal->fakultas_approval_date), $proposal->fakultas_user_name, get_date_time($proposal->kemahasiswaan_approval_date), $proposal->kemahasiswaan_user_name, get_date_time($proposal->laporan_kemahasiswaan_approval_date), $proposal->laporan_kemahasiswaan_user_name, $proposal->reject_note], null, "A$row");
                    $row++;
                    $number++;
                }
            }

            $max_row = $sheet->getHighestRow();
            $max_colomn = $sheet->getHighestColumn();
            $sheet->getColumnDimension('A')->setWidth(5);
            $sheet->getColumnDimension('B')->setWidth(16);
            $sheet->getColumnDimension('C')->setWidth(26);
            $sheet->getColumnDimension('D')->setWidth(15);
            $sheet->getColumnDimension('E')->setWidth(16);
            $sheet->getColumnDimension('F')->setWidth(16);
            $sheet->getColumnDimension('G')->setWidth(16);
            $sheet->getColumnDimension('H')->setWidth(16);
            $sheet->getColumnDimension('I')->setWidth(26);
            $sheet->getColumnDimension('J')->setWidth(15);
            $sheet->getColumnDimension('K')->setWidth(15);
            $sheet->getColumnDimension('L')->setWidth(15);
            $sheet->getColumnDimension('M')->setWidth(15);
            $sheet->getColumnDimension('N')->setWidth(15);
            $sheet->getColumnDimension('O')->setWidth(15);
            $sheet->getColumnDimension('P')->setWidth(15);

            $sheet
                ->getStyle('A3:' . $max_colomn . $max_row)
                ->getAlignment()
                ->setWrapText(true);

            $sheet->getStyle('A3:' . $max_colomn . $max_row)->applyFromArray([
                'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, 'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER],
                'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]],
            ]);

            return $this->export_excel($request->type);
        }
    }

    private function export_excel($sub_title)
    {
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . 'report_proposal_kegiatan-' . $sub_title . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = IOFactory::createWriter($this->spreadsheet, 'Xlsx');
        $writer->save('php://output');
    }
}
