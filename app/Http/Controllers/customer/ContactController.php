<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Models\RestaurantUser;
use Auth;

class ContactController extends Controller
{
    public function index()
    {
        $uid = Auth::user()->uid;
        $restaurantId = RestaurantUser::where('uid', $uid)->first();
        $restaurant = Restaurant::where('restaurant_id', $restaurantId->restaurant_id)
            ->whereHas('restaurant_user', function ($query) use ($uid) {
                $query->where('uid', $uid);
            })
            ->first();
        if (!$restaurant) {
            return back()->with('error', 'Invalid user for this restaurant.');
        }
        $data['cards'] = getUserCards($restaurantId, $uid);
        $data['address'] = $restaurant;
        $data['cards'] = getUserCards($restaurantId,$uid);
        $data['title'] = 'Contact Us';
        return view('customer.contact.index', $data);
    }
}
