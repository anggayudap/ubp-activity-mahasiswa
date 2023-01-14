<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDosenPenilaiColumnOnKompetisiParticipantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kompetisi_participants', function (Blueprint $table) {
            $table->bigInt('id_dosen_penilai')->nullable()->after('file_upload');
            $table->string('nip_dosen_penilai')->nullable()->after('id_dosen_penilai');
            $table->string('nama_dosen_penilai')->nullable()->after('nip_dosen_penilai');
            $table->string('email_dosen_penilai')->nullable()->after('nama_dosen_penilai');
            $table->string('prodi_dosen_penilai', 10)->nullable()->after('email_dosen_penilai');
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
            $table->dropColumn('id_dosen_penilai');
            $table->dropColumn('nip_dosen_penilai');
            $table->dropColumn('nama_dosen_penilai');
            $table->dropColumn('email_dosen_penilai');
            $table->dropColumn('prodi_dosen_penilai');
        });
    }
}
