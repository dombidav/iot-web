<?php

namespace App;

//use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

/**
 * @property string name
 */
class Group extends Model
{
    public function workers(){
        return $this->belongsToMany('App\Worker');
    }

    public function locks(){
        return $this->belongsToMany('App\Lock');
    }
}
