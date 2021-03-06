<?php

namespace App;

//use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Date;
use Jenssegers\Mongodb\Eloquent\Model;

/**
 * @property string name
 * @property Collection groups
 * @property mixed status
 * @property mixed updated_at
 * @property string device_id
 * @property int timeout
 * @method static Lock findOrFail($get)
 * @method static Lock find($get)
 * @method static paginate(int $int)
 */
class Lock extends Model
{
    protected $guarded = [];
    protected $appends = ['aliveUntil', 'isAlive'];

    public static function deviceID($input)
    {
        return Lock::where('device_id', $input)->first();
    }

    public function groups(){
        return $this->belongsToMany('App\Group');
    }

    public function getAliveUntilAttribute(){
        return Date::now()->subSeconds($this->timeout ?? 30);
    }

    public function getIsAliveAttribute(){
        return $this->updated_at > $this->getAliveUntilAttribute();
    }

    public function keepAlive(){
        $this->setUpdatedAt(Date::now());
        $this->save();
        return $this;
    }

    public function getRouteKeyName()
    {
        return 'device_id';
    }
}
