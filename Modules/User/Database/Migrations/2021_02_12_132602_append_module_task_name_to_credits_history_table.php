<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AppendModuleTaskNameToCreditsHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('credits_history', function (Blueprint $table) {
            $table->string('module_task_name')->nullable()->after('module_used_credits');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('credits_history', function (Blueprint $table) {
            $table->dropColumn('module_task_name');
        });
    }
}
