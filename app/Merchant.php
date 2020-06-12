<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Merchant extends Model
{
    use SoftDeletes;
    use Notifiable;

    protected $guard = 'merchant';

    public $table = 'merchants';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'arabic_name',
        'english_name',
        'phone',
        'email',
        'password',
        'user_name'
    ];
    public function products()
    {
        return $this->hasMany('App\Product');
    }
}
