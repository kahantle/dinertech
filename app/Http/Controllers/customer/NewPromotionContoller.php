<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
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

class NewPromotionContoller extends Controller
{
    public function discountcart(Request $request)
    {
        if ($request->ajax()) {
            $itemPrice = 0;
            $uid = Auth::user()->uid;
            $restaurant = getRestaurantId();
            $restaurantid = Restaurant::where('restaurant_id',$restaurant)->first();


            $cartItem = CartItem::where('cart_id',$request->cart_id)->get();
            $totalPrice=0;
            foreach($cartItem as $list){
                $totalPrice=$totalPrice+($list->menu_qty*$list->menu_price) +($list->menu_qty * $list->modifier_total);
            }

            $discount=0;
            $item=0;
            $status='';
            $msg='';
            if($restaurant != '' && $restaurant != '0')
            {
                $result = Promotion::select("*",DB::raw("CONCAT(promotions.restricted_days,' ',promotions.restricted_hours) AS publish_date_time"))->where('promotion_code', $request->coupon_code)->where('restaurant_id', getRestaurantId())->first();

                $availability=$result->availability;
                $couponcode=$request->coupon_code;
                if($result->status=='ACTIVE'){
                    if($availability == 'Always Available')
                    {
                        $promotionfunction=$result->promotion_function;
                        if($promotionfunction!='' && $promotionfunction=='Open')
                        {
                                $customertype=$result->client_type;
                            if($customertype!= '' && $customertype=='Any Customer,New or Returning')
                            {
                                    $minimumorder = $result->set_minimum_order_amount;
                                if($minimumorder>0){
                                    if($minimumorder<$totalPrice){
                                        $ordertype=$result->order_type;
                                        $cash=$result->only_selected_cash;
                                        $card=$result->only_selected_cash_delivery_person;
                                        if($cash != 0 && $cash== 1)
                                        {
                                            if($ordertype != '' && $ordertype == 'Pickup Type'){
                                                    $status="success";
                                                    $msg="Coupon code applied";
                                            }
                                            elseif($ordertype != '' && $ordertype == 'Any Type'){
                                                $status="success";
                                                $msg="Coupon code applied";
                                            }
                                        }
                                        elseif($card != 0 && $card==1)
                                        {
                                            if($ordertype != '' && $ordertype == 'Pickup Type'){
                                                $status="success";
                                                $msg="Coupon code applied";
                                            }
                                            elseif($ordertype != '' && $ordertype == 'Any Type'){
                                                $status="success";
                                                $msg="Coupon code applied";
                                            }
                                        }
                                    }
                                    else{
                                        $status='error';
                                        $msg="Cart amount must be less then $minimumorder";
                                    }
                                }
                            }
                            elseif($customertype!= '' && $customertype =='Only New Customer'){
                                $minimumorder = $result->set_minimum_order_amount;
                                if($minimumorder>0){
                                    if($minimumorder<$totalPrice){
                                        $ordertype=$result->order_type;
                                        $cash=$result->only_selected_cash;
                                        $card=$result->only_selected_cash_delivery_person;
                                        if($cash != 0 && $cash== 1)
                                        {
                                            if($ordertype != '' && $ordertype == 'Pickup Type'){
                                                $status="success";
                                                $msg="Coupon code applied";
                                            }
                                            elseif($ordertype != '' && $ordertype == 'Any Type'){
                                                $status="success";
                                                $msg="Coupon code applied";
                                            }
                                        }
                                        elseif($card != 0 && $card==1)
                                        {
                                            if($ordertype != '' && $ordertype == 'Pickup Type'){
                                                $status="success";
                                                $msg="Coupon code applied";
                                            }
                                            elseif($ordertype != '' && $ordertype == 'Any Type'){
                                                $status="success";
                                                $msg="Coupon code applied";
                                            }
                                        }
                                    }
                                    else{
                                        $status='error';
                                        $msg="Cart amount must be less then $minimumorder";
                                    }
                                }
                            }
                            elseif($customertype!= '' && $customertype =='Only Returning Customer'){
                                $minimumorder = $result->set_minimum_order_amount;
                                if($minimumorder>0){
                                    if($minimumorder<$totalPrice){
                                        $ordertype=$result->order_type;
                                        $cash=$result->only_selected_cash;
                                        $card=$result->only_selected_cash_delivery_person;
                                            if($cash != 0 && $cash== 1)
                                            {
                                                if($ordertype != '' && $ordertype == 'Pickup Type'){
                                                    $status="success";
                                                    $msg="Coupon code applied";
                                                }
                                                elseif($ordertype != '' && $ordertype == 'Any Type'){
                                                    $status="success";
                                                    $msg="Coupon code applied";
                                                }
                                            }
                                            elseif($card != 0 && $card==1)
                                            {
                                                if($ordertype != '' && $ordertype == 'Pickup Type'){
                                                    $status="success";
                                                    $msg="Coupon code applied";
                                                }
                                                elseif($ordertype != '' && $ordertype == 'Any Type'){
                                                    $status="success";
                                                    $msg="Coupon code applied";
                                                }
                                            }
                                    }
                                    else{
                                        $status='error';
                                        $msg="Cart amount must be less then $minimumorder";
                                    }
                                }
                            }
                        }
                        else{
                            $status="error";
                            // session()->flash('Prmotion Function Not Found');
                        }
                    }
                    elseif($availability == 'Restricted')
                    {
                        $restricted_days=$result->restricted_days;
                        $currentdate=date('Y-m-d  h:i:s a', time());
                        if($restricted_days > $currentdate)
                        {
                            $promotionfunction=$result->promotion_function;
                            if($promotionfunction!='' && $promotionfunction=='Open')
                            {
                                    $customertype=$result->client_type;
                                if($customertype!= '' && $customertype=='Any Customer,New or Returning')
                                {
                                        $minimumorder = $result->set_minimum_order_amount;
                                    if($minimumorder>0){
                                        if($minimumorder < $totalPrice){
                                            $ordertype=$result->order_type;
                                            $cash=$result->only_selected_cash;
                                            $card=$result->only_selected_cash_delivery_person;
                                            if($cash != 0 && $cash== 1)
                                            {
                                                if($ordertype != '' && $ordertype == 'Pickup Type'){
                                                    $status="success";
                                                    $msg="Coupon code applied";
                                                }
                                                elseif($ordertype != '' && $ordertype == 'Any Type'){
                                                    $status="success";
                                                    $msg="Coupon code applied";
                                                }
                                            }
                                            elseif($card != 0 && $card==1)
                                            {
                                                if($ordertype != '' && $ordertype == 'Pickup Type'){
                                                    $status="success";
                                                    $msg="Coupon code applied";
                                                }
                                                elseif($ordertype != '' && $ordertype == 'Any Type'){
                                                    $status="success";
                                                    $msg="Coupon code applied";
                                                }
                                            }
                                        }
                                        else{
                                            $status='error';
                                            $msg="Cart amount must be less then $minimumorder";
                                        }
                                    }
                                }
                                elseif($customertype!= '' && $customertype =='Only New Customer'){
                                    $minimumorder = $result->set_minimum_order_amount;
                                    if($minimumorder>0){
                                        if($minimumorder<  $totalPrice){
                                            $ordertype=$result->order_type;
                                            $cash=$result->only_selected_cash;
                                            $card=$result->only_selected_cash_delivery_person;
                                            if($cash != 0 && $cash== 1)
                                            {
                                                if($ordertype != '' && $ordertype == 'Pickup Type'){
                                                    $status="success";
                                                    $msg="Coupon code applied";
                                                }
                                                elseif($ordertype != '' && $ordertype == 'Any Type'){
                                                    $status="success";
                                                    $msg="Coupon code applied";
                                                }
                                            }
                                            elseif($card != 0 && $card==1)
                                            {

                                                if($ordertype != '' && $ordertype == 'Pickup Type'){
                                                    $status="success";
                                                    $msg="Coupon code applied";
                                                }
                                                elseif($ordertype != '' && $ordertype == 'Any Type'){
                                                    $status="success";
                                                    $msg="Coupon code applied";
                                                }
                                            }
                                        }
                                        else{
                                            $status='error';
                                            $msg="Cart amount must be less then $minimumorder";
                                        }
                                    }
                                }
                                elseif($customertype!= '' && $customertype =='Only Returning Customer'){
                                    $minimumorder = $result->set_minimum_order_amount;
                                    if($minimumorder>0){
                                        if($minimumorder < $totalPrice){
                                            $ordertype=$result->order_type;
                                            $cash=$result->only_selected_cash;
                                            $card=$result->only_selected_cash_delivery_person;
                                                if($cash != 0 && $cash== 1)
                                                {

                                                    if($ordertype != '' && $ordertype == 'Pickup Type'){
                                                        $status="success";
                                                        $msg="Coupon code applied";
                                                    }
                                                    elseif($ordertype != '' && $ordertype == 'Any Type'){
                                                        $status="success";
                                                        $msg="Coupon code applied";
                                                    }
                                                }
                                                elseif($card != 0 && $card==1)
                                                {

                                                    if($ordertype != '' && $ordertype == 'Pickup Type'){
                                                        $status="success";
                                                        $msg="Coupon code applied";
                                                    }
                                                    elseif($ordertype != '' && $ordertype == 'Any Type'){
                                                        $status="success";
                                                        $msg="Coupon code applied";
                                                    }
                                                }
                                        }
                                        else{
                                            $status='error';
                                            $msg="Cart amount must be less then $minimumorder";
                                        }
                                    }
                                }
                            }
                            else{
                                $status="error";
                                // session()->flash('Prmotion Function Not Found');
                            }
                        }
                        else
                        {
                            $status="error";
                            $msg="Coupen is Expired";

                    }
                }

                if($status=='success'){
                    $discount=$result->discount;
                    $discount_type=$result->discount_type;
                    if ($discount_type == 'USD') {
                        $item=$result->discount;
                        $itemPrice = $totalPrice - $discount;
                    }else {
                        $item = ($totalPrice* $discount) / 100;
                        $itemPrice=$totalPrice-$item;
                    }
                }
            }
        }

     }
     return response()->json(['msg'=>$msg,'status'=>$status,'couponcode'=> $couponcode,'discount'=>$item,'itemPrice'=>$itemPrice]);

    }
    public function remove_coupon_code(Request $request)
    {
        if ($request->ajax()) {
            $result = Promotion::select('promotions.*')->where('promotion_code', $request->coupon_code)->where('restaurant_id', getRestaurantId())->first();
            $grand_total=$request->grand_total;
        }
        return response()->json(['status'=>'success','msg'=>'Coupon code removed','grand_total'=>$grand_total]);
    }
}
