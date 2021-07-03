<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMarketingProServices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marketing_pro_services', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->nullable();
            $table->string('thumbnail')->nullable();
            $table->tinyInteger('priority')->nullable();
            $table->tinyInteger('sys_status')->nullable();
            $table->text('description')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('marketing_pro_services');
    }
}
