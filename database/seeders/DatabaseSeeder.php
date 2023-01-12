<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\ReviewSeeder;
use Database\Seeders\PeriodeSeeder;
use Database\Seeders\KlasifikasiKegiatanSeeder;

class DatabaseSeeder extends Seeder {
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run() {
        // $this->call(PeriodeSeeder::class);
        // $this->call(KlasifikasiKegiatanSeeder::class);
        // $this->call(RoleSeeder::class);
        $this->call(ReviewSeeder::class);

    }
}
