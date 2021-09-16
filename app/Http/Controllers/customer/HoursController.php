<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RestaurantHours;
use App\Models\RestaurantUser;
use Auth;
use Config;

class HoursController extends Controller
{
    public function index()
    {
        $uid = Auth::user()->uid;
        $restaurant = RestaurantUser::where('uid', $uid)->first();
        $data['hoursdata'] = RestaurantHours::select("hours_group_id","opening_time","closing_time","day")
        ->where('restaurant_id', $restaurant->restaurant_id)
        ->get();
        $data['title'] = 'Hours - Dinertech';
        return view('customer.hours.index',$data);
    }
}
