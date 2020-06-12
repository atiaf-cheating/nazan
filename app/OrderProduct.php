<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderProduct extends Model
{
    use SoftDeletes;

    public $table = 'order_product';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'order_id',
                'product_id',
                'merchant_id',
                'product_arabic_name' ,
                'product_english_name',
                'product_description' ,
                'product_image_url' ,
                'product_cat_id' ,
                'product_category_arabic_name',
                'product_category_english_name',
                'product_parent_cat_id',
                'product_brand_id' ,
                'product_brand_arabic_name' ,
                'product_brand_english_name',
                'product_color_id',
                'product_color_arabic_name',
                'product_color_english_name',
                'product_size_id',
                'product_size_arabic_name',
                'product_size_english_name',
                'product_size_cat_id',
                'product_price' ,
                'product_price_discount',
    ];

    public function order()
    {
        return $this->belongsTo('App\Order');
    }

}
