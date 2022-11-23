<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class KegiatansTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('kegiatans')->delete();
        
        \DB::table('kegiatans')->insert(array (
            0 => 
            array (
                'id' => 1,
                'nim' => '18416255201166',
                'nama_mahasiswa' => 'RAY NANDA PAMUNGKAS',
                'prodi' => '55201',
                'periode_id' => 1,
                'tahun_periode' => 2022,
                'nama_kegiatan' => 'Meneliti hewan melata',
                'tanggal_mulai' => '2022-11-01',
                'tanggal_akhir' => '2022-11-30',
                'klasifikasi_id' => 4,
                'surat_tugas' => 'upload/surat_tugas/202211231308-p3PKfuP.jpg',
                'foto_kegiatan' => 'upload/foto_kegiatan/202211231308-vLgzRAu.jpg',
                'url_event' => 'https://www.event.co.id',
                'bukti_kegiatan' => 'upload/bukti_kegiatan/202211231308-7skgtpl.jpg',
                'keterangan' => 'bagus',
                'prestasi' => NULL,
                'cakupan' => 'nasional',
                'status' => 'completed',
                'approval' => 'approve',
                'kemahasiswaan_user_id' => 1,
                'kemahasiswaan_user_name' => 'Akun Dummy',
                'created_at' => '2022-11-23 13:08:32',
                'updated_at' => '2022-11-23 14:55:02',
            ),
            1 => 
            array (
                'id' => 2,
                'nim' => '17416261201304',
                'nama_mahasiswa' => 'SAKINAH',
                'prodi' => '0',
                'periode_id' => 1,
                'tahun_periode' => 2022,
                'nama_kegiatan' => 'Possimus blanditiis',
                'tanggal_mulai' => '2022-11-01',
                'tanggal_akhir' => '2022-11-02',
                'klasifikasi_id' => 9,
                'surat_tugas' => 'upload/surat_tugas/202211231636-OJTFgzW.jpg',
                'foto_kegiatan' => 'upload/foto_kegiatan/202211231636-XKMOJ5C.jpg',
                'url_event' => 'https://www.event.co.id',
                'bukti_kegiatan' => 'upload/bukti_kegiatan/202211231636-5uZc4Ry.jpg',
                'keterangan' => 'Ipsum fugit molest',
                'prestasi' => 'Eu mollitia non labo',
                'cakupan' => 'internasional',
                'status' => 'completed',
                'approval' => 'reject',
                'kemahasiswaan_user_id' => 1,
                'kemahasiswaan_user_name' => 'Akun Dummy',
                'created_at' => '2022-11-23 16:36:16',
                'updated_at' => '2022-11-23 16:37:08',
            ),
            2 => 
            array (
                'id' => 3,
                'nim' => '16416226201117',
                'nama_mahasiswa' => 'RAHMAT HIDAYATULLAH',
                'prodi' => '26201',
                'periode_id' => NULL,
                'tahun_periode' => 2022,
                'nama_kegiatan' => 'Exercitationem nostr',
                'tanggal_mulai' => '2022-11-23',
                'tanggal_akhir' => '2022-11-30',
                'klasifikasi_id' => 8,
                'surat_tugas' => 'upload/surat_tugas/202211231641-8110ulS.pdf',
                'foto_kegiatan' => 'upload/foto_kegiatan/202211231641-WBQ5PgP.pdf',
                'url_event' => 'https://www.event.co.id',
                'bukti_kegiatan' => 'upload/bukti_kegiatan/202211231641-idUqcrH.pdf',
                'keterangan' => 'Est id veniam et v',
                'prestasi' => 'Omnis eum excepteur',
                'cakupan' => 'lokal',
                'status' => 'checked_kemahasiswaan',
                'approval' => NULL,
                'kemahasiswaan_user_id' => NULL,
                'kemahasiswaan_user_name' => NULL,
                'created_at' => '2022-11-23 16:41:09',
                'updated_at' => '2022-11-23 16:41:17',
            ),
        ));
        
        
    }
}