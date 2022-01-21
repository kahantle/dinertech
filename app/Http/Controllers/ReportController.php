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


        $duaration= ($request->get('duration'))?$request->get('duration'):1;
        $date = \Carbon\Carbon::today()->subDays($duaration);
        $avgStartDate = $date=date_create($date);
        $avgStartDate = date_sub($date,date_interval_create_from_date_string("$duaration days"));
        $avgStartDate = date_format($date,"Y-m-d");  
        $result =array ();
        $result['time_duration'] = $duaration;


        $result['all_order'] = Order::where('restaurant_id',$restaurant ->restaurant_id)
                                    ->count();



        $current_date = date("Y-m-d");
        $sub_date = \Carbon\Carbon::today()->subDays($duaration);
        $result['get_order'] = Order::where('restaurant_id',$restaurant ->restaurant_id)
        ->where('order_date','>',$sub_date)
        ->count();

        $result['get_order_pr'] = Order::where('restaurant_id',$restaurant ->restaurant_id)
        ->where('order_date','>=',$avgStartDate)
        ->where('order_date','<',$sub_date)
        ->count();

        $order_pr = ($result['get_order_pr'])?$result['get_order_pr']:1;
        $result['order_pr_status'] = (100* $result['get_order'])/ $order_pr;





        $result['all_pendingorder'] = Order::where('restaurant_id',$restaurant ->restaurant_id)
                                    ->where('order_progress_status',Config::get('constants.ORDER_STATUS.INITIAL'))
                                    ->whereNull('order_status')
                                    ->count();

        $result['get_pendingorder'] = Order::where('restaurant_id',$restaurant ->restaurant_id)
        ->where('order_progress_status',Config::get('constants.ORDER_STATUS.INITIAL'))
        ->whereNull('order_status')
        ->where('order_date','>=',$sub_date)
        ->where('order_date','<',$current_date)
        ->count();
        
        $result['get_pending_order_pr'] = Order::where('restaurant_id',$restaurant ->restaurant_id)
        ->where('order_progress_status',Config::get('constants.ORDER_STATUS.INITIAL'))
        ->whereNull('order_status')
        ->where('order_date','>=',$avgStartDate)
        ->where('order_date','<',$sub_date)
        ->count();

        $pending_order_pr = ($result['get_pending_order_pr'])?$result['get_pending_order_pr']:1;
        $result['pending_order_pr_status'] = (100* $result['get_pendingorder'])/ $pending_order_pr;
        

                            
        $result['all_delivery'] = Order::where('restaurant_id',$restaurant ->restaurant_id)
                                    ->where('order_progress_status',Config::get('constants.ORDER_STATUS.COMPLETED'))
                                    ->count();

        $result['get_delivery'] = Order::where('restaurant_id',$restaurant ->restaurant_id)
                                    ->where('order_progress_status',Config::get('constants.ORDER_STATUS.COMPLETED'))
                                    ->where('order_date','>=',$date)
                                    ->count();

        $restaurant_id = $restaurant ->restaurant_id;
        $result['repeat_clients'] = User::where('role',Config::get('constants.ROLES.CUSTOMER'))
                                    ->whereHas('orders',function($query)use($restaurant_id){
                                        $query->where('restaurant_id',$restaurant_id);
                                    })
                                    ->where('created_at','<=',$date)
                                    ->get();
        $result['new_client'] = User::where('role',Config::get('constants.ROLES.CUSTOMER'))
                                ->whereHas('orders',function($query)use($restaurant_id){
                                    $query->where('restaurant_id',$restaurant_id);
                                })
                                ->where('created_at','>=',$date)
                                ->count();

        $result['clients'] = "[['".$result['new_client']."',".$result['new_client']."],['".$result['repeat_clients']."',".$result['repeat_clients']."]]";

        


        $result['all_sales'] = Order::where('restaurant_id',$restaurant ->restaurant_id)
                                    ->sum('grand_total');

        $result['sales_total'] = Order::where('restaurant_id',$restaurant ->restaurant_id)
                                    ->where('order_date','>=',$sub_date)
                                    ->sum('grand_total');
        
        $result['current_week_sale'] = Order::where('restaurant_id',$restaurant ->restaurant_id)
                                    ->where('order_date','>=',$sub_date)
                                    ->where('order_date','<=',$current_date)
                                    ->sum('grand_total');
        
        $result['last_week_sale'] = Order::where('restaurant_id',$restaurant ->restaurant_id)
        ->where('order_date','>=',$avgStartDate)
        ->where('order_date','<=',$sub_date)
        ->sum('grand_total');

        $sales_per_status = ($result['last_week_sale'])?$result['last_week_sale']:1;
        $result['sales_per'] = (($result['current_week_sale'] - $result['last_week_sale'])/$sales_per_status)*100;


    
        $your_date = date("Y-m-d");
        $datediff = $this->dateDiff($restaurant->created_at, $your_date);                     
        $days_diff = $datediff / $duaration;

        $result['avg_values'] =  number_format(($result['all_sales'] /  $days_diff) ,2);
        $sales_pr = ($result['sales_total'] > 0)? (($result['sales_total'] - $result['last_week_sale'])/$result['sales_total'] )*100:0;
        
        $result['sales_pr_status'] = (abs($result['sales_total'] - $result['last_week_sale']))?1:0;


        $result['sales_total'] = number_format( $result['sales_total'] ,2);
        $result['all_sales'] = number_format( $result['all_sales'] ,2);
        $result['sales_pr'] =  number_format($sales_pr,2);

        $sales_array =array();
        for($var=1;$var<=$duaration;$var++) {
            $date = \Carbon\Carbon::today()->subDays($var)->format('Y-m-d');
            $tempArray=  number_format(Order::where('restaurant_id',$restaurant ->restaurant_id)
                                    ->where('order_progress_status',Config::get('constants.ORDER_STATUS.COMPLETED'))
                                    ->where('order_date','>=',$date)
                                    ->sum('grand_total'),0);
            array_push($sales_array,$tempArray);
        }
        $result['sales_array'] = implode(",",$sales_array);
        $result['sales_array'] = "[".$result['sales_array']."]";
        return view('report.index',compact('result'));
    }

    function dateDiff($date1, $date2)
{
    $date1_ts = strtotime($date1);
    $date2_ts = strtotime($date2);
    $diff = $date2_ts - $date1_ts;
    return round($diff / 86400);
}
}
