<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateColumnDeactivateUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function($table) {
            $table->string('account_status', 20)->nullable()->after('remember_token');
            $table->string('leaving_subject')->nullable()->after('account_status');
            $table->string('leaving_note')->nullable()->after('leaving_subject');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function($table) {
            $table->dropColumn('account_status');
            $table->dropColumn('leaving_subject');
            $table->dropColumn('leaving_note');
        });
    }
}
