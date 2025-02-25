<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Models\Order;
use App\Models\RestaurantUser;
use Auth;
use Config;
use Illuminate\Http\Request;
use App\Models\User;

class ChatController extends Controller
{
    public function index()
    {
        $database = app('firebase.database');
        $userId = Auth::user()->uid;
        $restaurantId = session()->get('restaurantId');
        $getChats = $database->getReference('chats/' . $restaurantId)->getValue();
        $orderArray = array();
        if($getChats!=null)
        {
            foreach ($getChats as $orderId => $chat) {
                if (isset($chat[$userId])) {
                    $messageDate = array_column($chat[$userId], 'message_date');
                    $orderArray[] = ['order_id' => $orderId, 'message_date' => date('F d, h:i A', strtotime(end($messageDate)))];
                }
            }
        }


        $data['orderIds'] = $orderArray;
        $data['getChats'] = $getChats;
        $data['title'] = 'Chat';
        $data['cartMenus'] = getCartItem();
        $data['cards'] = getUserCards($restaurantId, $userId);
        $data['uid'] = $userId;
        $data['resturantId'] = $restaurantId;
        // dd(Auth::user()->profile_image);
        return view('customer.chat.index', $data); 
    }

    public function getChat(Request $request)
    {
        if ($request->ajax() && !empty($request->orderId)) {
            $orderId = $request->orderId;
            $database = app('firebase.database');
            $userId = Auth::user()->uid;
            $restaurantId = session()->get('restaurantId');
            $getChats = $database->getReference('chats/' . $restaurantId . '/' . $orderId . '/' . $userId)->getValue();

            $data['chats'] = $getChats;
            return view('customer.chat.messages', $data)->render();
        }
    }

    public function sendMessage(Request $request)
    {
        if ($request->ajax()) {
            date_default_timezone_set(session()->get('sys_timezone'));
            $database = app('firebase.database');
            $orderId = $request->orderId;
            $message = $request->message;
            $userId = Auth::user()->uid;
            $fullName = Auth::user()->first_name . ' ' . Auth::user()->last_name;
            $restaurantId = session()->get('restaurantId');
            $messageData = (object) [
                'sender' => $userId,
                'receiver' => $restaurantId,
                'message' => $message,
                'isseen' => false,
                'full_name' => $fullName,
                'order_number' => $orderId,
                'message_date' => date("Y-m-d H:i A"),
                'sent_from' => Config::get('constants.ROLES.CUSTOMER'),
                'user_id' => $userId,
            ];

            $newPostKey = $database->getReference(Config::get('constants.FIREBASE_DB_NAME'))->push()->getKey();
            $url = Config::get('constants.FIREBASE_DB_NAME') . '/' . $restaurantId . '/' . $orderId . "/" . $userId . "/";
            $updates = [$url . $newPostKey => $messageData];



            //Push Notification
            $FcmTokenData = User::where('uid',$restaurantId)->first();
            $FcmTokenArray = [];
            $FcmTokenArray[] = $FcmTokenData->device_key;
            $name = Auth::user()->first_name . ' ' . Auth::user()->last_name .' ['. $orderId .']';
            $dynamicTitle =$name;

               $url = 'https://fcm.googleapis.com/fcm/send';
               $FcmToken = $FcmTokenArray;
            //    $FcmToken = User::whereNotNull('device_key')->pluck('device_key')->all();

               $serverKey = 'AAAAADRQWEU:APA91bEF_KhA3ZYH-yvdByEYV4EC0V1j0nY5gg_yWl3DC-vASs2scPEOBopdmqvqLZwGJt_aaq1HBMGYz1p2Oxo0B8v3X2zA-h7rWgduJXbSac_j6H7IvWtHv13MeMAXJGpsoFa9RfLR';
               $data = [
                   "registration_ids" => $FcmToken,
                   "notification" => [
                       "title" =>$dynamicTitle,
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

               if ($result === FALSE) {
                   die('Curl failed: ' . curl_error($ch));
               }
               curl_close($ch);

            //Push Notification Code Over

            $database->getReference()->update($updates);
            $restaurant = Restaurant::with(['order' => function ($order) use ($orderId, $restaurantId) {
                $order->where('order_number', $orderId)->where('restaurant_id', $restaurantId)->first();
            }])->first();
            $messageCount = $restaurant->order->customer_msg_count + 1;
            Order::where('order_number',$orderId)->where('restaurant_id',$restaurantId)->update(['customer_msg_count' => $messageCount]);
            return true;
        }
    }
    public function storeToken(Request $request)
    {
        auth()->user()->update(['device_key'=>$request->token]);
        return response()->json(['Token successfully stored.']);
    }

    public function chatExport($orderId)
    {
        $database = app('firebase.database');
        $userId = Auth::user()->uid;
        $restaurantId = session()->get('restaurantId');
        $getChats = $database->getReference('chats/' . $restaurantId . '/' . $orderId . '/' . $userId)->getValue();
        $data['chats'] = $getChats;
        $data['restaurant'] = Restaurant::where('restaurant_id', $restaurantId)->first();
        $data['orderId'] = $orderId;
        $pdf = \PDF::loadView('customer.chat.pdf', $data);
        return $pdf->download($orderId . '.pdf');
    }
}
