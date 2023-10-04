<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\CustomerAddress;
use Config;
use App\Models\Restaurant;
use App\Models\MenuItem;
use App\Models\Order;
use App\Models\OrderMenuItem;
use App\Models\OrderMenuGroup;
use App\Models\OrderMenuGroupItem;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\CartMenuGroup;
use App\Models\CartMenuGroupItem;
use App\Models\User;
use App\Models\Loyalty;
use App\Models\LoyaltyCategory;
use App\Notifications\PlaceOrderCash;
use App\Notifications\PlaceOrderCard;
use App\Notifications\PlaceFutureOrderCash;
use App\Notifications\PlaceFutureOrderCard;
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
            $uid = auth('api')->user()->uid;
            $list = Order::where('restaurant_id', $request->post('restaurant_id'))->where('uid',$uid)
             ->with('user');
            if($request->post('order_status')){
                 $list = $list->where(function($query){
                    $query->where('order_progress_status',Config::get('constants.ORDER_STATUS.INITIAL'));
                    $query->orWhere('order_progress_status',Config::get('constants.ORDER_STATUS.ACCEPTED'));
                    $query->orWhere('order_progress_status',Config::get('constants.ORDER_STATUS.PREPARED'));
                 });
                // $list = $list->where('order_progress_status',Config::get('constants.ORDER_STATUS.INITIAL'));
                // $list =  $list->orWhere('order_progress_status',Config::get('constants.ORDER_STATUS.ACCEPTED'));
                // $list =  $list->orWhere('order_progress_status',Config::get('constants.ORDER_STATUS.PREPARED'));

            }else{
                // $list =  $list->where('order_progress_status',Config::get('constants.ORDER_STATUS.CANCEL'));
                // $list = $list->orWhere('order_progress_status',Config::get('constants.ORDER_STATUS.COMPLETED'));
                 $list = $list->where(function($query){
                    $query->where('order_progress_status',Config::get('constants.ORDER_STATUS.CANCEL'));
                    $query->orWhere('order_progress_status',Config::get('constants.ORDER_STATUS.COMPLETED'));
                 });
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
                'cart_id'     => 'required',
                'delivery_charge' => 'required',
                'discount_charge' => 'required',
                'grand_total' => 'required',
                'address_id' => 'required',
                'is_feature' => 'required',
                'order_date' => 'required',
                'order_time' => 'required',
                'is_tip'     => 'required',
                'tip_amount' => 'required',
                // 'payment_card_id' => 'required',
                'isCash'          => 'required',
                // 'stripe_payment_id' => 'required',
                'menu_item'=>'required'
            ]);

            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()], 400);
            }

            $uid = auth('api')->user()->uid;
            $cartId = $request->post('cart_id');
            $check_cart = Cart::where('uid',$uid)->where('restaurant_id',$request->post('restaurant_id'))->where('cart_id',$cartId)->first();


            DB::beginTransaction();
            $order = new Order;
            $order->uid = $uid;
            $order->restaurant_id = $request->post('restaurant_id');
            $order->promotion_id = $check_cart->promotion_id ?? 0;
            $order->order_number = random_int(1000,1000000000000000);
            $order->payment_card_id = ($request->post('isCash') == 1) ? $request->post('payment_card_id') : NULL;
            $order->isCash = $request->post('isCash');
            $order->stripe_payment_id = ($request->post('isCash') == 1) ? $request->post('stripe_payment_id') : null;
            $order->stripe_charge_id = ($request->post('isCash') == 1) ? $request->post('stripe_charge_id') : null;
            $order->payment_method_id = ($request->post('isCash') == 1) ? $request->post('payment_method_id') : null;
            $order->payment_intent_id = ($request->post('isCash') == 1) ? $request->post('payment_intent_id') : null;
            $order->payment_intent_client_secret = ($request->post('isCash') == 1) ? $request->post('payment_intent_client_secret') : null;
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
            $order->is_tip   = $request->post('is_tip');
            $order->tip_amount = $request->post('tip_amount');
            $order->delivery_charge = $request->post('delivery_charge');
            $order->sales_tax = $request->post('sales_tax');
            $order->comments = $request->post('comments');
            $order->platform = $request->post('platform') ? $request->post('platform') : NULL;
            $order->grand_total = $request->post('grand_total');
            $order->order_progress_status = Config::get('constants.ORDER_STATUS.INITIAL');
            if($order->save()){
                foreach ($request->post('menu_item') as $key => $menuItem) {
                    $menu_price = MenuItem::where('menu_id',$menuItem['menu_id'])->where('restaurant_id',$request->post('restaurant_id'))->first();
                    $menuItemData = New OrderMenuItem;
                    $menuItemData->menu_id =    $menuItem['menu_id'];
                    $menuItemData->menu_name =  $menuItem['item_name'];
                    $menuItemData->menu_total = $menuItem['menu_total'];
                    $menuItemData->menu_qty =   $menuItem['item_qty'];
                    $menuItemData->menu_price = $menu_price->item_price;
                    $menuItemData->menu_total = $menuItem['menu_total'];
                    $menuItemData->is_loyalty = $menuItem['is_loyalty'];
                    $menuItemData->modifier_total = $menuItem['modifier_total'];
                    $menuItemData->order_id = $order->order_id;
                    if($menuItemData->save()) {
                        foreach ($menuItem['modifier_list'] as $key => $modifierGroup) {
                            $menuModifier = New OrderMenuGroup;
                            $menuModifier->modifier_group_id = $modifierGroup['modifier_group_id'];
                            $menuModifier->modifier_group_name = $modifierGroup['modifier_group_name'];
                            $menuModifier->order_menu_item_id = $menuItemData->order_menu_item_id;
                            $menuModifier->menu_id =  $menuItem['menu_id'];
                            $menuModifier->order_id = $order->order_id;
                            if($menuModifier->save()) {
                                foreach ($modifierGroup['modifier_items'] as $key => $modierMenu) {
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
                            } else {
                                return response()->json(['message' => "Order does not added successfully.", 'success' => true], 401);
                            }
                        }
                    } else {
                        return response()->json(['message' => "Order does not added successfully.", 'success' => true], 401);
                    }
                }
                DB::commit();
                $orderNumber = $order->order_number;
                $restaurant = Restaurant::with(['order' => function($order) use($uid,$orderNumber){
                    $order->with('user')->where('uid',$uid)->where('order_number',$orderNumber)->first();
                }])->find($request->post('restaurant_id'));

                if($request->post('is_feature') == 1){
                    // if($request->post('isCash') == 0)
                    // {
                    //     $restaurant->notify(new PlaceFutureOrderCash($restaurant));
                    // }
                    // else
                    // {
                    //     $restaurant->notify(new PlaceFutureOrderCard($restaurant));
                    // }
                    switch ($request->post('isCash')) {
                        case '0':
                            $restaurant->notify(new PlaceFutureOrderCash($restaurant));
                            break;

                        default:
                            $restaurant->notify(new PlaceFutureOrderCard($restaurant));
                            break;
                    }
                } else {
                    switch ($request->post('isCash')) {
                        case '0':
                            $restaurant->notify(new PlaceOrderCash($restaurant));
                            break;

                        default:
                            $restaurant->notify(new PlaceOrderCard($restaurant));
                            break;
                    }
                }
                $userPoint = auth('api')->user()->total_points;
                $redeemPoint = $request->post('point');
                if(($redeemPoint != 0) && ($userPoint < 0)){
                    $userRedeemPoint = $userPoint - $redeemPoint;
                    if($userRedeemPoint < 0){
                        $userRedeemPoint = 0;
                    }
                    User::where('uid',$uid)->update(['total_points' => $userRedeemPoint]);
                }
                $loyalty = Loyalty::where('status',Config::get('constants.STATUS.ACTIVE'))->where('restaurant_id',$request->post('restaurant_id'))->first();
                if($loyalty){
                    switch ($loyalty->loyalty_type) {
                        case Config::get('constants.LOYALTY_TYPE.NO_OF_ORDERS'):
                                $getOrderIds = Order::where('uid',$uid)->where('order_progress_status',Config::get('constants.ORDER_STATUS.COMPLETED'))->where('point_count',Config::get('constants.ORDER_POINT_COUNT.NO'))->limit($loyalty->no_of_orders)->get()->pluck('order_id');
                                if(count($getOrderIds) == $loyalty->no_of_orders){
                                    $totalPoint = $userPoint + $loyalty->point;
                                    User::where('uid',$uid)->update(['total_points' => $totalPoint]);
                                    Order::whereIn('order_id',$getOrderIds)->update(['point_count' => Config::get('constants.ORDER_POINT_COUNT.YES')]);
                                }
                            break;
                        case Config::get('constants.LOYALTY_TYPE.AMOUNT_SPENT'):
                            $grandTotal = $request->post('grand_total');
                            if($grandTotal > $loyalty->amount){
                                $totalPoint = $userPoint + $loyalty->point;
                                User::where('uid',$uid)->update(['total_points' => $totalPoint]);
                            }
                            break;
                        case Config::get('constants.LOYALTY_TYPE.CATEGORY_BASED'):
                            $loyaltyCategories = LoyaltyCategory::where('loyalty_id',$loyalty->loyalty_id)->where('restaurant_id',$request->post('restaurant_id'))->get()->pluck('category_id')->toArray();
                            foreach ($request->post('menu_item') as $key => $menuItem) {
                                $category_menu = MenuItem::where('menu_id',$menuItem['menu_id'])->first();
                                $addPoint = false;
                                if(in_array($category_menu->category_id,$loyaltyCategories)){
                                    $addPoint = true;
                                    break;
                                }
                            }
                            if($addPoint == true){
                                $totalPoint = $userPoint + $loyalty->point;
                                User::where('uid',$uid)->update(['total_points' => $totalPoint]);
                            }
                            break;
                    }
                }


                if($check_cart) {
                    CartItem::where('cart_id',$check_cart->cart_id)->delete();
                    CartMenuGroup::where('cart_id',$check_cart->cart_id)->delete();
                    CartMenuGroupItem::where('cart_id',$check_cart->cart_id)->delete();
                    $check_cart->delete();
                }
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
