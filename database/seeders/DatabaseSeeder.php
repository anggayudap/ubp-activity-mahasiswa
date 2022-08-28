<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\RoleUserSeeder;
use Database\Seeders\KlasifikasiKegiatanSeeder;

class DatabaseSeeder extends Seeder {
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run() {
        $this->call(KlasifikasiKegiatanSeeder::class);
        $this->call(RoleUserSeeder::class);
    }
}
