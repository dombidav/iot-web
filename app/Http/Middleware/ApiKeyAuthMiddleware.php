<?php

namespace App\Http\Middleware;

use Closure;
use \App\Helpers\ApiKeyHelper;
use \App\User;

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
        if(ApiKeyHelper::isValid($key)){
            if(User::where('api-key', $key)->count() > 0){
                return $next($request);
            }
            else {
              return ResponseWrapper::wrap('Key not found', $request->header(), 401);
            }
          }
          else {
            return ResponseWrapper::wrap('Malformed API Key', $request->header(), 400);
          }
        
    }
}
