<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->bigIncrements('id');
            $table->integer('status');
            $table->integer('customer_id');
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone');
            $table->integer('city_id');
            $table->integer('parent_city_id');
            $table->string('city_arabic_name');
            $table->string('city_english_name');
            $table->string('delivery_price');
            $table->string('street');
            $table->string('building_number');
            $table->string('coupon_code');
            $table->float('coupon_discount_percentage');
            $table->date('coupon_expiry_date');
            $table->integer('paymentMethod_id');
            $table->timestamps();
            $table->softDeletes();
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
