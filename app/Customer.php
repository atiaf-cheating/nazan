<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Authenticatable
{
    use SoftDeletes;
    use Notifiable;

//    protected $guard = 'customer';

    public $table = 'customers';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'remember_token',
        'verification_code',
        'active'
    ];
    protected $hidden = [
        'password', 'remember_token',
    ];
    public function reviews()
    {
        return $this->belongsTo('App\Review');
    }
    public function favourites()
    {
        return $this->hasMany('App\Favourites');
    }

    public function getAuthIdentifierName()
    {
        // TODO: Implement getAuthIdentifierName() method.
    }

    public function getAuthIdentifier()
    {
        // TODO: Implement getAuthIdentifier() method.
    }

    public function getAuthPassword()
    {
        // TODO: Implement getAuthPassword() method.
    }

    public function getRememberToken()
    {
        // TODO: Implement getRememberToken() method.
    }

    public function setRememberToken($value)
    {
        // TODO: Implement setRememberToken() method.
    }

    public function getRememberTokenName()
    {
        // TODO: Implement getRememberTokenName() method.
    }
}
