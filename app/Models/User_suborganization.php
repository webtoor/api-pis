<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User_suborganization extends Model
{
    protected $table = 'user_suborganizations';
    public $timestamps = false;


    public function suborganization(){
        return $this->belongsTo('App\Models\Suborganization');
    }
    public function package(){
        return $this->hasMany('App\Models\Package', 'suborganization_id');
    }
}
