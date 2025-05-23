<?php

namespace App\Http\Middleware;

use App\Traits\HttpResponses;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtMiddleware
{
    use HttpResponses;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            JWTAuth::parseToken()->authenticate();
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return $this->error(null, 'Token has expired', Response::HTTP_UNAUTHORIZED);
        }  catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return $this->error(null, 'Token invalid', Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}
