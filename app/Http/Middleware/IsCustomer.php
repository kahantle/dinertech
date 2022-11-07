<?php

namespace App\Http\Middleware;

use Closure;
use Config;
use Auth;

class IsCustomer
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
        // return $next($request);
        if(Auth::check())
        {
            if(auth()->user()->role === Config::get('constants.ROLES.CUSTOMER')){
                return $next($request);
            } else {
                return redirect()->route('customer.login');
            }
        }
        return redirect()->route('customer.login');
    }
}
