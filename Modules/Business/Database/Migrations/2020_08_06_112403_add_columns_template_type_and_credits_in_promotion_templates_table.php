<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsTemplateTypeAndCreditsInPromotionTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('promotion_templates', function (Blueprint $table) {
            $table->string('template_type')->nullable()->default(1);
            $table->integer('credits')->nullable();
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
            $table->dropColumn('template_type');
            $table->dropColumn('credits');
        });
    }
}
