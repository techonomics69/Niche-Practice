<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromotionDeleteColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('promotion_templates', function (Blueprint $table) {
            $table->integer('industry')->nullable();
            $table->integer('niche')->nullable();
            $table->integer('is_deleted')->default(0)->after('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('promotion_templates', function ($table) {
            $table->dropColumn('industry');
            $table->dropColumn('niche');
            $table->dropColumn('is_deleted');
        });
    }
}
