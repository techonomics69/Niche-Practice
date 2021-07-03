<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmailTemplateSavedBlock extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_templates_saved_block', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->text('definition')->nullable();
            $table->string('image')->nullable();

            $table->integer('created_by')->nullable();
            $table->integer('block_associated_template')->nullable()->comment('email_template_id');

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
