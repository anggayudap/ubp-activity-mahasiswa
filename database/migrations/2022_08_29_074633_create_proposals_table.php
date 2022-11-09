<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProposalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proposals', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('nim', 20);
            $table->string('nama_mahasiswa');
            $table->string('prodi', 10);
            $table->string('judul_proposal');
            $table->string('ketua_pelaksana');
            $table->double('anggaran_pengajuan', 10, 0);
            $table->string('file_proposal');
            $table->enum('current_status', ['pending', 'reject', 'completed'])->nullable();
            $table->enum('next_approval', ['fakultas', 'kemahasiswaan', 'completed'])->nullable();
            $table->foreignId('fakultas_user_id')->nullable();
            $table->string('fakultas_user_name')->nullable();
            $table->foreignId('kemahasiswaan_user_id')->nullable();
            $table->string('kemahasiswaan_user_name')->nullable();
            $table->dateTime('fakultas_approval_date')->nullable();
            $table->tinyInteger('rejected_fakultas')->default(0);
            $table->dateTime('kemahasiswaan_approval_date')->nullable();
            $table->tinyInteger('rejected_kemahasiswaan')->default(0);
            $table->dateTime('rektor_approval_date')->nullable();
            $table->tinyInteger('is_editable')->default(0);
            $table->string('reject_note')->nullable();
            $table->timestamps();

            $table
                ->foreign('fakultas_user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('no action')
                ->onDelete('no action');

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
        Schema::dropIfExists('proposals');
    }
}
