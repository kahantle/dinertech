<?php

namespace App\Http\Controllers\Api\Restaurant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\RestaurantFcmTokens;
use Auth;
use App\Models\Restaurant;
use Validator;
use Config;

class AccountController extends Controller
{
    public function getSettings(REQUEST $request)
    {
        try {
            $restaurant = Restaurant::where('restaurant_id', $request->post('restaurant_id'))->first();
            $restaurant_settings = Restaurant::select('sales_tax','is_pinprotected','auto_print_receipts')->where('restaurant_id', $request->post('restaurant_id'))->first();
            $user_settings = User::select('chat_notifications','location_tracking')->where('uid',$restaurant->uid)->first()->toArray();
            unset($user_settings['full_name'],$user_settings['image_path']);
            return response()->json([ 'settings' => array_merge($restaurant_settings->toArray(), $user_settings) , 'message' => "All Settings fetched Successfully.", 'success' => true], 200);
        } catch (\Throwable $th) {
            $errors['success'] = false;
            $errors['message'] = Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS');
            if ($request->debug_mode == 'ON') {
                $errors['debug'] = $th->getMessage();
            }
            return response()->json($errors, 500);
        }
    }

    public function updateSetting(Request $request){
        try {
            $request_data = $request->json()->all();
            $validator = Validator::make($request_data, [
                'restaurant_id' => 'required',
                'chat_notifications' => 'required',
                'location_tracking' =>  'required',
                'sales_tax'         => 'required',
                'auto_print_receipts' => 'required'
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()], 400);
            }

            $restaurant = Restaurant::where('restaurant_id', $request->post('restaurant_id'))
                ->first();
            $restaurant->sales_tax = $request->post('sales_tax');
            $restaurant->auto_print_receipts = ($request->post('auto_print_receipts') == "true") ? 1 : 0;
            $user = User::where('uid',$restaurant->uid)->first();
            if($user){
                $user->chat_notifications = ($request->post('chat_notifications') == "true") ? 1 : 0;
                $user->location_tracking  = ($request->post('location_tracking') == "true") ? 1 : 0;
                $user->save();
            }
            if($restaurant->save()){
                return response()->json(['message' => "Settings update Successfully.", 'success' => true], 200);
            }
            return response()->json(['message' => "Settings does not update successfully.", 'success' => true], 200);
        } catch (\Throwable $th) {
            $errors['success'] = false;
            $errors['message'] = Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS');
            if ($request->debug_mode == 'ON') {
                $errors['debug'] = $th->getMessage();
            }
            return response()->json($errors, 500);
        }
    }

    public function deleteAccount(Request $request)
    {
        try {
            $user = auth('api')->user();
            if (!Auth::guard('admin')->attempt(['email_id' => $user->email_id, 'password' => $request->password])) {
                $returns['success'] = false;
                $returns['message'] = "Wrong password !";
            } else {
                RestaurantFcmTokens::where('uid', $user->uid)->delete();
                $token = auth('api')->user()->token();
                $token->revoke();
                $user->delete();
                $returns['success'] = true;
                $returns['message'] = "Account Deleted !";
            }
            return response()->json($returns, 200);
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
