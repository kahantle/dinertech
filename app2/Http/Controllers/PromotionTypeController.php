<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PromotionType;
use App\Models\RestaurantPromotionTypes;
use App\Models\Restaurant;
use Toastr;
use Config;
use Validator;
use Auth;
use DB;

class PromotionTypeController extends Controller
{
    public function index()
    {
        $uid = Auth::user()->uid;
        $user = User::where('uid', $uid)->first();
        $restaurant = Restaurant::where('uid', $uid)->first();
    	$promotiontype = PromotionType::where('status', 'ACTIVE')->get();
        $promotionTypeData = RestaurantPromotionTypes::where('restaurant_id', $restaurant->restaurant_id)->get('promotion_type_id')->pluck('promotion_type_id')->toArray();
    	return view('promotionType.index',compact('promotiontype','promotionTypeData'));
    }

    public function add(Request $request)
    {
    	try {
            $validator = Validator::make($request->post(), [
                'promotionTypeId' => 'required',
            ]);
            
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()], 400);
            }

            $uid = Auth::user()->uid;
            $user = User::where('uid', $uid)->first();
            $restaurant = Restaurant::where('uid', $uid)->first();

            $RestaurantPromotionTypes = RestaurantPromotionTypes::where('restaurant_id', $restaurant->restaurant_id)
            ->where('promotion_type_id',$request->post('promotionTypeId'))
            ->first();
            if ($RestaurantPromotionTypes) {
                 $RestaurantPromotionTypes->delete();
                 $returns['success'] = true;
                 $returns['message'] = " Promotion type removed successfully!";
                 $returns['route'] = route('promotiontype');
            }else{
                $promotiontype = new  RestaurantPromotionTypes;
                $promotiontype->restaurant_id = $restaurant->restaurant_id;
                $promotiontype->promotion_type_id = $request->post('promotionTypeId');

                if ($promotiontype->save()) {
                    $returns['success'] = true;
                    $returns['message'] = ucfirst($request->post('type'))." Promotion type added successfully!";
                    $returns['route'] = route('promotiontype');
                }else{
                    $returns['success'] = false;
                    $returns['message'] = ucfirst($request->post('type'))." Promotion type does not change successfully!";
                    $returns['route'] = route('promotiontype');
                }
            }
            return response()->json($returns);

        } catch (\Throwable $th) {
           $returns['success'] = false;
           $returns['message'] = Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS');
           $returns['route'] = route('promotiontype');
           return response()->json($returns);
        }
    }
}
