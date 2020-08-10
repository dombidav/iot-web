<?php


namespace App\Helpers;


use Exception;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ResponseWrapper
{
    /**
     * Generates a JSON response for throwback
     * @param string $message
     * @param array $response_fields
     * @param int $status_code
     * @return JsonResponse
     */
    public static function wrap(string $message, array $response_fields, int $status_code = 400) {
        $array = [
            'message' => $message,
            'request' => $response_fields,
            'code' => $status_code
        ];
        return response()->json($array)->setStatusCode($status_code);
    }

    /**
     * Generates JSON response from an exception
     * @param Exception $exception
     * @param array $response_fields
     * @param int $status_code
     * @return JsonResponse
     */
    public static function wrapError(Exception $exception, array $response_fields, int $status_code = 500){
        return self::wrap($exception->getMessage(), $response_fields, $status_code);
    }
}
