<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\CustomerAddress;
use Config;
use App\Models\Restaurant;
use DB;

class AddressController extends Controller
{
    public function getAddressList(Request $request)
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
            $addressList = CustomerAddress::where('uid', $uid)->get(['customer_address_id','uid','type' ,'address', 'state', 'city','zip','lat','long']);
            return response()->json(['address_list' => $addressList, 'success' => true], 200);
        } catch (\Throwable $th) {
            $errors['success'] = false;
            $errors['message'] = Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS');
            if ($request->debug_mode == 'ON') {
                $errors['debug'] = $th->getMessage();
            }
            return response()->json($errors, 500);
        }
    }

    public function addAddress(Request $request)
    {
        try {
            $request_data = $request->json()->all();
            $validator = Validator::make($request_data, [
                'restaurant_id' => 'required',
                'address_details' => 'required',
                'lat' => 'required',
                'long' => 'required',
                'state' => 'required',
                'city' => 'required',
                'type'=>'required',
                'zip_code' => 'required',
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
            $user_address = new CustomerAddress;
            $user_address->uid = $uid;
            $user_address->address = $request->post('address_details');
            $user_address->state = $request->post('state');
            $user_address->city = $request->post('city');
            $user_address->lat = $request->post('lat');
            $user_address->long = $request->post('long');
            $user_address->type = $request->post('type');
            $user_address->zip = $request->post('zip_code');
            if($user_address->save()){
                DB::commit();
                return response()->json(['message' => "Address added successfully.", 'success' => true], 200);
            }else{
                DB::rollBack();
                return response()->json(['message' => "Address does not added successfully.", 'success' => true], 401);
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


    public function deleteAddress(Request $request)
    {
        try {
            $request_data = $request->json()->all();
            $validator = Validator::make($request_data, ['restaurant_id' => 'required','customer_address_id' =>'required']);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()], 400);
            }
            $uid = auth('api')->user()->uid;
            $restaurant = Restaurant::where('restaurant_id', $request->post('restaurant_id'))
            ->whereHas('restaurant_user', function($query)use($uid){
                $query->where('uid',$uid);
            })->first();
            if (!$restaurant) {
                return response()->json(['success' => false, 'message' => "Invalid user for this restaurant."], 400);
            }
            DB::beginTransaction();
            $address = CustomerAddress::where('customer_address_id',$request->post('customer_address_id'))->first();
            if($address){
                $address->delete();
                DB::commit();
                return response()->json(['message' => "Address delete successfully.", 'success' => true], 200);
            }else{
                DB::rollBack();
                return response()->json(['message' => "Address does not delete successfully.", 'success' => true], 401);
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
