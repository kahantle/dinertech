<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\MenuItem;
use App\Models\Promotion;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Stripe\Customer;
use Carbon\Carbon;
use DateTime;
use DateTimeZone;
use App\Traits\PromotionTrait;
use App\Enums\PromotionEnum;
use Config;

class NewPromotionContoller extends Controller
{
    use PromotionTrait;

    public function discountcart(Request $request)
    {
        // if ($request->ajax()) {
        //     $itemPrice = 0;
        //     $uid = Auth::user()->uid;
        //     $restaurant = getRestaurantId();
        //     $restaurantid = Restaurant::where('restaurant_id',$restaurant)->first();

        //     $cartItem = CartItem::where('cart_id',$request->cart_id)->get();
        //     $totalPrice=0;
        //     foreach($cartItem as $list){
        //         $totalPrice=$totalPrice+($list->menu_qty*$list->menu_price) +($list->menu_qty * $list->modifier_total);
        //     }

        //     $discount=0;
        //     $item=0;
        //     $status='';z
        //     $msg='';
        //     if($restaurant != '' && $restaurant != '0')
        //     {
        //         $result = Promotion::select("*",DB::raw("CONCAT(promotions.restricted_days,' ',promotions.restricted_hours) AS publish_date_time"))->where('promotion_code', $request->coupon_code)->where('restaurant_id', getRestaurantId())->first();

        //         $availability=$result->availability;
        //         $couponcode=$request->coupon_code;
        //         if($result->status=='ACTIVE'){
        //             if($availability == 'Always Available')
        //             {
        //                 $promotionfunction=$result->promotion_function;
        //                 if($promotionfunction!='' && $promotionfunction=='Open')
        //                 {
        //                         $customertype=$result->client_type;
        //                     if($customertype!= '' && $customertype=='Any Customer,New or Returning')
        //                     {
        //                             $minimumorder = $result->set_minimum_order_amount;
        //                         if($minimumorder>0){
        //                             if($minimumorder<$totalPrice){
        //                                 $ordertype=$result->order_type;
        //                                 $cash=$result->only_selected_cash;
        //                                 $card=$result->only_selected_cash_delivery_person;
        //                                 if($cash != 0 && $cash== 1)
        //                                 {
        //                                     if($ordertype != '' && $ordertype == 'Pickup Type'){
        //                                             $status="success";
        //                                             $msg="Coupon code applied";
        //                                     }
        //                                     elseif($ordertype != '' && $ordertype == 'Any Type'){
        //                                         $status="success";
        //                                         $msg="Coupon code applied";
        //                                     }
        //                                 }
        //                                 elseif($card != 0 && $card==1)
        //                                 {
        //                                     if($ordertype != '' && $ordertype == 'Pickup Type'){
        //                                         $status="success";
        //                                         $msg="Coupon code applied";
        //                                     }
        //                                     elseif($ordertype != '' && $ordertype == 'Any Type'){
        //                                         $status="success";
        //                                         $msg="Coupon code applied";
        //                                     }
        //                                 }
        //                             }
        //                             else{
        //                                 $status='error';
        //                                 $msg="Cart amount must be less then $minimumorder";
        //                             }
        //                         }
        //                     }
        //                     elseif($customertype!= '' && $customertype =='Only New Customer'){
        //                         $minimumorder = $result->set_minimum_order_amount;
        //                         if($minimumorder>0){
        //                             if($minimumorder<$totalPrice){
        //                                 $ordertype=$result->order_type;
        //                                 $cash=$result->only_selected_cash;
        //                                 $card=$result->only_selected_cash_delivery_person;
        //                                 if($cash != 0 && $cash== 1)
        //                                 {
        //                                     if($ordertype != '' && $ordertype == 'Pickup Type'){
        //                                         $status="success";
        //                                         $msg="Coupon code applied";
        //                                     }
        //                                     elseif($ordertype != '' && $ordertype == 'Any Type'){
        //                                         $status="success";
        //                                         $msg="Coupon code applied";
        //                                     }
        //                                 }
        //                                 elseif($card != 0 && $card==1)
        //                                 {
        //                                     if($ordertype != '' && $ordertype == 'Pickup Type'){
        //                                         $status="success";
        //                                         $msg="Coupon code applied";
        //                                     }
        //                                     elseif($ordertype != '' && $ordertype == 'Any Type'){
        //                                         $status="success";
        //                                         $msg="Coupon code applied";
        //                                     }
        //                                 }
        //                             }
        //                             else{
        //                                 $status='error';
        //                                 $msg="Cart amount must be less then $minimumorder";
        //                             }
        //                         }
        //                     }
        //                     elseif($customertype!= '' && $customertype =='Only Returning Customer'){
        //                         $minimumorder = $result->set_minimum_order_amount;
        //                         if($minimumorder>0){
        //                             if($minimumorder<$totalPrice){
        //                                 $ordertype=$result->order_type;
        //                                 $cash=$result->only_selected_cash;
        //                                 $card=$result->only_selected_cash_delivery_person;
        //                                     if($cash != 0 && $cash== 1)
        //                                     {
        //                                         if($ordertype != '' && $ordertype == 'Pickup Type'){
        //                                             $status="success";
        //                                             $msg="Coupon code applied";
        //                                         }
        //                                         elseif($ordertype != '' && $ordertype == 'Any Type'){
        //                                             $status="success";
        //                                             $msg="Coupon code applied";
        //                                         }
        //                                     }
        //                                     elseif($card != 0 && $card==1)
        //                                     {
        //                                         if($ordertype != '' && $ordertype == 'Pickup Type'){
        //                                             $status="success";
        //                                             $msg="Coupon code applied";
        //                                         }
        //                                         elseif($ordertype != '' && $ordertype == 'Any Type'){
        //                                             $status="success";
        //                                             $msg="Coupon code applied";
        //                                         }
        //                                     }
        //                             }
        //                             else{
        //                                 $status='error';
        //                                 $msg="Cart amount must be less then $minimumorder";
        //                             }
        //                         }
        //                     }
        //                 }
        //                 else{
        //                     $status="error";
        //                     // session()->flash('Prmotion Function Not Found');
        //                 }
        //             }
        //             elseif($availability == 'Restricted')
        //             {
        //                 $restricted_days=$result->restricted_days;
        //                 $currentdate=date('Y-m-d  h:i:s a', time());
        //                 if($restricted_days > $currentdate)
        //                 {
        //                     $promotionfunction=$result->promotion_function;
        //                     if($promotionfunction!='' && $promotionfunction=='Open')
        //                     {
        //                             $customertype=$result->client_type;
        //                         if($customertype!= '' && $customertype=='Any Customer,New or Returning')
        //                         {
        //                                 $minimumorder = $result->set_minimum_order_amount;
        //                             if($minimumorder>0){
        //                                 if($minimumorder < $totalPrice){
        //                                     $ordertype=$result->order_type;
        //                                     $cash=$result->only_selected_cash;
        //                                     $card=$result->only_selected_cash_delivery_person;
        //                                     if($cash != 0 && $cash== 1)
        //                                     {
        //                                         if($ordertype != '' && $ordertype == 'Pickup Type'){
        //                                             $status="success";
        //                                             $msg="Coupon code applied";
        //                                         }
        //                                         elseif($ordertype != '' && $ordertype == 'Any Type'){
        //                                             $status="success";
        //                                             $msg="Coupon code applied";
        //                                         }
        //                                     }
        //                                     elseif($card != 0 && $card==1)
        //                                     {
        //                                         if($ordertype != '' && $ordertype == 'Pickup Type'){
        //                                             $status="success";
        //                                             $msg="Coupon code applied";
        //                                         }
        //                                         elseif($ordertype != '' && $ordertype == 'Any Type'){
        //                                             $status="success";
        //                                             $msg="Coupon code applied";
        //                                         }
        //                                     }
        //                                 }
        //                                 else{
        //                                     $status='error';
        //                                     $msg="Cart amount must be less then $minimumorder";
        //                                 }
        //                             }
        //                         }
        //                         elseif($customertype!= '' && $customertype =='Only New Customer'){
        //                             $minimumorder = $result->set_minimum_order_amount;
        //                             if($minimumorder>0){
        //                                 if($minimumorder<  $totalPrice){
        //                                     $ordertype=$result->order_type;
        //                                     $cash=$result->only_selected_cash;
        //                                     $card=$result->only_selected_cash_delivery_person;
        //                                     if($cash != 0 && $cash== 1)
        //                                     {
        //                                         if($ordertype != '' && $ordertype == 'Pickup Type'){
        //                                             $status="success";
        //                                             $msg="Coupon code applied";
        //                                         }
        //                                         elseif($ordertype != '' && $ordertype == 'Any Type'){
        //                                             $status="success";
        //                                             $msg="Coupon code applied";
        //                                         }
        //                                     }
        //                                     elseif($card != 0 && $card==1)
        //                                     {

        //                                         if($ordertype != '' && $ordertype == 'Pickup Type'){
        //                                             $status="success";
        //                                             $msg="Coupon code applied";
        //                                         }
        //                                         elseif($ordertype != '' && $ordertype == 'Any Type'){
        //                                             $status="success";
        //                                             $msg="Coupon code applied";
        //                                         }
        //                                     }
        //                                 }
        //                                 else{
        //                                     $status='error';
        //                                     $msg="Cart amount must be less then $minimumorder";
        //                                 }
        //                             }
        //                         }
        //                         elseif($customertype!= '' && $customertype =='Only Returning Customer'){
        //                             $minimumorder = $result->set_minimum_order_amount;
        //                             if($minimumorder>0){
        //                                 if($minimumorder < $totalPrice){
        //                                     $ordertype=$result->order_type;
        //                                     $cash=$result->only_selected_cash;
        //                                     $card=$result->only_selected_cash_delivery_person;
        //                                         if($cash != 0 && $cash== 1)
        //                                         {

        //                                             if($ordertype != '' && $ordertype == 'Pickup Type'){
        //                                                 $status="success";
        //                                                 $msg="Coupon code applied";
        //                                             }
        //                                             elseif($ordertype != '' && $ordertype == 'Any Type'){
        //                                                 $status="success";
        //                                                 $msg="Coupon code applied";
        //                                             }
        //                                         }
        //                                         elseif($card != 0 && $card==1)
        //                                         {

        //                                             if($ordertype != '' && $ordertype == 'Pickup Type'){
        //                                                 $status="success";
        //                                                 $msg="Coupon code applied";
        //                                             }
        //                                             elseif($ordertype != '' && $ordertype == 'Any Type'){
        //                                                 $status="success";
        //                                                 $msg="Coupon code applied";
        //                                             }
        //                                         }
        //                                 }
        //                                 else{
        //                                     $status='error';
        //                                     $msg="Cart amount must be less then $minimumorder";
        //                                 }
        //                             }
        //                         }
        //                     }
        //                     else{
        //                         $status="error";
        //                         // session()->flash('Prmotion Function Not Found');
        //                     }
        //                 }
        //                 else
        //                 {
        //                     $status="error";
        //                     $msg="Coupen is Expired";

        //                 }
        //             }

        //             if($status=='success'){
        //                 $discount=$result->discount;
        //                 $discount_type=$result->discount_type;
        //                 if ($discount_type == 'USD') {
        //                     $item=$result->discount;
        //                     $itemPrice = $totalPrice - $discount;
        //                 }else {
        //                     $item = ($totalPrice* $discount) / 100;
        //                     $itemPrice=$totalPrice-$item;
        //                 }

        //                 $taxCharge = number_format(($itemPrice * $restaurantid->sales_tax) / 100,2);
        //                 $totalPayableAmount = number_format($itemPrice + $taxCharge,2);
        //                 Cart::where('uid',$uid)->where('restaurant_id',$restaurant)->where('cart_id',$request->cart_id)->update(['sub_total' => number_format($totalPrice,2),'discount_charge'=>number_format($item,2),'tax_charge' =>number_format($taxCharge,2),'total_due' => number_format($totalPayableAmount,2),'promotion_id'=>$result->promotion_id]);
        //             }
        //         }
        //     }
        // }
        // return response()->json(['msg'=>$msg,'status'=>$status,'couponcode'=> $couponcode,'discount'=>$item,'itemPrice'=>$itemPrice]);

        if ($request->ajax()) {
            /* Get Coupan Code Data */
            $couponCode = $request->coupon_code;
            $cartId = $request->cart_id;

            /* Get User & Restaurant Data */
            $uid = Auth::user()->uid;
            $restaurantId = 1;
            // $restaurantId = getRestaurantId();
            $restaurantInfo = Restaurant::where('restaurant_id',$restaurantId)->first();

            /* Get Cart Item Data */
            $cartItem = CartItem::where('cart_id',$request->cart_id)->get();
            $cartTotal=0;
            foreach($cartItem as $list){
                $cartTotal=$cartTotal+($list->menu_qty*$list->menu_price) +($list->menu_qty * $list->modifier_total);
            }

            /* Check Restaurant Exits Or Not */
            if (!empty($restaurantInfo)) {
                $PromotionInfo = Promotion::select("*",DB::raw("CONCAT(promotions.restricted_days,' ',promotions.restricted_hours) AS publish_date_time"))
                    ->where('promotion_code', $couponCode)
                    ->where('restaurant_id', $restaurantId)
                    ->with('promotion_type')
                    ->first();

                if (!empty($PromotionInfo)) {
                    $promotionType = $PromotionInfo->promotion_type->promotion_name;

                    switch($promotionType){
                        case Config::get('constants.PROMOTION_TYPES.FIRST'):
                            $this->DiscountInCart($PromotionInfo,$cartId);
                            break;

                        case Config::get('constants.PROMOTION_TYPES.TWO'):
                            dd( Config::get('constants.PROMOTION_TYPES.TWO') );
                            break;
                        case Config::get('constants.PROMOTION_TYPES.THREE'):
                            dd( Config::get('constants.PROMOTION_TYPES.THREE') );
                            break;
                        case Config::get('constants.PROMOTION_TYPES.FOUR'):
                            /* Done */
                            $data =  $this->PaymentMethodReward($PromotionInfo,$cartId,$restaurantInfo);
                            return $data;
                            break;
                        case Config::get('constants.PROMOTION_TYPES.FIVE'):
                            $data = $this->GetFreeItem($PromotionInfo,$cartId,$restaurantInfo);
                            dd($data);
                            break;
                        case Config::get('constants.PROMOTION_TYPES.SIX'):
                            $this->BuyOneGetOneFree($PromotionInfo,$cartId,$restaurantInfo);
                            break;
                        case Config::get('constants.PROMOTION_TYPES.SEVEN'):
                            $this->MealBundle($PromotionInfo,$cartId);
                            break;
                        case Config::get('constants.PROMOTION_TYPES.EIGHT'):
                            $this->BuyTwoThreeGetOneFree($PromotionInfo,$cartId);
                            break;
                        case Config::get('constants.PROMOTION_TYPES.NINE'):
                            $this->FixedDiscountAmountCombo($PromotionInfo,$cartId);
                            break;
                        case Config::get('constants.PROMOTION_TYPES.TEN'):
                            $this->DiscountOnComboDeal($PromotionInfo,$cartId);
                            break;
                        default:
                            return false;
                            break;
                    }
                }
            }

        }

    }

