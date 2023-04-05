<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use App\Models\CartItem;
use App\Models\CartMenuGroup;
use App\Models\Cart;
use App\Models\ModifierGroupItem;
use App\Models\CartMenuGroupItem;
use App\Models\ModifierGroup;
use Illuminate\Http\Request;
use App\Models\LoyaltyRule;
use App\Models\Restaurant;
use Config;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        if (!empty($cart)) {
            $cartItems = array();
            $modifierdata = array();
            foreach ($cart as $cartKey => $menuItems) {
                foreach ($menuItems as $menu) {
                    array_push($cartItems, $menu);
                    $modifierGroupIds = $menu['modifier'];
                    if (!empty($menu['modifier'])) {
                        $modifierGroupItems = call_user_func_array('array_merge', $menu['modifier_item']);

                        $modifierGroups = ModifierGroup::with(['modifier_item' => function ($query) use ($modifierGroupItems, $modifierGroupIds) {
                            $query->whereIn('modifier_item_id', $modifierGroupItems)->whereIn('modifier_group_id', $modifierGroupIds)->get(['modifier_item_id', 'modifier_group_id', 'modifier_group_item_name', 'modifier_group_id', 'modifier_group_item_price']);
                        }])->whereIn('modifier_group_id', $menu['modifier'])->get(['modifier_group_id', 'modifier_group_name', 'restaurant_id']);
                        $modifierItems[$cartKey][$menu['menu_id']] = $modifierGroups->toArray();
                        $data['modifierGroups'] = $modifierItems;
                    }
                    // else
                    // {
                    //     $modifierItems[][$menu['menu_id']] = array();
                    // }
                }
            }
            $data['cartItems'] = $cart;
        } else {
            $data['cartItems'] = array();
        }
        $data['promotions'] = session()->get('promotion');
        $data['title'] = 'Cart - Dinertech';
        return view('customer.cart.index', $data);
    }

    public function addToCart(Request $request)
    {

        $uid = auth()->id();
        $cart = Cart::where('uid',$uid)->first();
        $menuItem = MenuItem::where('menu_id',$request->menuId)->first();
        $restaurantId = session()->get('restaurantId');
        $restaurantid = Restaurant::where('restaurant_id',$restaurantId)->first();


        $isloyalty = 0;
        $loyaltyPoints = 0;

        if(isset($request->loyaltyRuleId)) {
            $loyaltyRule = LoyaltyRule::where('rules_id',$request->loyaltyRuleId)->first();
            $user = auth()->user();
            $user->update([
                'total_points' => $user->total_points - $loyaltyRule->point
            ]);
            $menuItem->item_price = 0;
            $loyaltyPoints = $loyaltyRule->point;
            $isloyalty = 1;
        }

        if($cart == NULL){
            $cart_sub_total = 0;
            $cart = new Cart;
            $cart->restaurant_id = 1;
            $cart->uid = $uid;
            $cart->order_type = Config::get('constants.ORDER_TYPE.2');
            $cart->is_payment = Config::get('constants.ORDER_PAYMENT_TYPE.CARD_PAYMENT');
            $cart->save();
        }
        $check_cart = Cart::where('uid',$uid)->where('restaurant_id', $restaurantId)->first();
        //Modifier id and Total
        $modifierItems=$request->modifierItems;
        $modifiertotal=0;
        if (is_null($modifierItems))
        {
            $modifiertotal=0;
        }
        else
        {
            foreach($modifierItems as $modifier_group_id)
            {
                $modifierPrice = ModifierGroupItem::where('modifier_item_id',$modifier_group_id)->first();
                $modifiertotal+= $modifierPrice->modifier_group_item_price;
            }
        }
        $cart_sub_total = $cart->sub_total;
        $cartMenuItemData = new CartItem;
        $cartMenuItemData->cart_id = $cart->cart_id;
        $cartMenuItemData->category_id = $menuItem->category_id;
        $cartMenuItemData->menu_id = $menuItem->menu_id;
        $cartMenuItemData->menu_name = $menuItem->item_name;
        $cartMenuItemData->menu_qty = 1;
        $cartMenuItemData->menu_price = $menuItem->item_price;
        $cartMenuItemData->item_img = $menuItem->getMenuImgAttribute();
        $cart_sub_total = $menuItem->item_price;
        $cartMenuItemData->modifier_total =$modifiertotal;
        $menutotal=$menuItem->item_price * 1 + $modifiertotal;
        $cartMenuItemData->menu_total=$menutotal;
        // $cartMenuItemData->modifier_total = $menuItem->item_price;
        $cartMenuItemData->is_loyalty = $isloyalty;
        $cartMenuItemData->loyalty_point = $loyaltyPoints;
        $cartMenuItemData->save();
        if(isset($request->modifierItems)){
            $modifierItems = $request->modifierItems;
            foreach($modifierItems as $modifier_group_id => $modifier_group_item_ids){
                $modifier = ModifierGroup::select('modifier_group_id','modifier_group_name')->where('modifier_group_id', $modifier_group_id)->first();
                $cartModifierGroup = new CartMenuGroup;
                $cartModifierGroup->cart_id = $cart->cart_id;
                $cartModifierGroup->cart_menu_item_id = $cartMenuItemData->cart_menu_item_id;
                $cartModifierGroup->menu_id = $request->menuId;
                $cartModifierGroup->modifier_group_id = $modifier->modifier_group_id;
                $cartModifierGroup->modifier_group_name = $modifier->modifier_group_name;
                $cartModifierGroup->save();

                foreach ($modifier_group_item_ids as $key => $item_id) {
                   $modifierGroupItem = ModifierGroupItem::where('modifier_item_id',$item_id)->first();
                    $cartModifierItem = new CartMenuGroupItem;
                    $cartModifierItem->cart_id = $cart->cart_id;
                    $cartModifierItem->cart_menu_item_id = $cartMenuItemData->cart_menu_item_id;
                    $cartModifierItem->menu_id = $request->menuId;
                    $cartModifierItem->cart_modifier_group_id = $cartModifierGroup->cart_modifier_group_id;
                    $cartModifierItem->modifier_item_id = $modifierGroupItem->modifier_item_id;
                    $cartModifierItem->modifier_group_id = $modifier->modifier_group_id;
                    $cartModifierItem->modifier_group_item_name = $modifierGroupItem->modifier_group_item_name;
                    $cartModifierItem->modifier_group_item_price = $modifierGroupItem->modifier_group_item_price;
                    $cartModifierItem->save();
                }

            }
        }
        //Total
        $subtotal = CartItem::where('cart_id',$check_cart->cart_id)->sum('menu_total');
        //Salestax
        $taxCharge = number_format(($subtotal * $restaurantid->sales_tax) / 100,2);
        $totalPayableAmount = number_format($subtotal + $taxCharge,2);

        Cart::where('uid',$uid)->where('restaurant_id',$restaurantId)->where('cart_id',$check_cart->cart_id)->update(['sub_total' => number_format($subtotal,2),  'tax_charge' => number_format($taxCharge,2), 'total_due' => number_format($totalPayableAmount,2)]);
        return response()->json(['status' => true,'menu_id' => $cartMenuItemData->menu_id], 200);
    }

    // public function quantityChange(Request $request)
    // {
    //     $cart = Cart::where('uid', auth()->id())->first();
    //     $cartMenuItem = $cart->cartMenuItems->where('cart_menu_item_id', $request->cartMenuItemId)->first();

    //     $request->action == 'increament' ? $cartMenuItem->menu_qty = $cartMenuItem->menu_qty + 1 :  $cartMenuItem->menu_qty = $cartMenuItem->menu_qty - 1 ;

    //     if ($cartMenuItem->save()) {
    //         return response()->json(['success' => true, 'new_qty' => $cartMenuItem->menu_qty], 200);
    //     } else {
    //         return response()->json(['success' => false], 200);
    //     }
    // }

    public function quantityChange(Request $request)
    {
        $uid = auth()->id();
        $restaurantId = session()->get('restaurantId');
        $check_cart = Cart::where('uid',$uid)->where('restaurant_id', $restaurantId)->first();
        $restaurantid = Restaurant::where('restaurant_id',$restaurantId)->first();
        if($request->action == 'increament'){
            if($check_cart){
                //   $cartItem = CartItem::where('cart_id',$check_cart->cart_id)->first();
                  $cartItem = CartItem::where('cart_menu_item_id',$request->cartMenuItemId)->first();
                if($cartItem){
                    $menuOldQuantity = $cartItem->menu_qty;
                    $menuprice=$cartItem->menu_price;
                    $menuNewQuantity = $menuOldQuantity + 1;
                    $modifiertotal=$cartItem->modifier_total * $menuNewQuantity ;
                    $cartItem->menu_qty = $menuNewQuantity;
                    $cartItem->menu_total = number_format($menuprice * $menuNewQuantity + $modifiertotal,2);
                    $cartItem->save();

                    $subtotal = CartItem::where('cart_id',$check_cart->cart_id)->sum('menu_total');
                    // $restaurant = Restaurant::where('restaurant_id',$request->post('restaurant_id'))->first();
                    // $salesTax = $restaurant->sales_tax;
                    // $taxCharge = ($subtotal * $salesTax) / 100;
                    // $finalTotal = $subtotal + $taxCharge;
                    $taxCharge = number_format(($subtotal * $restaurantid->sales_tax) / 100,2);
                    $totalPayableAmount = number_format($subtotal + $taxCharge,2);

                    Cart::where('uid',$uid)->where('restaurant_id',$restaurantId)->where('cart_id',$check_cart->cart_id)->update(['sub_total' => number_format($subtotal,2),  'tax_charge' => number_format($taxCharge,2), 'total_due' => number_format($totalPayableAmount,2)]);
                    if ($cartItem->save()) {
                        return response()->json(['success' => true, 'new_qty' => $cartItem->menu_qty], 200);
                    } else {
                        return response()->json(['success' => false], 200);
                    }
                }
            }
        }
        else{
             if($check_cart){
                    $cartItem = CartItem::where('cart_menu_item_id',$request->cartMenuItemId)->first();
                    if($cartItem){
                        $menuOldQuantity = $cartItem->menu_qty;
                        $modifier_total=$cartItem->modifier_total;
                        $menu_price  = $cartItem->menu_price;
                        $menuNewQuantity = $menuOldQuantity - 1;
                        $modifiertotal=$cartItem->modifier_total * $menuNewQuantity ;
                        $cartItem->menu_qty = $menuNewQuantity;
                        if($menuNewQuantity != 0){
                            $cartItem->menu_qty = $menuNewQuantity;
                            $cartItem->menu_total = number_format($menu_price * $menuNewQuantity + $modifiertotal,2);
                            $cartItem->save();

                            $subtotal = CartItem::where('cart_id',$check_cart->cart_id)->sum('menu_total');
                            // $restaurant = Restaurant::where('restaurant_id',$request->post('restaurant_id'))->first();
                            // $salesTax = $restaurant->sales_tax;
                            // $taxCharge = ($subtotal * $salesTax) / 100;
                            // $finalTotal = $subtotal + $taxCharge;
                            $taxCharge = number_format(($subtotal * $restaurantid->sales_tax) / 100,2);
                            $totalPayableAmount = number_format($subtotal + $taxCharge,2);

                            Cart::where('uid',$uid)->where('restaurant_id',$restaurantId)->where('cart_id',$check_cart->cart_id)->update(['sub_total' => number_format($subtotal,2),  'tax_charge' => number_format($taxCharge,2), 'total_due' => number_format($totalPayableAmount,2)]);
                            if ($cartItem->save()) {
                                return response()->json(['success' => true, 'new_qty' => $cartItem->menu_qty], 200);
                            } else {
                                return response()->json(['success' => false], 200);
                            }
                         }
                    }
                }
        }

    }

    public function removeItem(Request $request)
    {
        $cart = Cart::where('uid', auth()->id())->first();
        $cartMenuItem = $cart->cartMenuItems->where('cart_menu_item_id', $request->cartMenuItemId)->first();
        $menuId = $cartMenuItem->menu_id;
        $user = auth()->user();

        if ($cartMenuItem->is_loyalty == 1) {
            $user->update([
                'total_points' => $user->total_points + $cartMenuItem->loyalty_point
            ]);
        }
        $modifier_items = $cart->cartMenuModifierItems->where('cart_id',$cart->cart_id)->where('cart_menu_item_id', $request->cartMenuItemId)->first();
        $modifier_groups = CartMenuGroup::where('cart_id',$cart->cart_id)->where('cart_menu_item_id', $request->cartMenuItemId)->first();

        if (count((is_countable($modifier_groups)?$modifier_groups:[]))) {
            foreach ($modifier_items as $key => $item) {
                $item->delete();
            }

            foreach ($modifier_groups as $key => $group) {
                $group->delete();
            }
        }

        $delete_item = $cartMenuItem->delete();
        $cart = Cart::where('uid', auth()->id())->first();
        count($cart->cartMenuItems) == 0 ? $cart->delete() : '';
        $data = $delete_item ? ['success' => true, 'menu_id' => $menuId] : ['success' => false] ;
        return response()->json($data, 200);
    }

    public function modalForPlusWithModifiers(Request $request)
    {
        $cart = Cart::where('uid', auth()->id())->first();
        $cartMenuItem = $cart->cartMenuItems->where('cart_menu_item_id', $request->cartMenuItemId)->first();
        $data['cart_menu_item_id'] = $request->cartMenuItemId;
        $data['menuItem'] = MenuItem::where('menu_id', $cartMenuItem->menu_id)->first();
        return response()->json(['view' => \View('customer.cart.open_alert', $data)->render()], 200);
    }

    public function addToRepeatLast(Request $request)
    {
        if ($request->ajax()) {
            $cartItems = session()->get('cart', []);
            $menuId = $request->menuId;
            $cartKey = $request->cartKey;

            if (isset($cartItems[$cartKey][$menuId])) {
                $cartItems[$cartKey][$menuId]['quantity']++;
            }

            session()->put('cart', $cartItems);
            return true;
        }
    }

    public function cartCustomize(Request $request)
    {
        if ($request->ajax()) {
            $menuId = $request->menuId;
            $data['menuItem'] = MenuItem::with('modifierList', 'modifierList.modifier_item')->whereHas('modifierList')->where('menu_id', $menuId)->first();
            $cartItems = session()->get('cart', []);
            $cartKey = $request->cartKey;
            if (!empty($cartItems)) {
                // $cartArray = array_column($cartItems[$cartKey],$menuId);
                foreach ($cartItems[$cartKey] as $menuItems) {
                    // foreach($menuItems as $menu)
                    // {
                    if ($menuItems['menu_id'] == $menuId) {
                        $modifierGroupIds = $menuItems['modifier'];
                        $modifierGroupItems = call_user_func_array('array_merge', $menuItems['modifier_item']);
                        // foreach($modifierGroupIds as $key => $modifierGroupId)
                        // {
                        //     $modifierGroupItems = array_column($menuItems['modifier_item'],$modifierGroupId);
                        //     // $modifierGroupItems = $modifieritem;
                        // }
                    }
                    // }
                }
            }
            $data['modifierGroupItems'] = $modifierGroupItems;
            $data['cartKey'] = $request->cartKey;
            return view('customer.cart.customize', $data);
        }
    }

    public function cartCustomizeUpdate(Request $request)
    {
        $cartItems = session()->get('cart', []);
        $menuId = $request->menuId;
        $cartKey = $request->cartKey;
        $modifierGroupIds = array();
        $modifierItemsArray = array();
        foreach ($request->modifierGroupId as $modifierGroupId) {
            if (isset($request->modifierItems[$modifierGroupId])) {
                array_push($modifierGroupIds, $modifierGroupId);
                $modifierItemsArray = $request->modifierItems;
            }
        }

        if (isset($cartItems[$cartKey][$menuId])) {
            $cartItems[$cartKey][$menuId]['modifier'] = $modifierGroupIds;
            $cartItems[$cartKey][$menuId]['modifier_item'] = $modifierItemsArray;
        }

        session()->put('cart', $cartItems);
        return redirect()->back();
    }
}
