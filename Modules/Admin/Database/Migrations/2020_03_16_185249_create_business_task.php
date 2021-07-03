<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusinessTask extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business_task', function (Blueprint $table) {
            $table->increments('business_task_id');
            $table->string('status',10)->default('open');

            // foreign relationship of users table.
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');

            // foreign relationship of users table.
            $table->integer('task_id')->unsigned();
            $table->foreign('task_id')->references('id')->on('sys_task');

            $table->timestamp('due_date')->nullable(); //new

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
        Schema::dropIfExists('business_task');
    }
}
