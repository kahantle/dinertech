<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CustomerAddress;
use App\Models\Restaurant;
use App\Models\RestaurantUser;
use Config;
use Auth;

class ContactController extends Controller
{
    public function index()
    {
        $uid = Auth::user()->uid;
        $restaurantId = RestaurantUser::where('uid', $uid)->first();
        $restaurant = Restaurant::where('restaurant_id', $restaurantId->restaurant_id)
                ->whereHas('restaurant_user', function($query)use($uid){
                    $query->where('uid',$uid);
                })
                ->first();
        if (!$restaurant) 
        {
            return back()->with('error','Invalid user for this restaurant.');
        }
        $data['address'] = $restaurant;
        $data['title'] = 'Contact Us - Dinertech';
        return view('customer.contact.index',$data);
    }
}
