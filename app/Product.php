<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    public $table = 'products';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'arabic_name',
        'english_name',
        'description',
        'cat_id',
        'merchant_id',
        'brand_id',
        'image_url',
        'order',
        'active'
    ];
    public function colors()
    {
        return $this->hasMany('App\Color');
    }
    public function reviews()
    {
        return $this->hasMany('App\Review');
    }
    public function attachments()
    {
        return $this->hasMany('App\ProductAttachment');
    }
    public function favourites()
    {
        return $this->hasMany('App\Favourites');
    }
    public function merchant()
    {
        return $this->belongsTo('App\Merchant');
    }
    public function brand()
    {
        return $this->belongsTo('App\Brand');
    }
    public function category()
    {
        return $this->belongsTo('App\Category','cat_id');
    }
    public function promotion()
    {
        return $this->hasOne('App\Promotion');
    }
}
