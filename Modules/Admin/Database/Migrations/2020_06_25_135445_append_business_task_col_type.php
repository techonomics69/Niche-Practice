<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AppendBusinessTaskColType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('business_task', function (Blueprint $table) {
            $table->string('type')->nullable()->after('due_date');
            $table->date('available_clickable_at')->nullable()->after('type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('business_task', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->dropColumn('available_clickable_at');
        });
    }
}
