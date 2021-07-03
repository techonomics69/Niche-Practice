<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChangeStatTrackingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stat_tracking', function (Blueprint $table) {
            $table->integer('google_analytics_id')->unsigned()->nullable()->after('social_media_id');
            $table->foreign('google_analytics_id')->references('id')->on('google_analytics_master');

//            $table->enum('type', ['LK','RV','RG','PV'])->nullable()->change();
//            $table->enum('site_type', ['Tripadvisor', 'Yelp', 'Google Places', 'Facebook','GoogleAnalytics'])->nullable()->change();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stat_tracking', function ($table) {
            $table->dropColumn('google_analytics_id');
        });
    }
}
