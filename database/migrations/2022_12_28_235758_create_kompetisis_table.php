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
            $table->text('deskripsi_kompetisi')->nullable();
            $table->text('list_prodi')->nullable();
            $table->date('tanggal_mulai_pendaftaran');
            $table->date('tanggal_akhir_pendaftaran');
            $table->text('list_penilaian')->nullable();
            $table->tinyInteger('aktif')->default(1);
            $table->foreignId('user_id_created')->nullable();
            $table->string('user_name_created')->nullable();
            $table->timestamps();

            $table
                ->foreign('user_id_created')
                ->references('id')
                ->on('users')
                ->onUpdate('no action')
                ->onDelete('no action');
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
