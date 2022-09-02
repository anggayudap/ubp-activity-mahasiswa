<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\PeriodeSeeder;
use Database\Seeders\RoleUserSeeder;
use Database\Seeders\KlasifikasiKegiatanSeeder;

class DatabaseSeeder extends Seeder {
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run() {
        $this->call(RoleUserSeeder::class);
        $this->call(PeriodeSeeder::class);
        $this->call(KlasifikasiKegiatanSeeder::class);
    }
}
