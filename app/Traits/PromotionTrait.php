<?php

namespace App\Traits;

use Illuminate\Http\Request;
use App\Enums\PromotionEnum;
use App\Traits\PromotionLogicTrait;
use App\Models\Cart;
use Auth;

trait PromotionTrait {

    use PromotionLogicTrait;

    /**
     * @param Request $request
     * @return $this|false|string
     */
    /* Discount In Cart Promotion Logic*/
    public function DiscountInCart($PromotionInfo,$cartId) {
        /* Promotion Logic One */
        dd($PromotionInfo);
    }

    /* Discount On Selected Items Promotion Logic*/
    public function DiscountOnSelectedItems($PromotionInfo) {
        dd($PromotionInfo);
    }

    /* Free Delivery Promotion Logic*/
    public function FreeDelivery($PromotionInfo) {
        dd($PromotionInfo);
    }

    /* Payment Method Reward Promotion Logic*/
    public function PaymentMethodReward($PromotionInfo,$cartId,$restaurantInfo) {
        
        $logicOne = $this->PromotionCommanLogicOne($PromotionInfo,$cartId);

        $cartInfo = Cart::where('cart_id', $cartId)->first();
        $cartSubTotal = $cartInfo->sub_total;

        $minOrder = $PromotionInfo->set_minimum_order == 1 ? true : false;
        $minOrderAmount = $PromotionInfo->set_minimum_order_amount;

        $uid = Auth::user()->uid;

        if ($logicOne['type']) {

            if ($minOrder) {
                if($minOrderAmount < $cartSubTotal) {

                    $discount = $PromotionInfo->discount;
                    $discount_type = $PromotionInfo->discount_type;
                    if ($discount_type == 'USD') {
                        $item = $PromotionInfo->discount;
                        $dynamicSubTotal = $cartSubTotal - $discount;
                    }else {
                        $item = ($cartSubTotal* $discount) / 100;
                        $dynamicSubTotal = $cartSubTotal-$item;
                    }
                    
                    $taxCharge = number_format(($dynamicSubTotal * $restaurantInfo->sales_tax) / 100,2);
                    $totalPayableAmount = number_format($dynamicSubTotal + $taxCharge,2);
                    Cart::where('uid',$uid)->where('restaurant_id',$restaurantInfo->restaurant_id)
                    ->where('cart_id',$cartId)
                    ->update(['sub_total' => number_format($dynamicSubTotal,2),
                    'discount_charge'=>number_format($item,2),
                    'tax_charge' =>number_format($taxCharge,2),
                    'total_due' => number_format($totalPayableAmount,2),
                    'promotion_id'=>$PromotionInfo->promotion_id
                    ]);
                    
                    return response()->json(['msg'=>'Coupan Apply Successfully','status'=>true,'couponcode'=> $PromotionInfo->promotion_code,'discount'=>$item,'itemPrice'=>$dynamicSubTotal, 'promotionId'=>$PromotionInfo->promotion_id]);

                } else {
                    $data = [
                        'type' => false,
                        'message' => 'Valid for minimum order value $'.$minOrderAmount
                    ];
                    return $data;
                }
            }
        } else {
            return $logicOne;
        }
    }

    /* Get Free Item Promotion Logic*/
    public function GetFreeItem($PromotionInfo,$cartId) {

        $logicOne = $this->PromotionCommanLogicOne($PromotionInfo,$cartId);
        dd($logicOne);
    }

    /* Buy One Get One Free Promotion Logic*/
    public function BuyOneGetOneFree($PromotionInfo,$cartId) {

        $logicOne = $this->PromotionCommanLogicOne($PromotionInfo,$cartId);
        dd($logicOne);
    }

    /* Meal Bundle Promotion Logic*/
    public function MealBundle($PromotionInfo,$cartId) {

        $logicOne = $this->PromotionCommanLogicOne($PromotionInfo,$cartId);
        dd($logicOne);
    }

    /* Buy Two Three Get One Free Promotion Logic*/
    public function BuyTwoThreeGetOneFree($PromotionInfo,$cartId) {

        $logicOne = $this->PromotionCommanLogicOne($PromotionInfo,$cartId);
        dd($logicOne);
    }

    /* Fixed Discount Amount Combo Promotion Logic*/
    public function FixedDiscountAmountCombo($PromotionInfo,$cartId) {

        $logicOne = $this->PromotionCommanLogicOne($PromotionInfo,$cartId);
        dd($logicOne);
    }

    /* Discount On Combo Deal Promotion Logic*/
    public function DiscountOnComboDeal($PromotionInfo,$cartId) {

        $logicOne = $this->PromotionCommanLogicOne($PromotionInfo,$cartId);
        dd($logicOne);
    }
}
