<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOnboardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('onboard_steps', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name')->nullable();
            $table->text('description')->nullable();

            $table->tinyInteger('step')->nullable();
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
        Schema::dropIfExists('onboard_steps');
    }
}
