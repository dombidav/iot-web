<?php

namespace App;

//use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

class Log extends Model
{
    public function user(){
        return $this->hasOne('App\User');
    }

    public function worker(){
        return $this->hasOne('App\Worker');
    }

    public function devices(){
        return $this->belongsToMany('App\Device');
    }
}
