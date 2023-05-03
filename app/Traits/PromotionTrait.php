<?php

namespace App\Traits;

use Illuminate\Http\Request;
use App\Enums\PromotionEnum;
use App\Traits\PromotionLogicTrait;
use App\Models\Cart;
use App\Models\PromotionCategory;
use App\Models\PromotionCategoryItem;
use App\Models\CartItem;
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
                        'msg' => 'Valid for minimum order value $'.$minOrderAmount
                    ];
                    return $data;
                }
            }
        } else {
            return $logicOne;
        }
    }

    /* Get Free Item Promotion Logic*/
    public function GetFreeItem($PromotionInfo,$cartId,$restaurantInfo) {
        $logicOne = $this->PromotionCommanLogicOne($PromotionInfo,$cartId);

        $uid = Auth::user()->uid;
        $cartInfo = Cart::where('cart_id', $cartId)->first();
        $cartMenuItems = CartItem::where('cart_id', $cartId)->pluck('menu_id');
        $cartSubTotal = $cartInfo->sub_total;

        $minOrder = $PromotionInfo->set_minimum_order == 1 ? true : false;
        $minOrderAmount = $PromotionInfo->set_minimum_order_amount;

        $promotionCategory = PromotionCategory::where('promotion_id', $PromotionInfo->promotion_id)->pluck('category_id');
        $promotionCategoryItems = PromotionCategoryItem::where('promotion_id', $PromotionInfo->promotion_id)->pluck('item_id')->toArray();

        $eligibleItem = false;
        foreach ($cartMenuItems as $itemId) {
            if (in_array($itemId, $promotionCategoryItems)) {
                $eligibleItem = true;
            };
        }

        if ($logicOne['type']) {
            if ($minOrder) {
                if($eligibleItem) {
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
                            'msg' => 'Valid for minimum order value $'.$minOrderAmount
                        ];
                        return $data;
                    }
                } else {
                    $data = [
                        'type' => false,
                        'msg' => 'Cart items not eligible.'
                    ];
                    return $data;
                }
            }
        } else {
            return $logicOne;
        }
    }

    /* Buy One Get One Free Promotion Logic*/
    public function BuyOneGetOneFree($PromotionInfo,$cartId,$restaurantInfo) {
        $logicOne = $this->PromotionCommanLogicOne($PromotionInfo,$cartId);

        $uid = Auth::user()->uid;
        $cartInfo = Cart::where('cart_id', $cartId)->first();
        $cartMenuItems = CartItem::where('cart_id', $cartId)->pluck('menu_id');
        $cartSubTotal = $cartInfo->sub_total;

        $minOrder = $PromotionInfo->set_minimum_order == 1 ? true : false;
        $minOrderAmount = $PromotionInfo->set_minimum_order_amount;

        $promotionCategory = PromotionCategory::where('promotion_id', $PromotionInfo->promotion_id)->pluck('category_id');
        $promotionCategoryItems = PromotionCategoryItem::where('promotion_id', $PromotionInfo->promotion_id)->pluck('item_id')->toArray();

        $eligibleItem = false;
        foreach ($cartMenuItems as $itemId) {
            if (in_array($itemId, $promotionCategoryItems)) {
                $eligibleItem = true;
            };
        }

        if ($logicOne['type']) {
            if($eligibleItem) {
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
                        'msg' => 'Valid for minimum order value $'.$minOrderAmount
                    ];
                    return $data;
                }
            } else {
                $data = [
                    'type' => false,
                    'msg' => 'Cart items not eligible.'
                ];
                return $data;
            }
        } else {
            return $logicOne;
        }
    }

    /* Meal Bundle Promotion Logic*/
    public function MealBundle($PromotionInfo,$cartId,$restaurantInfo) {
        /* Working Here */
        $logicOne = $this->PromotionCommanLogicOne($PromotionInfo,$cartId);

        $uid = Auth::user()->uid;
        $cartInfo = Cart::where('cart_id', $cartId)->first();
        $cartMenuItems = CartItem::where('cart_id', $cartId)->pluck('menu_id');
        $cartSubTotal = $cartInfo->sub_total;

        $minOrder = $PromotionInfo->set_minimum_order == 1 ? true : false;
        $minOrderAmount = $PromotionInfo->set_minimum_order_amount;

        $promotionCategory = PromotionCategory::where('promotion_id', $PromotionInfo->promotion_id)->pluck('category_id');
        $promotionCategoryItems = PromotionCategoryItem::where('promotion_id', $PromotionInfo->promotion_id)->pluck('item_id')->toArray();

        $eligibleItem = false;
        foreach ($cartMenuItems as $itemId) {
            if (in_array($itemId, $promotionCategoryItems)) {
                $eligibleItem = true;
            };
        }

        if ($logicOne['type']) {
            if($eligibleItem) {
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
                        'msg' => 'Valid for minimum order value $'.$minOrderAmount
                    ];
                    return $data;
                }
            } else {
                $data = [
                    'type' => false,
                    'msg' => 'Cart items not eligible.'
                ];
                return $data;
            }
        } else {
            return $logicOne;
        }
    }

    /* Buy Two Three Get One Free Promotion Logic*/
    public function BuyTwoThreeGetOneFree($PromotionInfo,$cartId) {

        $logicOne = $this->PromotionCommanLogicOne($PromotionInfo,$cartId);
        dd($logicOne, 'Data test');
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
