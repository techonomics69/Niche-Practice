<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIframeRecordColumnBusiness extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('business_master', function($table) {
            $table->string('is_iframe_loaded')->nullable()->after('niche_id');
            $table->string('user_agent')->nullable()->after('niche_id');
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
            $table->dropColumn('is_iframe_loaded');
            $table->dropColumn('user_agent');
        });
    }
}
