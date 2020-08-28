<?php

namespace App\Http\Middleware;

use App\Exceptions\ApiRequestFieldMissingException;
use App\Helpers\ResponseWrapper;
use Closure;
use \App\Helpers\ApiKeyHelper;
use \App\User;
use Illuminate\Http\Response;

class ApiKeyAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $key = $request->header('api-key');
        if(!$key) return ResponseWrapper::wrap('API Key missing', $request->header(), Response::HTTP_UNAUTHORIZED);
        if(ApiKeyHelper::isValid($key ?? '')){
            if(User::where('apiKey', $key)->count() > 0){
                return $next($request);
            }
            else {
              return ResponseWrapper::wrap('Key not found', $request->header(), Response::HTTP_FORBIDDEN);
            }
          }
          else {
            return ResponseWrapper::wrap('Malformed API Key', $request->header(), Response::HTTP_BAD_REQUEST);
          }

    }
}
