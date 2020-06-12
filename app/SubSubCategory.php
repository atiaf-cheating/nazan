<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubSubCategory extends Model
{
    use SoftDeletes;

    public $table = 'sub_sub_categories';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'arabic_name',
        'english_name',
        'image_url',
        'category_id',
        'sub_category_id',
        'order'
    ];
    public function subCategory()
    {
        return $this->belongsTo('App\Category');
    }
}
