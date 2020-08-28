<?php


namespace App\Helpers;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Jenssegers\Mongodb\Eloquent\Builder;

class ApiValidator
{

    private $validated;

    public function __construct(Request $request, array $rules)
    {
        foreach ($rules as $key => $ruleCollection){
            $this->validated[$key] = $request->input($key);
        }
    }

    public function find($model){
        return $this->buildQuery($model)->first();
    }

    public function findAll($model){
        return $this->buildQuery($model)->get();
    }

    public static function validate(Request $request, array $rules)
    {
        $param = '';
        foreach ($rules as $key => $ruleCollection){
            foreach ($ruleCollection as $rule){
                if(Str::contains($rule, ':')){
                    $param = Str::after($rule, ':');
                    $rule = Str::before($rule, ':');
                }
                switch ($rule){
                    case 'required':
                        if($request->missing($key)) abort(Response::HTTP_BAD_REQUEST, "$key was missing.");
                        break;
                    case 'exists':
                        if(self::getModel($param)::where($key, $request->input($key))->count() < 1) abort(Response::HTTP_NOT_FOUND, "Not found $param where $key=" . $request->input($key) . ".");
                        break;
                    case 'max':
                        if(Str::length($request->input($key)) > intval($param)) abort(Response::HTTP_BAD_REQUEST, "$key was longer than $param.");
                        break;
                    case 'min':
                        if(Str::length($request->input($key)) < intval($param)) abort(Response::HTTP_BAD_REQUEST, "$key was shorter than $param.");
                        break;
                    case 'unique':
                        if(self::getModel($param)::where($key, $request->input($key))->count() > 0) abort(Response::HTTP_CONFLICT, "`$key: " . $request->input($key) . "` is not unique is $param");
                        break;
                    case 'email':
                        if(!filter_var($request->input($key), FILTER_VALIDATE_EMAIL)) abort(Response::HTTP_BAD_REQUEST, "$key was not a valid email");
                }
            }
        }
        return new ApiValidator($request, $rules);
    }

    private static function getModel(string $string){
        $className = 'App\\' . Str::studly($string);

        if(class_exists($className)) {
            return new $className;
        }
        return null;
    }

    /**
     * @param $model
     * @return Builder
     */
    private function buildQuery($model)
    {
        /** @var Builder $result */
        $result = ($model)::query();
        foreach ($this->validated as $key => $value) {
            $result = $result->orWhere($key, $value);
        }
        return $result;
    }
}
