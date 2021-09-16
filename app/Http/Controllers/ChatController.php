<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Kreait\Firebase;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Carbon\Carbon;
use Kreait\Firebase\Database;
use App\Models\Order;
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
            ->where('order_progress_status','!=',Config::get('constants.ORDER_STATUS.COMPLETED'))
            ->with('user');
            if($request->order_id){
                $orders = $orders->where('order_id',$request->order_id);
            }
            $orders = $orders->get();
            $resturant_id = $restaurant->restaurant_id;
            return view('chat.index',compact('orders','resturant_id'));
        }catch (ApiException $e) {
            $request = $e->getRequest();
        }
    }


    public function sendMessages(Request $request) {
        try{
                $database = app('firebase.database');
                $order_id =  $request->order_id;
                $postData =(object) [
                    'text' => $request->message,
                    'date_time'=>date("Y-m-d h:i:s"),
                    'is_read'=>1,
                    'created_by'=> Config::get('constants.ROLES.RESTAURANT'),
                ];
                // Create a key for a new post
                $user = Auth::user()->uid;
                $restaurant = Restaurant::where('uid', $user)->first();
                $newPostKey = $database->getReference(Config::get('constants.FIREBASE_DB_NAME'))->push()->getKey();
                $url = Config::get('constants.FIREBASE_DB_NAME').'/'.$restaurant->restaurant_id.'/'.$order_id."/";
                $updates = [$url.$newPostKey  => $postData];
                $database->getReference()->update($updates);
                return response()->json(['success'=> true,'message'=> 'Message successfully sent!']);
        }catch (ApiException $e) {
                $request = $e->getRequest();
        }
    }
}
