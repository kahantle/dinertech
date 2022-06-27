<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            if($request->is('login') == true){
                return redirect(RouteServiceProvider::HOME);
            }else if($request->is('admin') == true){
                return redirect(RouteServiceProvider::ADMIN_HOME);
            }
            // return redirect(RouteServiceProvider::HOME);
        }

        return $next($request);
    }
}
