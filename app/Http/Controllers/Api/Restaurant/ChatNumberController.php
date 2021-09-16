<?php

namespace App\Http\Controllers\Api\Restaurant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\MenuItem;
use App\Models\Restaurant;
use App\Models\Feedback;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Config;
use Hash;
use DB;

class ChatNumberController extends Controller
{

    public function index(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'restaurant_id' => 'required'
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()], 400);
            }
            $order = Order::where('restaurant_id',$request->restaurant_id)->with('user')->get();
            $result=[];
            foreach ($order as $key => $value) {
                $database = app('firebase.database');
                $url = Config::get('constants.FIREBASE_DB_NAME')."/".$request->restaurant_id."/".$value->order_number;
                $message = $database->getReference($url)->getvalue();
                $count = 0 ;
                if($message){
                    foreach ($message as $key1 => $value1) {
                        if(!$value1['is_read'] && $value1['created_by']=='RESTAURANT'){
                            $count =$count+1;
                        }
                    }
                }
                $result[$key]['order_id'] = $value->order_id;
                $result[$key]['order_number'] = $value->order_number;
                $result[$key]['order_time'] = $value->order_date." ".$value->order_time;
                $result[$key]['order_status'] = $value->order_progress_status;
                $result[$key]['restaurant_id'] = $value->restaurant_id;
                $result[$key]['customer_name'] = $value->user->full_name;
                $result[$key]['cutomer_image'] = $value->user->image_path;
                $result[$key]['unread_msg_count'] = $count ;
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

}
