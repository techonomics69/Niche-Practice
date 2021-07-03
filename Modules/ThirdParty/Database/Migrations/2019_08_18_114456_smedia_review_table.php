<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SmediaReviewTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('smedia_review', function (Blueprint $table) {
            $table->increments('review_id');

            $table->integer('social_media_id')->unsigned();
            $table->foreign('social_media_id')->references('id')->on('social_media_master')->onDelete('cascade');

            $table->integer('rating')->nullable();
            $table->string('reviewer',145)->nullable();
            $table->text('message')->nullable();
            $table->string('review_url',255)->nullable();

            $table->string ('review_date',255)->nullable(); //new

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('smedia_review');
    }
}
