<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKegiatansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kegiatans', function (Blueprint $table) {
            $table->id();
            $table->string('nim', 20);
            $table->string('nama_mahasiswa');
            $table->string('prodi', 10);
            $table->foreignId('periode_id')->nullable();
            $table->year('tahun_periode');
            $table->string('nama_kegiatan');
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_akhir')->nullable();
            $table->foreignId('klasifikasi_id');
            $table->text('surat_tugas')->nullable();
            $table->text('foto_kegiatan')->nullable();
            $table->text('url_event')->nullable();
            $table->text('url_publikasi')->nullable();
            $table->text('bukti_kegiatan')->nullable();
            $table->text('keterangan')->nullable();
            $table->string('prestasi')->nullable();
            $table->enum('cakupan', ['lokal', 'nasional', 'internasional'])->nullable();
            $table->enum('status', ['review', 'checked_dosen', 'checked_kemahasiswaan', 'completed']);
            $table->enum('approval', ['approve', 'reject'])->nullable();
            $table->foreignId('kemahasiswaan_user_id')->nullable();
            $table->string('kemahasiswaan_user_name')->nullable();
            $table->timestamps();

            $table
                ->foreign('klasifikasi_id')
                ->references('id')
                ->on('klasifikasi_kegiatans')
                ->restrictOnUpdate()
                ->restrictOnDelete();

            $table
                ->foreign('periode_id')
                ->references('id')
                ->on('periodes')
                ->restrictOnUpdate()
                ->restrictOnDelete();

            $table
                ->foreign('kemahasiswaan_user_id')
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
        Schema::dropIfExists('kegiatans');
    }
}
