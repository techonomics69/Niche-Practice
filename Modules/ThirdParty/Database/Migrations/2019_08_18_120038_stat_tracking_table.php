<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class StatTrackingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stat_tracking', function (Blueprint $table) {
            $table->increments('stat_id');

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->integer('third_party_id')->unsigned()->nullable();
            $table->foreign('third_party_id')->references('third_party_id')->on('third_party_master')->onDelete('cascade');;

            // foreign relationship of users table.
            $table->integer('social_media_id')->unsigned()->nullable();
            $table->foreign('social_media_id')->references('id')->on('social_media_master')->onDelete('cascade');;

            $table->integer('google_analytics_id')->unsigned()->nullable();
            $table->foreign('google_analytics_id')->references('id')->on('google_analytics_master');

            $table->enum('type', ['LK','RV','RG','PV','RR','CU','TP','EP','FP','PA','TR','PE','SP'])->nullable();
            $table->enum('site_type', ['Tripadvisor','Yelp','Google Places','Facebook','Googleanalytics','CRM'])->nullable();

            $table->integer('count')->unsigned()->nullable();
            $table->string('activity_date',255)->nullable();
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
        Schema::dropIfExists('stat_tracking');
    }
}
