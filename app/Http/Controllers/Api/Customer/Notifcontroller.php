<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Restaurant;
use App\Models\User;
use App\Notifications\PlaceFutureOrderCash;

class Notifcontroller extends Controller
{
    //
    public function send(Request $request){
        try {
            $orderNumber = $request->post('order_no');
            $uid = $request->post('uid');
            $restaurant = Restaurant::with(['order' => function($order) use($uid,$orderNumber){
                $order->with('user')->where('uid',$uid)->where('order_number',$orderNumber)->first();
            }])->find($request->post('restaurant_id'));
            // return response()->json([$restaurant]);
                $title = "Place Order";
                // $fcm_token = 'ezImCoZuTUYOvtfBLRr_0k:APA91bE4DvRJjsBvEWccrTqK2ULA1nLxBrv8NhVbCPNv-_vo3CmJKCFBh7ku9c_2ro4n08A4Z9nDYN-u-qeVel9otNtm8bGLNyLFXLPhsg30NJSmXCe-2Imni4f2AbyOb9EPZf4Zbbqc';// $restaurant->order->user->fcm_id;
                $fcm_token = User::where('uid', $uid)->first()->fcm_id;
                $message = $restaurant->order->user->full_name.' placed a Future Order with Order id '.$restaurant->order->order_number.' using Cash on Pickup. Future order pickup is on '.date('F d,Y',strtotime($restaurant->order->feature_date)).' at '.$restaurant->order->feature_time;
            // return response()->json([$fcm_token]);

                sendPlaceFutureOrder(1,2, $fcm_token, $title, $message, 1);
                // $restaurant->notify(new PlaceFutureOrderCash($restaurant));
            return response()->json([
                'status'=>'OK',
                'message'=>" the notification was send successfully !"
            ], 200);
        } catch (\Exception $th) {
            return response()->json(['message'=>$th->getMessage()], 500);
        }
    }
}
