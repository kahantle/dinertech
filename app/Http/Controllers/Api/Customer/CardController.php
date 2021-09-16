<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Category;
use App\Models\Card;
use Config;
use App\Models\Restaurant;
use DB;

class CardController extends Controller
{
    public function list(Request $request)
    {
        try {
            $request_data = $request->json()->all();
            $validator = Validator::make($request_data, ['restaurant_id' => 'required']);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()], 400);
            }
            $uid = auth('api')->user()->uid;
            $restaurant = Restaurant::where('restaurant_id', $request->post('restaurant_id'))
                ->whereHas('restaurant_user', function($query)use($uid){
                    $query->where('uid',$uid);
                })
                ->first();
            if (!$restaurant) {
                return response()->json(['success' => false, 'message' => "Invalid user for this restaurant."], 400);
            }
            $uid = auth('api')->user()->uid;
            $list = Card::where('uid', $uid)
            ->get(['card_id','uid', 'card_number', 'card_expire_date', 'card_holder_name','card_cvv','card_type']);
            return response()->json(['card_list' => $list, 'success' => true], 200);
        } catch (\Throwable $th) {
            $errors['success'] = false;
            $errors['message'] = Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS');
            if ($request->debug_mode == 'ON') {
                $errors['debug'] = $th->getMessage();
            }
            return response()->json($errors, 500);
        }
    }

    public function add(Request $request)
    {
        try {
            $request_data = $request->json()->all();
            $validator = Validator::make($request_data, [
                'restaurant_id' => 'required',
                'card_expire_date' => 'required',
                'card_number' => 'required',
                'card_holder_name' => 'required',
                'card_cvv' => 'required',
                'card_type' => 'required'
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()], 400);
            }
            $uid = auth('api')->user()->uid;
            $restaurant = Restaurant::where('restaurant_id', $request->post('restaurant_id'))
            ->whereHas('restaurant_user', function($query)use($uid){
                $query->where('uid',$uid);
            })
            ->first();
            if (!$restaurant) {
                return response()->json(['success' => false, 'message' => "Invalid user for this restaurant."], 400);
            }
            DB::beginTransaction();
            $user_card = new Card;
            $user_card->uid = $uid;
            $user_card->restaurant_id = $request->post('restaurant_id');
            $user_card->card_expire_date = $request->post('card_expire_date');
            $user_card->card_number = $request->post('card_number');
            $user_card->card_holder_name = $request->post('card_holder_name');
            $user_card->card_cvv = $request->post('card_cvv');
            $user_card->card_type = $request->post('card_type');
            if($user_card->save()){
                DB::commit();
                return response()->json(['message' => "Card added successfully.", 'success' => true], 200);
            }else{
                DB::rollBack();
                return response()->json(['message' => "Card does not added successfully.", 'success' => true], 401);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
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
            $validator = Validator::make($request_data, ['restaurant_id' => 'required','card_id' =>'required']);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()], 400);
            }
            $uid = auth('api')->user()->uid;
            $restaurant = Restaurant::where('restaurant_id', $request->post('restaurant_id'))
            ->whereHas('restaurant_user', function($query)use($uid){
                $query->where('uid',$uid);
            })
                            ->first();
            if (!$restaurant) {
                return response()->json(['success' => false, 'message' => "Invalid user for this restaurant."], 400);
            }
            DB::beginTransaction();
            $card = Card::where('card_id',$request->post('card_id'))->first();
            if($card){
                $card->delete();
                DB::commit();
                return response()->json(['message' => "Card delete successfully.", 'success' => true], 200);
            }else{
                DB::rollBack();
                return response()->json(['message' => "Card does not delete successfully.", 'success' => true], 401);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $errors['success'] = false;
            $errors['message'] = Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS');
            if ($request->debug_mode == 'ON') {
                $errors['debug'] = $th->getMessage();
            }
            return response()->json($errors, 500);
        }
    }
}
