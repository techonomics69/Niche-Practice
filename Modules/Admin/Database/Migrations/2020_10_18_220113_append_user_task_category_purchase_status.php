<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AppendUserTaskCategoryPurchaseStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_task_category', function (Blueprint $table) {
            $table->string('purchase_status')->nullable()->after('is_unlocked');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_task_category', function (Blueprint $table) {
            $table->dropColumn('purchase_status');
        });
    }
}
