<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Token extends Model
{
    use SoftDeletes;

    public $table = 'tokens';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'user_id',
        'token'
    ];
}
