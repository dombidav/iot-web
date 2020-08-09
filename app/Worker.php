<?php

namespace App;

//use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

/**
 * @method static paginate(int $int)
 * @property string name
 * @property string rfid
 */
class Worker extends Model
{
    public function groups(){
        return $this->belongsToMany('App\Group');
    }

    public function logs(){
        return $this->belongsToMany('App\Log');
    }
}
