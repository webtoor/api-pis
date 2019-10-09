<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $table = 'packages';
    public $timestamps = false;

    protected $fillable = [
        'packagename',
        'suborganization_id',
        'dtcreated',
        'totalsession',
        'duration',
        'dtstart',
        'dtend',
        'defaultprice',
        'active'
    ];
}
