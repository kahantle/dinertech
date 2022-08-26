<?php

namespace App\Http\Controllers\Api\Restaurant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Restaurant;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Config;
use Auth;
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

    public function index(Request $request)
    {

        try {

            // ------------------------------- validation check ----------------------

            $validator = Validator::make($request->all(), [
                'restaurant_id' => 'required',
                'time_duration' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()], 400);
            }

            // ----------------------------- duration fetch ----------------------------

            $duration = $request->time_duration == 'custom' ?  [$request->from_date,$request->to_date] : $this->durations[$request->time_duration ?? 'today'];

            $days_difference = $this->dateDiff($duration[0],$duration[1]);

            if ($request->time_duration == 'custom') {

                $comparison_duration = [date('Y-m-d', strtotime('-1 day', strtotime($request->from_date))) ,date('Y-m-d', strtotime("-$days_difference days", strtotime($request->from_date)))];

            } else {

                $comparison_duration = $this->comparison_durations[$request->time_duration ?? 'today'] ;

            }

            // ----------------------------- request data fetch ----------------------------

            $uid = Auth::user()->uid;
    	    $user = User::where('uid', $uid)->first();
            $restaurant = Restaurant::where('uid', $uid)->first();

            $result = [];

            $result['time_duration'] = $request->time_duration;

            // --------------------------------- order data logic ------------------------------------

            $result['all_order'] = Order::where('restaurant_id',$restaurant ->restaurant_id)->count();

            $result['get_order'] = Order::where('restaurant_id',$restaurant ->restaurant_id)
            ->whereBetween('order_date',[$duration])
            ->count();

            $sub_duration_orders = Order::where('restaurant_id',$restaurant ->restaurant_id)
            ->whereBetween('order_date',[$comparison_duration])
            ->count();

            $result['last_order_total'] = $sub_duration_orders;

            [$result['order_pr'], $result['order_pr_status']] = $this->getPercentageData($sub_duration_orders, $result['get_order']);

            // --------------------------------- order data logic ends ------------------------------------

            // --------------------------------- pending order data logic ends ------------------------------------

            $result['all_pendingorder'] = Order::where('restaurant_id',$restaurant ->restaurant_id)
            ->where('order_progress_status',Config::get('constants.ORDER_STATUS.INITIAL'))
            ->whereNull('order_status')
            ->count();

            $result['get_pendingorder'] = Order::where('restaurant_id',$restaurant ->restaurant_id)
            ->where('order_progress_status',Config::get('constants.ORDER_STATUS.INITIAL'))
            ->whereNull('order_status')
            ->whereBetween('order_date',[$duration])
            ->count();

            $sub_duration_pending_orders = Order::where('restaurant_id',$restaurant ->restaurant_id)
            ->where('order_progress_status',Config::get('constants.ORDER_STATUS.INITIAL'))
            ->whereNull('order_status')
            ->whereBetween('order_date',[$comparison_duration])
            ->count();

            $result['last_pending_order_total'] = $sub_duration_pending_orders ;

            [$result['pending_order_pr'], $result['pending_order_pr_status']] = $this->getPercentageData($sub_duration_pending_orders, $result['get_pendingorder']);


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

            [$result['delivery_pr'], $result['delivery_pr_status']] = $this->getPercentageData($sub_duration_deliveries, $result['get_delivery']);

            // --------------------------------- Delivery data logic ends ------------------------------------

            // --------------------------------- clients data logic  ------------------------------------

            $result['all_clients'] = User::where('role',Config::get('constants.ROLES.CUSTOMER'))->count();

            $result['new_client'] = User::where('role',Config::get('constants.ROLES.CUSTOMER'))
            ->whereBetween('created_at',[$duration])
            ->count();

            // --------------------------------- clients data logic ends ------------------------------------

            // --------------------------------- Sales data logic  -----------------------------------------

            $result['all_sales'] = Order::where('restaurant_id',$restaurant ->restaurant_id)->sum('grand_total');

            $result['sales_total'] = Order::where('restaurant_id',$restaurant ->restaurant_id)
            ->whereBetween('created_at',[$duration])
            ->sum('grand_total');

            $sub_duration_sales = Order::where('restaurant_id',$restaurant ->restaurant_id)
            ->whereBetween('created_at',[$comparison_duration])
            ->sum('grand_total');

            $result['last_sales_total'] = $sub_duration_sales;

            $restaurant_age = $this->dateDiff($restaurant->created_at, date("Y-m-d"));

            $days_diff = $restaurant_age / $days_difference;

            $result['avg_values'] =  number_format(($result['all_sales'] /  $days_diff) ,2);

            [$result['sales_pr '], $result['sales_pr_status']] = $this->getPercentageData($sub_duration_sales, $result['sales_total']);

            // ------------

            $interval = DateInterval::createFromDateString('1 day');
            $period = new DatePeriod(new DateTime($duration[0]), $interval, new DateTime($duration[1]));

            foreach ($period as $key => $date) {
                $tempArray['day'] = $key;
                $tempArray['day_sale'] =  number_format(Order::where('restaurant_id',$restaurant ->restaurant_id)
                ->where('order_progress_status',Config::get('constants.ORDER_STATUS.COMPLETED'))
                ->where('order_date',$date->format('Y-m-d'))
                ->sum('grand_total'),0);
                $result['sales_graph'][] = $tempArray;
            }

            // --------------------------------- tip data logic -------------------------------------------

            $result['all_tip'] = number_format(Order::where('restaurant_id',$restaurant ->restaurant_id)->sum('tip_amount'),2);

            $result['total_tip'] = Order::where('restaurant_id',$restaurant ->restaurant_id)
            ->whereBetween('order_date',[$duration])
            ->sum('tip_amount');

            $result['total_tip'] = number_format($result['total_tip'],2);

            // --------------------------------- tip data logic ends ------------------------------------

            return response()->json(['message' => $result, 'success' => true], 200);

        } catch (\Throwable $th) {

            $errors['success'] = false;

            $errors['message'] = Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS');

            if ($request->debug_mode == 'ON') {
                $errors['debug'] = $th->getMessage();
            }

            return response()->json($errors, 500);

        }
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

    function dateDiff($date1, $date2)
    {
        $date1_ts = strtotime($date1);
        $date2_ts = strtotime($date2);
        $diff = $date2_ts - $date1_ts;
        return round($diff / 86400);
    }

}
