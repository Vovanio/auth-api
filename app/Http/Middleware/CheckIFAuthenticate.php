<?php

namespace App\Http\Middleware;

use Closure;
use http\Message;
use Illuminate\Http\Request;
use mysql_xdevapi\Exception;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Tymon\JWTAuth\Exceptions\JWTException;

class CheckIFAuthenticate extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\JsonResponse
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            $user = auth()->parseToken();
        } catch (JWTException $e) {
            return response()->json([
                'error' => [
                    'code' => 403,
                    'message' => 'token is invalid or not found'
                ]
            ], 403);
        }
        return $next($request);
    }
}
