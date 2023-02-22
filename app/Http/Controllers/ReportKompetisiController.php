<?php

namespace App\Http\Controllers;

use App\Models\Prodi;
use App\Models\Periode;
use App\Models\Kegiatan;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use App\Models\KlasifikasiKegiatan;
use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\KompetisiParticipant;
use Illuminate\Database\Eloquent\Builder;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class ReportKompetisiController extends Controller
{
    protected $spreadsheet;

    public function __construct()
    {
        $this->spreadsheet = new Spreadsheet();
    }

    public function index()
    {
        $fetch_mahasiswa = Mahasiswa::select('id', 'nim', 'nama_mahasiswa')->get();
        $fetch_dosen = Dosen::select('id', 'nip', 'nama')->get();

        if ($fetch_mahasiswa->count() > 0) {
            $collection = collect($fetch_mahasiswa);
            $data['mahasiswa'] = $collection->keyBy('nim')->all();
        }
        if ($fetch_dosen->count() > 0) {
            $collection = collect($fetch_dosen);
            $data['dosen'] = $collection->keyBy('nip')->all();
        }

        return view('report.kompetisi.index', compact('data'));
    }

    public function submit(Request $request)
    {
        //     "_token" => "CUurvuI1a7KBQK4irmCJGP0Pfba9hlxaTu4zb3tB"
        //   "type" => "detail_kompetisi"
        //   "nim" => "18416274201009"
        //   "dosen_pembimbing" => "all"
        //   "dosen_penilai" => "all"
        //   "status" => array:1 [▼
        //     0 => "reviewed"
        //   ]
        //   "kompetisi_date_start" => "2023-02-04"
        //   "kompetisi_date_end" => "2023-02-04"
        //   "submit" => "view"

        $validated = $request->validate([
            'type' => 'required|in:detail_kompetisi,detail_review',
            'nim' => 'required', // all
            'dosen_pembimbing' => 'required', // all
            'dosen_penilai' => 'required', // all
            'kompetisi_date_start' => 'required|date_format:Y-m-d',
            'kompetisi_date_end' => 'required|date_format:Y-m-d',
            'status' => 'required|array',
            'submit' => 'required',
        ]);
        // dd($request);

        if ($request->type == 'detail_kompetisi') {
            return $this->detail_kompetisi($request);
        } elseif ($request->type == 'detail_review') {
            return $this->detail_review($request);
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

    private function detail_kompetisi($request)
    {
        $query = KompetisiParticipant::with(['kompetisi', 'member.prodi_mahasiswa'])
            ->whereIn('status', $request->status)
            ->whereBetween('created_at', [$request->kompetisi_date_start, $request->kompetisi_date_end]);

        if ($request->nim != 'all') {
            $query->whereHas('member', function (Builder $query_builder) use ($request) {
                $query_builder->where('nim', $request->nim);
            });
        }

        if ($request->dosen_pembimbing != 'all') {
            $query->where('nip_dosen_pembimbing', $request->dosen_pembimbing);
        }

        if ($request->dosen_penilai != 'all') {
            $query->where('nip_dosen_penilai', $request->dosen_penilai);
        }

        $output['result'] = $query->orderBy('created_at', 'DESC')->get();

        if ($request->submit == 'view') {
            return view('report.kompetisi.table_detail_kompetisi', compact('output'));
        } elseif ($request->submit == 'export') {
            $this->spreadsheet->setActiveSheetIndex(0);
            $sheet = $this->spreadsheet->getActiveSheet();

            $sheet->setCellValue('A1', 'Report' . ' :: ' . 'Detail Kompetisi');
            $header = ['NO', 'NAMA KOMPETISI', 'SKEMA KOMPETISI', 'JUDUL KOMPETISI PENILAIAN', 'NIDN PEMBIMBING', 'DOSEN PEMBIMBING', 'NAMA KETUA', 'PRODI', 'NAMA ANGGOTA', 'FILE', 'NIDN PENILAI', 'DOSEN PENILAI', 'CATATAN', 'TANGGAL APPROVAL', 'NAMA APPROVAL', 'STATUS', 'KEPUTUSAN'];

            for ($i = 1; $i <= 17; $i++) {
                $sheet->setCellValueByColumnAndRow($i, 3, $header[$i - 1]);
            }

            $row = 4;

            if ($output['result']) {
                $number = 1;
                foreach ($output['result'] as $kompetisi) {
                    $member_ketua = $kompetisi->member->filter(function ($value, $key) {
                        return $value->status_keanggotaan == 'ketua';
                    });
                    $member_ketua->all();
                    $member_ketua = $member_ketua->first();

                    $member_anggota = $kompetisi->member->filter(function ($value, $key) {
                        return $value->status_keanggotaan == 'anggota';
                    });
                    $member_anggota = $member_anggota->all();

                    $name_anggota = '';
                    foreach ($member_anggota as $anggota) {
                        $name_anggota .= $anggota->nama_mahasiswa . ' (' . $anggota->nim . ')' . ', ';
                    }

                    $sheet->fromArray([$number, $kompetisi->kompetisi->nama_kompetisi, $kompetisi->nama_skema, $kompetisi->judul, $kompetisi->nidn_dosen_pembimbing, $kompetisi->nama_dosen_pembimbing . ' (' . $kompetisi->nip_dosen_pembimbing . ')', $member_ketua->nama_mahasiswa . ' (' . $member_ketua->nim . ')', ($member_ketua->prodi_mahasiswa) ? $member_ketua->prodi_mahasiswa->nama_prodi : $member_ketua->prodi, $name_anggota, asset($kompetisi->file_upload), $kompetisi->nidn_dosen_penilai, $kompetisi->nama_dosen_penilai . ' (' . $kompetisi->nip_dosen_penilai . ')', $kompetisi->catatan, get_indo_date($kompetisi->tanggal_approval), $kompetisi->nama_approval, $kompetisi->status, $kompetisi->keputusan], null, "A$row");
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

            $sheet
                ->getStyle('A3:' . $max_colomn . $max_row)
                ->getAlignment()
                ->setWrapText(true);

            $sheet->getStyle('A3:' . $max_colomn . $max_row)->applyFromArray([
                'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, 'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER],
                'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]],
            ]);

            return $this->export_excel($request->type . '::detail_kompetisi');
        }
    }

    private function detail_review($request)
    {
        $query = KompetisiParticipant::with(['kompetisi', 'member.prodi_mahasiswa', 'review'])
            ->whereIn('status', $request->status)
            ->whereBetween('created_at', [$request->kompetisi_date_start, $request->kompetisi_date_end]);

        if ($request->nim != 'all') {
            $query->whereHas('member', function (Builder $query_builder) use ($request) {
                $query_builder->where('nim', $request->nim);
            });
        }

        if ($request->dosen_pembimbing != 'all') {
            $query->where('nip_dosen_pembimbing', $request->dosen_pembimbing);
        }

        if ($request->dosen_penilai != 'all') {
            $query->where('nip_dosen_penilai', $request->dosen_penilai);
        }

        $output['result'] = $query->orderBy('created_at', 'DESC')->get();

        if ($request->submit == 'view') {
            return view('report.kompetisi.table_detail_review', compact('output'));
        } elseif ($request->submit == 'export') {
            $this->spreadsheet->setActiveSheetIndex(0);
            $sheet = $this->spreadsheet->getActiveSheet();

            $sheet->setCellValue('A1', 'Report' . ' :: ' . 'Detail Review');
            $header = ['NO', 'NAMA KOMPETISI', 'SKEMA KOMPETISI', 'JUDUL KOMPETISI PENILAIAN', 'DOSEN PEMBIMBING', 'NAMA KETUA', 'PRODI', 'NAMA ANGGOTA', 'FILE', 'DOSEN PENILAI', 'ASPEK REVIEW', 'PENILAIAN REVIEW'];

            for ($i = 1; $i <= 12; $i++) {
                $sheet->setCellValueByColumnAndRow($i, 3, $header[$i - 1]);
            }

            $row = 4;

            if ($output['result']) {
                $number = 1;
                foreach ($output['result'] as $kompetisi) {
                    $member_ketua = $kompetisi->member->filter(function ($value, $key) {
                        return $value->status_keanggotaan == 'ketua';
                    });
                    $member_ketua->all();
                    $member_ketua = $member_ketua->first();

                    $member_anggota = $kompetisi->member->filter(function ($value, $key) {
                        return $value->status_keanggotaan == 'anggota';
                    });
                    $member_anggota = $member_anggota->all();

                    $name_anggota = '';
                    foreach ($member_anggota as $anggota) {
                        $name_anggota .= $anggota->nama_mahasiswa . ' (' . $anggota->nim . ')' . ', ';
                    }

                    $total = $kompetisi->review->count();
                    foreach ($kompetisi->review as $index => $review) {
                        if ($index > 0) {
                            $sheet->fromArray([null, null, null, null, null, null, null, null, null, null, $review->teks_review, $review->skor_review], null, "A$row");
                        } else {
                            $sheet->fromArray([$number, $kompetisi->kompetisi->nama_kompetisi, $kompetisi->nama_skema, $kompetisi->judul, $kompetisi->nama_dosen_pembimbing . ' (' . $kompetisi->nip_dosen_pembimbing . ')', $member_ketua->nama_mahasiswa . ' (' . $member_ketua->nim . ')', ($member_ketua->prodi_mahasiswa) ? $member_ketua->prodi_mahasiswa->nama_prodi : $member_ketua->prodi, $name_anggota, asset($kompetisi->file_upload), $kompetisi->nama_dosen_penilai . ' (' . $kompetisi->nip_dosen_penilai . ')', $review->teks_review, $review->skor_review], null, "A$row");
                            $sheet->mergeCells('A' . $row . ':A' . ($row + $total - 1));
                            $sheet->mergeCells('B' . $row . ':B' . ($row + $total - 1));
                            $sheet->mergeCells('C' . $row . ':C' . ($row + $total - 1));
                            $sheet->mergeCells('D' . $row . ':D' . ($row + $total - 1));
                            $sheet->mergeCells('E' . $row . ':E' . ($row + $total - 1));
                            $sheet->mergeCells('F' . $row . ':F' . ($row + $total - 1));
                            $sheet->mergeCells('G' . $row . ':G' . ($row + $total - 1));
                            $sheet->mergeCells('H' . $row . ':H' . ($row + $total - 1));
                            $sheet->mergeCells('I' . $row . ':I' . ($row + $total - 1));
                            $sheet->mergeCells('J' . $row . ':J' . ($row + $total - 1));
                            $number++;
                        }

                        $row++;
                    }
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
            $sheet->getColumnDimension('J')->setWidth(30);
            $sheet->getColumnDimension('K')->setWidth(15);

            $sheet
                ->getStyle('A3:' . $max_colomn . $max_row)
                ->getAlignment()
                ->setWrapText(true);

            $sheet->getStyle('A3:' . $max_colomn . $max_row)->applyFromArray([
                'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, 'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER],
                'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]],
            ]);

            return $this->export_excel($request->type . '::detail_review');
        }
    }
}
