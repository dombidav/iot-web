<?php

namespace App;

//use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

class Lock extends Model
{
    public function groups(){
        return $this->belongsToMany('App\WorkerGroup');
    }
}
