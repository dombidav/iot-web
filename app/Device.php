<?php

namespace App;

//use Illuminate\Database\Eloquent\Model;
use App\Helpers\CategoryEnum;
use Illuminate\Pagination\LengthAwarePaginator;
use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Helpers\EloquentBuilder;

/**
 * @property string name
 * @property CategoryEnum category
 * @method static EloquentBuilder where(string $field, string $operator, mixed $value)
 * @method static LengthAwarePaginator paginate(int $int)
 */
class Device extends Model
{

    public function getCategoryAttribute($category){
        try {
            return CategoryEnum::fromValue($category);
        }catch (\BadMethodCallException $exception){
            return null;
        }
    }
}
