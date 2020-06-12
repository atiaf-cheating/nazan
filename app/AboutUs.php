<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Te7aHoudini\LaravelTrix\Traits\HasTrixRichText;

class AboutUs extends Model
{
    use SoftDeletes;
    use HasTrixRichText;

    public $table = 'about_us';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'arabic_text',
        'english_text',
    ];
}
