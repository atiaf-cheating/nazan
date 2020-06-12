<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    public $table = 'orders';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'status',
        'merchant_id',
        'customer_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'city_id',
        'parent_city_id',
        'city_arabic_name',
        'city_english_name',
        'delivery_price',
        'street',
        'building_number',
        'coupon_code',
        'coupon_discount_percentage',
        'coupon_expiry_date',
        'paymentMethod_id',
    ];

    public function orderProducts()
    {
        return $this->hasMany('App\OrderProduct');
    }

    public function paymentMethod()
    {
        return $this->hasOne('App\PaymentMethod');
    }
}
