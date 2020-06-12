<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubCategory extends Model
{
    use SoftDeletes;

    public $table = 'sub_categories';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'arabic_name',
        'english_name',
        'image_url',
        'category_id',
        'order'
    ];
    public function category()
    {
        return $this->belongsTo('App\Category');
    }
    public function subSubCategories()
    {
        return $this->belongsTo('App\SubSubCategory');
    }
}
