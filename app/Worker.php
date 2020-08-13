<?php

namespace App;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;
use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Query\Builder;

/**
 * @method static LengthAwarePaginator paginate(int $int)
 * @method static Builder where(string $string, $worker_rfid)
 * @method static Worker firstWhere(string $string, $worker_rfid)
 * @property string name
 * @property string rfid
 * @property Group[] groups
 */
class Worker extends Model
{
    protected $guarded = [];
    
    /**
     * Shorthand for Worker::firstWhere('RFID', $worker_rfid);
     * @param $worker_rfid
     * @return Worker
     */
    public static function rfid($worker_rfid)
    {
        return Worker::where('RFID', $worker_rfid)->first();
    }

    public function groups(){
        return $this->belongsToMany('App\Group');
    }

    public function logs(){
        return $this->belongsToMany('App\Log');
    }
}
