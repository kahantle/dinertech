<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Restaurant;
use App\Models\User;
use App\Models\Order;
use Config;
use Auth;
use Session;
use DateInterval;
use DatePeriod;
use DateTime;

class ReportController extends Controller
{
    public $durations ;

    public function __construct()
    {
        $this->durations = [
            'today' => [date("Y-m-d",strtotime("-1 days")), date("Y-m-d")],
            'yesterday' => [date('Y-m-d',strtotime("-2 days")), date('Y-m-d',strtotime("-1 days"))],
            'this_week' => [\Carbon\Carbon::now()->startOfWeek()->format('Y-m-d'),date("Y-m-d")],
            'last_week' => [\Carbon\Carbon::now()->subWeek()->startOfWeek()->format('Y-m-d'), \Carbon\Carbon::now()->subWeek()->endOfWeek()->format('Y-m-d')],
            'this_month' => [\Carbon\Carbon::now()->startOfMonth()->format('Y-m-d'),date("Y-m-d")],
            'last_month' => [\Carbon\Carbon::now()->subMonth()->startOfMonth()->format('Y-m-d'), \Carbon\Carbon::now()->subMonth()->endOfMonth()->format('Y-m-d')],
            'year_to_date' => [\Carbon\Carbon::now()->startOfYear()->format('Y-m-d'),date("Y-m-d")],
            'last_year' => [\Carbon\Carbon::now()->subYear()->startOfYear()->format('Y-m-d'), \Carbon\Carbon::now()->subYear()->endOfYear()->format('Y-m-d')],
        ];

        $this->comparison_durations = [
            'today' => [date('Y-m-d',strtotime("-2 days")),date('Y-m-d',strtotime("-1 days"))],
            'yesterday' => [date('Y-m-d',strtotime("-3 days")), date('Y-m-d',strtotime("-2 days"))],
            'this_week' => [\Carbon\Carbon::now()->subWeek()->startOfWeek()->format('Y-m-d'), \Carbon\Carbon::now()->subWeek()->endOfWeek()->format('Y-m-d')],
            'last_week' => [\Carbon\Carbon::now()->subWeek(2)->startOfWeek()->format('Y-m-d'), \Carbon\Carbon::now()->subWeek(2)->endOfWeek()->format('Y-m-d')],
            'this_month' => [\Carbon\Carbon::now()->subMonth()->startOfMonth()->format('Y-m-d'), \Carbon\Carbon::now()->subMonth()->endOfMonth()->format('Y-m-d')],
            'last_month' => [\Carbon\Carbon::now()->subMonth(2)->startOfMonth()->format('Y-m-d'), \Carbon\Carbon::now()->subMonth(2)->endOfMonth()->format('Y-m-d')],
            'year_to_date' => [\Carbon\Carbon::now()->subYear()->startOfYear()->format('Y-m-d'), \Carbon\Carbon::now()->subYear()->endOfYear()->format('Y-m-d')],
            'last_year' => [\Carbon\Carbon::now()->subYear(2)->startOfYear()->format('Y-m-d'), \Carbon\Carbon::now()->subYear(2)->endOfYear()->format('Y-m-d')],
        ];

    }

