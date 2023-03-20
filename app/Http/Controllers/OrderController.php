<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Restaurant;
use App\Models\User;
use App\Models\CustomerAddress;
use App\Models\OrderMenuItem;
use Kreait\Firebase\Database;
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
            $orderPickupTime = null;
    		$restaurant = Restaurant::where('uid', $uid)->first();
            if(!$order){
                return response()->json(['route'=>route('dashboard'),'alert'=>[ $message,'', Config::get('constants.toster')],'success' => true],200);
            }

            $order->order_progress_status = $action;
            $order->action_time =  date('Y-m-d h:i:s');
            if($action==='ACCEPTED'){
                $pikUpTime = Carbon\Carbon::parse($request->post('pick_up_time'))->format('Y-m-d h:i:s A');
                $database = app('firebase.database');
                $order_id =  $id;
                $customer_id = $order->uid;
                $user = User::where('uid',$customer_id)->first();
                  // Create a key for a new post
                $user_id = Auth::user()->uid;
                $postData =(object) [
                    'full_name' => $user->first_name." ".$user->last_name,
                    'message' => 'How may I help you',
                    'message_date'=>date("Y-m-d h:i:A"),
                    'isseen'=>true,
                    'order_number'=>$order_id,
                    'receiver'=>$customer_id,
                    'sender'=>$user_id,
                    'sent_from'=> Config::get('constants.ROLES.RESTAURANT'),
                    'user_id'=>$customer_id
                ];
                $restaurant = Restaurant::where('uid', $user_id)->first();
                $newPostKey = $database->getReference(Config::get('constants.FIREBASE_DB_NAME'))->push()->getKey();
                $url = Config::get('constants.FIREBASE_DB_NAME').'/'.$restaurant->restaurant_id.'/'.$order->order_number."/"."/".$order->uid."/" ;
                $updates = [$url.$newPostKey  => $postData];
                $database->getReference()->update($updates);

                $order->pickup_time = $pikUpTime;
                $order->pickup_minutes = $request->post('minutes');
            }
            $order->order_status = ($action==Config::get('constants.ORDER_STATUS.CANCEL'))?0:1;
            $order->save();
            //removed if order completed
            if($action==Config::get('constants.ORDER_STATUS.COMPLETED')){
                $database = app('firebase.database');
                $url = Config::get('constants.FIREBASE_DB_NAME').'/'.$restaurant->restaurant_id."/".$order->order_number."/".$order->uid."/";
                $database->getReference($url)->remove();
            }

            return response()->json(['route'=>route('dashboard'),'alert'=>[$message ,'', Config::get('constants.toster')],'order_pickup_time' => $orderPickupTime,'success' => true], 200);
        } catch (\Throwable $th) {
            $errors['success'] = false;
            $errors['message'] =  $th->getMessage();
            return response()->json($errors, 401);
        }
    }

    public function generate_invoice($id){
        try{
            $order = Order::where('order_id',$id)->with('orderItems')->first();
            $uid = Auth::user()->uid;
            $user = User::where('uid', $uid)->first();
            $restaurant = Restaurant::where('uid', $uid)->first();
            $pdf = PDF::loadView('orders.pdf',compact('order','restaurant','user'));
            return $pdf->download('dinertech_'.$order->order_number.'.pdf');
        }catch(Exception $e){
                echo '<pre>',print_r($e),'</pre>';
        }
    }

    public function orderDueStatus(Request $request)
    {
        $orderId = $request->post('orderId');
        $order = Order::where('order_id',$orderId)->first();
        if($order)
        {
            $order->order_progress_status = Config::get('constants.ORDER_STATUS.ORDER_DUE');
            $order->save();
            return response()->json(['success' => true], 200);
        }
        else
        {
            return response()->json(['success' => false], 200);
        }
    }
}
