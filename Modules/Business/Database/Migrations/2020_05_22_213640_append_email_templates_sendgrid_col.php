<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AppendEmailTemplatesSendgridCol extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('email_templates', function (Blueprint $table) {
            $table->string('list_id')->nullable()->after('schedule_at');
            $table->string('list_name')->nullable()->after('list_id');

            $table->string('single_send_id')->nullable()->after('list_name');
            $table->string('single_send_name')->nullable()->after('single_send_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('email_templates', function (Blueprint $table) {
            $table->dropColumn('list_id');
            $table->dropColumn('list_name');
            $table->dropColumn('single_send_id');
            $table->dropColumn('single_send_name');
        });
    }
}
