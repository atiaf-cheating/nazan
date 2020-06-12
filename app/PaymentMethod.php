<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentMethod extends Model
{
    use SoftDeletes;

    public $table = 'payment_methods';


    protected $dates = ['deleted_at'];


    public $fillable = [

        'name'
    ];

    public function order()
    {
        return $this->belongsTo('App\Order');
    }
}
