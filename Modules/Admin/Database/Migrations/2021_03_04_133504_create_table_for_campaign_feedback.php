<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableForCampaignFeedback extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaign_feedback', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('star_rating')->default(0);
            $table->string('comment')->nullable();
            $table->integer('category')->nullable()->unsigned();
            $table->foreign('category')->references('id')->on('category');
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
        Schema::dropIfExists('campaign_feedback');
    }
}
