<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Restaurant;
use App\Models\User;
use App\Models\CustomerAddress;
use App\Models\OrderMenuItem;
use App\Notifications\AcceptOrder;
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
                    'message_date'=>date("Y-m-d H:i A"),
                    'isseen'=>true,
                    'order_number'=>$order->order_number,
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

            //Fcm Token push Notification
            $FcmTokenData = User::where('uid',$order->uid)->first();
            $FcmTokenArray = [];
            $FcmTokenArray[] = $FcmTokenData->device_key;

            //Push Notification
            $url = 'https://fcm.googleapis.com/fcm/send';
            $FcmToken = $FcmTokenArray;
            $serverKey = 'AAAAADRQWEU:APA91bEF_KhA3ZYH-yvdByEYV4EC0V1j0nY5gg_yWl3DC-vASs2scPEOBopdmqvqLZwGJt_aaq1HBMGYz1p2Oxo0B8v3X2zA-h7rWgduJXbSac_j6H7IvWtHv13MeMAXJGpsoFa9RfLR';
            $data = [
                "registration_ids" => $FcmToken,
                "notification" => [
                    "title" => $user->first_name." ".$user->last_name,
                    "body" => "Order Accepeted Successfully",
                ]
            ];
            $encodedData = json_encode($data);

            $headers = [
                'Authorization:key=' . $serverKey,
                'Content-Type: application/json',
            ];
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);

            $result = curl_exec($ch);
            curl_close($ch);

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
