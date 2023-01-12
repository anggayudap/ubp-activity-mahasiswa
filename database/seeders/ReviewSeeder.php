<?php

namespace Database\Seeders;

use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('reviews')->insert([
            'teks_review' => 'Ketajaman, Kebaruan, Orisinalitas',
            'deskripsi_review' => null,
            'aktif' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => null,
        ]);
        DB::table('reviews')->insert([
            'teks_review' => 'Ketepatan, Kesesuaian dengan masalah',
            'deskripsi_review' => null,
            'aktif' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => null,
        ]);
        DB::table('reviews')->insert([
            'teks_review' => 'Publikasi Ilmiah, Pengembangan Iptek, Pengayaan Bahan Ajar',
            'deskripsi_review' => null,
            'aktif' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => null,
        ]);
        DB::table('reviews')->insert([
            'teks_review' => 'Relevansi, Kemutakhiran, Penyusunan',
            'deskripsi_review' => null,
            'aktif' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => null,
        ]);
    }
}
