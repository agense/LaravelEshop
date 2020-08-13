<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('set null');
            $table->string('order_nr');
            $table->integer('billing_subtotal');
            $table->integer('billing_tax');
            $table->integer('billing_total');
            $table->integer('card_discount')->default(0);
            $table->string('card_discount_code')->nullable();
            $table->string('billing_name');
            $table->text('billing_details');
            $table->string('status', 20)->default('new');
            $table->dateTime('ready_at')->nullable();
            $table->dateTime('completed_at')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
