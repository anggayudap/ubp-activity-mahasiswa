<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKompetisiSkemasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kompetisi_skemas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kompetisi_id');
            $table->foreignId('skema_id');
            $table->string('nama_skema');
            $table->timestamps();

            $table
            ->foreign('kompetisi_id')
            ->references('id')
            ->on('kompetisis')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table
            ->foreign('skema_id')
            ->references('id')
            ->on('skemas')
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
        Schema::dropIfExists('kompetisi_skemas');
    }
}
