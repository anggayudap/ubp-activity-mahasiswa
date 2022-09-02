<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKegiatansTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('kegiatans', function (Blueprint $table) {
            $table->id();
            $table->string('nim', 20);
            $table->string('nama_mahasiswa');
            $table->foreignId('periode_id');
            $table->year('tahun_periode');
            $table->string('nama_kegiatan');
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_akhir')->nullable();
            $table->foreignId('klasifikasi_id');
            $table->text('surat_tugas')->nullable();
            $table->text('foto_kegiatan')->nullable();
            $table->text('url_event')->nullable();
            $table->text('bukti_sertifikat')->nullable();
            $table->text('keterangan')->nullable();
            $table->tinyInteger('checked_kemahasiswaan')->default(0);
            $table->tinyInteger('checked_warek')->default(0);
            $table->enum('decision_warek', ['reward', 'reprimand'])->nullable();
            $table->timestamps();

            $table->foreign('klasifikasi_id')->references('id')->on('klasifikasi_kegiatans')
                ->restrictOnUpdate()
                ->restrictOnDelete();

            $table->foreign('periode_id')->references('id')->on('periodes')
                ->restrictOnUpdate()
                ->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('kegiatans');
    }
}
