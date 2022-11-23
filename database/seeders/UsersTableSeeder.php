<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('users')->delete();
        
        \DB::table('users')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Akun Dummy',
                'user_id' => '397',
                'email' => 'dummy@ptk.ubpkarawang.ac.id',
                'email_verified_at' => NULL,
                'password' => '$2y$10$kqYqM/sbvu3l.3NHxwOSnOqs7SFwdLqyS/mWUx1kp1vciHD.upE/2',
                'remember_token' => NULL,
                'last_login_at' => '2022-11-23 12:49:18',
                'last_login_ip' => '::1',
                'created_at' => '2022-11-14 14:25:55',
                'updated_at' => '2022-11-23 12:49:18',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'RAY NANDA PAMUNGKAS',
                'user_id' => '18416255201166',
                'email' => 'if18.raypamungkas@mhs.ubpkarawang.ac.id',
                'email_verified_at' => NULL,
                'password' => '$2y$10$0Gt4vUGT2rPRPmQ7DZza.Oa47Eb9/1XOl9CghSVHOWzkqHa85X0qq',
                'remember_token' => NULL,
                'last_login_at' => '2022-11-23 15:34:09',
                'last_login_ip' => '::1',
                'created_at' => '2022-11-23 12:58:00',
                'updated_at' => '2022-11-23 15:34:09',
            ),
        ));
        
        
    }
}