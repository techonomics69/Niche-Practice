<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AppendTaskIdToCampaignFeedbackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('campaign_feedback', function (Blueprint $table) {
            $table->integer('task')->nullable()->unsigned();
            $table->foreign('task')->references('id')->on('sys_task');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('campaign_feedback', function (Blueprint $table) {
            $table->dropColumn('task');
        });
    }
}
