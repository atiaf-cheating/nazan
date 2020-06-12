<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductAttachment extends Model
{
//    use SoftDeletes;

    public $table = 'product_attachments';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'attachment_url',
        'product_id'
    ];

    public function product()
    {
        return $this->belongsTo('App\Product');
    }
}
