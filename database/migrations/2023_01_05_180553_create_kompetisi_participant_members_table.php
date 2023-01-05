<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKompetisiParticipantMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kompetisi_participant_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('participant_id')->nullable();
            $table->string('nim', 20);
            $table->string('nama_mahasiswa')->nullable();
            $table->string('prodi', 10)->nullable();
            $table->enum('status_keanggotaan', array('ketua','anggota'))->default('ketua');
            $table->timestamps();

            $table
                ->foreign('participant_id')
                ->references('id')
                ->on('kompetisi_participants')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kompetisi_participant_members');
    }
}
