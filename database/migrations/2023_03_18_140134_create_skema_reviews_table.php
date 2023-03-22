<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSkemaReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('skema_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('skema_id');
            $table->foreignId('review_id')->nullable();
            $table->timestamps();

            $table
                ->foreign('skema_id')
                ->references('id')
                ->on('skemas')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table
                ->foreign('review_id')
                ->references('id')
                ->on('reviews')
                ->onUpdate('cascade')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('skema_reviews');
    }
}
