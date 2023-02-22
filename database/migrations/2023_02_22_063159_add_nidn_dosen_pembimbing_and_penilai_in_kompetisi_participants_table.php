<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNidnDosenPembimbingAndPenilaiInKompetisiParticipantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kompetisi_participants', function (Blueprint $table) {
            $table->string('nidn_dosen_pembimbing')->nullable()->after('nip_dosen_pembimbing');
            $table->string('nidn_dosen_penilai')->nullable()->after('nip_dosen_penilai');            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kompetisi_participants', function (Blueprint $table) {
            $table->dropColumn('nidn_dosen_pembimbing');
            $table->dropColumn('nidn_dosen_penilai');
        });
    }
}
