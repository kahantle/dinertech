<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use Auth;
use Config;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index()
    {
        $database = app('firebase.database');
        $userId = Auth::user()->uid;
        $restaurantId = session()->get('restaurantId');
        $getChats = $database->getReference('chats/' . $restaurantId)->getValue();
        $orderArray = array();
        foreach ($getChats as $orderId => $chat) {
            if (isset($chat[$userId])) {
                $messageDate = array_column($chat[$userId], 'message_date');
                $orderArray[] = ['order_id' => $orderId, 'message_date' => date('F d, h:i A', strtotime(end($messageDate)))];
            }
        }

        $data['orderIds'] = $orderArray;
        $data['getChats'] = $getChats;
        $data['title'] = 'Chat';
        $data['cartMenus'] = getCartItem();
        $data['cards'] = getUserCards($restaurantId, $userId);
        $data['uid'] = $userId;
        $data['resturantId'] = $restaurantId;
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
            $database->getReference()->update($updates);
            return true;
        }
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
