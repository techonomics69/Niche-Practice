<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AppendNicheAndIndustryInCategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('category', function (Blueprint $table) {
            $table->integer('parent')->nullable()->after('description');
            $table->integer('industry')->nullable()->after('thumbnail');
            $table->integer('niche')->nullable()->after('industry');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('category', function (Blueprint $table) {
            $table->dropColumn('parent');
            $table->dropColumn('industry');
            $table->dropColumn('niche');
        });
    }
}
