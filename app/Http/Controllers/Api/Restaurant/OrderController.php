<?php

namespace App\Http\Controllers\Api\Restaurant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\CustomerAddress;
use Config;
use App\Models\Restaurant;
use App\Models\Order;
use App\Models\OrderMenuItem;
use App\Models\OrderMenuGroup;
use App\Models\OrderMenuGroupItem;
use App\Models\User;
use App\Notifications\AcceptOrder;
use App\Notifications\DeclineOrder;
use App\Notifications\PreparedOrder;
use DB;

class OrderController extends Controller
{
    public function getOrderList(Request $request)
    {

        try {
            $request_data = $request->json()->all();
            $validator = Validator::make($request_data,['restaurant_id' => 'required','order_status' => 'required|integer']);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()], 400);
            }
            $today = \Carbon\Carbon::now();
            $list = Order::where('restaurant_id', $request->post('restaurant_id'))
            ->where('order_status',$request->post('order_status'))
            ->with('user');

            if($request->post('order_status') == 0)
            {
                $list = $list->whereDate('order_date','=',$today->format('Y-m-d'));
            }
            $list = $list->get();
            $result = [];
            foreach($list as $key => $order)
            {
                if($order->order_progress_status == Config::get('constants.ORDER_STATUS.COMPLETED'))
                {
                    if((date("Y-m-d",strtotime($order->order_date)) >= date('Y-m-d', strtotime('-7 days'))) && (date("Y-m-d",strtotime($order->order_date)) <= $today->format('Y-m-d')))
                    {
                        $result[] = $order;
                    }
                }
                else
                {
                    $result[] = $order;
                }
            }
            return response()->json(['order_list' => $result, 'success' => true], 200);
        } catch (\Throwable $th) {
            $errors['success'] = false;
            $errors['message'] = Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS');
            if ($request->debug_mode == 'ON') {
                $errors['debug'] = $th->getMessage();
            }
            return response()->json($errors, 500);
        }
    }

    public function getOrderById(Request $request)
    {
        try {
            $result =[];
            $request_data = $request->json()->all();
            $validator = Validator::make($request_data,['restaurant_id' => 'required','order_id' => 'required']);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()], 400);
            }
            $order = Order::where('restaurant_id', $request->post('restaurant_id'))
                ->where('order_id',$request->post('order_id'))
                ->with('orderItems','orderItems.orderModifierItems','user','address')
                ->first();
            return response()->json(['order' => $order, 'success' => true], 200);
        } catch (\Throwable $th) {
            $errors['success'] = false;
            $errors['message'] = Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS');
            if ($request->debug_mode == 'ON') {
                $errors['debug'] = $th->getMessage();
            }
            return response()->json($errors, 500);
        }
    }

    public function add(Request $request)
    {
        try {
            $request_data = $request->json()->all();
            $validator = Validator::make($request_data,[
                'restaurant_id' => 'required',
                'cart_charge' => 'required',
                'delivery_charge' => 'required',
                'discount_charge' => 'required',
                'grand_total' => 'required',
                'address_id' => 'required',
                'is_feature' => 'required',
                'order_date' => 'required',
                'order_time' => 'required',
                'payment_card_id' => 'required',
                'stripe_payment_id' => 'required',
                'menu_item'=>'required'
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()], 400);
            }
            $uid = auth('api')->user()->uid;

            DB::beginTransaction();
            $order = new Order;
            $order->uid = $uid;
            $order->restaurant_id = $request->post('restaurant_id');
            $order->order_number = random_int(10,100);
            $order->payment_card_id = $request->post('payment_card_id');
            $order->stripe_payment_id = $request->post('stripe_payment_id');
            $order->cart_charge = $request->post('cart_charge');
            $order->delivery_charge = $request->post('delivery_charge');
            $order->discount_charge = $request->post('discount_charge');
            $order->is_feature = $request->post('is_feature');
            $order->address_id = $request->post('address_id');
            $order->order_date = date("Y-m-d",strtotime($request->post('order_date')));
            $order->order_time = date("h:m:s",strtotime($request->post('order_time')));
            $order->feature_date = date("Y-m-d",strtotime($request->post('feature_date')));
            $order->feature_time = date("h:m:s",strtotime($request->post('feature_time')));
            $order->isPickUp = $request->post('isPickUp');
            $order->delivery_charge = $request->post('delivery_charge');
            $order->comments = $request->post('comments');
            $order->grand_total = $request->post('grand_total');
            $order->order_progress_status = Config::get('constants.ORDER_STATUS.INTIAL');
            if($order->save()){
                foreach ($request->post('menu_item') as $key => $menuItem) {
                    $menuItemData = New OrderMenuItem;
                    $menuItemData->menu_id =    $menuItem['menu_id'];
                    $menuItemData->menu_name =  $menuItem['menu_name'];
                    $menuItemData->menu_total = $menuItem['menu_total'];
                    $menuItemData->menu_qty =   $menuItem['menu_qty'];
                    $menuItemData->menu_total = $menuItem['menu_total'];
                    $menuItemData->modifier_total = $menuItem['modifier_total'];
                    $menuItemData->order_id =$order->order_id;
                    if($menuItemData->save()){
                        foreach ($menuItem['modifier_list'] as $key => $modifierGroup) {
                            $menuModifier = New OrderMenuGroup;
                            $menuModifier->modifier_group_id = $modifierGroup['modifier_group_id'];
                            $menuModifier->modifier_group_name = $modifierGroup['modifier_group_name'];
                            $menuModifier->order_menu_item_id = $menuItemData->order_menu_item_id;
                            $menuModifier->menu_id =    $menuItem['menu_id'];
                            $menuModifier->order_id =$order->order_id;
                            if($menuModifier->save()){
                            foreach ($modifierGroup['modifier_item'] as $key => $modierMenu) {
                                    $menuModifierMenu = New OrderMenuGroupItem;
                                    $menuModifierMenu->order_menu_item_id = $menuItemData->order_menu_item_id;
                                    $menuModifierMenu->order_modifier_group_id = $menuModifier->order_modifier_group_id;
                                    $menuModifierMenu->modifier_item_id = $modierMenu['modifier_item_id'];
                                    $menuModifierMenu->modifier_group_id = $modierMenu['modifier_group_id'];
                                    $menuModifierMenu->menu_id = $menuItem['menu_id'];
                                    $menuModifierMenu->order_id =$order->order_id;
                                    $menuModifierMenu->modifier_group_item_name = $modierMenu['modifier_group_item_name'];
                                    $menuModifierMenu->save();
                                }
                            }else{
                                return response()->json(['message' => "Order does not added successfully.", 'success' => true], 401);
                            }
                        }
                    }else{
                        return response()->json(['message' => "Order does not added successfully.", 'success' => true], 401);
                    }
                }
                DB::commit();
                return response()->json(['message' => "Order added successfully.", 'success' => true], 200);
            }else{
                DB::rollBack();
                return response()->json(['message' => "Order does not added successfully.", 'success' => true], 401);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $errors['success'] = false;
            $errors['message'] = Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS');
            if ($request->debug_mode == 'ON') {
                $errors['debug'] = $th->getMessage();
            }
            return response()->json($errors, 500);
        }
    }


    public function makeOrder(Request $request)
    {
        try {
            $request_data = $request->json()->all();
            $validator = Validator::make($request_data,[
                'restaurant_id' => 'required',
                'order_id' => 'required',
                'pickup_time' => 'required',
                'pickup_minutes' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()], 400);
            }
            DB::beginTransaction();
            $order =  Order::where('restaurant_id', $request->post('restaurant_id'))
            ->where('order_id',$request->post('order_id'))
            ->whereNull('order_status')
            ->first();
            if(!$order){
                return response()->json(['message' => "Invalid Order or already procceed.", 'success' => true], 401);
            }

            $order->isPickUp = true;
            $order->pickup_time = $request->post('pickup_time');
            $order->pickup_minutes = $request->post('pickup_minutes');
            $order->order_status = 1;
            $order->order_progress_status = Config::get('constants.ORDER_STATUS.ACCEPTED');
            if($order->save()){
                DB::commit();
                $user = User::find($order->uid);
                $user->notify(new AcceptOrder);
                $database = app('firebase.database');
                $order_id =  $order->order_number;
                $customer_id = $order->uid;
                $user = User::where('uid',$customer_id)->first();
                $user_id = $request->post('restaurant_id');
                $postData =(object) [
                    'full_name' => $user->first_name." ".$user->last_name,
                    'message' => 'How may I help you',
                    'message_date'=>date("Y-m-d h:i:A"),
                    'isseen'=>true,
                    'order_number'=>$order_id,
                    'receiver'=>$customer_id,
                    'sender'=>$user_id,
                    'sent_from'=> Config::get('constants.ROLES.RESTAURANT'),
                    'user_id'=>$customer_id
                ];
                $newPostKey = $database->getReference(Config::get('constants.FIREBASE_DB_NAME'))->push()->getKey();
                $url = Config::get('constants.FIREBASE_DB_NAME').'/'.$user_id.'/'.$order_id."/"."/".$customer_id."/" ;
                $updates = [$url.$newPostKey  => $postData];
                $database->getReference()->update($updates);
                return response()->json(['message' => "Order accepted successfully.", 'success' => true], 200);
            }else{
                DB::rollBack();
                return response()->json(['message' => "Order does not accepted successfully.", 'success' => true], 401);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $errors['success'] = false;
            $errors['message'] = Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS');
            if ($request->debug_mode == 'ON') {
                $errors['debug'] = $th->getMessage();
            }
            return response()->json($errors, 500);
        }
    }


    public function cancelOrder(Request $request)
    {
        try {
            $request_data = $request->json()->all();
            $validator = Validator::make($request_data,[
                'restaurant_id' => 'required',
                'order_id' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()], 400);
            }
            DB::beginTransaction();
            $order =  Order::where('restaurant_id', $request->post('restaurant_id'))
            ->where('order_id',$request->post('order_id'))
            ->whereNull('order_status')
            ->first();
            if(!$order){
                return response()->json(['message' => "Invalid Order or already procceed.", 'success' => true], 401);
            }
            $order->isPickUp = true;
            $order->order_status = 0;
            $order->order_progress_status = Config::get('constants.ORDER_STATUS.CANCEL');
            if($order->save()){
                DB::commit();
                $user = User::find($order->uid);
                $user->notify(new DeclineOrder($order));
                return response()->json(['message' => "Order declined successfully.", 'success' => true], 200);
            }else{
                DB::rollBack();
                return response()->json(['message' => "Order does not cancel successfully.", 'success' => true], 401);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $errors['success'] = false;
            $errors['message'] = Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS');
            if ($request->debug_mode == 'ON') {
                $errors['debug'] = $th->getMessage();
            }
            return response()->json($errors, 500);
        }
    }


    public function preparedOrder(Request $request)
    {
        try {
            $request_data = $request->json()->all();
            $validator = Validator::make($request_data,[
                'restaurant_id' => 'required',
                'order_id' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()], 400);
            }
            DB::beginTransaction();
            $order =  Order::where('restaurant_id', $request->post('restaurant_id'))
            ->where('order_id',$request->post('order_id'))
            ->first();
            if($order){
                $order->order_status = 1;
                $order->order_progress_status = Config::get('constants.ORDER_STATUS.PREPARED');
                if($order->save()){
                    DB::commit();
                    $user = User::find($order->uid);
                    $user->notify(new PreparedOrder);
                    return response()->json(['message' => "Order has been Prepared Now.", 'success' => true], 200);
                }else{
                    DB::rollBack();
                    return response()->json(['message' => "Order does not prepared successfully.", 'success' => true], 401);
                }
            }
            DB::rollBack();
            return response()->json(['message' => "Order not found.", 'success' => true], 401);
        } catch (\Throwable $th) {
            DB::rollBack();
            $errors['success'] = false;
            $errors['message'] = Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS');
            if ($request->debug_mode == 'ON') {
                $errors['debug'] = $th->getMessage();
            }
            return response()->json($errors, 500);
        }
    }

    public function dueOrder(Request $request)
    {
        try {
            $request_data = $request->json()->all();
            $validator = Validator::make($request_data,[
                'restaurant_id' => 'required',
                'order_number' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()], 400);
            }
            DB::beginTransaction();
            $order =  Order::where('restaurant_id', $request->post('restaurant_id'))
            ->where('order_number',$request->post('order_number'))
            ->first();
            if(!$order){
                return response()->json(['message' => "Invalid Order.", 'success' => true], 401);
            }
            $order->order_progress_status = Config::get('constants.ORDER_STATUS.ORDER_DUE');
            if($order->save()){
                DB::commit();
                return response()->json(['message' => "Order due successfully.", 'success' => true], 200);
            }else{
                DB::rollBack();
                return response()->json(['message' => "Order not due successfully.", 'success' => true], 401);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $errors['success'] = false;
            $errors['message'] = Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS');
            if ($request->debug_mode == 'ON') {
                $errors['debug'] = $th->getMessage();
            }
            return response()->json($errors, 500);
        }
    }

    public function getRecentOrder(Request $request)
    {
        try {
            $request_data = $request->json()->all();
            $validator = Validator::make($request_data,['restaurant_id' => 'required']);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()], 400);
            }
            $order = Order::where('restaurant_id', $request->post('restaurant_id'))
                //->whereNull('order_status')
                ->where(function($q){
                    $q->where('is_feature',1);
                    $q->orWhere('order_progress_status',Config::get('constants.ORDER_STATUS.INITIAL'));
                    $q->orWhere('order_progress_status',Config::get('constants.ORDER_STATUS.ACCEPTED'));
                    $q->orWhere('order_progress_status',Config::get('constants.ORDER_STATUS.ORDER_DUE'));
                })
                ->where('order_progress_status',Config::get('constants.ORDER_STATUS.INITIAL'))
                ->orWhere('order_progress_status',Config::get('constants.ORDER_STATUS.ACCEPTED'))
                ->orWhere('order_progress_status',Config::get('constants.ORDER_STATUS.ORDER_DUE'))
                ->with('orderItems','user')
                ->latest()
                ->get();
            return response()->json(['order' => $order, 'success' => true], 200);
            // $result = [];
            // foreach ($order as $key => $value) {
            //     $database = app('firebase.database');
            //     $url = Config::get('constants.FIREBASE_DB_NAME')."/".$request->post('restaurant_id')."/".$value->order_number."/".$value->uid."/";
            //     $message = $database->getReference($url)->getvalue();
            //     $count = 0 ;
            //     if($message){
            //         foreach ($message as $key => $value1) {
            //             if(!$value1['is_read'] && $value1['created_by']=='RESTAURANT'){
            //                 $count =$count+1;
            //             }
            //         }
            //     }
            //     $result[$key] = $value;
            //     $result[$key]['notification_badge'] = $count ;
            // }


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
