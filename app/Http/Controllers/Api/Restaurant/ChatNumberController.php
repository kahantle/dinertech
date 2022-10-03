<?php

namespace App\Http\Controllers\Api\Restaurant;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Restaurant;
use App\Models\User;
use App\Notifications\CustomerChat;
use Config;
use Illuminate\Http\Request;
use Validator;

class ChatNumberController extends Controller
{

    public function index(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'restaurant_id' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()], 400);
            }
            $order = Order::where('restaurant_id', $request->restaurant_id)->with('user')->get();
            $result = [];
            foreach ($order as $key => $value) {
                $database = app('firebase.database');
                $url = Config::get('constants.FIREBASE_DB_NAME') . "/" . $request->restaurant_id . "/" . $value->order_number . "/" . $order->uid . "/";
                $message = $database->getReference($url)->getvalue();
                $count = 0;
                if ($message) {
                    foreach ($message as $key1 => $value1) {
                        if (!$value1['is_read'] && $value1['created_by'] == 'RESTAURANT') {
                            $count = $count + 1;
                        }
                    }
                }
                $result[$key]['order_id'] = $value->order_id;
                $result[$key]['order_number'] = $value->order_number;
                $result[$key]['order_time'] = $value->order_date . " " . $value->order_time;
                $result[$key]['order_status'] = $value->order_progress_status;
                $result[$key]['restaurant_id'] = $value->restaurant_id;
                $result[$key]['customer_name'] = $value->user->full_name;
                $result[$key]['cutomer_image'] = $value->user->image_path;
                $result[$key]['unread_msg_count'] = $count;
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

    public function sendChatNotification(Request $request)
    {
        try {
            $request_data = $request->json()->all();
            $validator = Validator::make($request_data, [
                'order_number' => 'required',
                'message' => 'required',
                'restaurant_id' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()], 400);
            }
            $orderNumber = $request->post('order_number');
            $restaurantId = $request->post('restaurant_id');
            $message = $request->post('message');
            $order = Order::where('order_number', $orderNumber)->where('restaurant_id', $restaurantId)->first();
            $user = User::where('uid', $order->uid)->first();
            $messageData = ['message' => $message, 'chat_data' => $request->post('chat_data'), 'order_id' => (string) $order->order_id, 'order_number' => (string) $order->order_number];
            $user->notify(new CustomerChat($messageData));
            return response()->json(['message' => 'Chat notification send successfully.', 'success' => true], 200);
        } catch (\Throwable $th) {
            $errors['success'] = false;
            $errors['message'] = Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS');
            if ($request->debug_mode == 'ON') {
                $errors['debug'] = $th->getMessage();
            }
            return response()->json($errors, 401);
        }
    }

    public function readChatMessage(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'restaurant_id' => 'required',
                'order_number'  => 'required'
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()], 400);
            }
            $restaurantId = $request->post('restaurant_id');
            $order = Order::where('order_number',$request->post('order_number'))->where('restaurant_id', $restaurantId)->first();
            if($order){
                $database = app('firebase.database');
                $url = Config::get('constants.FIREBASE_DB_NAME') . "/" . $restaurantId . "/" . $order->order_number . "/" . $order->uid . "/";
                $messages = $database->getReference($url)->getvalue();
                if($messages){
                    foreach ($messages as $key => $value) {
                        if ($value['sent_from'] == Config::get('constants.ROLES.CUSTOMER')) {
                            $updates = (object)[];
                            $value['isseen'] = true;
                            $updateUrl = $url.'/'.$key.'/';
                            $updates[$updateUrl]  = $value;
                            $database->getReference()->update($updates);
                            if($order->customer_msg_count > 0){
                                $messageCount = 0;
                                Order::where('order_number',$request->post('order_number'))->where('restaurant_id', $restaurantId)->update(['customer_msg_count' => $messageCount]);
                            }
                        }
                    }
                }
                return response()->json(['message' => 'Message read successfully.', 'success' => true], 200);
            }else{
                return response()->json(['message' => 'Order not found.', 'success' => false], 200);
            }
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
