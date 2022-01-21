<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Restaurant;
use App\Models\User;
use Auth;
use Config;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $uid = Auth::user()->uid;
        $restaurant = Restaurant::where('uid', $uid)->first();
        $orders = Order::where('restaurant_id', $restaurant->restaurant_id)
            ->where(function ($query) {
                $query->whereNull('order_status');
                $query->orWhereIn('order_progress_status', [
                    Config::get('constants.ORDER_STATUS.INTIAL'),
                    Config::get('constants.ORDER_STATUS.PREPARED'),
                    Config::get('constants.ORDER_STATUS.ACCEPTED'),
                ]);
            })->orderByDesc('order_date')->paginate(7);
        return view('dashboard', compact('orders'));
    }

}
