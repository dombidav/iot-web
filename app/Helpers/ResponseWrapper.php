<?php


namespace App\Helpers;


use Exception;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * Class ResponseWrapper: Wrapper function for JSON Responses
 * @package App\Helpers
 */
class ResponseWrapper
{
    public const OK = 200;
    public const CREATED = 201;
    public const ACCEPTED = 202;

    public const BAD_REQUEST = 400;
    public const UNAUTHORIZED = 401;
    public const ACCESS_DENIED = 403;
    public const NOT_FOUND = 404;
    public const METHOD_NOT_ALLOWED = 405;
    public const CONFLICT = 409;

    public const SERVER_ERROR = 500;
    public const SERVICE_UNAVAILABLE = 503;
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
