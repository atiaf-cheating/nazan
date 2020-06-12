<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ColorSize extends Model
{
    use SoftDeletes;

    public $table = 'color_size';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'color_product',
        'product_id',
        'color_id',
        'size_id',
        'quantity',
        'price',
        'order',
        'active',
    ];
    public function sizes()
    {
        return $this->belongsTo('App\Size','size_id');
    }
}
