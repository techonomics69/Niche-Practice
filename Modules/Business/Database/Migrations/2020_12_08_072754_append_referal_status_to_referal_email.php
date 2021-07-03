<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AppendReferalStatusToReferalEmail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('referalemails', function (Blueprint $table) {
            $table->boolean('onboarding_status')->default(0);

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
            $table->dropColumn('onboarding_status');
        });
    }
}
