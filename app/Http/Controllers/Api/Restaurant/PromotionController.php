<?php
 
namespace App\Http\Controllers\Api\Restaurant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Category;
use App\Models\MenuItem;
use App\Models\PromotionType;
use App\Models\PromotionItem;
use App\Models\PromotionCategoryItem;
use App\Models\PromotionCategory;
use App\Models\PromotionEligibleItem;
use App\Models\Promotion;
use App\Models\Restaurant;
use Config;

class PromotionController extends Controller
{
    public function addRecord(Request $request)
    {
        try {
            $request_data = $request->json()->all();
            // $validator = Validator::make($request_data, [ 
            //     'restaurant_id' => 'required',
            //     'promotion_type_id' => 'required',
            //     'promotion_name' => 'required',
            //     'promotion_details'=>'required',
            //     'discount_type'=>'required',
            //     'discount'=>'required',
            //     'client_type'=>'required',
            //     'order_type'=>'required',
            //     'selected_payment_status'=>"required",
            //     "mark_promoas_status"=>"required",
            //     'promotion_code' => 'required',
            //     'promotion_status' => 'required',
            //     'display_time' => 'required',
            //     'minimum_order_status' => 'required',
            //     'no_extra_charge_type' => 'required',
            //     'set_minimum_order_amount' => 'required',
            //     'only_once_per_client'   => 'required',
            //     // "eligible_item"=>"required",
            // ]);
            $validator = Validator::make($request_data, [ 
                'restaurant_id' => 'required',
                'promotion_type_id' => 'required',
                'promotion_name' => 'required',
                'promotion_details'=>'required',
                'discount_type'=>'required',
                'discount'=>'required',
                'client_type'=>'required',
                'order_type'=>'required',
                'selected_payment_status'=>"required",
                "mark_promoas_status"=>"required",
                'promotion_code' => 'required',
                'promotion_status' => 'required',
                'display_time' => 'required',
                'set_minimum_order_amount' => 'required',
                'only_once_per_client'   => 'required',
                // "eligible_item"=>"required",
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()], 400);
            }
           
            $promotion = new  Promotion;
            $promotion->restaurant_id = $request->post('restaurant_id');
            $promotion->promotion_type_id = $request->post('promotion_type_id');
            $promotion->promotion_name = $request->post('promotion_name');
            $promotion->promotion_code = $request->post('promotion_code');
            $promotion->promotion_status = $request->post('promotion_status');
            $promotion->promotion_used = $request->post('promotion_used');
            $promotion->promotion_details = $request->post('promotion_details');
            $promotion->discount = $request->post('discount');
            $promotion->discount_type = $request->post('discount_type');
            $promotion->minimum_order_status = $request->post('minimum_order_status');
            $promotion->set_minimum_order_amount = $request->post('set_minimum_order_amount');
            $promotion->only_once_per_client = ($request->post('only_once_per_client') == "true") ? 0 : 1;
            $promotion->selected_payment_status = $request->post('selected_payment_status');
            $promotion->discount_expensive = ($request->post('discount_expensive'))  ? $request->post('discount_expensive') : null;
            $promotion->discount_cheapest = ($request->post('discount_cheapest'))  ? $request->post('discount_cheapest') : null;
            $promotion->client_type   = ($request->post('client_type')) ? $request->post('client_type') : null;
            $promotion->order_type   = ($request->post('order_type')) ? $request->post('order_type') : null;
            $promotion->no_extra_charge_type = ($request->post('no_extra_charge_type')) ? $request->post('no_extra_charge_type') : null;
            $promotion->mark_promoas_status = ($request->post('mark_promoas_status')) ? $request->post('mark_promoas_status') : null;
            $promotion->display_time = $request->display_time;
            $promotion->save();
            $promotionItem = New PromotionItem;
            // if($request->post('eligible_item')){
            //     $data = array();
            //     foreach ($request->post('eligible_item') as $key => $value) {
            //         $data[$key]['promotion_id'] = $promotion->promotion_id;
            //         $data[$key]['modifier_id'] = $value['modifier_id'];
            //         $data[$key]['status'] = 'ACTIVE';
            //     }
            //     $promotionItem->insert($data);
            // }
            if($request->post('eligible_items'))
            {
                foreach ($request->post('eligible_items') as $key => $value) {
                    $category = New PromotionCategory;
                    $category->promotion_id = $promotion->promotion_id;
                    $category->category_id = $value['category_id'];
                    $category->restaurant_id = $value['restaurant_id'];
                    if($category->save())
                    {
                        $categoryItem = New PromotionCategoryItem;
                        $categoryItem->promotion_id = $promotion->promotion_id;
                        $categoryItem->category_id = $value['category_id'];
                        $categoryItem->promotion_category_id = $category->promotion_category_id;
                        $categoryItem->item_id = $value['menu_id'];
                        $categoryItem->save();
                    }
                }
            }
            return response()->json(['message' => "Promotion added successfully.", 'success' => true], 200);
        } catch (\Throwable $th) {
            $errors['success'] = false;
            $errors['message'] = Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS');
            if ($request->debug_mode == 'ON') {
                $errors['debug'] = $th->getMessage();
            }
            return response()->json($errors, 500);
        }
    }

    public function addCategoryRecord(Request $request)
    {
        try {
            $request_data = $request->json()->all();
            // $validator = Validator::make($request_data, [ 
            //     'restaurant_id' => 'required',
            //     'promotion_type_id' => 'required',
            //     'promotion_name' => 'required',
            //     'promotion_details'=>'required',
            //     'discount_type'=>'required',
            //     'discount'=>'required',
            //     'client_type'=>'required',
            //     'order_type'=>'required',
            //     'selected_payment_status'=>"required",
            //     "mark_promoas_status"=>"required",
            //     'promotion_code' => 'required',
            //     'promotion_status' => 'required',
            //     'display_time' => 'required',
            //     'minimum_order_status' => 'required',
            //     'no_extra_charge_type' => 'required',
            //     'set_minimum_order_amount' => 'required',
            //     'only_once_per_client'   => 'required',
            // ]);
            $validator = Validator::make($request_data, [ 
                'restaurant_id' => 'required',
                'promotion_type_id' => 'required',
                'promotion_name' => 'required',
                'promotion_details'=>'required',
                'discount_type'=>'required',
                'discount'=>'required',
                'client_type'=>'required',
                'order_type'=>'required',
                'selected_payment_status'=>"required",
                "mark_promoas_status"=>"required",
                'promotion_code' => 'required',
                'promotion_status' => 'required',
                'display_time' => 'required',
                'set_minimum_order_amount' => 'required',
                'only_once_per_client'   => 'required',
                // "eligible_item"=>"required",
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()], 400);
            }
           
            $promotion = new  Promotion;
            $promotion->restaurant_id = $request->post('restaurant_id');
            $promotion->promotion_type_id = $request->post('promotion_type_id');
            $promotion->promotion_name = $request->post('promotion_name');
            $promotion->promotion_code = $request->post('promotion_code');
            $promotion->promotion_status = $request->post('promotion_status');
            $promotion->promotion_used = $request->post('promotion_used');
            $promotion->promotion_details = $request->post('promotion_details');
            $promotion->discount = $request->post('discount');
            $promotion->discount_type = $request->post('discount_type');
            $promotion->minimum_order_status = $request->post('minimum_order_status');
            $promotion->set_minimum_order_amount = $request->post('set_minimum_order_amount');
            $promotion->only_once_per_client = ($request->post('only_once_per_client') == "true") ? 0 : 1;
            $promotion->selected_payment_status = $request->post('selected_payment_status');
            $promotion->discount_expensive = ($request->post('discount_expensive'))  ? $request->post('discount_expensive') : null;
            $promotion->discount_cheapest = ($request->post('discount_cheapest'))  ? $request->post('discount_cheapest') : null;
            $promotion->client_type   = ($request->post('client_type')) ? $request->post('client_type') : null;
            $promotion->order_type   = ($request->post('order_type')) ? $request->post('order_type') : null;
            $promotion->no_extra_charge_type = ($request->post('no_extra_charge_type')) ? $request->post('no_extra_charge_type') : null;
            $promotion->mark_promoas_status = ($request->post('mark_promoas_status')) ? $request->post('mark_promoas_status') : null;
            $promotion->display_time = $request->display_time;
            $promotion->save();
            $data = array();

            if($request->has('eligible_items')){
                // foreach ($request->post('eligible_items') as $key => $val) {
                //     $eligible_item = New PromotionEligibleItem;
                //     $eligible_item->eligible_item_id  = $val['eligible_id'];
                //     $eligible_item->promotion_id = $promotion->promotion_id;
                //     if($eligible_item->save()){
                //         foreach($val['eligible_category'] as $key=>$value){
                //             $category = New PromotionCategory;
                //             $category->promotion_id = $promotion->promotion_id;
                //             $category->eligible_item_id  = $val['eligible_id'];
                //             $category->category_id = $value['category_id'];
                //             $category->promotion_eligible_item_id = $eligible_item->promotion_eligible_item_id;
                //             if($category->save()){
                //                 foreach ($value['category_item'] as $key1 => $value1) {
                //                     $categoryItem = New PromotionCategoryItem;
                //                     $categoryItem->promotion_id = $promotion->promotion_id;
                //                     $categoryItem->category_id = $value['category_id'];
                //                     $categoryItem->eligible_item_id  = $val['eligible_id'];
                //                     $categoryItem->promotion_category_id = $category->promotion_category_id;
                //                     $categoryItem->promotion_eligible_item_id = $eligible_item->promotion_eligible_item_id;
                //                     $categoryItem->item_id = $value1['item_id'];
                //                     $categoryItem->save();
                //                 }
                //             }
                //         }
                //     }
                // }
                foreach ($request->post('eligible_items') as $key => $value) {
                    $category = New PromotionCategory;
                    $category->promotion_id = $promotion->promotion_id;
                    $category->category_id = $value['category_id'];
                    $category->restaurant_id = $value['restaurant_id'];
                    if($category->save())
                    {
                        $categoryItem = New PromotionCategoryItem;
                        $categoryItem->promotion_id = $promotion->promotion_id;
                        $categoryItem->category_id = $value['category_id'];
                        $categoryItem->promotion_category_id = $category->promotion_category_id;
                        $categoryItem->item_id = $value['menu_id'];
                        $categoryItem->save();
                    }
                }
            }
            return response()->json(['message' => "Promotion added successfully.", 'success' => true], 200);
        } catch (\Throwable $th) {
            $errors['success'] = false;
            $errors['message'] = Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS');
            if ($request->debug_mode == 'ON') {
                $errors['debug'] = $th->getMessage();
            }
            return response()->json($errors, 500);
        }
    }


    public function active(Request $request)
    {
        try {
            $request_data = $request->json()->all();
                $validator = Validator::make($request_data, [ 
                'restaurant_id' => 'required',
                'promotion_id' => 'required',
                'status' => 'required'
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()], 400);
            }
            $promotion =  Promotion::where('promotion_id',$request->post('promotion_id'))->first();
            $promotion->status = $request->post('status');
            $promotion->save();
            return response()->json(['message' => "Promotion updated successfully.", 'success' => true], 200);
        } catch (\Throwable $th) {
            $errors['success'] = false;
            $errors['message'] = Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS');
            if ($request->debug_mode == 'ON') {
                $errors['debug'] = $th->getMessage();
            }
            return response()->json($errors, 500);
        }
    }

    public function getRecords(Request $request)
    {   try { 
            $request_data = $request->json()->all();
                $validator = Validator::make($request_data, [ 'restaurant_id' => 'required'
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()], 400);
            }
            $result = array();
            $promotionList = Promotion::where('restaurant_id',$request->post('restaurant_id'))->get(['promotion_id','promotion_type_id','restaurant_id','promotion_code','promotion_name','promotion_details','discount','discount_type','client_type','order_type','selected_payment_status','mark_promoas_status','display_time','promotion_status','minimum_order_status','set_minimum_order_amount','created_at','no_extra_charge_type','discount_expensive','discount_cheapest','only_once_per_client']);
            foreach ($promotionList as $promotionKey => $promotion) {
                $result[$promotionKey] = $promotion;
                $promotionCategoryItems = PromotionCategoryItem::where('promotion_category_items.promotion_id',$promotion->promotion_id)
                                        ->with('category_item')
                                        ->get();
                foreach($promotionCategoryItems as $key => $value)
                {
                    foreach ($value->category_item as $key1 => $value1) {
                        $result[$promotionKey]['eligible_items'][] = $value1;
                    }
                }
                
                // $promotionEligibleList = PromotionEligibleItem:: where('promotion_id',$promotion->promotion_id)->get();
                // foreach ($promotionEligibleList as $key => $value) {
                //         $result[$promotionKey]['eligible_items'][$key] = $value;
                //         $category_items =  Category::select('*')
                //             ->join('promotion_category','promotion_category.category_id','=','categories.category_id')
                //             ->where('promotion_category.promotion_id',$request->post('promotion_id'))
                //             ->where('promotion_category.promotion_eligible_item_id',$value->promotion_eligible_item_id)
                //             ->get();     
                //             $result[$promotionKey]['eligible_items'][$key]['eligible_category'] = $category_items ;

                          
                //             if( $category_items){
                //                 // dd( $promotionList);
                //                 foreach ($category_items as $key1 => $value1) {
                //                     if($value){
                //                     $category_items =  MenuItem::select('*')
                //                         ->join('promotion_category_items','promotion_category_items.item_id','=','menu_items.menu_id')
                //                         ->where('promotion_category_items.promotion_id',$request->post('promotion_id'))
                //                         ->where('menu_items.category_id',$value1->category_id)
                //                         ->get(); 
                //                         $result[$promotionKey]['eligible_items'][$key]['eligible_category'][$key1]['category_item'] = $category_items;
                //                     }
                //                 }
                //             }
                // }
            }
            return response()->json(['promotion_list' => $result, 'success' => true], 200);
        } catch (\Throwable $th) {
            $errors['success'] = false;
            $errors['message'] = Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS');
            if ($request->debug_mode == 'ON') {
                $errors['debug'] = $th->getMessage();
            }
            return response()->json($errors, 500);
        }
    }

    public function getRecordById(Request $request)
    {   try { 
            $request_data = $request->json()->all();
                $validator = Validator::make($request_data, 
                [ 'restaurant_id' => 'required',
                   'promotion_id' => 'required'
                ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()], 400);
            }
            $result = array();
            $promotionId= $request->post('promotion_id');
            $result = Promotion::where('promotion_id',$request->post('promotion_id'))->first();
            $promotionList = PromotionEligibleItem:: where('promotion_id',$request->post('promotion_id'))->get();
                foreach ($promotionList as $key => $value) {
                        $result['eligible_items'][$key] = $value;
                        $category_items =  Category::select('*')
                            ->join('promotion_category','promotion_category.category_id','=','categories.category_id')
                            ->where('promotion_category.promotion_id',$request->post('promotion_id'))
                            ->where('promotion_category.promotion_eligible_item_id',$value->promotion_eligible_item_id)
                            ->get();     
                            $result['eligible_items'][$key]['eligible_category'] = $category_items ;

                          
                            if( $category_items){
                                // dd( $promotionList);
                                foreach ($category_items as $key1 => $value1) {
                                    if($value){
                                    $category_items =  MenuItem::select('*')
                                        ->join('promotion_category_items','promotion_category_items.item_id','=','menu_items.menu_id')
                                        ->where('promotion_category_items.promotion_id',$request->post('promotion_id'))
                                        ->where('menu_items.category_id',$value1->category_id)
                                        ->get(); 
                                        $result['eligible_items'][$key]['eligible_category'][$key1]['category_item'] = $category_items;
                                    }
                                }
                        }
                }
            
            return response()->json(['data' => $result, 'success' => true], 200);
        } catch (\Throwable $th) {
            $errors['success'] = false;
            $errors['message'] = Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS');
            if ($request->debug_mode == 'ON') {
                $errors['debug'] = $th->getMessage();
            }
            return response()->json($errors, 500);
        }
    }

    public function status(Request $request)
    {   try { 
            $request_data = $request->json()->all();
                $validator = Validator::make($request_data, [
                     'restaurant_id' => 'required',
                     'promotion_id' => 'required',
                     'status'=>'required'
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()], 400);
            }
            $result = array();
            $promotionList = Promotion::where('restaurant_id', $request->post('restaurant_id'))
            ->where('promotion_id',$request->promotion_id)
            ->first();
            if($promotionList){
                $status = ($request->status==true)?'ACTIVE':'INACTIVE';
                $promotionList->status = $status ;
                $promotionList->save();
            }
            return response()->json(['message' =>'Promotion update successfully.', 'success' => true], 200);
        } catch (\Throwable $th) {
            $errors['success'] = false;
            $errors['message'] = Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS');
            if ($request->debug_mode == 'ON') {
                $errors['debug'] = $th->getMessage();
            }
            return response()->json($errors, 500);
        }
    }

    public function delete(Request $request)
    {
        try { 
            $request_data = $request->json()->all();
            $validator = Validator::make($request_data, [
                    'restaurant_id' => 'required',
                    'promotion_id' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()], 400);
            }
            $result = array();
            $promotion = Promotion::where('restaurant_id', $request->post('restaurant_id'))
            ->where('promotion_id',$request->post('promotion_id'))
            ->delete();
            if($promotion){
                PromotionCategory::where('promotion_id',$request->post('promotion_id'))->where('restaurant_id',$request->post('restaurant_id'))->delete();
                PromotionCategoryItem::where('promotion_id',$request->post('promotion_id'))->delete();
                return response()->json(['message' =>'Promotion delete successfully.', 'success' => true], 200);
            }
            else
            {
                return response()->json(['message' =>'Promotion not found.', 'success' => false], 200);
            }
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