    public function index(Request $request){

        $duration = $request->duration == 'custom' ?  [$request->from_date,$request->to_date] : $this->durations[$request->duration ?? 'today'];

        $days_difference = $this->dateDiff($duration[0],$duration[1]);

        if ($request->duration == 'custom') {

            $comparison_duration = [date('Y-m-d', strtotime('-1 day', strtotime($request->from_date))) ,date('Y-m-d', strtotime("-$days_difference days", strtotime($request->from_date)))];

        } else {

            $comparison_duration = $this->comparison_durations[$request->duration ?? 'today'] ;

        }

       	$uid = Auth::user()->uid;
    	$user = User::where('uid', $uid)->first();
        $restaurant = Restaurant::where('uid', $uid)->first();

        if($restaurant->is_pinprotected){
            $is_verified = Session::get('is_pin_verify');
            if(!$is_verified){
                return redirect()->route('account');
            }
        }

        $result['time_duration'] = $request->duration;

        // --------------------------------- order data logic ------------------------------------

        $result['all_orders'] = Order::where('restaurant_id',$restaurant ->restaurant_id)->count();

        $result['get_orders'] = Order::where('restaurant_id',$restaurant ->restaurant_id)
        ->whereBetween('order_date',[$duration])
        ->count();

        $sub_duration_orders = Order::where('restaurant_id',$restaurant ->restaurant_id)
        ->whereBetween('order_date',[$comparison_duration])
        ->count();

        [$result['order_percentage'], $result['order_percentage_status']] = $this->getPercentageData($sub_duration_orders, $result['get_orders']);


        // --------------------------------- order data logic ends ------------------------------------

        // --------------------------------- pending order data logic ends ------------------------------------

        $result['all_pending_orders'] = Order::where('restaurant_id',$restaurant ->restaurant_id)
        ->where('order_progress_status',Config::get('constants.ORDER_STATUS.INITIAL'))
        ->whereNull('order_status')
        ->count();

        $result['get_pending_orders'] = Order::where('restaurant_id',$restaurant ->restaurant_id)
        ->where('order_progress_status',Config::get('constants.ORDER_STATUS.INITIAL'))
        ->whereNull('order_status')
        ->whereBetween('order_date',[$duration])
        ->count();

        $sub_duration_pending_orders = Order::where('restaurant_id',$restaurant ->restaurant_id)
        ->where('order_progress_status',Config::get('constants.ORDER_STATUS.INITIAL'))
        ->whereNull('order_status')
        ->whereBetween('order_date',[$comparison_duration])
        ->count();

        [$result['pending_order_percentage'], $result['pending_order_percentage_status']] = $this->getPercentageData($sub_duration_pending_orders, $result['get_pending_orders']);


        // --------------------------------- pending order data logic ends ---------------------------

        // --------------------------------- Delivery data logic  ------------------------------------

        $result['all_delivery'] = Order::where('restaurant_id',$restaurant ->restaurant_id)
        ->where('order_progress_status',Config::get('constants.ORDER_STATUS.COMPLETED'))
        ->count();

        $result['get_delivery'] = Order::where('restaurant_id',$restaurant ->restaurant_id)
        ->where('order_progress_status',Config::get('constants.ORDER_STATUS.COMPLETED'))
        ->whereBetween('order_date',[$duration])
        ->count();

        $sub_duration_deliveries = Order::where('restaurant_id',$restaurant ->restaurant_id)
        ->where('order_progress_status',Config::get('constants.ORDER_STATUS.COMPLETED'))
        ->whereBetween('order_date',[$comparison_duration])
        ->count();

        [$result['delivery_percentage'], $result['delivery_percentage_status']] = $this->getPercentageData($sub_duration_deliveries, $result['get_delivery']);


        // --------------------------------- Delivery data logic ends ------------------------------------

        // --------------------------------- Clients data logic  -------------------------------------

        $restaurant_id = $restaurant ->restaurant_id;

        $result['repeat_clients'] = User::where('role',Config::get('constants.ROLES.CUSTOMER'))
        ->whereHas('orders',function($query)use($restaurant_id){
            $query->where('restaurant_id',$restaurant_id);
        })
        ->whereBetween('created_at',[$duration])
        ->get();

        $result['new_client'] = User::where('role',Config::get('constants.ROLES.CUSTOMER'))
        ->whereHas('orders',function($query)use($restaurant_id){
            $query->where('restaurant_id',$restaurant_id);
        })
        ->whereBetween('created_at',[$duration])
        ->count();

        $result['clients'] = "[['".$result['new_client']."',".$result['new_client']."],['".$result['repeat_clients']."',".$result['repeat_clients']."]]";

        // --------------------------------- Clients data logic ends ----------------------------------

        // --------------------------------- Sales data logic  ------------------------------------

        $result['all_sales'] = Order::where('restaurant_id',$restaurant ->restaurant_id)->sum('grand_total');

        $result['sales_total'] = Order::where('restaurant_id',$restaurant ->restaurant_id)
        ->whereBetween('created_at',[$duration])
        ->sum('grand_total');

        $sub_duration_sales = Order::where('restaurant_id',$restaurant ->restaurant_id)
        ->whereBetween('created_at',[$comparison_duration])
        ->sum('grand_total');

        $restaurant_age = $this->dateDiff($restaurant->created_at, date("Y-m-d"));

        $days_diff = $restaurant_age / $days_difference;

        $result['average_values'] =  number_format(($result['all_sales'] /  $days_diff) ,2);

        [$result['sales_percentage'], $result['sales_percentage_status']] = $this->getPercentageData($sub_duration_sales, $result['sales_total']);

        // ------------

        $result['sales_total'] = number_format( $result['sales_total'] ,2);
        $result['all_sales'] = number_format( $result['all_sales'] ,2);
        $result['sales_percentage'] =  number_format($result['sales_percentage'],2);

        $interval = DateInterval::createFromDateString('1 day');
        $period = new DatePeriod(new DateTime($duration[0]), $interval, new DateTime($duration[1]));
        $sales_array = [];
        foreach ($period as $key => $date) {
            $tempArray=  number_format(Order::where('restaurant_id',$restaurant ->restaurant_id)
            ->where('order_progress_status',Config::get('constants.ORDER_STATUS.COMPLETED'))
            ->where('order_date',$date->format('Y-m-d'))
            ->sum('grand_total'),0);
            array_push($sales_array,$tempArray);
        }


        $result['sales_array'] = implode(",",$sales_array);
        $result['sales_array'] = "[".$result['sales_array']."]";


        // --------------------------------- Sales data logic ends ------------------------------------

        // --------------------------------- tip data logic -------------------------------------------

        $result['all_tip'] = number_format(Order::where('restaurant_id',$restaurant ->restaurant_id)->sum('tip_amount'),2);

        $result['total_tip'] = Order::where('restaurant_id',$restaurant ->restaurant_id)
        ->whereBetween('order_date',[$duration])
        ->sum('tip_amount');

        $result['total_tip'] = number_format($result['total_tip'],2);

        // --------------------------------- tip data logic ends ------------------------------------

        return view('report.index',compact('result'));
    }

    public function getPercentageData($comparison_data, $actual_data)
    {
       if ($comparison_data > 0) {

            $percentage = (100*$actual_data/$comparison_data) ;

        } else if ($comparison_data == $actual_data) {

            $percentage = 0 ;

        } else {

            $percentage = $actual_data*100 ;

        }

        $status = $actual_data >  $comparison_data  ? true : false ;

        return [$percentage, $status];
    }

    public function customTips(Request $request)
    {
        $from = date($request->from_time);
        $to = date($request->to_time);
        $uid = Auth::user()->uid;
    	$user = User::where('uid', $uid)->first();
        $restaurant = Restaurant::where('uid', $uid)->first();
        $sub_date = \Carbon\Carbon::today()->subDays($request->duration == 'today' ? 1 : 2);
        $result['total_tip'] = Order::where('restaurant_id',$restaurant ->restaurant_id)
        ->where('order_date','>=',$sub_date)
        ->whereBetween('order_time',[$from,$to])
        ->sum('tip_amount');
        return response()->json($result, 200);
    }

    function dateDiff($date1, $date2)
    {
        $date1_ts = strtotime($date1);
        $date2_ts = strtotime($date2);
        $diff = $date2_ts - $date1_ts;
        return round($diff / 86400);
    }
}
