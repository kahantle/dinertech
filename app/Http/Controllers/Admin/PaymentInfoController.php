<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Restaurant;
use App\Models\User;
use Config;

class PaymentInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = 'Payment Info';
        $data['restaurants'] = User::with(['restaurant' => function($restaurant){
            $restaurant->select("*",\DB::raw('(SELECT SUM(grand_total) FROM orders WHERE isCash = 1 And orders.restaurant_id = restaurants.restaurant_id) as totalOnlineSales'),
            \DB::raw('(SELECT COUNT(*) FROM orders WHERE isCash = 1 And orders.restaurant_id = restaurants.restaurant_id) as totalOnlinePayments'),
            \DB::raw('(SELECT SUM(cart_charge) FROM orders WHERE isCash = 1 And orders.restaurant_id = restaurants.restaurant_id) as totalOnlineCartCharge'),
            \DB::raw('(SELECT SUM(discount_charge) FROM orders WHERE isCash = 1 And orders.restaurant_id = restaurants.restaurant_id) as totalOnlineDiscountCharge'))->withCount('orders')->get();
        }])->where('role',Config::get('constants.ROLES.RESTAURANT'))->latest()->paginate(12);
        // dd($data['restaurants']);
        return view('admin.payment.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($restaurantId)
    {
        $data['title'] = 'Report';
        return view('admin.payment.report',$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
