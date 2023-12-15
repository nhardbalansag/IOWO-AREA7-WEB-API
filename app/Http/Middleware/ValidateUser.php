<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $user): Response
    {
        if(($user === 'user')){
            return $next($request);
        }else{
            return response()->json("Unauthorized", 401, [], JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT);
        }
    }
}
