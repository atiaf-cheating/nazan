<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Promotion extends Model
{
    use SoftDeletes;

    public $table = 'promotions';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'product_id',
        'expires_in_days',
        'image_url',
        'expiry_date',
        'active'
    ];
    public function product()
    {
        return $this->belongsTo('App\Product');
    }
}
