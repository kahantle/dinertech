<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Config;
use DB;
use App\Models\Cart;
// use App\Models\MenuItem;
use App\Models\CartItem;
use App\Models\Restaurant;
use App\Models\CartMenuGroup;
use App\Models\CartMenuGroupItem;
use App\Models\PromotionType;
use App\Models\Promotion;
use Auth;

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
            $validator = Validator::make($request_data,[
                'restaurant_id'  => 'required'
            ]);
            $uid = auth('api')->user()->uid;
            $restaurantId = $request->post('restaurant_id');

            $cartItem = Cart::with(['cartMenuItems' => function($cartItems){
                $cartItems->select(['cart_menu_item_id','cart_id','menu_id','menu_name','menu_qty','menu_price','menu_total','modifier_total','is_loyalty'])->with(['cartMenuGroups' => function($cartMenuGroups){
                    $cartMenuGroups->select(['cart_modifier_group_id','cart_menu_item_id','menu_id','modifier_group_id','modifier_group_name'])->with('cartMenuGroupItems')->get();
                }])->get();
            }])->where('restaurant_id',$restaurantId)->where('uid',$uid)->select('cart_id','restaurant_id','promotion_id','uid','sub_total','discount_charge','tax_charge','total_due','is_payment')->first();

            if($cartItem){

                DB::beginTransaction();
                // if((empty($cartItem->promotion_id) || $cartItem->promotion_id == null) && (empty($cartItem->discount_charge) || floatval($cartItem->discount_charge) == 0)){
                    //  if(!$cartItem->promotion_id){
                    //     Cart::where('cart_id',$cartItem->cart_id)->where('uid',$uid)->where('restaurant_id',$restaurantId)->update(['discount_charge' =>  0,'tax_charge' => 0,'total_due' => $cartItem->sub_total]);
                    // }
                    $promotionTypes = PromotionType::all();
                    foreach($promotionTypes as $promotion_type){
                        /* Promotions Helper logic function */
                        $test[] = [$promotion_type->id];
                        if(apply_promotion($promotion_type->promotion_name,$uid,$restaurantId,$cartItem) == true){
                           break;
                        }
                    }
                // }
                DB::commit();

                $cartItem = Cart::with(['cartMenuItems' => function($cartItems){
                $cartItems->select(['cart_menu_item_id','cart_id','menu_id','menu_name','menu_qty','menu_price','menu_total','modifier_total','is_loyalty'])->with(['cartMenuGroups' => function($cartMenuGroups){
                    $cartMenuGroups->select(['cart_modifier_group_id','cart_menu_item_id','menu_id','modifier_group_id','modifier_group_name'])->with('cartMenuGroupItems')->get();
                }])->get();

            }])->where('restaurant_id',$restaurantId)->where('uid',$uid)->select('cart_id','restaurant_id','promotion_id','uid','sub_total','discount_charge','tax_charge','total_due','is_payment')->with('promotion')->first();
                return response()->json(['cart_list' => $cartItem, 'success' => true], 200);
            }
            return response()->json(['cart_list' => (object)[],'message' => 'Your cart is empty','success' => true], 200);

        } catch (\Throwable $th) {
            $errors['success'] = false;
            $errors['message'] = Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS');
            if($request->post('debug_mode') == 'ON'){
                $errors['debug'] = $th->getMessage();
            }
            return response()->json($errors, 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $request_data = $request->json()->all();
            $validator = Validator::make($request_data,[
                'restaurant_id' => 'required',
                'menu_item'    => 'required',
                // 'is_loyalty'  =>  'required',
            ]);

            $user = Auth::user();
            foreach ($request->post('menu_item') as $menu_item) {
                if ($menu_item['is_loyalty'] == true) {
                    $user->update(['total_points' => $user->total_points - $menu_item['loyalty_point']]);
                }
            }

            if($validator->fails()){
                return response()->json(['success' => false,'message' => $validator->errors()], 400);
            }
            $uid = auth('api')->user()->uid;
            // $restaurant = Restaurant::where('restaurant_id',$request->post('restaurant_id'))->first();
            // $salesTax = $restaurant->sales_tax;
            $check_cart = Cart::where('uid',$uid)->where('restaurant_id',$request->post('restaurant_id'))->first();
            $finalTotal = 0;
            if($check_cart == NULL){
                $cart_sub_total = 0;
                $cart = new Cart;
                $cart->uid = $uid;
                $cart->restaurant_id = $request->post('restaurant_id');
                $cart->order_type = ($request->post('order_type') == Config::get('constants.ORDER_TYPE.1')) ? Config::get('constants.ORDER_TYPE.1') : Config::get('constants.ORDER_TYPE.2');
                $cart->is_payment = ($request->post('is_payment') == Config::get('constants.ORDER_PAYMENT_TYPE.CASH_PAYMENT')) ? Config::get('constants.ORDER_PAYMENT_TYPE.CASH_PAYMENT') : Config::get('constants.ORDER_PAYMENT_TYPE.CARD_PAYMENT');
                if($cart->save()){
                    foreach($request->post('menu_item') as $key => $menuItem){
                        $cartMenuItemData = new CartItem;
                        $cartMenuItemData->cart_id = $cart->cart_id;
                        $cartMenuItemData->category_id = $menuItem['category_id'];
                        $cartMenuItemData->menu_id = $menuItem['menu_id'];
                        $cartMenuItemData->menu_name = $menuItem['item_name'];
                        $cartMenuItemData->menu_qty = $menuItem['item_qty'];
                        $cartMenuItemData->menu_price = $menuItem['item_price'];
                        $cartMenuItemData->menu_total = $menuItem['menu_total'];
                        $cart_sub_total = $menuItem['menu_total'];
                        $cartMenuItemData->modifier_total = $menuItem['modifier_total'];
                        $cartMenuItemData->is_loyalty = ($menuItem['is_loyalty'] == true) ? 1:0;
                        $cartMenuItemData->loyalty_point = $menuItem['loyalty_point'];
                        $cartMenuItemData->save();
                        if(isset($menuItem['modifier_list'])){
                           foreach($menuItem['modifier_list'] as $modifierKey => $modifier){
                                $cartModifierGroup = new CartMenuGroup;
                                $cartModifierGroup->cart_id = $cart->cart_id;
                                $cartModifierGroup->cart_menu_item_id = $cartMenuItemData->cart_menu_item_id;
                                $cartModifierGroup->menu_id = $menuItem['menu_id'];
                                $cartModifierGroup->modifier_group_id = $modifier['modifier_group_id'];
                                $cartModifierGroup->modifier_group_name = $modifier['modifier_group_name'];
                                if($cartModifierGroup->save()){
                                    if(isset($modifier['modifier_items'])){
                                        foreach($modifier['modifier_items'] as $modifierItemKey => $modifierItem){
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
                    Cart::where('uid',$uid)->where('restaurant_id',$request->post('restaurant_id'))->where('cart_id',$cart->cart_id)->update(['sub_total' => number_format($finalTotal,2),  'total_due' => number_format($finalTotal,2)]);
                }
            }else{
                $cart_sub_total = $check_cart->sub_total;
                foreach($request->post('menu_item') as $key => $menuItem){
                    $cartMenuItemData = new CartItem;
                    $cartMenuItemData->cart_id = $check_cart->cart_id;
                    $cartMenuItemData->category_id = $menuItem['category_id'];
                    $cartMenuItemData->menu_id = $menuItem['menu_id'];
                    $cartMenuItemData->menu_name = $menuItem['item_name'];
                    $cartMenuItemData->menu_qty = $menuItem['item_qty'];
                    $cartMenuItemData->menu_price = $menuItem['item_price'];
                    $cartMenuItemData->modifier_total = $menuItem['modifier_total'];
                    $cartMenuItemData->menu_total = $menuItem['menu_total'];
                    $cart_sub_total += $menuItem['menu_total'];
                    $cartMenuItemData->is_loyalty = ($menuItem['is_loyalty'] == true) ? 1:0;
                    $cartMenuItemData->loyalty_point = $menuItem['loyalty_point'];
                    $cartMenuItemData->save();
                    if(isset($menuItem['modifier_list'])){
                        foreach($menuItem['modifier_list'] as $modifierKey => $modifier){
                            $cartModifierGroup = new CartMenuGroup;
                            $cartModifierGroup->cart_id = $check_cart->cart_id;
                            $cartModifierGroup->cart_menu_item_id = $cartMenuItemData->cart_menu_item_id;
                            $cartModifierGroup->menu_id = $menuItem['menu_id'];
                            $cartModifierGroup->modifier_group_id = $modifier['modifier_group_id'];
                            $cartModifierGroup->modifier_group_name = $modifier['modifier_group_name'];
                            if($cartModifierGroup->save()){
                                if(isset($modifier['modifier_items'])){
                                    foreach($modifier['modifier_items'] as $modifierItemKey => $modifierItem){
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
                // $taxCharge = ($finalTotal * $salesTax) / 100;
                // $finalTotal = $finalTotal + $taxCharge;
                $orderType = ($request->post('order_type') == Config::get('constants.ORDER_TYPE.1')) ? Config::get('constants.ORDER_TYPE.1') : Config::get('constants.ORDER_TYPE.2');
                // Cart::where('uid',$uid)->where('restaurant_id',$request->post('restaurant_id'))->where('cart_id',$check_cart->cart_id)->update(['order_type' => $orderType,'sub_total' => number_format($cart_sub_total,2), 'tax_charge' => number_format($taxCharge,2), 'total_due' => number_format($finalTotal,2)]);
                Cart::where('uid',$uid)->where('restaurant_id',$request->post('restaurant_id'))->where('cart_id',$check_cart->cart_id)->update(['order_type' => $orderType, 'sub_total' => number_format($finalTotal,2), 'total_due' => number_format($finalTotal,2)]);
            }

           return response()->json(['success' => true, 'message' => "Item added to the cart successfully."], 200);
        } catch (\Throwable $th) {
            $errors['success'] = false;
            $errors['message'] = Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS');
            if($request->post('debug_mode') == 'ON'){
                $errors['debug'] = $th->getMessage();
            }
            return response()->json($errors,500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getCartMenuModifier(Request $request)
    {
        try {
            $request_data = $request->json()->all();
            $validator = Validator::make($request_data,[
                'restaurant_id' => 'required',
                'cart_menu_item_id' => 'required',
                'menu_id'    => 'required'
            ]);

            if($validator->fails()){
                return response()->json(['success' => false,'message' => $validator->errors()], 400);
            }

            $cartModifiers = CartMenuGroup::with('cartMenuGroupItems')->with('modifierGroup')->where('cart_menu_item_id',$request->post('cart_menu_item_id'))->where('menu_id',$request->post('menu_id'))->get(['cart_modifier_group_id','cart_id','cart_menu_item_id','menu_id','modifier_group_id','modifier_group_name']);

            if($cartModifiers){
                return response()->json(['modifier_list' => $cartModifiers,'success' => true], 200);
            }else{
                return response()->json(['message' => 'Cart menu modifiers not found.','success' => false], 400);
            }
        } catch (\Throwable $th) {
            $errors['success'] = false;
            $errors['message'] = Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS');
            if($request->post('debug_mode') == 'ON'){
                $errors['debug'] = $th->getMessage();
            }
            return response()->json($errors, 500);
        }
    }

    /**
     * Update the specified modifier in cart menu item.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function customizeModifier(Request $request)
    {
        try {
            $request_data = $request->json()->all();
            $validator = Validator::make($request_data,[
                'restaurant_id' => 'required',
                'cart_menu_item_id' => 'required',
                'menu_id'    => 'required',
                'modifier_list' => 'required',
                'modifier_total' => 'required'
            ]);

            if($validator->fails()){
                return response()->json(['success' => false,'message' => $validator->errors()], 400);
            }

            $cartItem = CartItem::where('cart_menu_item_id',$request->post('cart_menu_item_id'))->first();
            if($cartItem){
                $cartItem->modifier_total = $request->post('modifier_total');
                $menuTotal = ($request->post('modifier_total') + $cartItem->menu_price) * $cartItem->menu_qty;
                $cartItem->menu_total = number_format($menuTotal,2);
                if($cartItem->save()){
                    CartMenuGroup::where('cart_menu_item_id',$request->post('cart_menu_item_id'))->where('menu_id',$request->post('menu_id'))->delete();
                    CartMenuGroupItem::where('cart_menu_item_id',$request->post('cart_menu_item_id'))->where('menu_id',$request->post('menu_id'))->delete();
                    foreach($request->post('modifier_list') as $modifierKey => $modifier){
                        $cartModifierGroup = new CartMenuGroup;
                        $cartModifierGroup->cart_id = $cartItem->cart_id;
                        $cartModifierGroup->cart_menu_item_id = $request->post('cart_menu_item_id');
                        $cartModifierGroup->menu_id = $request->post('menu_id');
                        $cartModifierGroup->modifier_group_id = $modifier['modifier_group_id'];
                        $cartModifierGroup->modifier_group_name = $modifier['modifier_group_name'];
                        if($cartModifierGroup->save()){
                            if($modifier['modifier_items']){
                                foreach($modifier['modifier_items'] as $modifierItemKey => $modifierItem){
                                    $cartModifierItem = new CartMenuGroupItem;
                                    $cartModifierItem->cart_id = $cartItem->cart_id;
                                    $cartModifierItem->cart_menu_item_id = $request->post('cart_menu_item_id');
                                    $cartModifierItem->menu_id = $request->post('menu_id');
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
                    return response()->json(['message' => 'Modifiers update successfully.','success' => true], 200);
                }else{
                    return response()->json(['message' => 'Modifiers does not update successfully.','success' => false], 200);
                }
            }else{
                return response()->json(['message' => 'Item not found in cart.','success' => false], 400);
            }
        } catch (\Throwable $th) {
            $errors['success'] = false;
            $errors['message'] = Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS');
            if($request->post('debug_mode') == 'ON'){
                $errors['debug'] = $th->getMessage();
            }
            return response()->json($errors, 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try {
            $request_data = $request->json()->all();
            $validator = Validator::make($request_data,[
                'restaurant_id'  => 'required',
                'cart_menu_item_id' => 'required'
            ]);

            if($validator->fails()){
                return response()->json(['success' => false,'message' => $validator->errors()], 400);
            }

            $cart_menu_item = CartItem::where('cart_menu_item_id',$request->post('cart_menu_item_id'))->first();
            if ($cart_menu_item->is_loyalty == 1) {
                $user = Auth::user();
                $user->update(['total_points' => $user->total_points + (int)$cart_menu_item->loyalty_point]);
            }

            $uid = auth('api')->user()->uid;
            $check_cart = Cart::where('uid',$uid)->where('restaurant_id',$request->post('restaurant_id'))->first();
            $cartMenuItems = CartItem::where('cart_id',$check_cart->cart_id);

            if($cartMenuItems->get()->count() > 1){
                CartMenuGroup::where('cart_menu_item_id',$request->post('cart_menu_item_id'))->where('cart_id',$check_cart->cart_id)->delete();
                CartMenuGroupItem::where('cart_menu_item_id',$request->post('cart_menu_item_id'))->where('cart_id',$check_cart->cart_id)->delete();
                $cartMenuItems->where('cart_id',$check_cart->cart_id)->where('cart_menu_item_id',$request->post('cart_menu_item_id'))->delete();
            }else{
                CartMenuGroup::where('cart_id',$check_cart->cart_id)->delete();
                CartMenuGroupItem::where('cart_id',$check_cart->cart_id)->delete();
                $cartMenuItems->where('cart_menu_item_id',$request->post('cart_menu_item_id'))->delete();
                $check_cart->delete();
            }
            return response()->json(['success' => true,'message' => 'Cart item remove successfully.'], 200);
        } catch (\Throwable $th) {
            $errors['success'] = false;
            $errors['message'] = Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS');
            if($request->post('debug_mode') == 'ON'){
                $errors['debug'] = $th->getMessage();
            }
            return response()->json($errors, 500);
        }
    }

    public function quantityIncrement(Request $request){
        try {
            $request_data = $request->json()->all();
            $validator = Validator::make($request_data,[
                'restaurant_id' => 'required',
                'cart_menu_item_id' => 'required',
                'menu_id'           => 'required'
            ]);

            if($validator->fails()){
                return response()->json(['success' => false,'message' => $validator->errors()], 400);
            }else{
                $uid = auth('api')->user()->uid;
                $check_cart = Cart::where('uid',$uid)->where('restaurant_id',$request->post('restaurant_id'))->first();
                if($check_cart){
                    $cartItem = CartItem::where('cart_menu_item_id',$request->post('cart_menu_item_id'))->where('menu_id',$request->post('menu_id'))->where('cart_id',$check_cart->cart_id)->first();
                    if($cartItem){
                        $menuOldQuantity = $cartItem->menu_qty;
                        $menuOldTotal  = $cartItem->menu_total;
                        $menuNewQuantity = $menuOldQuantity + 1;
                        $cartItem->menu_qty = $menuNewQuantity;
                        $cartItem->menu_total = number_format($menuOldTotal * $menuNewQuantity,2);
                        $cartItem->save();

                        $subtotal = CartItem::where('cart_id',$check_cart->cart_id)->sum('menu_total');
                        // $restaurant = Restaurant::where('restaurant_id',$request->post('restaurant_id'))->first();
                        // $salesTax = $restaurant->sales_tax;
                        // $taxCharge = ($subtotal * $salesTax) / 100;
                        // $finalTotal = $subtotal + $taxCharge;
                        Cart::where('uid',$uid)->where('restaurant_id',$request->post('restaurant_id'))->where('cart_id',$check_cart->cart_id)->update(['sub_total' => number_format($subtotal,2),  'total_due' => number_format($subtotal,2)]);
                        return response()->json(['message' => "Cart quantity increment successfully.", 'success' => true], 200);
                    }else{
                        return response()->json(['message' => "Cart item not found.", 'success' => false], 400);
                    }
                }else{
                    return response()->json(['message' => "Cart item not found.", 'success' => false], 400);
                }
            }
        } catch (\Throwable $th) {
            $errors['success'] = false;
            $errors['message'] = Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS');
            if($request->post('debug_mode') == 'ON'){
                 $errors['debug'] = $th->getMessage();
            }
            return response()->json($errors, 500);
        }
    }

    public function quantityDecrement(Request $request){
        try {
            $request_data = $request->json()->all();
            $validator = Validator::make($request_data,[
                'restaurant_id' => 'required',
                'cart_menu_item_id' => 'required',
                'menu_id'           => 'required'
            ]);

            if($validator->fails()){
                return response()->json(['success' => false,'message' => $validator->errors()], 400);
            }else{
                $uid = auth('api')->user()->uid;
                $check_cart = Cart::where('uid',$uid)->where('restaurant_id',$request->post('restaurant_id'))->first();
                if($check_cart){
                    $cartItem = CartItem::where('cart_menu_item_id',$request->post('cart_menu_item_id'))->where('menu_id',$request->post('menu_id'))->where('cart_id',$check_cart->cart_id)->first();
                    if($cartItem){
                        $menuOldQuantity = $cartItem->menu_qty;
                        $menuOldTotal  = $cartItem->menu_price + $cartItem->modifier_total;
                        $menuNewQuantity = $menuOldQuantity - 1;
                        if($menuNewQuantity != 0){
                            $cartItem->menu_qty = $menuNewQuantity;
                            $cartItem->menu_total = number_format($menuOldTotal * $menuNewQuantity,2);
                            $cartItem->save();

                            $subtotal = CartItem::where('cart_id',$check_cart->cart_id)->sum('menu_total');
                            // $restaurant = Restaurant::where('restaurant_id',$request->post('restaurant_id'))->first();
                            // $salesTax = $restaurant->sales_tax;
                            // $taxCharge = ($subtotal * $salesTax) / 100;
                            // $finalTotal = $subtotal + $taxCharge;
                            Cart::where('uid',$uid)->where('restaurant_id',$request->post('restaurant_id'))->where('cart_id',$check_cart->cart_id)->update(['sub_total' => number_format($subtotal,2),  'total_due' => number_format($subtotal,2)]);
                            return response()->json(['message' => "Cart quantity decrement successfully.", 'success' => true], 200);
                        }else{
                            return response()->json(['message' => "Do not set quantity to less than one.", 'success' => true], 400);
                        }
                    }else{
                        return response()->json(['message' => "Cart item not found.", 'success' => false], 400);
                    }
                }else{
                    return response()->json(['message' => "Cart item not found.", 'success' => false], 400);
                }
            }
        } catch (\Throwable $th) {
            $errors['success'] = false;
            $errors['message'] = Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS');
            if($request->post('debug_mode') == 'ON'){
                 $errors['debug'] = $th->getMessage();
            }
            return response()->json($errors, 500);
        }
    }

    public function removePromotion(Request $request)
    {
        try{
            $cart = Cart::where([
                'uid' => auth('api')->user()->uid,
                'restaurant_id' => $request->post('restaurant_id'),
                'cart_id' => $request->post('cart_id')
            ])->first();

            $cart->promotion_id = NULL;
            return $cart->save() ? response()->json(['message' => "Promotion removed successfully !", 'success' => false], 400) : "" ;

        } catch (\Throwable $th) {
            $errors['success'] = false;
            $errors['message'] = Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS');
            if($request->post('debug_mode') == 'ON'){
                $errors['debug'] = $th->getMessage();
            }
            return response()->json($errors, 500);
        }
    }
}
