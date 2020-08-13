<?php

namespace App;

//use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Jenssegers\Mongodb\Eloquent\Model;

/**
 * @property string name
 * @property Collection groups
 * @property mixed status
 * @method static Lock findOrFail($get)
 * @method static Lock find($get)
 */
class Lock extends Model
{
    public function groups(){
        return $this->belongsToMany('App\Group');
    }
}
