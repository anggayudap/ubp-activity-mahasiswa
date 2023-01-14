<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKompetisiParticipantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kompetisi_participants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kompetisi_id');
            $table->bigInt('id_dosen_pembimbing')->nullable();
            $table->string('nip_dosen_pembimbing')->nullable();
            $table->string('nama_dosen_pembimbing')->nullable();
            $table->string('email_dosen_pembimbing')->nullable();
            $table->string('prodi_dosen_pembimbing', 10)->nullable();
            $table->string('judul');
            $table->year('tahun');
            $table->string('nama_skema')->nullable();
            $table->string('deskripsi_skema')->nullable();
            $table->text('file_upload')->nullable();
            $table->mediumText('review')->nullable();
            $table->text('catatan')->nullable();
            $table->dateTime('tanggal_approval')->nullable();
            $table->foreignId('user_approval')->nullable();
            $table->string('nama_approval')->nullable();
            $table->enum('keputusan', ['lolos', 'tidak_lolos'])->nullable();
            $table->enum('status', ['pending', 'reject', 'in_review', 'completed'])->default('pending');
            $table->text('note_reject')->nullable();
            $table->tinyInteger('is_editable')->default(0);
            $table->timestamps();

            $table
                ->foreign('kompetisi_id')
                ->references('id')
                ->on('kompetisis')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table
                ->foreign('user_approval')
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
        Schema::dropIfExists('kompetisi_participants');
    }
}
