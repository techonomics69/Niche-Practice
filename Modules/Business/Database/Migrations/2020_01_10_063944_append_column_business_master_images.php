<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AppendColumnBusinessMasterImages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('business_master', function($table) {
            $table->string('avatar')->nullable()->after('niche_id');
            $table->string('logo')->nullable()->after('avatar');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('business_master', function($table) {
            $table->dropColumn('avatar');
            $table->dropColumn('logo');
        });
    }
}
