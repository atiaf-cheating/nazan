<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ColorProduct extends Model
{
    use SoftDeletes;

    public $table = 'color_product';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'product_id',
        'color_id',
        'order',
        'active',
    ];
    public function colors()
    {
        return $this->belongsTo('App\Color','color_id');
    }
}
