<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDosensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dosens', function (Blueprint $table) {
            $table->id();
            $table->string('nip', 20);
            $table->string('jabatan_struktural')->nullable();
            $table->string('id_sipt')->nullable();
            $table->string('nama');
            $table->string('email')->nullable();
            $table->string('nidn', 20)->nullable();
            $table->string('singkatan')->nullable();
            $table->string('prodi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dosens');
    }
}
