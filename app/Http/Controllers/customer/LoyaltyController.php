<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;
use App\Models\LoyaltyRule;
use App\Models\Restaurant;
use Auth;

class LoyaltyController extends Controller
{
    public function index()
    {
        $restaurantId = 1;
        $restaurant = Restaurant::where('restaurant_id', $restaurantId)->first();
        $user = $data['user'] = Auth::user();
        $uid = $user->uid;
        $userCart = Cart::where('restaurant_id',$restaurantId)->where('uid', $uid)->first();
        $cart_id = $userCart->cart_id ?? 0;
        $data['cards'] = getUserCards($restaurantId, $uid);
        $data['cart_id'] = $cart_id;
        $data['tip1'] = $restaurant ? $restaurant->tip1 : 0.0;
        $data['tip2'] = $restaurant ? $restaurant->tip2 : 0.0;
        $data['tip3'] = $restaurant ? $restaurant->tip3 : 0.0;
        $data['title'] = 'Loyalty'; 
        $data['loyalties'] = LoyaltyRule::with('rulesItems')->where('restaurant_id',$restaurantId)->get(['rules_id','restaurant_id','point']);
        return view('customer.loyalty.index',$data);
    }
}
