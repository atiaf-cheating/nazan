<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_product', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('order_id');
            $table->integer('product_id');
            $table->string('product_arabic_name');
            $table->string('product_english_name');
            $table->longText('product_description');
            $table->string('product_image_url');
            $table->integer('product_cat_id');
            $table->string('product_category_arabic_name');
            $table->string('product_category_english_name');
            $table->integer('product_parent_cat_id');
            $table->integer('product_brand_id');
            $table->string('product_brand_arabic_name');
            $table->string('product_brand_english_name');
            $table->integer('product_color_id');
            $table->string('product_color_arabic_name');
            $table->string('product_color_english_name');
            $table->integer('product_size_id');
            $table->string('product_size_arabic_name');
            $table->string('product_size_english_name');
            $table->integer('product_size_cat_id');
            $table->string('product_price');
            $table->string('product_price_discount');
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
        Schema::dropIfExists('order_product');
    }
}
