<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@email.com',
            'password' => bcrypt('12345678'),
        ]);
        $admin->assignRole('admin');

        $mahasiswa = User::create([
            'name' => 'Mahasiswa',
            'email' => 'mhs@email.com',
            'password' => bcrypt('12345678'),
        ]);
        $mahasiswa->assignRole('mahasiswa');

        $dosen = User::create([
            'name' => 'Dosen',
            'email' => 'dosen@email.com',
            'password' => bcrypt('12345678'),
        ]);
        $dosen->assignRole('dosen');

        $warek = User::create([
            'name' => 'Warek',
            'email' => 'warek@email.com',
            'password' => bcrypt('12345678'),
        ]);
        $warek->assignRole('warek');
    }
}