<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTemplateType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('template_type', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->tinyInteger('priority')->nullable();
            $table->string('status')->default(1)->comment('1=active, 0=inactive');;
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
        Schema::dropIfExists('template_type');
    }
}
