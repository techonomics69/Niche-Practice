<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AppendEmailAndToggleValueInDb extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('business_master', function (Blueprint $table) {
            $table->string('notification_email')->after('country')->nullable();
            $table->boolean('notification_switch')->after('country')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('business_master', function (Blueprint $table) {
            $table->dropColumn('notification_email');
            $table->dropColumn('notification_switch');
        });
    }
}
