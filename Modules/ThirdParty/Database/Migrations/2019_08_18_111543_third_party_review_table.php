<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ThirdPartyReviewTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('third_party_review', function (Blueprint $table) {
            $table->increments('review_id');

            $table->integer('third_party_id')->unsigned();
            $table->foreign('third_party_id')->references('third_party_id')->on('third_party_master')->onDelete('cascade');

            $table->enum('type',['Tripadvisor', 'Google Places','Yelp'])->nullable(); //new

            $table->integer('rating')->nullable();
            $table->string('reviewer',100)->nullable();
            $table->text('message')->nullable();
            $table->string('review_url',255)->nullable();

            $table->string('review_date')->nullable(); //new
            $table->integer('is_notification_send')->nullable()->default(0); //new
            $table->string('review_unique_identifier',150)->nullable(); //new
            $table->unique('review_unique_identifier'); //new

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
        Schema::dropIfExists('third_party_review');
    }
}
