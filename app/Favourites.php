<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Favourites extends Model
{
    use SoftDeletes;

    public $table = 'favourites';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'user_id',
        'customer_id',
        'product_id'
    ];

    public function product()
    {
        return $this->belongsTo('App\Product');
    }
}
