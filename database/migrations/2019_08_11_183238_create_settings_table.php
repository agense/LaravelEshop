<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('site_name')->nullable();
            $table->string('email_primary')->nullable();
            $table->string('email_secondary')->nullable();
            $table->string('phone_primary')->nullable();
            $table->string('phone_secondary')->nullable();
            $table->string('address')->nullable();
            $table->string('currency')->nullable();
            $table->string('first_slide_title')->nullable();
            $table->string('first_slide_subtitle')->nullable();
            $table->string('first_slide_btn_text')->nullable();
            $table->string('first_slide_btn_link')->nullable();
            $table->string('second_slide_title')->nullable();
            $table->string('second_slide_subtitle')->nullable();
            $table->string('second_slide_btn_text')->nullable();
            $table->string('second_slide_btn_link')->nullable();
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
        Schema::dropIfExists('settings');
    }
}
