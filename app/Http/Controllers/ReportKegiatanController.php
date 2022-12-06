<?php

namespace App\Http\Controllers;

use App\Models\Prodi;
use App\Models\Periode;
use App\Models\Kegiatan;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use App\Models\KlasifikasiKegiatan;
use App\Http\Controllers\Controller;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class ReportKegiatanController extends Controller
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
        $data['fetch_klasifikasi'] = KlasifikasiKegiatan::all();
        $data['fetch_periode'] = Periode::all();

        if ($fetch_mahasiswa->count() > 0) {
            $collection = collect($fetch_mahasiswa);
            $data['mahasiswa'] = $collection->keyBy('nim')->all();
        }

        return view('report.kegiatan.index', compact('data'));
    }

    public function submit(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required',
            'nim' => 'required',
            'prodi' => 'nullable',
            'klasifikasi' => 'nullable',
            'periode' => 'nullable',
            'tahun_periode' => 'required',
            'status' => 'array|required',
        ]);

        if ($request->type == 'detail') {
            return $this->detail($request);
        } elseif ($request->type == 'custom_detail') {
            return $this->detail_custom($request);
        } elseif ($request->type == 'custom_summary') {
            return $this->summary_custom($request);
        }
    }

    private function export_excel($sub_title)
    {
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . 'report_kegiatan-' . $sub_title . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = IOFactory::createWriter($this->spreadsheet, 'Xlsx');
        $writer->save('php://output');
    }

    private function detail($request)
    {
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

        $output['result'] = $query->get();

        if ($request->submit == 'view') {
            return view('report.kegiatan.table_detail', compact('output'));
        } elseif ($request->submit == 'export') {
            $this->spreadsheet->setActiveSheetIndex(0);
            $sheet = $this->spreadsheet->getActiveSheet();

            $sheet->setCellValue('A1', 'Report' . ' :: ' . 'Detail Kegiatan');
            $header = ['NO', 'NIM', 'NAMA MAHASISWA', 'PRODI', 'PERIODE', 'TAHUN', 'NAMA KEGIATAN', 'KLASIFIKASI', 'TANGGAL KEGIATAN', 'CAKUPAN', 'URL PENYELENGGARA', 'URL PUBLIKASI', 'STATUS', 'APPROVAL', 'PRESTASI YANG DIRAIH', 'KETERANGAN'];

            for ($i = 1; $i <= 16; $i++) {
                $sheet->setCellValueByColumnAndRow($i, 3, $header[$i - 1]);
            }

            $row = 4;

            if ($output['result']) {
                $number = 1;
                foreach ($output['result'] as $kegiatan) {
                    $sheet->fromArray([$number, '\''.$kegiatan->nim, $kegiatan->nama_mahasiswa, $kegiatan->prodi_mahasiswa->nama_prodi ?? $kegiatan->prodi, $kegiatan->periode ? $kegiatan->periode->periode_awal . '-' . $kegiatan->periode->periode_akhir : '', $kegiatan->tahun_periode, $kegiatan->nama_kegiatan, $kegiatan->klasifikasi->name_kegiatan, get_indo_date($kegiatan->tanggal_mulai) . ' s/d ' . get_indo_date($kegiatan->tanggal_akhir), ucfirst($kegiatan->cakupan), $kegiatan->url_event, $kegiatan->url_publikasi, $kegiatan->status, $kegiatan->approval, $kegiatan->prestasi, $kegiatan->keterangan], null, "A$row");
                    $row++;
                    $number++;
                }
            }

            $max_row = $sheet->getHighestRow();
            $max_colomn = $sheet->getHighestColumn();
            $sheet->getColumnDimension('A')->setWidth(5);
            $sheet->getColumnDimension('B')->setWidth(16);
            $sheet->getColumnDimension('C')->setWidth(26);
            $sheet->getColumnDimension('D')->setWidth(26);
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
            $sheet->getColumnDimension('O')->setWidth(18);

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

    private function detail_custom($request)
    {
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

        $output['result'] = $query->get();

        if ($request->submit == 'view') {
            return view('report.kegiatan.table_customdetail', compact('output'));
        } elseif ($request->submit == 'export') {
            $this->spreadsheet->setActiveSheetIndex(0);
            $sheet = $this->spreadsheet->getActiveSheet();

            $sheet->setCellValue('A1', 'Report' . ' :: ' . 'Custom Detail Kegiatan');
            $header = ['NO', 'NIM', 'NAMA KEGIATAN', 'WAKTU PENYELENGGARAAN', 'TINGKAT PROVINSI/WILAYAH', 'TINGKAT NASIONAL', 'TINGKAT INTERNASIONAL', 'PRESTASI YANG DICAPAI'];

            for ($i = 1; $i <= 8; $i++) {
                $sheet->setCellValueByColumnAndRow($i, 3, $header[$i - 1]);
            }

            $row = 4;

            if ($output['result']) {
                $number = 1;
                foreach ($output['result'] as $kegiatan) {
                    $sheet->fromArray([$number, '\''.$kegiatan->nim, $kegiatan->nama_kegiatan, $kegiatan->tahun_periode, $kegiatan->cakupan == 'lokal' ? 'V' : '', $kegiatan->cakupan == 'nasional' ? 'V' : '', $kegiatan->cakupan == 'internasional' ? 'V' : '', $kegiatan->prestasi], null, "A$row");
                    $row++;
                    $number++;
                }
            }

            $max_row = $sheet->getHighestRow();
            $max_colomn = $sheet->getHighestColumn();
            $sheet->getColumnDimension('A')->setWidth(5);
            $sheet->getColumnDimension('B')->setWidth(16);
            $sheet->getColumnDimension('C')->setWidth(36);
            $sheet->getColumnDimension('D')->setWidth(26);
            $sheet->getColumnDimension('E')->setWidth(18);
            $sheet->getColumnDimension('F')->setWidth(18);
            $sheet->getColumnDimension('G')->setWidth(18);
            $sheet->getColumnDimension('H')->setWidth(16);

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

    private function summary_custom($request)
    {
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

        $output['result'] = $query->get();

        $output['cakupans'] = [];
        foreach ($output['result']->groupBy('prodi') as $kode_prodi => $kegiatans) {
            $cakupan_lokal = 0;
            $cakupan_nasional = 0;
            $cakupan_internasional = 0;

            foreach ($kegiatans as $kegiatan) {
                if ($kegiatan->cakupan == 'lokal') {
                    $cakupan_lokal++;
                } elseif ($kegiatan->cakupan == 'nasional') {
                    $cakupan_nasional++;
                } elseif ($kegiatan->cakupan == 'internasional') {
                    $cakupan_internasional++;
                }
            }
            $output['cakupans'][$kode_prodi] = [
                'lokal' => $cakupan_lokal,
                'nasional' => $cakupan_nasional,
                'internasional' => $cakupan_internasional,
            ];
        }

        if ($request->submit == 'view') {
            return view('report.kegiatan.table_customsummary', compact('output'));
        } elseif ($request->submit == 'export') {
            $this->spreadsheet->setActiveSheetIndex(0);
            $sheet = $this->spreadsheet->getActiveSheet();

            $sheet->setCellValue('A1', 'Report' . ' :: ' . 'Custom Summary Kegiatan by Prodi');
            $header = ['NAMA PRODI (KODE)', 'TOTAL KEGIATAN', 'Cakupan PROVINSI/WILAYAH', 'CAKUPAN NASIONAL', 'CAKUPAN INTERNASIONAL', 'DETAIL'];

            for ($i = 1; $i <= 6; $i++) {
                $sheet->setCellValueByColumnAndRow($i, 3, $header[$i - 1]);
            }

            $row = 4;

            if ($output['result']) {
                $number = 1;
                foreach ($output['result']->groupBy('prodi') as $kode_prodi => $kegiatan) {
                    $sheet->fromArray([
                        ($kegiatan[0]->prodi_mahasiswa->nama_prodi ?? 'Tidak ada data prodi') . ' (' . $kegiatan[0]->prodi . ')', 
                        $kegiatan->count(), 
                        $output['cakupans'][$kode_prodi]['lokal'], 
                        $output['cakupans'][$kode_prodi]['nasional'], 
                        $output['cakupans'][$kode_prodi]['internasional'], 
                        ''], null, "A$row");
                    $param_value = '';
                    foreach ($kegiatan as $value) {
                        $param_value .= '• ' . $value->nama_kegiatan . "\n";
                    }
                    $sheet->setCellValue('F' . $row, $param_value);
                    $sheet->getRowDimension($row)->setRowHeight(-1);
                    $sheet
                        ->getStyle('F' . $row)
                        ->getAlignment()
                        ->setWrapText(true);

                    $row++;
                    $number++;
                }
            }

            $max_row = $sheet->getHighestRow();
            $max_colomn = $sheet->getHighestColumn();
            $sheet->getColumnDimension('A')->setWidth(34);
            $sheet->getColumnDimension('B')->setWidth(12);
            $sheet->getColumnDimension('C')->setWidth(12);
            $sheet->getColumnDimension('D')->setWidth(12);
            $sheet->getColumnDimension('E')->setWidth(12);
            $sheet->getColumnDimension('F')->setWidth(66);

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
}
