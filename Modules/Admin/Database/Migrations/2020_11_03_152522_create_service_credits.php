<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceCredits extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_credits', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pro_service_id')->nullable();
            $table->string('title')->nullable();
            $table->integer('credits')->nullable();
            $table->tinyInteger('priority')->nullable();

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
        Schema::dropIfExists('service_credits');
    }
}
