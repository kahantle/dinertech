<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Restaurant;
use App\Models\User;
use Auth;
use Config;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

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
    public function index(Request $request)
    {
        $uid = Auth::user()->uid;
        $restaurant = Restaurant::where('uid', $uid)->first();


        // -------------- due orders -----------------
        // $orders = [];
        // $due_orders = Order::where([
        //         'restaurant_id' => $restaurant->restaurant_id,
        //         'order_progress_status'=>'ORDER DUE'
        // ])
        // ->orderBy('pickup_time')->get();
        // foreach ($due_orders as $key => $order) {
        //     $orders[] = $order;
        // }

        // // -------------- Accepted orders -----------------
        // $accepted_orders = Order::where([
        //     'restaurant_id' => $restaurant->restaurant_id,
        //     'order_progress_status'=>'ACCEPTED'
        // ])
        // ->orderBy('pickup_time')->get();
        // foreach ($accepted_orders as $key => $order) {
        //     $orders[] = $order;
        // }

        // // -------------- Initial orders -----------------
        // $initial_orders = Order::where([
        //     'restaurant_id' => $restaurant->restaurant_id,
        //     'order_progress_status'=>'INITIAL',
        //     'order_status' => NULL
        // ])->get();
        // foreach ($initial_orders as $key => $order) {
        //     $orders[] = $order;
        // }

        $orders = Order::where('restaurant_id', $restaurant->restaurant_id)
        ->where(function ($query) {
            $query->whereIn('order_progress_status',['ORDER DUE','ACCEPTED','INITIAL'])
            ->orWhereNull('order_status');
        })->orderBy('created_at', 'DESC')->get();

        // ------------ manually paginating orders ----------
        $orders = $this->paginate($orders);

        $restaurantId = $restaurant->restaurant_id;
        return view('dashboard', ['orders' => $orders, 'restaurantId' => $restaurantId]);
    }

    public function paginate($items, $perPage = 7, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, [
            'path' => LengthAwarePaginator::resolveCurrentPath(),
            'pageName' => 'page',
        ]);
    }

}
