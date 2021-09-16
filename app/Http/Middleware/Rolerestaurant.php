<?php

namespace App\Http\Middleware;

use Closure;
use Config;
use App\Models\Restaurant;

class RoleRestaurant
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
        if (auth('api')->user()->role === Config::get('constants.ROLES.RESTAURANT')) {
            $restaurantId = Restaurant::where('uid',auth('api')->user()->uid)->first()->restaurant_id;
            if($restaurantId==$request->post('restaurant_id')){
                return $next($request);
            }
            return response()->json(['message' => "Invalid restaurant for this user."], 401);
        }
        return response()->json(['message' => "Unauthenticated request."], 401);
    }
}
