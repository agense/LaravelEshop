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
            $table->string('logo')->nullable();
            $table->string('currency')->nullable();
            $table->double('tax_rate', 4, 2)->nullable();
            $table->boolean('tax_included')->default(0);
            $table->string('company_name')->nullable();
            $table->string('tax_payers_id')->nullable();
            $table->string('email_primary')->nullable();
            $table->string('email_secondary')->nullable();
            $table->string('phone_primary')->nullable();
            $table->string('phone_secondary')->nullable();
            $table->string('address')->nullable();
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
