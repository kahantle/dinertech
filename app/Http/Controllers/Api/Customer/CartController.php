<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Validator;
use Config;
use App\Models\Cart;
// use App\Models\MenuItem;
use App\Models\CartItem;
use App\Models\Restaurant;
use App\Models\CartMenuGroup;
use App\Models\CartMenuGroupItem;
use App\Models\MenuItem;
use App\Models\PromotionType;
use App\Models\Promotion;
use App\Models\PromotionCategoryItem;

//require_once 'C:\xampp\htdocs\dinertech\app\helpers\custom.php';

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        try {
            $request_data = $request->json()->all();
            $validator = Validator::make($request_data, [
                'restaurant_id' => 'required'
            ]);
            $uid = auth('api')->user()->uid;
            $restaurantId = $request->post('restaurant_id');
            $restaurant = Restaurant::where('restaurant_id', $request->post('restaurant_id'))->first();

            $cartItem = Cart::with(['cartMenuItems' => function ($cartItems) {
                $cartItems->select(['cart_menu_item_id', 'cart_id', 'menu_id', 'menu_name', 'menu_qty', 'menu_price', 'menu_total', 'modifier_total', 'is_loyalty'])->with(['cartMenuGroups' => function ($cartMenuGroups) {
                    $cartMenuGroups->select(['cart_modifier_group_id', 'cart_menu_item_id', 'menu_id', 'modifier_group_id', 'modifier_group_name'])->with('cartMenuGroupItems')->get();
                }])->get();
            }])->where('restaurant_id', $restaurantId)->where('uid', $uid)->select('cart_id', 'restaurant_id', 'promotion_id', 'uid', 'sub_total', 'discount_charge', 'tax_charge', 'total_due', 'is_payment')->first();

            if ($cartItem) {

                $promotion_id = $cartItem->promotion_id;
                //Sales Tax
                $subTotal = $cartItem->sub_total;
                $taxCharge = ($subTotal * $restaurant->sales_tax) / 100;
                $totalPayableAmount = $subTotal + $taxCharge;

                if ($cartItem->promotion_id == 0) {
                    Cart::where('cart_id', $cartItem->cart_id)->where('uid', $uid)->where('restaurant_id', $restaurantId)->update(['sub_total' => (float)$subTotal, 'tax_charge' => (float)$taxCharge, 'total_due' => (float)$totalPayableAmount]);
                }
                DB::beginTransaction();
                // if((empty($cartItem->promotion_id) || $cartItem->promotion_id == null) && (empty($cartItem->discount_charge) || floatval($cartItem->discount_charge) == 0)){
                //  if(!$cartItem->promotion_id){
                //     Cart::where('cart_id',$cartItem->cart_id)->where('uid',$uid)->where('restaurant_id',$restaurantId)->update(['discount_charge' =>  0,'tax_charge' => 0,'total_due' => $cartItem->sub_total]);
                // }
                $promotionTypes = PromotionType::all();
                // foreach($promotionTypes as $promotion_type){
                //     /* Promotions Helper logic function */
                //     $test[] = [$promotion_type->id];
                //     if(apply_promotion($promotion_type->promotion_name,$uid,$restaurantId,$cartItem) == true){
                //        break;
                //     }
                // }
                // }
                DB::commit();

                $cartItem = Cart::where('restaurant_id', $restaurantId)->where('uid', $uid)->first();
                $cartItem->promotion_id = $promotion_id;
                $cartItem->save();

                $cartItem = Cart::with(['cartMenuItems' => function ($cartItems) {
                    $cartItems->select(['cart_menu_item_id', 'cart_id', 'menu_id', 'menu_name', 'menu_qty', 'menu_price', 'menu_total', 'modifier_total', 'is_loyalty', 'redeem_status'])->with(['cartMenuGroups' => function ($cartMenuGroups) {
                        $cartMenuGroups->select(['cart_modifier_group_id', 'cart_menu_item_id', 'menu_id', 'modifier_group_id', 'modifier_group_name'])->with('cartMenuGroupItems')->get();
                    }])->get();
                }])->where('restaurant_id', $restaurantId)->where('uid', $uid)->select('cart_id', 'restaurant_id', 'promotion_id', 'uid', 'sub_total', 'discount_charge', 'tax_charge', 'total_due', 'is_payment')->with('promotion')->first();
//dd($cartItem);
                return response()->json(['cart_list' => $cartItem, 'success' => true], 200);
            }
            return response()->json(['cart_list' => (object)[], 'message' => 'Your cart is empty', 'success' => true], 200);

        } catch (\Throwable $th) {
            $errors['success'] = false;
            $errors['message'] = Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS');
            if ($request->post('debug_mode') == 'ON') {
                $errors['debug'] = $th->getMessage();
            }
            return response()->json($errors, 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $request_data = $request->json()->all();
            $validator = Validator::make($request_data, [
                'restaurant_id' => 'required',
                'menu_item' => 'required',
                // 'is_loyalty'  =>  'required',
            ]);

            $user = Auth::user();
            foreach ($request->post('menu_item') as $menu_item) {
                if ($menu_item['is_loyalty'] == true) {
                    $user->update(['total_points' => $user->total_points - $menu_item['loyalty_point']]);
                }
            }

            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()], 400);
            }
            $uid = auth('api')->user()->uid;
            // $restaurant = Restaurant::where('restaurant_id',$request->post('restaurant_id'))->first();
            // $salesTax = $restaurant->sales_tax;
            $check_cart = Cart::where('uid', $uid)->where('restaurant_id', $request->post('restaurant_id'))->first();
            $finalTotal = 0;
            if ($check_cart == NULL) {
                $cart_sub_total = 0;
                $cart = new Cart;   //for adding new cart
                $cart->uid = $uid; //user id
                $cart->restaurant_id = $request->post('restaurant_id');
                $cart->order_type = ($request->post('order_type') == Config::get('constants.ORDER_TYPE.1')) ? Config::get('constants.ORDER_TYPE.1') : Config::get('constants.ORDER_TYPE.2');
                $cart->is_payment = ($request->post('is_payment') == Config::get('constants.ORDER_PAYMENT_TYPE.CASH_PAYMENT')) ? Config::get('constants.ORDER_PAYMENT_TYPE.CASH_PAYMENT') : Config::get('constants.ORDER_PAYMENT_TYPE.CARD_PAYMENT');
                if ($cart->save()) {
                    foreach ($request->post('menu_item') as $key => $menuItem) {
                        $cartMenuItemData = new CartItem;
                        $cartMenuItemData->cart_id = $cart->cart_id;
                        $cartMenuItemData->category_id = (int)$menuItem['category_id'];
                        $cartMenuItemData->menu_id = (int)$menuItem['menu_id'];
                        $cartMenuItemData->menu_name = $menuItem['item_name'];
                        $cartMenuItemData->menu_qty = $menuItem['item_qty'];
                        $cartMenuItemData->menu_price = $menuItem['item_price'];
                        $cartMenuItemData->menu_total = $menuItem['menu_total'];
                        $cart_sub_total = $menuItem['menu_total'];
                        $cartMenuItemData->modifier_total = $menuItem['modifier_total'];
                        $cartMenuItemData->is_loyalty = ($menuItem['is_loyalty'] == true) ? 1 : 0;
                        $cartMenuItemData->loyalty_point = $menuItem['loyalty_point'];
                        $cartMenuItemData->save();
                        if (isset($menuItem['modifier_list'])) {
                            foreach ($menuItem['modifier_list'] as $modifierKey => $modifier) {
                                $cartModifierGroup = new CartMenuGroup;
                                $cartModifierGroup->cart_id = $cart->cart_id;
                                $cartModifierGroup->cart_menu_item_id = $cartMenuItemData->cart_menu_item_id;
                                $cartModifierGroup->menu_id = $menuItem['menu_id'];
                                $cartModifierGroup->modifier_group_id = $modifier['modifier_group_id'];
                                $cartModifierGroup->modifier_group_name = $modifier['modifier_group_name'];
                                if ($cartModifierGroup->save()) {
                                    if (isset($modifier['modifier_items'])) {
                                        foreach ($modifier['modifier_items'] as $modifierItemKey => $modifierItem) {
                                            $cartModifierItem = new CartMenuGroupItem;
                                            $cartModifierItem->cart_id = $cart->cart_id;
                                            $cartModifierItem->cart_menu_item_id = $cartMenuItemData->cart_menu_item_id;
                                            $cartModifierItem->menu_id = $menuItem['menu_id'];
                                            $cartModifierItem->cart_modifier_group_id = $cartModifierGroup->cart_modifier_group_id;
                                            $cartModifierItem->modifier_item_id = $modifierItem['modifier_item_id'];
                                            $cartModifierItem->modifier_group_id = $modifier['modifier_group_id'];
                                            $cartModifierItem->modifier_group_item_name = $modifierItem['modifier_group_item_name'];
                                            $cartModifierItem->modifier_group_item_price = $modifierItem['modifier_group_item_price'];
                                            $cartModifierItem->save();
                                        }
                                    }
                                }
                            }
                        }
                        $finalTotal += $cart_sub_total;
                    }
                    // $taxCharge = ($finalTotal * $salesTax) / 100;
                    // $finalTotal = $finalTotal + $taxCharge;
                    Cart::where('uid', $uid)->where('restaurant_id', $request->post('restaurant_id'))->where('cart_id', $cart->cart_id)->update(['sub_total' => number_format($finalTotal, 2), 'total_due' => number_format($finalTotal, 2)]);
                }
            } else {
                $cart_sub_total = $check_cart->sub_total;

                if (!isset($request_data['cartmenuitemid'])) {
                // if(!array_key_exists('cartmenuitemid', $request_data)){
                    foreach ($request->post('menu_item') as $key => $menuItem) {
                        $cartMenuItemData = new CartItem;
                        $cartMenuItemData->cart_id = $check_cart->cart_id;
                        $cartMenuItemData->category_id = (int)$menuItem['category_id'];
                        $cartMenuItemData->menu_id = (int)$menuItem['menu_id'];
                        $cartMenuItemData->menu_name = $menuItem['item_name'];
                        $cartMenuItemData->menu_qty = $menuItem['item_qty'];
                        $cartMenuItemData->menu_price = $menuItem['item_price'];
                        $cartMenuItemData->modifier_total = $menuItem['modifier_total'];
                        $cartMenuItemData->menu_total = $menuItem['menu_total'];
                        $cart_sub_total += $menuItem['menu_total'];
                        $cartMenuItemData->is_loyalty = ($menuItem['is_loyalty'] == true) ? 1 : 0;
                        $cartMenuItemData->loyalty_point = $menuItem['loyalty_point'];
                        $cartMenuItemData->save();
                        if (isset($menuItem['modifier_list'])) {
                            foreach ($menuItem['modifier_list'] as $modifierKey => $modifier) {
                                $cartModifierGroup = new CartMenuGroup;
                                $cartModifierGroup->cart_id = $check_cart->cart_id;
                                $cartModifierGroup->cart_menu_item_id = $cartMenuItemData->cart_menu_item_id;
                                $cartModifierGroup->menu_id = $menuItem['menu_id'];
                                $cartModifierGroup->modifier_group_id = $modifier['modifier_group_id'];
                                $cartModifierGroup->modifier_group_name = $modifier['modifier_group_name'];
                                if ($cartModifierGroup->save()) {
                                    if (isset($modifier['modifier_items'])) {
                                        foreach ($modifier['modifier_items'] as $modifierItemKey => $modifierItem) {
                                            $cartModifierItem = new CartMenuGroupItem;
                                            $cartModifierItem->cart_id = $check_cart->cart_id;
                                            $cartModifierItem->cart_menu_item_id = $cartMenuItemData->cart_menu_item_id;
                                            $cartModifierItem->menu_id = $menuItem['menu_id'];
                                            $cartModifierItem->cart_modifier_group_id = $cartModifierGroup->cart_modifier_group_id;
                                            $cartModifierItem->modifier_item_id = $modifierItem['modifier_item_id'];
                                            $cartModifierItem->modifier_group_id = $modifier['modifier_group_id'];
                                            $cartModifierItem->modifier_group_item_name = $modifierItem['modifier_group_item_name'];
                                            $cartModifierItem->modifier_group_item_price = $modifierItem['modifier_group_item_price'];
                                            $cartModifierItem->save();
                                        }
                                    }
                                }
                            }
                        }
                        $finalTotal += $cart_sub_total;
                    }
                }
                if (isset($request_data['cartmenuitemid'])) {
                    $cart_item = CartItem::where('cart_menu_item_id', $request_data['cartmenuitemid'])->first();
                    if ($cart_item->menu_qty == "1") {
                        $cartitemdelete = $cart_item->delete();
                        if ($cartitemdelete == true) {
                            foreach ($request->post('menu_item') as $key => $menuItem) {
                                $cartMenuItemData = new CartItem;
                                $cartMenuItemData->cart_id = $check_cart->cart_id;
                                $cartMenuItemData->category_id = (int)$menuItem['category_id'];
                                $cartMenuItemData->menu_id = (int)$menuItem['menu_id'];
                                $cartMenuItemData->rule_id = (int)$menuItem['rule_id'];
                                $cartMenuItemData->menu_name = $menuItem['item_name'];
                                $cartMenuItemData->menu_qty = 1;
                                $cartMenuItemData->menu_price = 0.00;
                                $cartMenuItemData->price = $menuItem['item_price'];
                                $cartMenuItemData->modifier_total = $menuItem['modifier_total'];
                                $cartMenuItemData->menu_total = $menuItem['menu_total'];
                                $cart_sub_total += $menuItem['menu_total'];
                                $cartMenuItemData->is_loyalty = ($menuItem['is_loyalty'] == true) ? 1 : 0;
                                $cartMenuItemData->loyalty_point = $menuItem['loyalty_point'];
                                $cartMenuItemData->save();
                                if (isset($menuItem['modifier_list'])) {
                                    foreach ($menuItem['modifier_list'] as $modifierKey => $modifier) {
                                        $cartModifierGroup = new CartMenuGroup;
                                        $cartModifierGroup->cart_id = $check_cart->cart_id;
                                        $cartModifierGroup->cart_menu_item_id = $cartMenuItemData->cart_menu_item_id;
                                        $cartModifierGroup->menu_id = $menuItem['menu_id'];
                                        $cartModifierGroup->modifier_group_id = $modifier['modifier_group_id'];
                                        $cartModifierGroup->modifier_group_name = $modifier['modifier_group_name'];
                                        if ($cartModifierGroup->save()) {
                                            if (isset($modifier['modifier_items'])) {
                                                foreach ($modifier['modifier_items'] as $modifierItemKey => $modifierItem) {
                                                    $cartModifierItem = new CartMenuGroupItem;
                                                    $cartModifierItem->cart_id = $check_cart->cart_id;
                                                    $cartModifierItem->cart_menu_item_id = $cartMenuItemData->cart_menu_item_id;
                                                    $cartModifierItem->menu_id = $menuItem['menu_id'];
                                                    $cartModifierItem->cart_modifier_group_id = $cartModifierGroup->cart_modifier_group_id;
                                                    $cartModifierItem->modifier_item_id = $modifierItem['modifier_item_id'];
                                                    $cartModifierItem->modifier_group_id = $modifier['modifier_group_id'];
                                                    $cartModifierItem->modifier_group_item_name = $modifierItem['modifier_group_item_name'];
                                                    $cartModifierItem->modifier_group_item_price = $modifierItem['modifier_group_item_price'];
                                                    $cartModifierItem->save();
                                                }
                                            }
                                        }
                                    }
                                }
                                $finalTotal += 0.00;
                            }
                        }
                    } elseif ($cart_item) {
                        $qty = $cart_item->menu_qty;
                        $newqty = $qty - "1";
                        $cart_item->menu_qty = (string)$newqty;
                        $cart_item->save();
                        $menutotal = $cart_item->menu_qty * $cart_item->menu_price + $cart_item->modifier_total;
                        CartItem::where('cart_menu_item_id', $cart_item->cart_menu_item_id)->update(['menu_total' => $menutotal]);
                        Cart::where('restaurant_id', $request->post('restaurant_id'))->update(['sub_total' => $menutotal, 'total_due' => number_format($menutotal, 2)]);
                        $check_carts = Cart::where('uid', $uid)->where('restaurant_id', $request->post('restaurant_id'))->first();
                        $cartsubtotal = $check_carts->sub_total;
                        foreach ($request->post('menu_item') as $key => $menuItem) {
                            $cartMenuItemData = new CartItem;
                            $cartMenuItemData->cart_id = $check_cart->cart_id;
                            $cartMenuItemData->category_id = (int)$menuItem['category_id'];
                            $cartMenuItemData->menu_id = (int)$menuItem['menu_id'];
                            $cartMenuItemData->rule_id = (int)$menuItem['rule_id'];
                            $cartMenuItemData->menu_name = $menuItem['item_name'];
                            $cartMenuItemData->menu_qty = 1;
                            $cartMenuItemData->menu_price = "0.00";
                            $cartMenuItemData->price = $menuItem['price'];
                            $cartMenuItemData->modifier_total = $menuItem['modifier_total'];
                            $cartMenuItemData->menu_total = $menuItem['menu_total'];
                            $cartsubtotal += $menuItem['menu_total'];
                            $cartMenuItemData->is_loyalty = ($menuItem['is_loyalty'] == true) ? 1 : 0;
                            $cartMenuItemData->loyalty_point = $menuItem['loyalty_point'];
                            $cartMenuItemData->save();
                            if (isset($menuItem['modifier_list'])) {
                                foreach ($menuItem['modifier_list'] as $modifierKey => $modifier) {
                                    $cartModifierGroup = new CartMenuGroup;
                                    $cartModifierGroup->cart_id = $check_cart->cart_id;
                                    $cartModifierGroup->cart_menu_item_id = $cartMenuItemData->cart_menu_item_id;
                                    $cartModifierGroup->menu_id = $menuItem['menu_id'];
                                    $cartModifierGroup->modifier_group_id = $modifier['modifier_group_id'];
                                    $cartModifierGroup->modifier_group_name = $modifier['modifier_group_name'];
                                    if ($cartModifierGroup->save()) {
                                        if (isset($modifier['modifier_items'])) {
                                            foreach ($modifier['modifier_items'] as $modifierItemKey => $modifierItem) {
                                                $cartModifierItem = new CartMenuGroupItem;
                                                $cartModifierItem->cart_id = $check_cart->cart_id;
                                                $cartModifierItem->cart_menu_item_id = $cartMenuItemData->cart_menu_item_id;
                                                $cartModifierItem->menu_id = $menuItem['menu_id'];
                                                $cartModifierItem->cart_modifier_group_id = $cartModifierGroup->cart_modifier_group_id;
                                                $cartModifierItem->modifier_item_id = $modifierItem['modifier_item_id'];
                                                $cartModifierItem->modifier_group_id = $modifier['modifier_group_id'];
                                                $cartModifierItem->modifier_group_item_name = $modifierItem['modifier_group_item_name'];
                                                $cartModifierItem->modifier_group_item_price = $modifierItem['modifier_group_item_price'];
                                                $cartModifierItem->save();
                                            }
                                        }
                                    }
                                }
                            }
                            CartItem::where('cart_menu_item_id', $cart_item->cart_menu_item_id)->update(['redeem_status' => 1]);
                        }
                        $finalTotal += $cartsubtotal;
                    }
                }
                // else{
                //     foreach($request->post('menu_item') as $key => $menuItem){
                //         $cartMenuItemData = new CartItem;
                //         $cartMenuItemData->cart_id = $check_cart->cart_id;
                //         $cartMenuItemData->category_id = (int)$menuItem['category_id'];
                //         $cartMenuItemData->menu_id = (int)$menuItem['menu_id'];
                //         $cartMenuItemData->menu_name = $menuItem['item_name'];
                //         $cartMenuItemData->menu_qty = $menuItem['item_qty'];
                //         $cartMenuItemData->menu_price = $menuItem['item_price'];
                //         $cartMenuItemData->modifier_total = $menuItem['modifier_total'];
                //         $cartMenuItemData->menu_total = $menuItem['menu_total'];
                //         $cart_sub_total += $menuItem['menu_total'];
                //         $cartMenuItemData->is_loyalty = ($menuItem['is_loyalty'] == true) ? 1:0;
                //         $cartMenuItemData->loyalty_point = $menuItem['loyalty_point'];
                //         $cartMenuItemData->save();
                //         if(isset($menuItem['modifier_list'])){
                //             foreach($menuItem['modifier_list'] as $modifierKey => $modifier){
                //                 $cartModifierGroup = new CartMenuGroup;
                //                 $cartModifierGroup->cart_id = $check_cart->cart_id;
                //                 $cartModifierGroup->cart_menu_item_id = $cartMenuItemData->cart_menu_item_id;
                //                 $cartModifierGroup->menu_id = $menuItem['menu_id'];
                //                 $cartModifierGroup->modifier_group_id = $modifier['modifier_group_id'];
                //                 $cartModifierGroup->modifier_group_name = $modifier['modifier_group_name'];
                //                 if($cartModifierGroup->save()){
                //                     if(isset($modifier['modifier_items'])){
                //                         foreach($modifier['modifier_items'] as $modifierItemKey => $modifierItem){
                //                             $cartModifierItem = new CartMenuGroupItem;
                //                             $cartModifierItem->cart_id = $check_cart->cart_id;
                //                             $cartModifierItem->cart_menu_item_id = $cartMenuItemData->cart_menu_item_id;
                //                             $cartModifierItem->menu_id = $menuItem['menu_id'];
                //                             $cartModifierItem->cart_modifier_group_id = $cartModifierGroup->cart_modifier_group_id;
                //                             $cartModifierItem->modifier_item_id = $modifierItem['modifier_item_id'];
                //                             $cartModifierItem->modifier_group_id = $modifier['modifier_group_id'];
                //                             $cartModifierItem->modifier_group_item_name = $modifierItem['modifier_group_item_name'];
                //                             $cartModifierItem->modifier_group_item_price = $modifierItem['modifier_group_item_price'];
                //                             $cartModifierItem->save();
                //                         }
                //                     }
                //                 }
                //             }
                //         }
                //         $finalTotal += $cart_sub_total;
                //     }
                // }

                // $taxCharge = ($finalTotal * $salesTax) / 100;
                // $finalTotal = $finalTotal + $taxCharge;
                $orderType = ($request->post('order_type') == Config::get('constants.ORDER_TYPE.1')) ? Config::get('constants.ORDER_TYPE.1') : Config::get('constants.ORDER_TYPE.2');
                // Cart::where('uid',$uid)->where('restaurant_id',$request->post('restaurant_id'))->where('cart_id',$check_cart->cart_id)->update(['order_type' => $orderType,'sub_total' => number_format($cart_sub_total,2), 'tax_charge' => number_format($taxCharge,2), 'total_due' => number_format($finalTotal,2)]);
                Cart::where('uid', $uid)->where('restaurant_id', $request->post('restaurant_id'))->where('cart_id', $check_cart->cart_id)->update(['order_type' => $orderType, 'sub_total' => number_format($finalTotal, 2), 'total_due' => number_format($finalTotal, 2)]);
            }
            return response()->json(['success' => true, 'message' => "Item added to the cart successfully."], 200);
        } catch (\Throwable $th) {
            $errors['success'] = false;
            $errors['message'] = Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS');
            if ($request->post('debug_mode') == 'ON') {
                $errors['debug'] = $th->getMessage();
            }
            return response()->json($errors, 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function getCartMenuModifier(Request $request)
    {
        try {
            $request_data = $request->json()->all();
            $validator = Validator::make($request_data, [
                'restaurant_id' => 'required',
                'cart_menu_item_id' => 'required',
                'menu_id' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()], 400);
            }

            $cartModifiers = CartMenuGroup::with('cartMenuGroupItems')->with('modifierGroup')->where('cart_menu_item_id', $request->post('cart_menu_item_id'))->where('menu_id', $request->post('menu_id'))->get(['cart_modifier_group_id', 'cart_id', 'cart_menu_item_id', 'menu_id', 'modifier_group_id', 'modifier_group_name']);

            if ($cartModifiers) {
                return response()->json(['modifier_list' => $cartModifiers, 'success' => true], 200);
            } else {
                return response()->json(['message' => 'Cart menu modifiers not found.', 'success' => false], 400);
            }
        } catch (\Throwable $th) {
            $errors['success'] = false;
            $errors['message'] = Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS');
            if ($request->post('debug_mode') == 'ON') {
                $errors['debug'] = $th->getMessage();
            }
            return response()->json($errors, 500);
        }
    }

    /**
     * Update the specified modifier in cart menu item.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function customizeModifier(Request $request)
    {
        try {
            $request_data = $request->json()->all();
            $validator = Validator::make($request_data, [
                'restaurant_id' => 'required',
                'cart_menu_item_id' => 'required',
                'menu_id' => 'required',
                'modifier_list' => 'required',
                'modifier_total' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()], 400);
            }
            $updatemodifireprice = 0;
            $cartItem = CartItem::where('cart_menu_item_id', $request->post('cart_menu_item_id'))->first();
            if ($cartItem) {
                CartMenuGroup::where('cart_menu_item_id', $request->post('cart_menu_item_id'))->where('menu_id', $request->post('menu_id'))->delete();
                CartMenuGroupItem::where('cart_menu_item_id', $request->post('cart_menu_item_id'))->where('menu_id', $request->post('menu_id'))->delete();
                foreach ($request->post('modifier_list') as $modifierKey => $modifier) {
                    $cartModifierGroup = new CartMenuGroup;
                    $cartModifierGroup->cart_id = $cartItem->cart_id;
                    $cartModifierGroup->cart_menu_item_id = $request->post('cart_menu_item_id');
                    $cartModifierGroup->menu_id = $request->post('menu_id');
                    $cartModifierGroup->modifier_group_id = $modifier['modifier_group_id'];
                    $cartModifierGroup->modifier_group_name = $modifier['modifier_group_name'];
                    if ($cartModifierGroup->save()) {
                        if ($modifier['modifier_items']) {
                            foreach ($modifier['modifier_items'] as $modifierItemKey => $modifierItem) {
                                $cartModifierItem = new CartMenuGroupItem;
                                $cartModifierItem->cart_id = $cartItem->cart_id;
                                $cartModifierItem->cart_menu_item_id = $request->post('cart_menu_item_id');
                                $cartModifierItem->menu_id = $request->post('menu_id');
                                $cartModifierItem->cart_modifier_group_id = $cartModifierGroup->cart_modifier_group_id;
                                $cartModifierItem->modifier_item_id = $modifierItem['modifier_item_id'];
                                $cartModifierItem->modifier_group_id = $modifier['modifier_group_id'];
                                $cartModifierItem->modifier_group_item_name = $modifierItem['modifier_group_item_name'];
                                $cartModifierItem->modifier_group_item_price = $modifierItem['modifier_group_item_price'];
                                $updatemodifireprice += $modifierItem['modifier_group_item_price'];
                                $cartModifierItem->save();
                            }
                        }
                    }
                }
                $finalTotal = $updatemodifireprice;


                $cartItem->modifier_total = $finalTotal;
                $menuTotal = ($finalTotal + $cartItem->menu_price) * $cartItem->menu_qty;
                $cartItem->menu_total = number_format($menuTotal, 2);
                $cartItem->save();
                return response()->json(['message' => 'Modifiers update successfully.', 'success' => true], 200);

                // if($cartItem->save()){
                //     CartMenuGroup::where('cart_menu_item_id',$request->post('cart_menu_item_id'))->where('menu_id',$request->post('menu_id'))->delete();
                //     CartMenuGroupItem::where('cart_menu_item_id',$request->post('cart_menu_item_id'))->where('menu_id',$request->post('menu_id'))->delete();
                //     foreach($request->post('modifier_list') as $modifierKey => $modifier){
                //         $cartModifierGroup = new CartMenuGroup;
                //         $cartModifierGroup->cart_id = $cartItem->cart_id;
                //         $cartModifierGroup->cart_menu_item_id = $request->post('cart_menu_item_id');
                //         $cartModifierGroup->menu_id = $request->post('menu_id');
                //         $cartModifierGroup->modifier_group_id = $modifier['modifier_group_id'];
                //         $cartModifierGroup->modifier_group_name = $modifier['modifier_group_name'];
                //         if($cartModifierGroup->save()){
                //             if($modifier['modifier_items']){
                //                 foreach($modifier['modifier_items'] as $modifierItemKey => $modifierItem){
                //                     $cartModifierItem = new CartMenuGroupItem;
                //                     $cartModifierItem->cart_id = $cartItem->cart_id;
                //                     $cartModifierItem->cart_menu_item_id = $request->post('cart_menu_item_id');
                //                     $cartModifierItem->menu_id = $request->post('menu_id');
                //                     $cartModifierItem->cart_modifier_group_id = $cartModifierGroup->cart_modifier_group_id;
                //                     $cartModifierItem->modifier_item_id = $modifierItem['modifier_item_id'];
                //                     $cartModifierItem->modifier_group_id = $modifier['modifier_group_id'];
                //                     $cartModifierItem->modifier_group_item_name = $modifierItem['modifier_group_item_name'];
                //                     $cartModifierItem->modifier_group_item_price = $modifierItem['modifier_group_item_price'];
                //                     $cartModifierItem->save();
                //                 }
                //             }
                //         }
                //     }
                //     return response()->json(['message' => 'Modifiers update successfully.','success' => true], 200);
                // }else{
                //     return response()->json(['message' => 'Modifiers does not update successfully.','success' => false], 200);
                // }
            } else {
                return response()->json(['message' => 'Item not found in cart.', 'success' => false], 400);
            }
        } catch (\Throwable $th) {
            $errors['success'] = false;
            $errors['message'] = Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS');
            if ($request->post('debug_mode') == 'ON') {
                $errors['debug'] = $th->getMessage();
            }
            return response()->json($errors, 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try {
            $request_data = $request->json()->all();
            $validator = Validator::make($request_data, [
                'restaurant_id' => 'required',
                'cart_menu_item_id' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()], 400);
            }

            $cart_menu_item = CartItem::where('cart_menu_item_id', $request->post('cart_menu_item_id'))->first();
            if ($cart_menu_item->is_loyalty == 1) {
                $user = Auth::user();
                $user->update(['total_points' => $user->total_points + (int)$cart_menu_item->loyalty_point]);
            }

            $uid = auth('api')->user()->uid;
            $check_cart = Cart::where('uid', $uid)->where('restaurant_id', $request->post('restaurant_id'))->first();
            $cartMenuItems = CartItem::where('cart_id', $check_cart->cart_id);


            if ($cartMenuItems->get()->count() > 1) {
                CartMenuGroup::where('cart_menu_item_id', $request->post('cart_menu_item_id'))->where('cart_id', $check_cart->cart_id)->delete();
                CartMenuGroupItem::where('cart_menu_item_id', $request->post('cart_menu_item_id'))->where('cart_id', $check_cart->cart_id)->delete();
                $cartMenuItems->where('cart_id', $check_cart->cart_id)->where('cart_menu_item_id', $request->post('cart_menu_item_id'))->delete();
            } else {
                CartMenuGroup::where('cart_id', $check_cart->cart_id)->delete();
                CartMenuGroupItem::where('cart_id', $check_cart->cart_id)->delete();
                $cartMenuItems->where('cart_menu_item_id', $request->post('cart_menu_item_id'))->delete();
                $check_cart->delete();
            }
            //Cart Total Update
            $restaurantid = Restaurant::where('restaurant_id', $request->post('restaurant_id'))->first();
            $subtotal = CartItem::where('cart_id', $check_cart->cart_id)->sum('menu_total');
            $taxCharge = ($subtotal * $restaurantid->sales_tax) / 100;
            $totalPayableAmount = $subtotal + $taxCharge;

            Cart::where('uid', auth()->id())->where('restaurant_id', $request->post('restaurant_id'))->where('cart_id', $check_cart->cart_id)->update(['sub_total' => (float)$subtotal, 'tax_charge' => (float)$taxCharge, 'total_due' => (float)$totalPayableAmount]);
            return response()->json(['success' => true, 'message' => 'Cart item remove successfully.'], 200);
        } catch (\Throwable $th) {
            $errors['success'] = false;
            $errors['message'] = Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS');
            if ($request->post('debug_mode') == 'ON') {
                $errors['debug'] = $th->getMessage();
            }
            return response()->json($errors, 500);
        }
    }

    public function quantityIncrement(Request $request)
    {
        try {
            $request_data = $request->json()->all();
            $validator = Validator::make($request_data, [
                'restaurant_id' => 'required',
                'cart_menu_item_id' => 'required',
                'menu_id' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()], 400);
            } else {
                $uid = auth('api')->user()->uid;
                $check_cart = Cart::where('uid', $uid)->where('restaurant_id', $request->post('restaurant_id'))->first();
                if ($check_cart) {
                    //   $cartItem = CartItem::where('cart_id',$check_cart->cart_id)->first();
                    $cartItem = CartItem::where('cart_menu_item_id', $request->post('cart_menu_item_id'))->where('menu_id', $request->post('menu_id'))->where('cart_id', $check_cart->cart_id)->first();
                    $menuItem = MenuItem::where('menu_id', $request->post('menu_id'))->first();
                    if ($cartItem->is_loyalty == 0) {
                        $menuOldQuantity = $cartItem->menu_qty;
                        $modifier_total = $cartItem->modifier_total;
                        $menuprice = $cartItem->menu_price;
                        $menuNewQuantity = $menuOldQuantity + 1;
                        $modifiertotal = $cartItem->modifier_total * $menuNewQuantity;
                        $cartItem->menu_qty = $menuNewQuantity;
                        $cartItem->menu_total = (float)$menuprice * (float)$menuNewQuantity + (float)$modifiertotal;
                        $cartItem->save();

                        $subtotal = CartItem::where('cart_id', $check_cart->cart_id)->sum('menu_total');
                        // $restaurant = Restaurant::where('restaurant_id',$request->post('restaurant_id'))->first();
                        // $salesTax = $restaurant->sales_tax;
                        // $taxCharge = ($subtotal * $salesTax) / 100;
                        // $finalTotal = $subtotal + $taxCharge;
                        Cart::where('uid', $uid)->where('restaurant_id', $request->post('restaurant_id'))->where('cart_id', $check_cart->cart_id)->update(['sub_total' => (float)$subtotal, 'total_due' => (float)$subtotal]);
                        return response()->json(['message' => "Cart quantity increment successfully.", 'success' => true], 200);
                    } elseif ($cartItem->is_loyalty == 1) {
                        $cartItem = CartItem::where('menu_id', $request->post('menu_id'))->where('cart_id', $check_cart->cart_id)->where('is_loyalty', "0")->first();
                        if ($cartItem) {
                            $menuOldQuantity = $cartItem->menu_qty;
                            $modifier_total = $cartItem->modifier_total;
                            $menuprice = $cartItem->menu_price;
                            $menuNewQuantity = $menuOldQuantity + 1;
                            $modifiertotal = $cartItem->modifier_total * $menuNewQuantity;
                            $cartItem->menu_qty = $menuNewQuantity;
                            $cartItem->menu_total = (float)$menuprice * (float)$menuNewQuantity + (float)$modifiertotal;
                            $cartItem->save();
                            $subtotal = CartItem::where('cart_id', $check_cart->cart_id)->sum('menu_total');
                            // $restaurant = Restaurant::where('restaurant_id',$request->post('restaurant_id'))->first();
                            // $salesTax = $restaurant->sales_tax;
                            // $taxCharge = ($subtotal * $salesTax) / 100;
                            // $finalTotal = $subtotal + $taxCharge;
                            Cart::where('uid', $uid)->where('restaurant_id', $request->post('restaurant_id'))->where('cart_id', $check_cart->cart_id)->update(['sub_total' => (float)$subtotal, 'total_due' => (float)$subtotal]);
                        } else {
                            $cartMenuItemData = new CartItem;
                            $cartMenuItemData->cart_id = $check_cart->cart_id;
                            $cartMenuItemData->category_id = $menuItem['category_id'];
                            $cartMenuItemData->menu_id = $menuItem['menu_id'];
                            $cartMenuItemData->menu_name = $menuItem['item_name'];
                            $cartMenuItemData->menu_qty = 1;
                            $cartMenuItemData->menu_price = $menuItem['item_price'];
                            $menutotal = $cartMenuItemData->menu_price * $cartMenuItemData->menu_qty;
                            $cartMenuItemData->menu_total = $menutotal;
                            $cartMenuItemData->is_loyalty = 0;
                            $cartMenuItemData->loyalty_point = $menuItem['loyalty_point'];
                            $cartMenuItemData->save();
                            $subtotal = CartItem::where('cart_id', $check_cart->cart_id)->sum('menu_total');
                            Cart::where('uid', $uid)->where('restaurant_id', $request->post('restaurant_id'))->where('cart_id', $check_cart->cart_id)->update(['sub_total' => (float)$subtotal, 'total_due' => (float)$subtotal]);
                        }
                        return response()->json(['message' => "Cart quantity increment successfully.", 'success' => true], 200);
                    } else {
                        return response()->json(['message' => "Cart item not found.", 'success' => false], 400);
                    }
                } else {
                    return response()->json(['message' => "Cart item not found.", 'success' => false], 400);
                }
            }
        } catch (\Throwable $th) {
            $errors['success'] = false;
            $errors['message'] = Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS');
            if ($request->post('debug_mode') == 'ON') {
                $errors['debug'] = $th->getMessage();
            }
            return response()->json($errors, 500);
        }
    }

    public function quantityDecrement(Request $request)
    {
        try {
            $request_data = $request->json()->all();
            $validator = Validator::make($request_data, [
                'restaurant_id' => 'required',
                'cart_menu_item_id' => 'required',
                'menu_id' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()], 400);
            } else {
                $uid = auth('api')->user()->uid;
                $check_cart = Cart::where('uid', $uid)->where('restaurant_id', $request->post('restaurant_id'))->first();
                if ($check_cart) {
                    $cartItem = CartItem::where('cart_menu_item_id', $request->post('cart_menu_item_id'))->where('menu_id', $request->post('menu_id'))->where('cart_id', $check_cart->cart_id)->first();
                    $menuItem = MenuItem::where('menu_id', $request->post('menu_id'))->first();
                    if ($cartItem->is_loyalty == 0) {
                        $menuOldQuantity = $cartItem->menu_qty;
                        $modifier_total = $cartItem->modifier_total;
                        $menu_price = $cartItem->menu_price;
                        $menuNewQuantity = $menuOldQuantity - 1;
                        $modifiertotal = $cartItem->modifier_total * $menuNewQuantity;
                        $cartItem->menu_qty = $menuNewQuantity;
                        if ($menuNewQuantity != 0) {
                            $cartItem->menu_qty = $menuNewQuantity;
                            $cartItem->menu_total = (float)$menu_price * (float)$menuNewQuantity + (float)$modifiertotal;
                            $cartItem->save();

                            $subtotal = CartItem::where('cart_id', $check_cart->cart_id)->sum('menu_total');
                            // $restaurant = Restaurant::where('restaurant_id',$request->post('restaurant_id'))->first();
                            // $salesTax = $restaurant->sales_tax;
                            // $taxCharge = ($subtotal * $salesTax) / 100;
                            // $finalTotal = $subtotal + $taxCharge;
                            Cart::where('uid', $uid)->where('restaurant_id', $request->post('restaurant_id'))->where('cart_id', $check_cart->cart_id)->update(['sub_total' => (float)$subtotal, 'total_due' => (float)$subtotal]);
                            return response()->json(['message' => "Cart quantity decrement successfully.", 'success' => true], 200);
                        } else {
                            return response()->json(['message' => "Do not set quantity to less than one.", 'success' => true], 400);
                        }
                    } elseif ($cartItem->is_loyalty == 1) {
                        $cartItem = CartItem::where('menu_id', $request->post('menu_id'))->where('cart_id', $check_cart->cart_id)->where('is_loyalty', "0")->first();
                        if ($cartItem) {
                            $menuOldQuantity = $cartItem->menu_qty;
                            $modifier_total = $cartItem->modifier_total;
                            $menu_price = $cartItem->menu_price;
                            $menuNewQuantity = $menuOldQuantity - 1;
                            $modifiertotal = $cartItem->modifier_total * $menuNewQuantity;
                            $cartItem->menu_qty = $menuNewQuantity;
                            if ($menuNewQuantity != 0) {
                                $cartItem->menu_qty = $menuNewQuantity;
                                $cartItem->menu_total = (float)$menu_price * (float)$menuNewQuantity + (float)$modifiertotal;
                                $cartItem->save();

                                $subtotal = CartItem::where('cart_id', $check_cart->cart_id)->sum('menu_total');
                                // $restaurant = Restaurant::where('restaurant_id',$request->post('restaurant_id'))->first();
                                // $salesTax = $restaurant->sales_tax;
                                // $taxCharge = ($subtotal * $salesTax) / 100;
                                // $finalTotal = $subtotal + $taxCharge;
                                Cart::where('uid', $uid)->where('restaurant_id', $request->post('restaurant_id'))->where('cart_id', $check_cart->cart_id)->update(['sub_total' => (float)$subtotal, 'total_due' => (float)$subtotal]);
                                return response()->json(['message' => "Cart quantity decrement successfully.", 'success' => true], 200);
                            } else {
                                return response()->json(['message' => "Do not set quantity to less than one.", 'success' => true], 400);
                            }
                        } else {
                            $cartMenuItemData = new CartItem;
                            $cartMenuItemData->cart_id = $check_cart->cart_id;
                            $cartMenuItemData->category_id = $menuItem['category_id'];
                            $cartMenuItemData->menu_id = $menuItem['menu_id'];
                            $cartMenuItemData->menu_name = $menuItem['item_name'];
                            $cartMenuItemData->menu_qty = 1;
                            $cartMenuItemData->menu_price = $menuItem['item_price'];
                            $menutotal = $cartMenuItemData->menu_price * $cartMenuItemData->menu_qty;
                            $cartMenuItemData->menu_total = $menutotal;
                            $cartMenuItemData->is_loyalty = 0;
                            $cartMenuItemData->loyalty_point = $menuItem['loyalty_point'];
                            $cartMenuItemData->save();
                            $subtotal = CartItem::where('cart_id', $check_cart->cart_id)->sum('menu_total');
                            Cart::where('uid', $uid)->where('restaurant_id', $request->post('restaurant_id'))->where('cart_id', $check_cart->cart_id)->update(['sub_total' => (float)$subtotal, 'total_due' => (float)$subtotal]);
                        }

                    } else {
                        return response()->json(['message' => "Cart item not found.", 'success' => false], 400);
                    }
                } else {
                    return response()->json(['message' => "Cart item not found.", 'success' => false], 400);
                }
            }
        } catch (\Throwable $th) {
            $errors['success'] = false;
            $errors['message'] = Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS');
            if ($request->post('debug_mode') == 'ON') {
                $errors['debug'] = $th->getMessage();
            }
            return response()->json($errors, 500);
        }
    }

//    public function applyPromotion(Request $request)
//    {
//
//        try {
//
//            //adding a new line in code for different cart id and promotions.
//            $cartId = $request->post('cart_id');
//            $existingPromotion = Cart::where('cart_id', $cartId)->pluck('promotion_id')->first();
//
//            // Check if a different promotion is already applied to the cart
//            if ($existingPromotion && $existingPromotion !== $request->post('promotion_code')) {
//                return response()->json(['message' => "Another promotion is already applied to this cart!", 'success' => false]);
//            }
//
//            $promotion = Promotion::with('eligible_items')->where([
//                'restaurant_id' => $request->post('restaurant_id'),
//                'promotion_code' => $request->post('promotion_code'),
//
//            ])->first();
////            dd($promotion);
//
//            if (!$promotion) {
//                return response()->json(['message' => "Invalid promotion code !", 'success' => false]);
//            }
//
//            //FOR AVAILABILITY
////            if ($promotion->availability === 'Hidden') {
////                return response()->json(['message' => "Promotion is hidden!", 'success' => false]);
////            }
////            elseif ($promotion->availability === 'Always Available') {
////                return response()->json(['message' => "Promotion is Always Available!", 'success' => false]);
////            }
////            elseif ($promotion->availability === 'Restricted') {
////                // If promotion is restricted, check if it is currently applicable based on restricted_days and restricted_hours
////                $now = now();
////                $restrictedDays = explode(',', $promotion->restricted_days);
////                $restrictedHours = explode('-', $promotion->restricted_hours);
////
////                // Check if today is a restricted day
////                if (in_array(strtolower($now->format('l')), $restrictedDays)) {
////                    // Check if the current time is within the restricted hours
////                    $startHour = (int) trim($restrictedHours[0]);
////                    $endHour = (int) trim($restrictedHours[1]);
////
////                    if ($now->hour >= $startHour && $now->hour < $endHour) {
////                        // Promotion is applicable during the restricted time
////                    } else {
////                        return response()->json(['message' => "Promotion is restricted at this time!", 'success' => false]);
////                    }
////                } else {
////                    return response()->json(['message' => "Promotion is restricted on this day!", 'success' => false]);
////                }
////            }
//
//
//            $promotion_category_items = PromotionCategoryItem::where('promotion_id', $promotion->promotion_id)->with('category_item')->get();
//
//            $eligible_item_ids = [];
//            foreach ($promotion_category_items as $promotion_category_item) {
//                $eligible_item_ids[] = $promotion_category_item->category_item[0]->menu_id;
//            }
//
//            $cart = Cart::find($request->post('cart_id'));
//            $cartItemIds = [];
//            foreach ($cart->cartMenuItems as $item) {
//                $cartItemIds[] = $item->menu_id;
//            }
////            dd($promotion);
//
//
//            // FOR ADDONS
//            // Check if modifier_total is available in any cart menu item
//            $hasModifierTotal = $cart->cartMenuItems()->whereNotNull('modifier_total')->exists();
//
//            // Apply Promotion
//            if ($hasModifierTotal) {
//                $modifierTotal = $cart->cartMenuItems()->sum('modifier_total');
//                $cart->cartMenuItems()->update(['menu_total' => DB::raw('menu_total - modifier_total')]);
//
//                // Check the no_extra_charge_type from the promotions table
//                if ($promotion->no_extra_charge_type == 'No extra charges') {
//
//                    // Add the promotion discount to the cart's sub_total
//                    $cart->sub_total -= $promotion->discount;
//                    $newTaxRate = 0.1; // Adjust this based on your actual tax rate
//                    $cart->tax_charge = $cart->sub_total * $newTaxRate;
//                    $cart->total_due = $cart->sub_total + $cart->tax_charge;
//
//                }else {
//                    // Check if the no_extra_charge_type includes charges for choices/addons or choices/addons/sizes
//                    if (Str::contains($promotion->no_extra_charge_type, ['Charges extra for Choices/Addons', 'Charges extra for Choices/Addons & Sizes'])) {
//                        // Add the modifier_total to the cart's sub_total
//                        $cart->sub_total += $modifierTotal;
//                    }
//                }
//            }
//
//            //Apply Promotion
//            $uid = auth()->id();
//            $restaurantId = $request->post('restaurant_id');
//
////            // Check if the promotion is already applied to the user's cart
//            $existingPromotion = Cart::where('uid', $uid)->pluck('promotion_id')->first();
//
//            if ($existingPromotion && $promotion->only_once_per_client == 0) {
//                return response()->json(['message' => "This promotion can only be applied once per client!", 'success' => false]);
//            }
//
//
//            //for customer type
//            $isReturningCustomer = Order::where('uid', $uid)->exists();
//            $isNewCustomer = !Order::where('uid', $uid)->exists();
//             $promotionTypes = PromotionType::where('promotion_type_id',$promotion->promotion_type_id)->first();
//
////            if (($promotion->client_type == 'Only New Customer' && $isReturningCustomer) || ($promotion->client_type == 'Only Returning Customer' && $isNewCustomer)) {
////                return response()->json(['message' => "Promotion not applicable for the user type!", 'success' => false]);
////            }
//
//             /* Promotions Helper logic function */
//             $test[] = [$promotionTypes->promotion_type_id];
//             // apply_promotion($promotionTypes->promotion_name,$promotion,$uid,$restaurantId,$cart);
//             if(apply_promotion($promotionTypes->promotion_name,$promotion,$uid,$restaurantId,$cart) == true){
//             }
//
//
//            //for minimum order amount
//            $cart = Cart::find($request->post('cart_id'));
//            $cartTotal = $cart->total_due;
//
//            // Check if the cart total is less than the minimum order amount required by the promotion
////            if ($promotion->set_minimum_order_amount && $cartTotal < $promotion->set_minimum_order_amount) {
////                return response()->json([
////                    'message' => "Promotion can not applied!",
////                    'success' => false
////                ]);
////            }
//
//
//            $promotionTypes = PromotionType::all();
//            foreach ($promotionTypes as $promotion_type) {
//                /* Promotions Helper logic function */
//                $test[] = [$promotion_type->id];
//
//                 //calling the custom.php apply_promotion function
//                if (apply_promotion($promotion_type->promotion_name, $promotion, $uid, $restaurantId, $cart) == true) {
//                    break;
//
//                }
////                dd($promotion_type);
//
//            }
//
////            dd($cart);
//            $cartItem = Cart::where('restaurant_id', $restaurantId)->where('uid', $uid)->first();
////            $cartItem->save();
////            dd($cartItem);
//            //==========================************
////             dd($cart);
//
//
//            $cart->promotion_id = $promotion->promotion_id;
//            if ($cart->save()) {
//                return response()->json([
//                    'message' => "Promotion applied !",
//                    'data' => [
//                        'cart_list' => $cartItem,
//                        'promotion_code' => $promotion->promotion_code,
//                        'promotion_name' => $promotion->promotion_name,
//                        'promotion_details' => $promotion->promotion_details,
//                        'promotion_selected_payment_method'=>$promotion->selected_payment_status,
//
//                    ],
//                    'success' => true], 200);
//
//            } else {
//                return response()->json(['message' => "Promotion is not elegible for any item of the Cart !", 'success' => false]);
//            }
//
//        } catch (\Throwable $th) {
//            $errors['success'] = false;
//            $errors['message'] = Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS');
//            if ($request->post('debug_mode') == 'ON') {
//                $errors['debug'] = $th->getMessage();
//            }
//            return response()->json($errors, 500);
//        }
//
//    }


    public function applyPromotion(Request $request)
    {
        try {
            $cartId = $request->post('cart_id');
            $existingPromotion = Cart::where('cart_id', $cartId)->pluck('promotion_id')->first();

            // Check if a different promotion is already applied to the cart
            if ($existingPromotion && $existingPromotion !== $request->post('promotion_code')) {
                return response()->json(['message' => "Another promotion is already applied to this cart!", 'success' => false]);
            }
            $promotion = Promotion::with('eligible_items')->where([
                'restaurant_id' => $request->post('restaurant_id'),
                'promotion_code' => $request->post('promotion_code'),
            ])->first();

            if (!$promotion) {
                return response()->json(['message' => "Invalid promotion code!", 'success' => false]);
            }
//            //FOR AVAILABILITY
////            if ($promotion->availability === 'Hidden') {
////                return response()->json(['message' => "Promotion is hidden!", 'success' => false]);
////            }
////            elseif ($promotion->availability === 'Always Available') {
////                return response()->json(['message' => "Promotion is Always Available!", 'success' => false]);
////            }
////            elseif ($promotion->availability === 'Restricted') {
////                // If promotion is restricted, check if it is currently applicable based on restricted_days and restricted_hours
////                $now = now();
////                $restrictedDays = explode(',', $promotion->restricted_days);
////                $restrictedHours = explode('-', $promotion->restricted_hours);
////
////                // Check if today is a restricted day
////                if (in_array(strtolower($now->format('l')), $restrictedDays)) {
////                    // Check if the current time is within the restricted hours
////                    $startHour = (int) trim($restrictedHours[0]);
////                    $endHour = (int) trim($restrictedHours[1]);
////
////                    if ($now->hour >= $startHour && $now->hour < $endHour) {
////                        // Promotion is applicable during the restricted time
////                    } else {
////                        return response()->json(['message' => "Promotion is restricted at this time!", 'success' => false]);
////                    }
////                } else {
////                    return response()->json(['message' => "Promotion is restricted on this day!", 'success' => false]);
////                }
////            }
//
            $promotion_category_items = PromotionCategoryItem::where('promotion_id', $promotion->promotion_id)
                ->with('category_item')->get();

            $eligible_item_ids = [];
            foreach ($promotion_category_items as $promotion_category_item) {
                $eligible_item_ids[] = $promotion_category_item->category_item[0]->menu_id;
            }

            $cart = Cart::find($cartId);
            if (!$cart) {
                return response()->json(['message' => "Cart not found!", 'success' => false]);
            }

            $cartItemIds = [];
            foreach ($cart->cartMenuItems as $item) {
                $cartItemIds[] = $item->menu_id;
            }

            $uid = auth()->id();
            $restaurantId = $request->post('restaurant_id');
            $existingPromotion = Cart::where('uid', $uid)->pluck('promotion_id')->first();

            if ($existingPromotion && $promotion->only_once_per_client == 0) {
                return response()->json(['message' => "This promotion can only be applied once per client!", 'success' => false]);
            }

//            //for customer type
            $isReturningCustomer = Order::where('uid', $uid)->exists();
            $isNewCustomer = !Order::where('uid', $uid)->exists();
             $promotionTypes = PromotionType::where('promotion_type_id',$promotion->promotion_type_id)->first();

//            if (($promotion->client_type == 'Only New Customer' && $isReturningCustomer) || ($promotion->client_type == 'Only Returning Customer' && $isNewCustomer)) {
//                return response()->json(['message' => "Promotion not applicable for the user type!", 'success' => false]);
//            }

             //for minimum order amount
            $cart = Cart::find($request->post('cart_id'));
            $cartTotal = $cart->total_due;

            // Check if the cart total is less than the minimum order amount required by the promotion
            if ($promotion->set_minimum_order_amount && $cartTotal < $promotion->set_minimum_order_amount) {
                return response()->json([
                    'message' => "Promotion can not applied!",
                    'success' => false
                ]);
            }


             /* Promotions Helper logic function */
             $test[] = [$promotionTypes->promotion_type_id];
             // apply_promotion($promotionTypes->promotion_name,$promotion,$uid,$restaurantId,$cart);
             if(apply_promotion($promotionTypes->promotion_name,$promotion,$uid,$restaurantId,$cart) == true){
             }


            $promotionTypes = PromotionType::all();
            foreach ($promotionTypes as $promotion_type) {
                if (apply_promotion($promotion_type->promotion_name, $promotion, $uid, $restaurantId, $cart) == true) {
                    break;
                }
            }

            //FOR ADDONS Discount
                if ($promotion->no_extra_charge_type === 'No extra charges') {
                    // Apply the discount
                    $cart->discount_charge = $promotion->discount;
                    $cart->sub_total -= $promotion->discount;

                    // Retrieve the sales tax rate from the restaurant table
                    $restaurant = Restaurant::find($restaurantId);
                    if (!$restaurant) {
                        return response()->json(['message' => "Restaurant not found!", 'success' => false]);
                    }

                    $salesTaxRate = $restaurant->sales_tax / 100; // Convert percentage to decimal

                    // Calculate the new tax and total due
                    $cart->tax_charge = $cart->sub_total * $salesTaxRate;
                    $cart->total_due = $cart->sub_total + $cart->tax_charge;

                }else {
                    // Check if the no_extra_charge_type includes charges for choices/addons or choices/addons/sizes
                    if (Str::contains($promotion->no_extra_charge_type, ['Charges extra for Choices/Addons', 'Charges extra for Choices/Addons & Sizes'])) {
                        // Add the modifier_total to the cart's sub_total
                        $modifierTotal = $cart->cartMenuItems()->sum('modifier_total');
                        $cart->sub_total += $modifierTotal;
                    }
                }
                $cart->promotion_id = $promotion->promotion_id;

            if ($cart->save()) {
                return response()->json([
                    'message' => "Promotion applied!",
                    'data' => [
                        'cart_list' => $cart,
                        'promotion_code' => $promotion->promotion_code,
                        'promotion_name' => $promotion->promotion_name,
                        'promotion_details' => $promotion->promotion_details,
                        'promotion_selected_payment_method' => $promotion->selected_payment_status,
                    ],
                    'success' => true,
                ], 200);
            } else {
                return response()->json(['message' => "Promotion is not eligible for any item of the Cart!", 'success' => false]);
            }
        } catch (\Throwable $th) {
            $errors['success'] = false;
            $errors['message'] = Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS');
            if ($request->post('debug_mode') == 'ON') {
                $errors['debug'] = $th->getMessage();
            }
            return response()->json($errors, 500);
        }
    }

    public function removePromotion(Request $request)
    {

        try {
            $cart = Cart::where([
                'uid' => auth('api')->user()->uid,
                'restaurant_id' => $request->post('restaurant_id'),
                'cart_id' => $request->post('cart_id')
            ])->first();
//        dd($cart);
//            $uid = auth()->id();

            $uid = auth('api')->user()->uid;
//            dd($uid);
            //Remove Promotion
            $cartItem = CartItem::where('cart_id', $request->post('cart_id'))->get();
            $restaurant = Restaurant::where('restaurant_id', $request->post('restaurant_id'))->first();
//       dd($cartItem);

            $totalPrice = 0;
            $totalmodifier = 0;
            foreach ($cartItem as $list) {
                $totalPrice = $totalPrice + ($list->menu_qty * $list->menu_price) + ($list->menu_qty * $list->modifier_total);
            }

            //Sales Tax
            $taxCharge = number_format(($totalPrice * $restaurant->sales_tax) / 100, 2);
            $totalPayableAmount = number_format($totalPrice + $taxCharge, 2);

            $prmotionid = $cart->promotion_id = 0;
            $dicountcharge = $cart->discount_charge = 0.00;
            Cart::where('cart_id', $request->post('cart_id'))->where('uid', $uid)->where('restaurant_id', $request->post('restaurant_id'))->update(['sub_total' => number_format($totalPrice, 2), 'tax_charge' => number_format($taxCharge, 2), 'discount_charge' => number_format($dicountcharge, 2), 'total_due' => number_format($totalPayableAmount, 2), 'promotion_id' => $prmotionid]);
            $cartItem = Cart::where('restaurant_id', $request->post('restaurant_id'))->where('uid', $uid)->first();
            $cartItem->save();


            if ($cart->save()) {
                return response()->json([
                    'message' => "Promotion removed successfully !",
                    'data' => [
                        'cartItem' => $cartItem,
                    ],
                    'success' => true], 200);
            } else {
                return response()->json(['message' => "Promotion is not elegible for any item of the Cart !", 'success' => false]);
            }

        } catch (\Throwable $th) {
            $errors['success'] = false;
            $errors['message'] = Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS');
            if ($request->post('debug_mode') == 'ON') {
                $errors['debug'] = $th->getMessage();
            }
            return response()->json($errors, 500);
        }

    }

//    public function checkGeneralParametersCheck($promotion, $promotions, $uid, $restaurantId, $cart)
//    {
//        // '1' => 'Any Client,new or Returning',
//        // '2' => 'Only new Clients',
//        // '3' => 'Only Returning'
//
//        $user = User::where('uid', $uid)->first();
//        $list = Order::where('restaurant_id', $restaurantId)
//            ->where('uid', $uid)
//            ->with('user')
//            ->get();
//
//        $count = $list->count();
//
//        // Check if the selected client type is "Any Client"
//        if ($promotion->client_type == Config::get('constants.CLIENT_TYPE.1')) {
//            // Check if the order count is greater than or equal to 0
//            if ($count >= 0) {
//                // Logic for applying the promotion
//                // You can add your specific conditions and actions here
//
//                // Check minimum order amount
//                if ($cart->sub_total < $promotion->minimum_order_amount) {
//                    return response()->json(['message' => 'Minimum order amount not met', 'success' => false], 400);
//                }
//
//                // Return success response or perform additional actions
//                return response()->json(['message' => 'Promotion applied!', 'success' => true], 200);
//            } else {
//                // If the order count is less than 0, return an error response
//                return response()->json(['message' => 'Invalid order count for Any Client type', 'success' => false], 400);
//            }
//        } else {
//            // If the client type is not "Any Client", return an error response
//            return response()->json(['message' => 'Promotion is only applicable for Any Client type', 'success' => false], 400);
//        }
//    }


}
