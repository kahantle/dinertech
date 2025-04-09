<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Restaurant;
use App\Models\User;
use App\Models\Order;
use Carbon\Carbon;
use Config;

class PaymentInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($filter = null)
    {
        $data['title'] = 'Payment Info';

        $restaurant = User::where('role',Config::get('constants.ROLES.RESTAURANT'));
        if($filter == 'today')
        {
            // $restaurant = $restaurant->with(['restaurant' => function($restaurant){
            //     $restaurant->select("*",\DB::raw('(SELECT SUM(grand_total) FROM orders WHERE isCash = 1 And orders.restaurant_id = restaurants.restaurant_id) as totalOnlineSales'),
            //     \DB::raw('(SELECT COUNT(*) FROM orders WHERE isCash = 1 And orders.restaurant_id = restaurants.restaurant_id) as totalOnlinePayments'),
            //     \DB::raw('(SELECT SUM(cart_charge) FROM orders WHERE isCash = 1 And orders.restaurant_id = restaurants.restaurant_id) as totalOnlineCartCharge'),
            //     \DB::raw('(SELECT SUM(discount_charge) FROM orders WHERE isCash = 1 And orders.restaurant_id = restaurants.restaurant_id) as totalOnlineDiscountCharge'))->withCount('orders')->get();
            // }]);
            $restaurant = $restaurant->with(['restaurant' => function($restaurant){
                $restaurant->withCount(['OnlineOrders' => function($orders){
                    $orders->whereDate('order_date',date('d'));
                }])->with(['OnlineOrders' => function($onlineOrders){
                    $onlineOrders->where('order_progress_status',Config::get('constants.ORDER_STATUS.COMPLETED'))->whereDate('order_date',date('d'))->get();
                },'orders' => function($orders){
                    $orders->where('order_progress_status',Config::get('constants.ORDER_STATUS.COMPLETED'))->whereDate('order_date',date('d'))->get();
                }])->withCount('orders')->get();
            }]);
            $data['filterType'] = '1 Day';
        }
        elseif($filter == 'currentYear')
        {
            $restaurant = $restaurant->with(['restaurant' => function($restaurant){
                $restaurant->withCount(['OnlineOrders' => function($orders){
                    $orders->whereYear('order_date',date('Y'));
                }])->with(['OnlineOrders' => function($onlineOrders){
                    $onlineOrders->where('order_progress_status',Config::get('constants.ORDER_STATUS.COMPLETED'))->whereYear('order_date',date('Y'))->get();
                },'orders' => function($orders){
                    $orders->where('order_progress_status',Config::get('constants.ORDER_STATUS.COMPLETED'))->whereYear('order_date',date('Y'))->get();
                }])->withCount('orders')->get();
            }]);
            $data['filterType'] = '1 Year';
        }
        else
        {
            $restaurant = $restaurant->with(['restaurant' => function($restaurant){
                $restaurant->withCount(['OnlineOrders' => function($orders){
                    $orders->whereMonth('order_date',date('m'));
                }])->with(['OnlineOrders' => function($onlineOrders){
                    $onlineOrders->where('order_progress_status',Config::get('constants.ORDER_STATUS.COMPLETED'))->whereMonth('order_date',date('m'))->get();
                },'orders' => function($orders){
                    $orders->where('order_progress_status',Config::get('constants.ORDER_STATUS.COMPLETED'))->whereMonth('order_date',date('m'))->get();
                }])->withCount('orders')->get();
            }]);
            $data['filterType'] = '1 Month';
        }

        $data['restaurants'] = $restaurant->latest()->paginate(12);
        // $restaurant = $restaurant->latest()->get();
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
        $data['restaurantId'] = $restaurantId;
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

    public function getChartDetail(Request $request)
    {
        $restaurantId = $request->restaurantId;
        $filter = $request->filterValue;
        if(!empty($filter))
        {
            if($filter == 'Month')
            {
                $duaration = date('t');
                $amounts = [];
                // \DB::enableQueryLog();
                for($var=1;$var<=$duaration;$var++)
                {
                    // $data['days'][] = "Day".$var;
                    // $data['colors'][] =  '#706bc8';
                    $colors[] =  '#706bc8';
                    $date = \Carbon\Carbon::today()->subDays($var)->format('Y-m-d');
                    $days[] = 'Days '.date('d',strtotime($date));
                    $order = \DB::table('orders')
                                ->where('order_progress_status',Config::get('constants.ORDER_STATUS.COMPLETED'))
                                ->where('order_date','=',$date)
                                ->sum('grand_total');
                    $amounts[] = number_format($order,2);


                    $cartCharge = \DB::table('orders')
                            ->where('order_progress_status',Config::get('constants.ORDER_STATUS.COMPLETED'))
                            ->where('order_date','>=',$date)
                            ->sum('cart_charge');

                    $discountCharge = \DB::table('orders')
                            ->where('order_progress_status',Config::get('constants.ORDER_STATUS.COMPLETED'))
                            ->where('order_date','>=',$date)
                            ->sum('discount_charge');

                    $taxCharge = \DB::table('orders')
                            ->where('order_progress_status',Config::get('constants.ORDER_STATUS.COMPLETED'))
                            ->where('order_date','>=',$date)
                            ->sum('tax_charge');
                    $profit[] = number_format($cartCharge - $discountCharge - $taxCharge,2);

                }
                $salesData['amount'] =  array_reverse($amounts);
                $salesData['days'] = array_reverse($days);
                $salesData['colors'] = $colors;
                $data['salesData'] = $salesData;

                $profitData['days'] = array_reverse($days);
                $profitData['colors'] = $colors;
                $profitData['profits'] = $profit;
                $data['profit'] = array_reverse($profitData);
            }
            elseif ($filter == 'Year')
            {
                $amounts = [];
                for($var=1;$var<=12;$var++) {
                    $month = date('m',strtotime('-'.$var.' month'));
                    $days[] = date("F", mktime(0, 0, 0, $month, 10));
                    $colors[] = '#706bc8';
                    // $data['amount'][] =  number_format(Order::where('restaurant_id',$restaurantId)
                    //                         ->where('order_progress_status',Config::get('constants.ORDER_STATUS.COMPLETED'))
                    //                         ->whereMonth('order_date', date('m',strtotime('-'.$var.' month')))
                    //                         ->sum('grand_total'),2);

                    $order = \DB::table('orders')
                            ->where('order_progress_status',Config::get('constants.ORDER_STATUS.COMPLETED'))
                            ->whereMonth('order_date', date('m',strtotime('-'.$var.' month')))
                            ->sum('grand_total');
                    $amounts[] =  number_format($order,2);
                    // $salesData['amount'][] =  number_format($order,2);

                    $cartCharge = \DB::table('orders')
                                ->where('order_progress_status',Config::get('constants.ORDER_STATUS.COMPLETED'))
                                ->whereMonth('order_date', date('m',strtotime('-'.$var.' month')))
                                ->sum('cart_charge');

                    $discountCharge = \DB::table('orders')
                            ->where('order_progress_status',Config::get('constants.ORDER_STATUS.COMPLETED'))
                            ->whereMonth('order_date', date('m',strtotime('-'.$var.' month')))
                            ->sum('discount_charge');

                    $taxCharge = \DB::table('orders')
                            ->where('order_progress_status',Config::get('constants.ORDER_STATUS.COMPLETED'))
                            ->whereMonth('order_date', date('m',strtotime('-'.$var.' month')))
                            ->sum('tax_charge');
                    // echo $cartCharge;
                    $profit[] = number_format($cartCharge - $discountCharge - $taxCharge,2);
                }
                $salesData['days'] = $days;
                $salesData['colors'] = $colors;
                $salesData['amount'] = $amounts;
                $data['salesData'] = $salesData;

                $profitData['days'] = $days;
                $profitData['colors'] = $colors;
                $profitData['profits'] = $profit;
                $data['profit'] = $profitData;
            }
            elseif ($filter == 'Day')
            {
                $amounts = [];
                for($var=1;$var<=7;$var++) {
                    // $data['days'][] = date ("l", strtotime('-'.$var.' day'));;
                    // $data['colors'][] =  '#706bc8';
                    // // $data['amount'][] =  number_format(Order::where('restaurant_id',$restaurantId)
                    // //                         ->where('order_progress_status',Config::get('constants.ORDER_STATUS.COMPLETED'))
                    // //                         ->whereMonth('order_date', date('m',strtotime('-'.$var.' month')))
                    // //                         ->sum('grand_total'),2);
                    $days[] = date ("l", strtotime('-'.$var.' day'));
                    $colors[] = '#706bc8';

                    $order = \DB::table('orders')
                            ->where('order_progress_status',Config::get('constants.ORDER_STATUS.COMPLETED'))
                            ->whereDate('order_date', date('Y-m-d',strtotime('-'.$var.' day')))
                            ->sum('grand_total');
                    $amounts[] = number_format($order,2);
                    // $salesData['amount'][] =  number_format($order,2);

                    $cartCharge = \DB::table('orders')
                        ->where('order_progress_status',Config::get('constants.ORDER_STATUS.COMPLETED'))
                        ->whereDate('order_date', date('Y-m-d',strtotime('-'.$var.' day')))
                        ->sum('cart_charge');

                    $discountCharge = \DB::table('orders')
                            ->where('order_progress_status',Config::get('constants.ORDER_STATUS.COMPLETED'))
                            ->whereDate('order_date', date('Y-m-d',strtotime('-'.$var.' day')))
                            ->sum('discount_charge');

                    $taxCharge = \DB::table('orders')
                            ->where('order_progress_status',Config::get('constants.ORDER_STATUS.COMPLETED'))
                            ->whereDate('order_date', date('Y-m-d',strtotime('-'.$var.' day')))
                            ->sum('tax_charge');
                    // echo $cartCharge;
                    $profit[] = number_format($cartCharge - $discountCharge - $taxCharge,2);

                }
                $salesData['days'] = array_reverse($days);
                $salesData['amount'] = array_reverse($amounts);
                $salesData['colors'] = $colors;
                $data['salesData'] = $salesData;
                $profitData['days'] = array_reverse($days);
                $profitData['colors'] = $colors;
                $profitData['profits'] = array_reverse($profit);
                $data['profit'] = $profitData;
            }
        }
        else
        {

            $duaration = date('t');
            $amounts = [];
            // \DB::enableQueryLog();
            for($var=1;$var<=$duaration;$var++)
            {
                $colors[] =  '#706bc8';
                $date = \Carbon\Carbon::today()->subDays($var)->format('Y-m-d');
                $days[] = 'Days '.date('d',strtotime($date));
                $order = \DB::table('orders')
                            ->where('order_progress_status',Config::get('constants.ORDER_STATUS.COMPLETED'))
                            ->where('order_date','=',$date)
                            ->sum('grand_total');
                $amounts[] = number_format($order,2);


                $cartCharge = \DB::table('orders')
                        ->where('order_progress_status',Config::get('constants.ORDER_STATUS.COMPLETED'))
                        ->where('order_date','=',$date)
                        ->sum('cart_charge');

                $discountCharge = \DB::table('orders')
                        ->where('order_progress_status',Config::get('constants.ORDER_STATUS.COMPLETED'))
                        ->where('order_date','=',$date)
                        ->sum('discount_charge');

                $taxCharge = \DB::table('orders')
                        ->where('order_progress_status',Config::get('constants.ORDER_STATUS.COMPLETED'))
                        ->where('order_date','=',$date)
                        ->sum('tax_charge');
                $profit[] = number_format($cartCharge - $discountCharge - $taxCharge,2);

            }
            $salesData['amount'] =  array_reverse($amounts);
            $salesData['days'] = array_reverse($days);
            $salesData['colors'] = $colors;
            $data['salesData'] = $salesData;

            $profitData['days'] = array_reverse($days);
            $profitData['colors'] = $colors;
            $profitData['profits'] = array_reverse($profit);
            $data['profit'] = array_reverse($profitData);
        }

        return response()->json($data);
    }
}
