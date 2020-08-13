<?php

namespace App;

//use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

/**
 * @property string name
 * @method static paginate(int $int)
 * @method static Group findOrFail(Group $workerGroup)
 * @method static Group find(Group $workerGroup)
 */
class Group extends Model
{
    protected $guarded = [];

    public function workers(){
        return $this->belongsToMany('App\Worker');
    }

    public function locks(){
        return $this->belongsToMany('App\Lock');
    }
}
