<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKompetisiParticipantReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kompetisi_participant_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('participant_id');
            $table->foreignId('review_id');
            $table->string('teks_review')->nullable();
            $table->integer('skor_review')->nullable();
            $table->timestamps();

            $table
                ->foreign('participant_id')
                ->references('id')
                ->on('kompetisi_participants')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table
                ->foreign('review_id')
                ->references('id')
                ->on('reviews')
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
        Schema::dropIfExists('kompetisi_participant_reviews');
    }
}
