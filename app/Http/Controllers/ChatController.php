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
                    // dd($value[array_key_last($value)]);
                    $last_messages[$key]['value'] = $value[array_key_last($value)]['message'] ?? "";
                    // $last_messages[$key]['is_seen'] = $value[array_key_last($value)]['message'] == true ?? false;
                    $last_messages[$key]['is_seen'] = isset($value[array_key_last($value)]['message']) ? $value[array_key_last($value)]['message'] == true : false;
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
                'message_date'=>date("Y-m-d H:i A"),
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


            // $FcmToken = User::whereNotNull('device_key')->pluck('device_key')->all();
            $FcmTokenData = User::where('uid', $request->uid)->first();
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
                    "body" => $request->message,
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
