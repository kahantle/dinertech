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

class ReportController extends Controller
{
    public function index(Request $request){


       	$uid = Auth::user()->uid;
    	$user = User::where('uid', $uid)->first();
        $restaurant = Restaurant::where('uid', $uid)->first();

        if($restaurant->is_pinprotected){
            $is_verified = Session::get('is_pin_verify');
            if(!$is_verified){
                return redirect()->route('account');
            }
        }


        $duaration= ($request->get('duration'))?$request->get('duration'):7;
        $date = \Carbon\Carbon::today()->subDays($duaration);
        $avgStartDate = $date=date_create($date);
        $avgStartDate = date_sub($date,date_interval_create_from_date_string("$duaration days"));
        $avgStartDate = date_format($date,"Y-m-d");  
        $result =array ();
        $result['time_duration'] = $duaration;
        $result['all_order'] = Order::where('restaurant_id',$restaurant ->restaurant_id)
                                    ->count();

        $result['get_order'] = Order::where('restaurant_id',$restaurant ->restaurant_id)
                                    ->where('order_date','>=',$date)
                                    ->count();

        $result['last_order_total'] = Order::where('restaurant_id',$restaurant ->restaurant_id)
                                    ->where('order_date','>=',$date)
                                    ->where('order_date','<=',$avgStartDate)
                                    ->count();
        $result['order_pr_status'] = (abs($result['get_order'] - $result['last_order_total']))?1:0;


        $result['all_pendingorder'] = Order::where('restaurant_id',$restaurant ->restaurant_id)
                                    ->where('order_progress_status',Config::get('constants.ORDER_STATUS.INITIAL'))
                                    ->whereNull('order_status')
                                    ->count();

        $result['get_pendingorder'] = Order::where('restaurant_id',$restaurant ->restaurant_id)
                                    ->where('order_progress_status',Config::get('constants.ORDER_STATUS.INITIAL'))
                                    ->whereNull('order_status')
                                    ->where('order_date','>=',$date)
                                    ->count();
        
        $result['last_pending_order_total'] = Order::where('restaurant_id',$restaurant ->restaurant_id)
                                    ->whereNull('order_status')
                                    ->where('order_date','>=',$date)
                                    ->where('order_date','<=',$avgStartDate)
                                    ->count();

        $result['pending_order_pr_status'] = (abs($result['get_order'] - $result['last_pending_order_total']))?1:0;

                            
        $result['all_delivery'] = Order::where('restaurant_id',$restaurant ->restaurant_id)
                                    ->where('order_progress_status',Config::get('constants.ORDER_STATUS.COMPLETED'))
                                    ->count();

        $result['get_delivery'] = Order::where('restaurant_id',$restaurant ->restaurant_id)
                                    ->where('order_progress_status',Config::get('constants.ORDER_STATUS.COMPLETED'))
                                    ->where('order_date','>=',$date)
                                    ->count();

        $result['all_sales'] = Order::where('restaurant_id',$restaurant ->restaurant_id)
                                    ->sum('grand_total');

        $result['sales_total'] = Order::where('restaurant_id',$restaurant ->restaurant_id)
                                    ->where('order_date','>=',$date)
                                    ->sum('grand_total');

        $result['last_sales_total'] = Order::where('restaurant_id',$restaurant ->restaurant_id)
                                    ->where('order_date','>=',$date)
                                    ->where('order_date','<=',$avgStartDate)
                                    ->sum('grand_total');

        $result['all_clients'] = User::where('role',Config::get('constants.ROLES.CUSTOMER'))->whereHas('orders')
                                        ->where('created_at','<=',$date)
                                        ->count();

        $result['new_client'] = User::where('role',Config::get('constants.ROLES.CUSTOMER'))
                                    ->whereHas('orders')
                                    ->where('created_at','>=',$date)
                                    ->count();

        $result['avg_values'] =  number_format(($result['sales_total'] + $result['last_sales_total'])/2 ,2);
        $sales_pr = ($result['sales_total'] > 0)? (($result['sales_total'] - $result['last_sales_total'])/$result['sales_total'] )*100:0;
        
        $result['sales_pr_status'] = (abs($result['sales_total'] - $result['last_sales_total']))?1:0;


        $result['pendingorder_pr'] = (isset($result['get_pendingorder']))? number_format(($result['get_pendingorder'] / 100) * 1,2):[];
        $result['order_pr'] = (isset($result['all_order'])) ? number_format(($result['all_order'] / 100) * 1,2) : [];
        $result['reporting_client'] = 50;
        $result['sales_total'] = number_format( $result['sales_total'] ,2);
        $result['all_sales'] = number_format( $result['all_sales'] ,2);
        $result['sales_pr'] =  number_format($sales_pr,2);

        $sales_array =array();
        for($var=1;$var<=$duaration;$var++) {
           // $tempArray['day'] = $var;
            $date = \Carbon\Carbon::today()->subDays($var)->format('Y-m-d');
            $tempArray=  number_format(Order::where('restaurant_id',$restaurant ->restaurant_id)
                                    ->where('order_progress_status',Config::get('constants.ORDER_STATUS.COMPLETED'))
                                    ->where('order_date','>=',$date)
                                    ->sum('grand_total'),0);
            array_push($sales_array,$tempArray);
        }
        $result['sales_array'] = implode(",",$sales_array);
        $result['sales_array'] = "[".$result['sales_array']."]";
        $result['clients'] = "[['".$result['all_clients']."',".$result['all_clients']."],['".$result['new_client']."',".$result['new_client']."]]";
        return view('report.index',compact('result'));
    }

}
