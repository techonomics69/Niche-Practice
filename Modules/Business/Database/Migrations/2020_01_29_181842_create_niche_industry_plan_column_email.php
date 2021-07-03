<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNicheIndustryPlanColumnEmail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('email_templates', function($table) {
            $table->integer('industry')->nullable();
            $table->integer('niche')->nullable();
            $table->integer('plan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('email_templates', function ($table) {
            $table->dropColumn('industry');
            $table->dropColumn('niche');
            $table->dropColumn('plan');
        });
    }
}
