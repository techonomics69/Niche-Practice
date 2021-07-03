<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlertControllerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alert_controller', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title',255)->nullable();
            $table->longText('description')->nullable();
            $table->tinyInteger('impact')->nullable()->comment('1=Low Impact, 3=Medium Impact,5=High Impact');
            $table->tinyInteger('sys_status')->default(1)->comment('1=active, 0=inactive');

            $table->integer('category')->nullable(); //new

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
        Schema::dropIfExists('alert_controller');
    }
}
