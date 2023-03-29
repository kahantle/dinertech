<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Kreait\Firebase;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Carbon\Carbon;
use Kreait\Firebase\Database;
use App\Models\Order;
use App\Models\User;
use App\Models\Restaurant;
use Config;
use Auth;

class ChatController extends Controller
{

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

   public function index(Request $request){

        try{
            $database = app('firebase.database');
            $user = Auth::user()->uid;
            $restaurant = Restaurant::where('uid', $user)->first();
            $orders = Order::where('restaurant_id', $restaurant->restaurant_id)
            ->whereIn('order_progress_status',[
                Config::get('constants.ORDER_STATUS.PREPARED'),
                Config::get('constants.ORDER_STATUS.ACCEPTED'),
                Config::get('constants.ORDER_STATUS.ORDER_DUE')
            ])
            ->with('user');
            $orderNumber = $request->order_number;
            if($orderNumber){
                $orders = $orders->where('order_number','like','%'.$orderNumber.'%');
            }
            $orders = $orders->get();
            $resturant_id = $restaurant->restaurant_id;

            foreach ($orders as $key => $order) {
                $reference = $this->database->getReference('/chats/'.$resturant_id.'/'.$order->order_number.'/'.$order->user->uid.'/');
                if ($value = $reference->getValue()) {
                    $last_messages[$key]['value'] = $value[array_key_last($value)]['message'];
                    $last_messages[$key]['is_seen'] = $value[array_key_last($value)]['message'] == true ?? false;
                } else {
                    $last_messages[$key]['value'] = "";
                    $last_messages[$key]['is_seen'] = "";
                }
            }
            // return  $last_messages;
            return view('chat.index',compact('orders','resturant_id','orderNumber','last_messages'));
        }catch (ApiException $e) {
            $request = $e->getRequest();
        }
    }

    public function sendMessages(Request $request) {
        try{
            $database = app('firebase.database');
            $order_id =  $request->order_id;
            $customer_id= $request->customer_id;
            $uid=$request->uid;
            $user = User::where('uid',$customer_id)->first();
                // Create a key for a new post
            $user_id = Auth::user()->uid;

            $userid=Auth::user();
            $postData =(object) [
                'full_name' => $user->first_name." ".$user->last_name,
                'message' => $request->message,
                'message_date'=>date("Y-m-d H:i:s"),
                'isseen'=>false,
                'order_number'=>$order_id,
                'receiver'=>$customer_id,
                'sender'=>$user_id,
                'sent_from'=> Config::get('constants.ROLES.RESTAURANT'),
                'user_id'=>$customer_id
            ];
            $restaurant = Restaurant::where('uid', $user_id)->first();
            // $newPostKey = $database->getReference(Config::get('constants.FIREBASE_DB_NAME'))->push()->getKey();
            // $url = Config::get('constants.FIREBASE_DB_NAME').'/'.$restaurant->restaurant_id.'/'.$order_id."/".$customer_id ;
            // return $url.$newPostKey;
            // $updates = [$url.$newPostKey  => $postData];
            // $database->getReference()->update($updates);
            // $database->getReference(Config::get('constants.FIREBASE_DB_NAME'))->update($updates);
            $url = Config::get('constants.FIREBASE_DB_NAME').'/'.$restaurant->restaurant_id.'/'.$order_id."/".$customer_id.'/';

            $database->getReference($url)->push($postData);
         
            // FCM response

            return response()->json(['success'=> true,'message'=> 'Message successfully sent!']);
        }catch (ApiException $e) {
            $request = $e->getRequest();
        }
    }
        public function storeToken(Request $request)
        {
            auth()->user()->update(['device_key'=>$request->token]);
            return response()->json(['Token successfully stored.']);
        }

    public function readChatMessage(Request $request)
    {
        if ($request->ajax()) {
            $uid = Auth::user()->uid;
            $restaurant = Restaurant::where('uid', $uid)->first();
            $restaurantId = $restaurant->restaurant_id;
            $orderNumber = $request->post('order_number');
            $order = Order::where('order_number',$orderNumber)->where('restaurant_id', $restaurantId)->first();
            if($order){
                $database = app('firebase.database');
                $url = Config::get('constants.FIREBASE_DB_NAME') . "/" . $restaurantId . "/" . $order->order_number . "/" . $order->uid . "/";
                $messages = $database->getReference($url)->getvalue();
                if($messages){
                    foreach ($messages as $key => $value) {
                        if ($value['sent_from'] == Config::get('constants.ROLES.CUSTOMER')) {
                            $value['isseen'] = true;
                            $updateUrl = $url.'/'.$key.'/';
                            $updates[$updateUrl]  = $value;
                            $database->getReference()->update($updates);
                            if($order->customer_msg_count > 0){
                                $messageCount = 0;
                                Order::where('order_number',$orderNumber)->where('restaurant_id', $restaurantId)->update(['customer_msg_count' => $messageCount]);
                            }
                        }
                    }
                }
                return true;
            }
        }

    }
}
