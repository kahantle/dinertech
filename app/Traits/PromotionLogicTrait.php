<?php

namespace App\Traits;

use Illuminate\Http\Request;
use App\Enums\PromotionEnum;
use Auth;
use App\Models\User;
use App\Models\Order;
use App\Models\Cart;

trait PromotionLogicTrait {

    /**
    * @param Request $request
    * @return $this|false|string
    */

    /* Promotion Logic One */
    public function PromotionCommanLogicOne($PromotionInfo,$cartId) {

        $uid = Auth::user()->uid;
        $userInfo = User::where('uid', $uid)->first();
        
        $availabilityType = $PromotionInfo->availability;
        $clientType = $PromotionInfo->client_type;
        $cash = $PromotionInfo->only_selected_cash;
        $card = $PromotionInfo->only_selected_cash_delivery_person;
        $ordertype = $PromotionInfo->order_type;

        /* Get Old Order Info */
        $firstUser = Order::where('uid', $uid)->exists();
        $returnCustomer = Order::where('uid', $uid)->count();
        
        /* Get Cart Info */
        $cartInfo = Cart::where('cart_id', $cartId)->first();
        $customerPayment = $cartInfo->is_payment;
        $customerOrderType = $cartInfo->order_type;
        $checkOrder = Order::where('uid', $uid)->where('promotion_id', $PromotionInfo->promotion_id)->first();
        
        if (!$checkOrder) {
            /* Promotion Availability */
            if ($availabilityType === PromotionEnum::ALWAYSAVAILABLE) {

                /* Promotion Customer Type */
                if($clientType === PromotionEnum::ANYCUSTOMER){

                    /* Promotion Payment Type */
                    if ($cash === PromotionEnum::ONE && $customerPayment === PromotionEnum::CASE){

                        if ($ordertype ===  PromotionEnum::PICKUP && $customerOrderType === PromotionEnum::PICKUPTIME){
                            $data = [
                                'type' => true,
                                'message' => 'Coupan Matched'
                            ];
                            return $data;
                        } elseif ($ordertype ===  PromotionEnum::ANY && $customerOrderType === PromotionEnum::ANY){
                            $data = [
                                'type' => true,
                                'message' => 'Coupan Matched'
                            ];
                            return $data;
                        } else {
                            $data = [
                                'type' => false,
                                'message' => 'valid Order Type '.'('.$ordertype.')'
                            ];
                            return $data;
                        }

                    } elseif($card === PromotionEnum::ONE && $customerPayment === PromotionEnum::CARD){
                        if ($ordertype ===  PromotionEnum::PICKUP && $customerOrderType === PromotionEnum::PICKUPTIME){
                            $data = [
                                'type' => true,
                                'msg' => 'Coupan Matched'
                            ];
                            return $data;
                        } elseif ($ordertype ===  PromotionEnum::ANY && $customerOrderType === PromotionEnum::ANY){
                            $data = [
                                'type' => true,
                                'msg' => 'Coupan Matched'
                            ];
                            return $data;
                        } else {
                            $data = [
                                'type' => false,
                                'msg' => 'valid Order Type '.'('.$ordertype.')'
                            ];
                            return $data;
                        }
                    } else {
                        $data = [
                            'type' => false,
                            'msg' => 'Invalid Payment Method'
                        ];
                        return $data;
                    }

                } elseif ($clientType === PromotionEnum::NEWCUSTOMER && !$firstUser){

                    /* Promotion Payment Type */
                    if ($cash === PromotionEnum::ONE && $customerPayment === PromotionEnum::CASE){

                        if ($ordertype ===  PromotionEnum::PICKUP && $customerOrderType === PromotionEnum::PICKUPTIME){
                            $data = [
                                'type' => true,
                                'message' => 'Coupan Matched'
                            ];
                            return $data;
                        } elseif ($ordertype ===  PromotionEnum::ANY && $customerOrderType === PromotionEnum::ANY){
                            $data = [
                                'type' => true,
                                'message' => 'Coupan Matched'
                            ];
                            return $data;
                        } else {
                            $data = [
                                'type' => false,
                                'message' => 'valid Order Type '.'('.$ordertype.')'
                            ];
                            dd($data);
                            return $data;
                        }

                    } elseif($card === PromotionEnum::ONE && $customerPayment === PromotionEnum::CARD){
                        if ($ordertype ===  PromotionEnum::PICKUP && $customerOrderType === PromotionEnum::PICKUPTIME){
                            $data = [
                                'type' => true,
                                'message' => 'Coupan Matched'
                            ];
                            return $data;
                        } elseif ($ordertype ===  PromotionEnum::ANY && $customerOrderType === PromotionEnum::ANY){
                            $data = [
                                'type' => true,
                                'message' => 'Coupan Matched'
                            ];
                            return $data;
                        } else {
                            $data = [
                                'type' => false,
                                'message' => 'valid Order Type '.'('.$ordertype.')'
                            ];
                            return $data;
                        }
                    } else {
                        $data = [
                            'type' => false,
                            'message' => 'Invalid Payment Method'
                        ];
                        return $data;
                    }

                } elseif ($clientType === PromotionEnum::RETURNCUSTOMER && $returnCustomer != 0){

                    /* Promotion Payment Type */
                    if ($cash === PromotionEnum::ONE && $customerPayment === PromotionEnum::CASE){

                        if ($ordertype ===  PromotionEnum::PICKUP && $customerOrderType === PromotionEnum::PICKUPTIME){
                            $data = [
                                'type' => true,
                                'message' => 'Coupan Matched'
                            ];
                            return $data;
                        } elseif ($ordertype ===  PromotionEnum::ANY && $customerOrderType === PromotionEnum::ANY){
                            $data = [
                                'type' => true,
                                'message' => 'Coupan Matched'
                            ];
                            return $data;
                        } else {
                            $data = [
                                'type' => false,
                                'message' => 'valid Order Type '.'('.$ordertype.')'
                            ];
                            dd($data);
                            return $data;
                        }

                    } elseif($card === PromotionEnum::ONE && $customerPayment === PromotionEnum::CARD){
                        if ($ordertype ===  PromotionEnum::PICKUP && $customerOrderType === PromotionEnum::PICKUPTIME){
                            $data = [
                                'type' => true,
                                'message' => 'Coupan Matched'
                            ];
                            return $data;
                        } elseif ($ordertype ===  PromotionEnum::ANY && $customerOrderType === PromotionEnum::ANY){
                            $data = [
                                'type' => true,
                                'message' => 'Coupan Matched'
                            ];
                            return $data;
                        } else {
                            $data = [
                                'type' => false,
                                'message' => 'valid Order Type '.'('.$ordertype.')'
                            ];
                            return $data;
                        }
                    } else {
                        $data = [
                            'type' => false,
                            'message' => 'Invalid Payment Method'
                        ];
                        return $data;
                    }

                } else {
                    $data = [
                        'type' => false,
                        'message' => 'valid for '.$clientType
                    ];
                    return $data;
                }

            } elseif ($availabilityType === PromotionEnum::RESTRICTED) {

                /* Promotion Customer Type */
                if($clientType === PromotionEnum::ANYCUSTOMER){

                    /* Promotion Payment Type */
                    if ($cash === PromotionEnum::ONE && $customerPayment === PromotionEnum::CASE){

                        if ($ordertype ===  PromotionEnum::PICKUP && $customerOrderType === PromotionEnum::PICKUPTIME){
                            $data = [
                                'type' => true,
                                'message' => 'Coupan Matched'
                            ];
                            return $data;
                        } elseif ($ordertype ===  PromotionEnum::ANY && $customerOrderType === PromotionEnum::ANY){
                            $data = [
                                'type' => true,
                                'message' => 'Coupan Matched'
                            ];
                            return $data;
                        } else {
                            $data = [
                                'type' => false,
                                'message' => 'valid Order Type '.'('.$ordertype.')'
                            ];
                            return $data;
                        }

                    } elseif($card === PromotionEnum::ONE && $customerPayment === PromotionEnum::CARD){
                        if ($ordertype ===  PromotionEnum::PICKUP && $customerOrderType === PromotionEnum::PICKUPTIME){
                            $data = [
                                'type' => true,
                                'message' => 'Coupan Matched'
                            ];
                            return $data;
                        } elseif ($ordertype ===  PromotionEnum::ANY && $customerOrderType === PromotionEnum::ANY){
                            $data = [
                                'type' => true,
                                'message' => 'Coupan Matched'
                            ];
                            return $data;
                        } else {
                            $data = [
                                'type' => false,
                                'message' => 'valid Order Type '.'('.$ordertype.')'
                            ];
                            return $data;
                        }
                    } else {
                        $data = [
                            'type' => false,
                            'message' => 'Invalid Payment Method'
                        ];
                        return $data;
                    }

                } elseif ($clientType === PromotionEnum::NEWCUSTOMER && !$firstUser){

                    /* Promotion Payment Type */
                    if ($cash === PromotionEnum::ONE && $customerPayment === PromotionEnum::CASE){

                        if ($ordertype ===  PromotionEnum::PICKUP && $customerOrderType === PromotionEnum::PICKUPTIME){
                            $data = [
                                'type' => true,
                                'message' => 'Coupan Matched'
                            ];
                            return $data;
                        } elseif ($ordertype ===  PromotionEnum::ANY && $customerOrderType === PromotionEnum::ANY){
                            $data = [
                                'type' => true,
                                'message' => 'Coupan Matched'
                            ];
                            return $data;
                        } else {
                            $data = [
                                'type' => false,
                                'message' => 'valid Order Type '.'('.$ordertype.')'
                            ];
                            return $data;
                        }

                    } elseif($card === PromotionEnum::ONE && $customerPayment === PromotionEnum::CARD){
                        if ($ordertype ===  PromotionEnum::PICKUP && $customerOrderType === PromotionEnum::PICKUPTIME){
                            $data = [
                                'type' => true,
                                'message' => 'Coupan Matched'
                            ];
                            return $data;
                        } elseif ($ordertype ===  PromotionEnum::ANY && $customerOrderType === PromotionEnum::ANY){
                            $data = [
                                'type' => true,
                                'message' => 'Coupan Matched'
                            ];
                            return $data;
                        } else {
                            $data = [
                                'type' => false,
                                'message' => 'valid Order Type '.'('.$ordertype.')'
                            ];
                            return $data;
                        }
                    } else {
                        $data = [
                            'type' => false,
                            'message' => 'Invalid Payment Method'
                        ];
                        return $data;
                    }

                } elseif ($clientType === PromotionEnum::RETURNCUSTOMER && $returnCustomer != 0){

                    /* Promotion Payment Type */
                    if ($cash === PromotionEnum::ONE && $customerPayment === PromotionEnum::CASE){

                        if ($ordertype ===  PromotionEnum::PICKUP && $customerOrderType === PromotionEnum::PICKUPTIME){
                            $data = [
                                'type' => true,
                                'message' => 'Coupan Matched'
                            ];
                            return $data;
                        } elseif ($ordertype ===  PromotionEnum::ANY && $customerOrderType === PromotionEnum::ANY){
                            $data = [
                                'type' => true,
                                'message' => 'Coupan Matched'
                            ];
                            return $data;
                        } else {
                            $data = [
                                'type' => false,
                                'message' => 'valid Order Type '.'('.$ordertype.')'
                            ];
                            dd($data);
                            return $data;
                        }

                    } elseif($card === PromotionEnum::ONE && $customerPayment === PromotionEnum::CARD){
                        if ($ordertype ===  PromotionEnum::PICKUP && $customerOrderType === PromotionEnum::PICKUPTIME){
                            $data = [
                                'type' => true,
                                'message' => 'Coupan Matched'
                            ];
                            return $data;
                        } elseif ($ordertype ===  PromotionEnum::ANY && $customerOrderType === PromotionEnum::ANY){
                            $data = [
                                'type' => true,
                                'message' => 'Coupan Matched'
                            ];
                            return $data;
                        } else {
                            $data = [
                                'type' => false,
                                'message' => 'valid Order Type '.'('.$ordertype.')'
                            ];
                            return $data;
                        }
                    } else {
                        $data = [
                            'type' => false,
                            'message' => 'Invalid Payment Method'
                        ];
                        return $data;
                    }

                } else {
                    $data = [
                        'type' => false,
                        'message' => 'valid for '.$clientType
                    ];
                    return $data;
                }

            } elseif ($availabilityType === PromotionEnum::HIDDEN) {
                $data = [
                    'type' => false,
                    'message' => 'Availability Hidden(Under Discusse)'
                ];
                return $data;
            } else {
                $data = [
                    'type' => false,
                    'message' => 'Coupon code is not valid'
                ];
                return $data;
            }
        } else {
            $data = [
                'type' => false,
                'msg' => 'Coupon has already been used'
            ];
            return $data;
        }
    }



}
