<?php

namespace App;

//use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

class WorkerGroup extends Model
{
    public function workers(){
        return $this->hasMany('App\Worker');
    }

    public function locks(){
        return $this->hasMany('App\Lock');
    }
}
