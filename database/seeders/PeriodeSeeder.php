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
            ],
            [
                'periode_awal' => 'Desember',
                'periode_akhir' => 'Februari',
            ],
            [
                'periode_awal' => 'Maret',
                'periode_akhir' => 'Mei',
            ],
            [
                'periode_awal' => 'Juni',
                'periode_akhir' => 'Agustus',
            ],
        ];

        Periode::insert($periode_array);
    }
}
