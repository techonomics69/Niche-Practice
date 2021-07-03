<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AppendShowTemplateInDashboardToPromotionTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('promotion_templates', function (Blueprint $table) {
            $table->boolean('show_in_dashboard')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('promotion_templates', function (Blueprint $table) {
            $table->dropColumn('show_in_dashboard');
        });
    }
}
