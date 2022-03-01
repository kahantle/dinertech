<?php
 
namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Promotion;
use App\Models\PromotionCategoryItem;
use App\Models\Order;
use Config;

class PromotionController extends Controller
{
    
    public function getRecords(Request $request)
    {   
        try { 
            $request_data = $request->json()->all();
                $validator = Validator::make($request_data, [ 'restaurant_id' => 'required'
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()], 400);
            }
            if(auth('api')->check()){
                
                // $uid = auth('api')->user()->uid;
                // $orders = Order::where('uid',$uid)->where('restaurant_id',$request->post('restaurant_id'))->get();
                $promotionList = Promotion::where('restaurant_id',$request->post('restaurant_id'))->where('client_type',Config::get('constants.PROMOTION_STATUS.AnyClient'));
                $uid = auth('api')->user()->uid;
                $orders = Order::where('uid',$uid)->where('restaurant_id',$request->post('restaurant_id'))->get();
                if(!empty($orders)){
                    if($orders->count() > 1){
                        $promotionList = $promotionList->OrWhere('client_type',Config::get('constants.PROMOTION_STATUS.OneOrder'));
                    }
                    elseif($orders->count() == 0){
                        $promotionList = $promotionList->OrWhere('client_type',Config::get('constants.PROMOTION_STATUS.NewClient'));
                    }
                }
                $promotionList = $promotionList->get(['promotion_id','promotion_type_id','restaurant_id','promotion_code','promotion_name','promotion_details','discount','discount_type','client_type','order_type','selected_payment_status','mark_promoas_status','display_time','promotion_status','minimum_order_status','set_minimum_order_amount','created_at','no_extra_charge_type','discount_expensive','discount_cheapest','only_once_per_client']);
            }else{
                $promotionList = Promotion::where('restaurant_id',$request->post('restaurant_id'))->get(['promotion_id','promotion_type_id','restaurant_id','promotion_code','promotion_name','promotion_details','discount','discount_type','client_type','order_type','selected_payment_status','mark_promoas_status','display_time','promotion_status','minimum_order_status','set_minimum_order_amount','created_at','no_extra_charge_type','discount_expensive','discount_cheapest','only_once_per_client']);
            }
            foreach ($promotionList as $promotionKey => $promotion) {
                $result[$promotionKey] = $promotion;
                $promotionCategoryItems = PromotionCategoryItem::where('promotion_category_items.promotion_id',$promotion->promotion_id)
                                        ->with('category_item')
                                        ->get();
                foreach($promotionCategoryItems as $key => $value){
                    foreach ($value->category_item as $key1 => $value1) {
                        $result[$promotionKey]['eligible_items'][] = $value1;
                    }
                }
            }
            // $promotionList = Promotion::where('restaurant_id', $request->post('restaurant_id'))
            //     ->with('promotion_item')
            //     ->get();
            return response()->json(['promotion_list' => $promotionList, 'success' => true], 200);
        } catch (\Throwable $th) {
            $errors['success'] = false;
            $errors['message'] = Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS');
            if ($request->debug_mode == 'ON') {
                $errors['debug'] = $th->getMessage();
            }
            return response()->json($errors, 500);
        }
    }

    public function getItems(Request $request)
    {
        try {
            $request_data = $request->json()->all();
            $validator = Validator::make($request_data, 
                [ 
                    'restaurant_id' => 'required',
                    'promotion_id'  => 'required'
                ]
            );

            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()], 400);
            }
            $promotionId = $request->post('promotion_id');
            $getItems = PromotionCategoryItem::where('promotion_id',$promotionId)
                                        ->with('category_item')
                                        ->get();
            $result = [];
            foreach($getItems as $key => $value)
            {
                foreach ($value->category_item as $key1 => $value1) {
                    $result[] = $value1;
                }
            }
            return response()->json(['promotion_items' => $result, 'success' => true], 200);
        } catch (\Throwable $th) {
            $errors['success'] = false;
            $errors['message'] = Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS');
            if ($request->debug_mode == 'ON') {
                $errors['debug'] = $th->getMessage();
            }
            return response()->json($errors, 500);            
        }
    }
}
