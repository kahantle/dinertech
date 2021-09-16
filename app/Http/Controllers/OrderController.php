<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Restaurant;
use App\Models\User;
use App\Models\CustomerAddress;
use App\Models\OrderMenuItem;
use Auth;
use DB;
use Config;
use Toastr;
use Carbon;
use PDF;


class OrderController extends Controller
{
	public function index(){
		$uid = Auth::user()->uid;
		$restaurant = Restaurant::where('uid', $uid)->first();
        // if(session()->get('restaurantId') != '')
        // {
        //     $restaurant->restaurant_id = session()->get('restaurantId');
        // }
        $completedOrders = Order::where('restaurant_id',$restaurant->restaurant_id)->where('order_progress_status','COMPLETED')->get();
        $canceldOrders = Order::where('restaurant_id',$restaurant->restaurant_id)->where('order_progress_status','CANCEL')->get();
        return view('orders.index',compact('completedOrders','canceldOrders'));
	}

	public function showOrderDetails($id){
		$order = Order::where('order_id',$id)->with('orderItems')->first();
		$userdata = User::where('uid',$order->uid)->first();
		$orderAddress = CustomerAddress::where('customer_address_id',$order->address_id)->first();
		return view('orders.order-details',compact('order','userdata','orderAddress'));
	}

	public function OrderAction(Request $request,$id,$action){
        try {
            $message = strtolower($action);
            $message = "Order $message successfully.";
            $order = Order::where('order_id',$id)->first();
            $uid = Auth::user()->uid;
    		$restaurant = Restaurant::where('uid', $uid)->first();
            if(!$order){
                return response()->json(['route'=>route('dashboard'),'alert'=>[ $message,'', Config::get('constants.toster')],'success' => true],200);
            }
            $order->order_progress_status = $action;
            $order->action_time =  date('Y-m-d h:i:s');
            if($action==='ACCEPTED'){
                if($request->post('type')==='hours'){
                    $order->pickup_time = $request->post('minutes')." Hours";
                }else{
                    $order->pickup_time = $request->post('minutes')." Minutes";
                }
            }
            $order->order_status = ($action==Config::get('constants.ORDER_STATUS.CANCEL'))?0:1;
            $order->save();
            //removed if order completed 
            if($action==Config::get('constants.ORDER_STATUS.COMPLETED')){
                $database = app('firebase.database');
                $url = Config::get('constants.FIREBASE_DB_NAME').'/'.$restaurant->restaurant_id."/".$order->order_number."/";
                $database->getReference($url)->remove();
            }

            return response()->json(['route'=>route('dashboard'),'alert'=>[$message ,'', Config::get('constants.toster')],'success' => true], 200);
        } catch (\Throwable $th) {
            $errors['success'] = false;
            $errors['message'] =  $th->getMessage();
            return response()->json($errors, 401);
        }
    }

    public function generate_invoice($id){
        try{

                $order = Order::where('order_id',$id)->with('orderItems')->first();
                $pdf = PDF::loadView('orders.pdf',compact('order'));
                $pdf_name =$order->order_number.'.pdf';
                return $pdf->download('dinertech_'.$order->order_number.'.pdf');
        }catch(Exception $e){
                echo '<pre>',print_r($e),'</pre>';
        }
    }
}
