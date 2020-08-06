<?php

namespace App;

//use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Helpers\EloquentBuilder;

/**
 * @property string name
 * @method static EloquentBuilder where(string $field, string $operator, mixed $value)
 * @method static LengthAwarePaginator paginate(int $int)
 */
class Device extends Model
{
    //protected $connection = "mongoDB";
   // protected $table =
}
