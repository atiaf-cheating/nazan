<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    use SoftDeletes;

    public $table = 'brands';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'arabic_name',
        'english_name',
        'image_url',
        'order',
        'active'
    ];
    public function products()
    {
        return $this->hasMany('App\Product');
    }
}

