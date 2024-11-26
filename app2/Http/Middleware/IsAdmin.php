<?php

namespace App\Http\Middleware;

use Closure;
use Config;
use Auth;

class IsAdmin
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
        if(Auth::check())
        {
            if(auth()->guard('admin')->user()->role === Config::get('constants.ROLES.ADMIN')){
                return $next($request);
            }
        }
        return redirect()->route('admin.login');
    }
}
