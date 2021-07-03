<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserSendgridLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_sendgrid_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');

            $table->string('job_id')->nullable();
            $table->string('source')->nullable();
            $table->text('logs')->nullable();

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
        Schema::dropIfExists('user_sendgrid_logs');
    }
}
