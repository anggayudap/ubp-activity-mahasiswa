<?php

namespace Database\Seeders;

use App\Models\Periode;
use Illuminate\Database\Seeder;

class PeriodeSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $periode_array = [
            [
                'periode_awal' => 'September',
                'periode_akhir' => 'November',
                'range_bulan' => '["9","10","11"]',
            ],
            [
                'periode_awal' => 'Desember',
                'periode_akhir' => 'Februari',
                'range_bulan' => '["12","1","2"]',
            ],
            [
                'periode_awal' => 'Maret',
                'periode_akhir' => 'Mei',
                'range_bulan' => '["3","4","5"]',
            ],
            [
                'periode_awal' => 'Juni',
                'periode_akhir' => 'Agustus',
                'range_bulan' => '["6","7","8"]',
            ],
        ];

        Periode::insert($periode_array);
    }
}
