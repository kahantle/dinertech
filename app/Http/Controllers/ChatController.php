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
            $user = Auth::user()->uid;
            $restaurant = Restaurant::where('uid', $user)->first();
            $orders = Order::where('restaurant_id', $restaurant->restaurant_id)
            ->whereIn('order_progress_status',[
                Config::get('constants.ORDER_STATUS.PREPARED'),
                Config::get('constants.ORDER_STATUS.ACCEPTED')
            ])
            ->with('user');
            $order_number = $request->order_id;
            if($request->order_id){
                $orders = $orders->where('order_number','like','%'.$order_number.'%');
            }
            $orders = $orders->get();
            $resturant_id = $restaurant->restaurant_id;
            return view('chat.index',compact('orders','resturant_id','order_number'));
        }catch (ApiException $e) {
            $request = $e->getRequest();
        }
    }


    public function sendMessages(Request $request) {
        try{
                $database = app('firebase.database');
                $order_id =  $request->order_id;
                $customer_id = $request->customer_id;
                $user = User::where('uid',$customer_id)->first();
                  // Create a key for a new post
                $user_id = Auth::user()->uid;
                $postData =(object) [
                    'full_name' => $user->first_name." ".$user->last_name,
                    'message' => $request->message,
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
                $url = Config::get('constants.FIREBASE_DB_NAME').'/'.$restaurant->restaurant_id.'/'.$order_id."/"."/".$customer_id."/" ;
                $updates = [$url.$newPostKey  => $postData];
                $database->getReference()->update($updates);
                return response()->json(['success'=> true,'message'=> 'Message successfully sent!']);
        }catch (ApiException $e) {
                $request = $e->getRequest();
        }
    }
}
