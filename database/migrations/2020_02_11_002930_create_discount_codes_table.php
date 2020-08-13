<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use \Carbon\Carbon;

class CreateDiscountCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discount_codes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique();
            $table->string('type');
            $table->integer('value');
            $table->dateTime('activation_date')->default(Carbon::now());
            $table->dateTime('expiration_date');
            $table->boolean('public')->default(false);
            $table->softDeletes();
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
        Schema::dropIfExists('discount_codes');
    }
}
