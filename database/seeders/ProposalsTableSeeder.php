<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProposalsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('proposals')->delete();
        
        \DB::table('proposals')->insert(array (
            0 => 
            array (
                'id' => 1,
                'date' => '2022-11-23',
                'nim' => '18416255201166',
                'nama_mahasiswa' => 'RAY NANDA PAMUNGKAS',
                'prodi' => '55201',
                'judul_proposal' => 'Numquam rerum blandi',
                'ketua_pelaksana' => 'Minim quam est aperi',
                'anggaran_pengajuan' => 1200000.0,
                'file_proposal' => 'upload/file_proposal/202211231654-bQhUpyn.pdf',
                'current_status' => 'reject',
                'next_approval' => 'kemahasiswaan',
                'fakultas_user_id' => 1,
                'fakultas_user_name' => 'Akun Dummy',
                'kemahasiswaan_user_id' => NULL,
                'kemahasiswaan_user_name' => NULL,
                'fakultas_approval_date' => '2022-11-23 17:29:51',
                'rejected_fakultas' => 0,
                'kemahasiswaan_approval_date' => NULL,
                'rejected_kemahasiswaan' => 1,
                'rektor_approval_date' => NULL,
                'is_editable' => 1,
                'reject_note' => 'tydac jelas',
                'created_at' => '2022-11-23 16:54:46',
                'updated_at' => '2022-11-23 17:31:46',
            ),
            1 => 
            array (
                'id' => 2,
                'date' => '2022-11-23',
                'nim' => '18416255201166',
                'nama_mahasiswa' => 'RAY NANDA PAMUNGKAS',
                'prodi' => '55201',
                'judul_proposal' => 'Numquam rerum blandi',
                'ketua_pelaksana' => 'Minim quam est aperi',
                'anggaran_pengajuan' => 1200000.0,
                'file_proposal' => 'upload/file_proposal/202211231654-bQhUpyn.pdf',
                'current_status' => 'completed',
                'next_approval' => 'completed',
                'fakultas_user_id' => 1,
                'fakultas_user_name' => 'Akun Dummy',
                'kemahasiswaan_user_id' => 1,
                'kemahasiswaan_user_name' => 'Akun Dummy',
                'fakultas_approval_date' => '2022-11-23 17:30:04',
                'rejected_fakultas' => 0,
                'kemahasiswaan_approval_date' => '2022-11-23 17:32:06',
                'rejected_kemahasiswaan' => 0,
                'rektor_approval_date' => NULL,
                'is_editable' => 0,
                'reject_note' => NULL,
                'created_at' => '2022-11-23 16:54:46',
                'updated_at' => '2022-11-23 17:32:06',
            ),
        ));
        
        
    }
}