    public function remove_coupon_code(Request $request)
    {
        if ($request->ajax()) {
            $restaurant = getRestaurantId();
            $uid=Auth::user()->uid;
            $cart = Cart::where([
                'uid' => $uid ,
                'restaurant_id' => $restaurant,
                'cart_id' => $request->cart_id
            ])->first();
            $result = Promotion::select('promotions.*')->where('promotion_code', $request->coupon_code)->where('restaurant_id', getRestaurantId())->first();
            $restaurantid = Restaurant::where('restaurant_id',$restaurant)->first();
            $cartItem = CartItem::where('cart_id',$request->cart_id)->get();


            $totalPrice=0;
            $totalmodifier=0;
            foreach($cartItem as $list){
                 $totalPrice=$totalPrice+($list->menu_qty*$list->menu_price)+($list->menu_qty*$list->modifier_total);
            }

            //Sales Tax
            $taxCharge = number_format(($totalPrice * $restaurantid->sales_tax) / 100,2);
            $totalPayableAmount = number_format($totalPrice + $taxCharge,2);


            $prmotionid=$cart->promotion_id = 0;
            $dicountcharge=$cart->discount_charge=0.00;

        Cart::where('cart_id',$request->cart_id)->where('uid',$uid)->where('restaurant_id',$restaurant)->update(['sub_total' => number_format($totalPrice,2),'tax_charge' => number_format($taxCharge,2),'discount_charge' => number_format($dicountcharge,2), 'total_due' => number_format($totalPayableAmount,2),'promotion_id' => $prmotionid]);
            $cartItem = Cart::where('restaurant_id',$restaurant)->where('uid',$uid)->first();
            $cartItem->save();
        }
        return response()->json(['status'=>'success','msg'=>'Coupon code removed','sales_tax'=> $taxCharge,'grand_total'=>$totalPayableAmount]);
    }
}
