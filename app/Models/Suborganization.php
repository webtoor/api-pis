<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Suborganization extends Model
{
    protected $table = 'suborganizations';
    public function trainer(){
        return $this->belongsToMany('App\User', 'user_suborganizations')->orderBy('id', 'asc');
    }
}
