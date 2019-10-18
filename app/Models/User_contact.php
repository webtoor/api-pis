<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User_contact extends Model
{
    protected $table = 'user_contacts';
    protected $fillable = [
        'user_id',
        'contacttype_id',
        'contactvalue',
        'dtstart'
    ];
    public $timestamps = false;
}
