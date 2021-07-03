<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSendgridEventLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sendgrid_event_logs', function (Blueprint $table) {
            $table->increments('id');

            $table->string('event')->nullable();
            $table->string('email')->nullable();
            $table->string('sg_event_id')->nullable();

            $table->integer('recipient_id')->nullable();
            $table->string('event_target_id')->nullable()->comment('single_send_id');
            $table->string('event_source_name')->nullable()->comment('single_send_name');
            $table->string('event_source')->nullable()->comment('single_send, review');

            $table->string('sg_message_id')->nullable();
            $table->string('sg_template_id')->nullable();
            $table->string('category')->nullable();
            $table->string('unique_arg')->nullable();

            $table->text('response_meta')->nullable();

            $table->string('timestamp')->nullable();

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
        Schema::dropIfExists('sendgrid_event_logs');
    }
}
