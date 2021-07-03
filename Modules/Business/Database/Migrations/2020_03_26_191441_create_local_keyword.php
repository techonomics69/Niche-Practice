<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocalKeyword extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('local_keyword', function (Blueprint $table) {
            $table->increments('id');
//            $table->integer('user_id')->unsigned();
//            $table->foreign('user_id')->references('id')->on('user_master');

            $table->integer('business_id')->unsigned();
            $table->foreign('business_id')->references('business_id')->on('business_master')->onDelete('cascade');

            $table->string('keyword',100)->nullable();
            $table->integer('rank')->nullable();
            $table->string('rank_status')->nullable();
            $table->integer('volume')->nullable();
            $table->string('search_engine')->nullable();
            $table->dateTime('date')->nullable();

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
        Schema::dropIfExists('local_keyword');
    }
}
