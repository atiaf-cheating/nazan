<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Te7aHoudini\LaravelTrix\Traits\HasTrixRichText;

class UsagePolicy extends Model
{
    use SoftDeletes;
    use HasTrixRichText;

    public $table = 'usage_policy';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'arabic_text',
        'english_text',
    ];
}
