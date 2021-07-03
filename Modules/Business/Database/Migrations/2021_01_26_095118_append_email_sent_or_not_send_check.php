<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AppendEmailSentOrNotSendCheck extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('referalemails', function (Blueprint $table) {
            $table->boolean('mail_sent_to_user')->after('user_id')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('referalemails', function (Blueprint $table) {
            $table->dropColumn('mail_sent_to_user');
        });
    }
}
