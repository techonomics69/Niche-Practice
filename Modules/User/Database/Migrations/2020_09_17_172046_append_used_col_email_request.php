<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AppendUsedColEmailRequest extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('emailrequestlogs', function($table) {
            $table->Integer('used')->default(0)->after('maximum');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('emailrequestlogs', function (Blueprint $table) {
            $table->dropColumn('used');
        });
    }
}
