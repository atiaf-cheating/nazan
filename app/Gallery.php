<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gallery extends Model
{
    use SoftDeletes;

    public $table = 'galleries';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'large_image',
        'phone_image',
        'active',
    ];
//    public function products()
//    {
//        return $this->hasMany('App\Product');
//    }
}
