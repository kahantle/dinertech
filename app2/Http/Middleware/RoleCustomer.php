<?php

namespace App\Http\Middleware;

use Closure;
use Config;

class RoleCustomer
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
        if (auth('api')->user()->role === Config::get('constants.ROLES.CUSTOMER')) {
            return $next($request);
        }
        return response()->json(['message' => "Unauthenticated."], 401);
    }
}
