<?php

namespace App;

//use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Jenssegers\Mongodb\Eloquent\Model;

/**
 * @property string name
 * @property Collection groups
 * @method static Lock findOrFail($get)
 * @method static find($get)
 */
class Lock extends Model
{
    public function groups(){
        return $this->belongsToMany('App\Group');
    }
}
