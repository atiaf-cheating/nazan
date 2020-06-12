<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    use SoftDeletes;

    public $table = 'coupons';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'code',
        'expiry_date',
        'expires_in_days',
        'discount_percentage',
        'active',
    ];
}
