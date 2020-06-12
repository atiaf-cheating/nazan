<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MailInbox extends Model
{
    use SoftDeletes;

    public $table = 'mail_inboxes';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'email',
        'message',
        'category',
    ];
}
