<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AppendSendgridAddCol extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_sendgrid_logs', function (Blueprint $table) {
            $table->string('list_id')->nullable()->after('logs');
            $table->integer('associated_id')->nullable()->after('list_id')->comment('any user_id or template_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_sendgrid_logs', function (Blueprint $table) {
            $table->dropColumn('list_id');
            $table->dropColumn('associated_id');
        });
    }
}
