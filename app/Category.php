<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    public $table = 'categories';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'arabic_name',
        'english_name',
        'parent_cat_id',
        'image_url',
        'order'
    ];
    public function subCategories()
    {
        return $this->hasMany('App\Category' , 'parent_cat_id');
    }
    public function products()
    {
        return $this->hasMany('App\Product' , 'parent_cat_id');
    }
}
