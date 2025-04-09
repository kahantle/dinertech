<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\RestaurantPayments;
use Carbon\Carbon;
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
        $this->middleware('auth');
    }


    public function index()
    {
        $data['users'] = User::where('role',Config('constants.ROLES.CUSTOMER'))->whereMonth('created_at',date('m'))->count();
        $data['restaurants'] = User::where('role',Config('constants.ROLES.RESTAURANT'))->whereMonth('created_at',date('m'))->count();
        $data['orders'] = Order::whereMonth('order_date',date('m'))->count();
        $data['activeOrders'] = Order::where('order_progress_status','!=',Config::get('constants.ORDER_STATUS.COMPLETED'))->where('order_progress_status','!=',Config::get('constants.ORDER_STATUS.CANCEL'))->whereMonth('order_date',date('m'))->count();
        $data['declinedOrders'] = Order::where('order_progress_status','!=',Config::get('constants.ORDER_STATUS.CANCEL'))->whereMonth('order_date',date('m'))->count();
        $totalSales = RestaurantPayments::where('status','SUCCESS')->sum('amount');
        $data['totalSales'] = $totalSales; 
        $data['percentage'] = ($totalSales * 1) / 100;
        $data['liveSales'] = Order::where('order_progress_status',Config::get('constants.ORDER_STATUS.COMPLETED'))->whereMonth('order_date',date('m'))->sum('grand_total');
        $previousMonth = date('m',strtotime('-1 month'));
        $data['previousSales'] = Order::where('order_progress_status',Config::get('constants.ORDER_STATUS.COMPLETED'))->whereMonth('order_date',$previousMonth)->sum('grand_total');
        $sales = array();
        $days = array();
        $duaration = date('t');

        for($var=1; $var<=$duaration; $var++) {
            $date = \Carbon\Carbon::today()->subDays($var)->format('Y-m-d');
            $days[] = 'Days '.date('d',strtotime($date));
            $sales[] = number_format(\DB::table('restaurant_payment')->where('status','SUCCESS')->whereDate('created_at',$date)->sum('amount'));
        }

        $data['chart']['sales'] = array_reverse($sales);
        $data['chart']['days'] = array_reverse($days);
        $data['filter'] = '1 Month';
        $data['title'] = 'Dashboard';
        return view('admin.dashboard',$data);
    }

    public function dashboardFilter(Request $request)
    {
        if($request->ajax())
        {
            $filter = $request->filterType;
            if($filter == 'Month')
            {
                $data['users'] = User::where('role',Config('constants.ROLES.CUSTOMER'))->whereMonth('created_at',date('m'))->count();
                $data['restaurants'] = User::where('role',Config('constants.ROLES.RESTAURANT'))->whereMonth('created_at',date('m'))->count();
                $data['orders'] = Order::whereMonth('order_date',date('m'))->count();
                $data['activeOrders'] = Order::where('order_progress_status','!=',Config::get('constants.ORDER_STATUS.COMPLETED'))->where('order_progress_status','!=',Config::get('constants.ORDER_STATUS.CANCEL'))->whereMonth('order_date',date('m'))->count();
                $data['declinedOrders'] = Order::where('order_progress_status','!=',Config::get('constants.ORDER_STATUS.CANCEL'))->whereMonth('order_date',date('m'))->count();
                $totalSales = RestaurantPayments::where('status','SUCCESS')->sum('amount');
                $data['totalSales'] = number_format($totalSales,2);
                $data['percentage'] = number_format(($totalSales * 1) / 100);
                $data['liveSales'] = number_format(Order::where('order_progress_status',Config::get('constants.ORDER_STATUS.COMPLETED'))->whereMonth('order_date',date('m'))->sum('grand_total'),2);
                $previousMonth = date('m',strtotime('-1 month'));
                $data['previousSales'] = Order::where('order_progress_status',Config::get('constants.ORDER_STATUS.COMPLETED'))->whereMonth('order_date',$previousMonth)->sum('grand_total');
                $sales = array();
                $days = array();
                $duaration = date('t');
                for($var=1; $var<=$duaration; $var++) {
                    $date = \Carbon\Carbon::today()->subDays($var)->format('Y-m-d');
                    $days[] = 'Days '.date('d',strtotime($date));
                    $sales[] = number_format(\DB::table('restaurant_payment')->where('status','SUCCESS')->whereDate('created_at',$date)->sum('amount'));
                }
                $data['chart']['sales'] = array_reverse($sales);
                $data['chart']['days'] = array_reverse($days);
                $data['filter'] = '1 Month';
            }
            elseif ($filter == 'Year')
            {
                $data['users'] = User::where('role',Config('constants.ROLES.CUSTOMER'))->whereYear('created_at',date('Y'))->count();
                $data['restaurants'] = User::where('role',Config('constants.ROLES.RESTAURANT'))->whereYear('created_at',date('Y'))->count();
                $data['orders'] = Order::whereYear('order_date',date('Y'))->count();
                $data['activeOrders'] = Order::where('order_progress_status','!=',Config::get('constants.ORDER_STATUS.COMPLETED'))->where('order_progress_status','!=',Config::get('constants.ORDER_STATUS.CANCEL'))->whereYear('order_date',date('Y'))->count();
                $data['declinedOrders'] = Order::where('order_progress_status','!=',Config::get('constants.ORDER_STATUS.CANCEL'))->whereYear('order_date',date('Y'))->count();
                $totalSales = RestaurantPayments::where('status','SUCCESS')->sum('amount');
                $data['totalSales'] = number_format($totalSales,2);
                $data['percentage'] = number_format(($totalSales * 1) / 100);
                $data['liveSales'] = number_format(Order::where('order_progress_status',Config::get('constants.ORDER_STATUS.COMPLETED'))->whereYear('order_date',date('Y'))->sum('grand_total'),2);
                $previousYear = date('Y',strtotime('-1 year'));
                $data['previousSales'] = Order::where('order_progress_status',Config::get('constants.ORDER_STATUS.COMPLETED'))->whereYear('order_date',$previousYear)->sum('grand_total');
                $sales = array();
                $days = array();
                for($var=1; $var<=12; $var++) {
                    $days[] = date('F', mktime(0,0,0,$var, 1, date('Y')));
                    $explodeDate = explode('-',date('Y-m',strtotime('-'.$var.' month')));
                    $sales[] = number_format(\DB::table('restaurant_payment')->where('status','SUCCESS')->whereMonth('created_at',$explodeDate[1])->whereYear('created_at',$explodeDate[0])->sum('amount'),2);
                }
                $data['chart']['sales'] = $sales;
                $data['chart']['days'] = $days;
                $data['filter'] = 'Current Year';
            }
            elseif($filter == 'Today')
            {
                $day = Carbon::today()->format('Y-m-d');
                $data['users'] = User::where('role',Config('constants.ROLES.CUSTOMER'))->whereDate('created_at',$day)->count();
                $data['restaurants'] = User::where('role',Config('constants.ROLES.RESTAURANT'))->whereDate('created_at',$day)->count();
                $data['orders'] = Order::whereDate('order_date',$day)->count();
                $data['activeOrders'] = Order::where('order_progress_status','!=',Config::get('constants.ORDER_STATUS.COMPLETED'))->where('order_progress_status','!=',Config::get('constants.ORDER_STATUS.CANCEL'))->whereDate('order_date',$day)->count();
                $data['declinedOrders'] = Order::where('order_progress_status','!=',Config::get('constants.ORDER_STATUS.CANCEL'))->whereDate('order_date',$day)->count();
                $totalSales = RestaurantPayments::where('status','SUCCESS')->sum('amount');
                $data['totalSales'] = number_format($totalSales,2);
                $data['percentage'] = number_format(($totalSales * 1) / 100);
                $data['liveSales'] = number_format(Order::where('order_progress_status',Config::get('constants.ORDER_STATUS.COMPLETED'))->whereDate('order_date',$day)->sum('grand_total'),2);
                $yesterday =  Carbon::yesterday();
                $data['previousSales'] = Order::where('order_progress_status',Config::get('constants.ORDER_STATUS.COMPLETED'))->whereDate('order_date',$yesterday)->sum('grand_total');
                $sales = number_format(\DB::table('restaurant_payment')->where('status','SUCCESS')->whereDate('created_at',$day)->sum('amount'),2);
                $data['chart']['sales'] = (array)$sales;
                $data['chart']['days'] = (array)date('d-m-Y',strtotime($day));
                $data['filter'] = 'Today';
            }
            elseif($filter == 'Week')
            {
                $yesterday  = Carbon::yesterday();
                $fromDate = $yesterday->startOfWeek()->format('Y-m-d');
                $toDate = $yesterday->endOfWeek()->format('Y-m-d');
                $data['users'] = User::where('role',Config('constants.ROLES.CUSTOMER'))->whereBetween('created_at',[$fromDate,$toDate])->count();
                $data['restaurants'] = User::where('role',Config('constants.ROLES.RESTAURANT'))->whereBetween('created_at',[$fromDate,$toDate])->count();
                $data['orders'] = Order::whereBetween('order_date',[$fromDate,$toDate])->count();
                $data['activeOrders'] = Order::where('order_progress_status','!=',Config::get('constants.ORDER_STATUS.COMPLETED'))->where('order_progress_status','!=',Config::get('constants.ORDER_STATUS.CANCEL'))->whereBetween('order_date',[$fromDate,$toDate])->count();
                $data['declinedOrders'] = Order::where('order_progress_status','!=',Config::get('constants.ORDER_STATUS.CANCEL'))->whereBetween('order_date',[$fromDate,$toDate])->count();
                $totalSales = RestaurantPayments::where('status','SUCCESS')->sum('amount');
                $data['totalSales'] = number_format($totalSales,2);
                $data['percentage'] = number_format(($totalSales * 1) / 100);
                $data['liveSales'] = number_format(Order::where('order_progress_status',Config::get('constants.ORDER_STATUS.COMPLETED'))->whereBetween('order_date',[$fromDate,$toDate])->sum('grand_total'),2);

                /* Last Week */
                $today =  Carbon::now()->startOfWeek();
                $startOfLastWeek  =  $today->copy()->subDays(7)->format('Y-m-d');
                $endOfLastWeek    =  $today->subDays($today->dayOfWeek)->endOfWeek()->format('Y-m-d');
                $data['previousSales'] = Order::where('order_progress_status',Config::get('constants.ORDER_STATUS.COMPLETED'))->whereBetween('order_date',[$startOfLastWeek,$endOfLastWeek])->sum('grand_total');

                $sales = array();
                $days = array();
                for($var=1;$var<=7;$var++) {
                    $days[] = date ("l", strtotime('-'.$var.' day'));
                    $sales[] = number_format(\DB::table('restaurant_payment')->where('status','SUCCESS')->whereDate('created_at',date('d',strtotime('-'.$var.' day')))->sum('amount'),2);
                }
                $data['chart']['sales'] = $sales;
                $data['chart']['days'] = $days;
                $data['filter'] = date('d-m-Y',strtotime($fromDate)).' To '.date('d-m-Y',strtotime($toDate));
            }
            elseif($filter == 'Custom')
            {
                $fromDate = Carbon::createFromFormat('Y-m-d',$request->fromDate);
                $toDate = Carbon::createFromFormat('Y-m-d',$request->toDate);

                $data['filter'] = date('d-m-Y',strtotime($fromDate)).' To '.date('d-m-Y',strtotime($toDate));
                $data['users'] = User::where('role',Config('constants.ROLES.CUSTOMER'))->whereBetween('created_at',[$fromDate->format('Y-m-d'),$toDate->format('Y-m-d')])->count();
                $data['restaurants'] = User::where('role',Config('constants.ROLES.RESTAURANT'))->whereBetween('created_at',[$fromDate->format('Y-m-d'),$toDate->format('Y-m-d')])->count();
                $data['orders'] = Order::whereBetween('order_date',[$fromDate->format('Y-m-d'),$toDate->format('Y-m-d')])->count();
                $data['activeOrders'] = Order::where('order_progress_status','!=',Config::get('constants.ORDER_STATUS.COMPLETED'))->where('order_progress_status','!=',Config::get('constants.ORDER_STATUS.CANCEL'))->whereBetween('order_date',[$fromDate->format('Y-m-d'),$toDate->format('Y-m-d')])->count();
                $data['declinedOrders'] = Order::where('order_progress_status','!=',Config::get('constants.ORDER_STATUS.CANCEL'))->whereBetween('order_date',[$fromDate->format('Y-m-d'),$toDate->format('Y-m-d')])->count();
                $totalSales = RestaurantPayments::where('status','SUCCESS')->sum('amount');
                $data['totalSales'] = number_format($totalSales,2);
                $data['percentage'] = number_format(($totalSales * 1) / 100);
                $data['liveSales'] = number_format(Order::where('order_progress_status',Config::get('constants.ORDER_STATUS.COMPLETED'))->whereBetween('order_date',[$fromDate->format('Y-m-d'),$toDate->format('Y-m-d')])->sum('grand_total'),2);

                $different =  $fromDate->diffInDays($toDate);
                $sales = array();
                $days = array();
                $period = \Carbon\CarbonPeriod::create($fromDate->format('Y-m-d'), $toDate->format('Y-m-d'));

                // Iterate over the period
                foreach ($period as $date) {
                    $days[] = $date->format('d-m-Y');
                    $sales[] = number_format(\DB::table('restaurant_payment')->where('status','SUCCESS')->whereDate('created_at',$date->format('Y-m-d'))->sum('amount'),2);
                }

                $data['chart']['sales'] = $sales;
                $data['chart']['days'] = $days;

                /* Previous Dates */
                $previousFromDate = $fromDate->subDays($different)->format('Y-m-d');
                $previousToDate = $toDate->subDays($different)->format('Y-m-d');
                $data['previousSales'] = Order::where('order_progress_status',Config::get('constants.ORDER_STATUS.COMPLETED'))->whereBetween('order_date',[$previousFromDate,$previousToDate])->sum('grand_total');

            }
            else
            {
               $data = [];
            }
            return response()->json($data);
        }
    }
}
