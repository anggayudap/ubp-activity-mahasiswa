<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        Role::create([
            'name' => 'mahasiswa',
            'guard_name' => 'web',
        ]);

        Role::create([
            'name' => 'dosen',
            'guard_name' => 'web',
        ]);
        
        Role::create([
            'name' => 'dpm',
            'guard_name' => 'web',
        ]);

        Role::create([
            'name' => 'kemahasiswaan',
            'guard_name' => 'web',
        ]);

    }
}