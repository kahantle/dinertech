<?php

namespace App\Http\Controllers\Api\Customer;

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
             $list = Order::where('restaurant_id', $request->post('restaurant_id'))
             ->with('user');
            if($request->post('order_status')){
                $list = $list->where('order_progress_status',Config::get('constants.ORDER_STATUS.INITIAL'));
                $list =  $list->orWhere('order_progress_status',Config::get('constants.ORDER_STATUS.ACCEPTED'));
                $list =  $list->orWhere('order_progress_status',Config::get('constants.ORDER_STATUS.PREPARED'));
                
            }else{
                $list =  $list->where('order_progress_status',Config::get('constants.ORDER_STATUS.CANCEL'));
                $list = $list->orWhere('order_progress_status',Config::get('constants.ORDER_STATUS.COMPLETED'));
            }
            $list = $list->get();
            return response()->json(['order_list' => $list, 'success' => true], 200);
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
            $request_data = $request->json()->all();
            $validator = Validator::make($request_data,['restaurant_id' => 'required','order_id' => 'required']);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()], 400);
            }
            $order = Order::where('restaurant_id', $request->post('restaurant_id'))
                ->where('order_id',$request->post('order_id'))
                ->with('orderItems')
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
            $order->order_number = random_int(1000,1000000000000000);
            $order->payment_card_id = $request->post('payment_card_id');
            $order->stripe_payment_id = $request->post('stripe_payment_id');
            $order->cart_charge = $request->post('cart_charge');
            $order->delivery_charge = $request->post('delivery_charge');
            $order->discount_charge = $request->post('discount_charge');
            $order->is_feature = $request->post('is_feature');
            $order->address_id = $request->post('address_id');
            $order->order_date = date("Y-m-d",strtotime($request->post('order_date')));
            $order->order_time = date("h:m:A",strtotime($request->post('order_time')));
            $order->feature_date = date("Y-m-d",strtotime($request->post('feature_date')));
            $order->feature_time = date("h:m:A",strtotime($request->post('feature_time')));
            $order->action_time =  date('Y-m-d m:i:s');
            $order->isPickUp = $request->post('isPickUp');
            $order->delivery_charge = $request->post('delivery_charge');
            $order->comments = $request->post('comments');
            $order->grand_total = $request->post('grand_total');
            $order->order_progress_status = Config::get('constants.ORDER_STATUS.INITIAL');
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
                                    $menuModifierMenu->modifier_group_item_price = $modierMenu['modifier_group_item_price'];
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
                return response()->json(['message' => "Order added successfully.", 'order_id'=>$order->order_id, 'order_number'=>$order->order_number,  'success' => true], 200);
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
}
