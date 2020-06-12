<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use SoftDeletes;

    public $table = 'articles';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'title',
        'body',
        'active',
        'order',
        'image_url'
    ];
}
