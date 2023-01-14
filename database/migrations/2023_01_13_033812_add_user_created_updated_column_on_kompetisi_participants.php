<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserCreatedUpdatedColumnOnKompetisiParticipants extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kompetisi_participants', function (Blueprint $table) {
            $table->bigInteger('user_created')->nullable()->after('is_editable');
            $table->bigInteger('user_updated')->nullable()->after('user_created');
            
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
            $table->dropColumn('user_created');
            $table->dropColumn('user_updated');
        });
    }
}
