<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotifications extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->increments('id');

            // foreign relationship of users table.
            $table->integer('sender'); // admin/system/superadmin
            $table->integer('receiver'); // user

            $table->text('message')->nullable();
            $table->integer('parent')->unsigned()->nullable(); //new
            $table->foreign('parent')->references('id')->on('notifications');

            $table->string('action')->nullable()->comment('reply_awaiting, set_schedule'); //new
            $table->tinyInteger('read')->default(0);  //new
            $table->integer('business_id')->nullable();

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
        Schema::dropIfExists('');
    }
}
