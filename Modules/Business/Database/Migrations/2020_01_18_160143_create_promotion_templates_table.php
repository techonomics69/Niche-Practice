<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromotionTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promotion_templates', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->string('title')->nullable();
            $table->string('subject')->nullable();
            $table->longText('response')->nullable();
            $table->longText('template_preview')->nullable();
            $table->string('thumbnail')->nullable();

            $table->integer('template_linked_id')->nullable();
            $table->string('step_status')->nullable();
            $table->string('from')->nullable();
            $table->string('reply_email')->nullable();
            $table->string('status')->nullable();
            $table->dateTIme('schedule_at')->nullable();

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
        Schema::dropIfExists('promotion_templates');
    }
}
