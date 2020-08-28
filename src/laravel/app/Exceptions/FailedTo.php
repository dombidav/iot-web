<?php


namespace App\Exceptions;


use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FailedTo
{

    public static function Store()
    {
        return self::Operation('Store');
    }

    public static function Update()
    {
        return self::Operation('Update');
    }

    public static function Destroy()
    {
        return self::Operation('Destroy');
    }

    public static function Find()
    {
        return response()->json([
            'error' => 'Not Found',
            'message' => "Failed to find resource",
            'request' => [
                'headers' => \request()->header(),
                'fields' => request()->all()
            ]
        ])->setStatusCode(Response::HTTP_NOT_FOUND);
    }

    public static function Operation($operation)
    {
        return response()->json([
            'error' => 'Internal Server Error',
            'message' => "Failed $operation Operation",
            'request' => [
                'headers' => \request()->header(),
                'fields' => request()->all()
            ]
        ])->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public static function Attach()
    {
        return self::Operation('Attach');
    }

    public static function Detach()
    {
        return self::Operation('Detach');
    }
}
