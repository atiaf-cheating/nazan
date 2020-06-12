<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Color extends Model
{
    use SoftDeletes;

    public $table = 'colors';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'arabic_name',
        'english_name',
        'order',
        'active'
    ];
    public function Products()
    {
        return $this->belongsToMany('App\Product', 'color_product');
    }
    public function sizes()
    {
        return $this->hasMany('App\ColorSize','size_id','id');
    }
    public function coloProduct()
    {
        return $this->hasMany('App\ColorProduct');
    }
}
