<?php

namespace App;

//use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Date;
use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Helpers\EloquentBuilder;

/**
 * @property string name
 * @property mixed updated_at
 * @property mixed timeout
 * @method static EloquentBuilder where(string $field, string $operator, mixed $value)
 * @method static LengthAwarePaginator paginate(int $int)
 */
class Device extends Model
{
    protected $guarded = [];
    protected $appends = ['aliveUntil', 'isAlive'];

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
}
