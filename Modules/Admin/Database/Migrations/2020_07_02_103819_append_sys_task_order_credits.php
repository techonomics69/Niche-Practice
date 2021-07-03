<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AppendSysTaskOrderCredits extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sys_task', function($table) {
            $table->integer('credits')->nullable()->after('recurring_days');
            $table->text('credits_description')->nullable()->after('credits');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sys_task', function (Blueprint $table) {
            $table->dropColumn('credits');
            $table->dropColumn('credits_description');
        });
    }
}
