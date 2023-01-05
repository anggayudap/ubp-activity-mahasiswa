<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKompetisisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kompetisis', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kompetisi');
            $table->text('list_prodi')->nullable();
            $table->date('tanggal_buka_pendaftaran');
            $table->date('tanggal_tutup_pendaftaran');
            $table->text('list_penilaian')->nullable();
            $table->tinyInteger('aktif')->default(1);
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
        Schema::dropIfExists('kompetisis');
    }
}
