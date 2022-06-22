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

class ReportController extends Controller
{

    public function index(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'restaurant_id' => 'required',
                'time_duration' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()], 400);
            }
            
            $duaration= $request->post('time_duration');
            $date = \Carbon\Carbon::today()->subDays($duaration);
            $avgStartDate = $date=date_create($date);
            $avgStartDate = date_sub($date,date_interval_create_from_date_string("$duaration days"));
            $avgStartDate = date_format($date,"Y-m-d");


            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()], 400);
            }
            $result =array ();

            $result['time_duration'] = $duaration;
            $result['all_order'] = Order::where('restaurant_id',$request->post('restaurant_id'))
                                        ->count();

            $result['get_order'] = Order::where('restaurant_id',$request->post('restaurant_id'))
                                        ->where('order_date','>=',$date)
                                        ->count();

            $result['last_order_total'] = Order::where('restaurant_id',$request->post('restaurant_id'))
                                        ->where('order_date','>=',$date)
                                        ->where('order_date','<=',$avgStartDate)
                                        ->count();
            $result['order_pr_status'] = (abs($result['get_order'] - $result['last_order_total']))?1:0;


            $result['all_pendingorder'] = Order::where('restaurant_id',$request->post('restaurant_id'))
                                        ->where('order_progress_status',Config::get('constants.ORDER_STATUS.INITIAL'))
                                        ->whereNull('order_status')
                                        ->count();

            $result['get_pendingorder'] = Order::where('restaurant_id',$request->post('restaurant_id'))
                                        ->where('order_progress_status',Config::get('constants.ORDER_STATUS.INITIAL'))
                                        ->whereNull('order_status')
                                        ->where('order_date','>=',$date)
                                        ->count();
            
            $result['last_pending_order_total'] = Order::where('restaurant_id',$request->post('restaurant_id'))
                                        ->whereNull('order_status')
                                        ->where('order_date','>=',$date)
                                        ->where('order_date','<=',$avgStartDate)
                                        ->count();

            $result['pending_order_pr_status'] = (abs($result['get_order'] - $result['last_pending_order_total']))?1:0;

                                
            $result['all_delivery'] = Order::where('restaurant_id',$request->post('restaurant_id'))
                                        ->where('order_progress_status',Config::get('constants.ORDER_STATUS.COMPLETED'))
                                        ->count();

            $result['get_delivery'] = Order::where('restaurant_id',$request->post('restaurant_id'))
                                        ->where('order_progress_status',Config::get('constants.ORDER_STATUS.COMPLETED'))
                                        ->where('order_date','>=',$date)
                                        ->count();

            $result['all_sales'] = Order::where('restaurant_id',$request->post('restaurant_id'))
                                        ->sum('grand_total');

            $result['sales_total'] = Order::where('restaurant_id',$request->post('restaurant_id'))
                                        ->where('order_date','>=',$date)
                                        ->sum('grand_total');

            $result['last_sales_total'] = Order::where('restaurant_id',$request->post('restaurant_id'))
                                        ->where('order_date','>=',$date)
                                        ->where('order_date','<=',$avgStartDate)
                                        ->sum('grand_total');

            $result['all_clients'] = User::where('role',Config::get('constants.ROLES.CUSTOMER'))->count();

            $result['new_client'] = User::where('role',Config::get('constants.ROLES.CUSTOMER'))
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

            $result['all_tip'] = Order::where('restaurant_id',$request->post('restaurant_id'))
                                        // ->where('order_date','>=',$date)
                                        ->sum('tip_amount');
            $result['all_tip'] = number_format($result['all_tip'],2);

            $result['total_tip'] = Order::where('restaurant_id',$request->post('restaurant_id'))
                                        ->where('order_date','>=',$date)
                                        ->where('order_date','<=',$avgStartDate)
                                        ->sum('tip_amount');
            $result['total_tip'] = number_format($result['total_tip'],2);

            for($var=1;$var<=$duaration;$var++) {
                $tempArray['day'] = $var;
                $date = \Carbon\Carbon::today()->subDays($var)->format('Y-m-d');
              //  $tempArray['date'] = $date;
                $tempArray['day_sale'] =  number_format(Order::where('restaurant_id',$request->post('restaurant_id'))
                                        ->where('order_progress_status',Config::get('constants.ORDER_STATUS.COMPLETED'))
                                        ->where('order_date','>=',$date)
                                        ->sum('grand_total'),2);
                $result['sales_graph'][] =$tempArray;
            }
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

}
