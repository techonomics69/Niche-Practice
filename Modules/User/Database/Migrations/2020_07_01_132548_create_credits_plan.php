<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCreditsPlan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('credits_plan', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name')->nullable();
            $table->string('price_id')->nullable();
            $table->string('product_id')->nullable();
            $table->double('price')->nullable();
            $table->double('credit_rate')->nullable();
            $table->integer('qty')->nullable();
            $table->decimal('credits_of_this')->nullable();

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
        Schema::dropIfExists('credits_plan');
    }
}
