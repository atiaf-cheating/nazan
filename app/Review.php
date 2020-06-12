<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use SoftDeletes;

    public $table = 'reviews';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'user_id',
        'product_id',
        'comment',
        'review'
    ];
    public function product()
    {
        return $this->belongsTo('App\Product');
    }
    public function customer()
    {
        return $this->belongsTo('App\Customer', 'user_id');
    }
}
