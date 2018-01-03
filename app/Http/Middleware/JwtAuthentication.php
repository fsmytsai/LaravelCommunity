<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class JwtAuthentication extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            $this->auth->parseToken()->authenticate();
        } catch (JWTException $exception) {
            return response()->json(['未登入'], 400);
        }
        $request['user'] = Auth::guard()->user();
        return $next($request);
    }
}
