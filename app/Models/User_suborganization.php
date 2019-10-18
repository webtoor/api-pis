<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User_suborganization extends Model
{
    protected $table = 'user_suborganizations';
    protected $fillable = [
        'user_id',
        'suborganization_id',
        'dtjoined',
        'active'
    ];
    public $timestamps = false;


    public function suborganization(){
        return $this->belongsTo('App\Models\Suborganization');
    }
    public function user(){
        return $this->belongsTo('App\Models\User');
    }
    public function role(){
        return $this->hasOne('App\Models\User_role', 'user_id', 'user_id');
    }
    public function package(){
        return $this->hasMany('App\Models\Package', 'suborganization_id');
    }
    public function trainer(){
        return $this->hasMany('App\Models\User', 'id', 'user_id')->orderBy('id', 'asc');
    }
}
