<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KlasifikasiKegiatanSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('klasifikasi_kegiatans')->insert([
            'name_kegiatan' => 'Pertukaran Pelajar',
            'group_kegiatan' => 'MBKM',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('klasifikasi_kegiatans')->insert([
            'name_kegiatan' => 'Magang/PKL',
            'group_kegiatan' => 'MBKM',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('klasifikasi_kegiatans')->insert([
            'name_kegiatan' => 'Mengajar PLP',
            'group_kegiatan' => 'MBKM',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('klasifikasi_kegiatans')->insert([
            'name_kegiatan' => 'Penelitian',
            'group_kegiatan' => 'MBKM',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('klasifikasi_kegiatans')->insert([
            'name_kegiatan' => 'Proyek Kemanusiaan',
            'group_kegiatan' => 'MBKM',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('klasifikasi_kegiatans')->insert([
            'name_kegiatan' => 'Proyek Desa',
            'group_kegiatan' => 'MBKM',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('klasifikasi_kegiatans')->insert([
            'name_kegiatan' => 'Wirausaha',
            'group_kegiatan' => 'MBKM',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('klasifikasi_kegiatans')->insert([
            'name_kegiatan' => 'Studi Proyek Independent',
            'group_kegiatan' => 'MBKM',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('klasifikasi_kegiatans')->insert([
            'name_kegiatan' => 'Pengabdian pada Masyarakat',
            'group_kegiatan' => 'MBKM',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('klasifikasi_kegiatans')->insert([
            'name_kegiatan' => 'Rekognisi (HAKI, Pemakalah, Pemateri)',
            'group_kegiatan' => 'Non Lomba',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('klasifikasi_kegiatans')->insert([
            'name_kegiatan' => 'Pembinaan Mental (Pendidikan Norma, Etika, Karakter, dan Soft Skills)',
            'group_kegiatan' => 'Non Lomba',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('klasifikasi_kegiatans')->insert([
            'name_kegiatan' => 'Prestasi Nasional dan Internasional dan Ekstrakulikuler',
            'group_kegiatan' => 'Kegiatan Mandiri',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
    }
}
