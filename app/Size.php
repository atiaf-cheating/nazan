<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Size extends Model
{
    use SoftDeletes;

    public $table = 'sizes';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'arabic_name',
        'english_name',
        'order',
        'cat_id',
        'active'
    ];
    public function colors()
    {
        return $this->belongsToMany('App\Color', 'color_size');
    }

    public function coloSizes()
    {
        return $this->hasMany('App\ColorSize');
    }
}
