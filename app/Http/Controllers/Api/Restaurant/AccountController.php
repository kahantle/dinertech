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
            $restaurant_settings = Restaurant::select('sales_tax','is_pinprotected','auto_print_receipts', 'tip1', 'tip2', 'tip3')->where('restaurant_id', $request->post('restaurant_id'))->first();
            if ($restaurant_settings) {
                // Ensure tip values are properly formatted as strings with two decimal places
                $restaurant_settings->tip1 = sprintf("%.2f", (float) $restaurant_settings->tip1);
                $restaurant_settings->tip2 = sprintf("%.2f", (float) $restaurant_settings->tip2);
                $restaurant_settings->tip3 = sprintf("%.2f", (float) $restaurant_settings->tip3);
            }
            
            
            
            $user_settings = User::select('chat_notifications','location_tracking','pin_notifications','pin','pin As menu_pin')->where('uid',$restaurant->uid)->first()->toArray();
            unset($user_settings['full_name'],$user_settings['image_path']);
            return response()->json([ 
                'settings' => array_merge(
                    collect($restaurant_settings->toArray())->map(function ($value, $key) {
                        return in_array($key, ['tip1', 'tip2', 'tip3']) ? sprintf("%.2f", (float) $value) : $value;
                    })->toArray(),
                 $user_settings) , 'message' => "All Settings fetched Successfully.", 'success' => true], 200);
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
            if(($request->post('tip1')) && !empty($request->post('tip1'))){
                $restaurant->tip1 = $request->post('tip1');
            }
            if(($request->post('tip2')) && !empty($request->post('tip2'))){
                $restaurant->tip2 = $request->post('tip2');
            }
            if(($request->post('tip3')) && !empty($request->post('tip3'))){
                $restaurant->tip3 = $request->post('tip3');
            }

            $user = User::where('uid',$restaurant->uid)->first();
            if($user){
                $user->chat_notifications = ($request->post('chat_notifications') == "true") ? 1 : 0;
                $user->pin_notifications = $request->post('pin_enable');
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

    public function getSubscriptions(Request $request)
    {
        try {
            $user = auth('api')->user();
            $returns['email_subscription'] = $user->email_subscription;
            $returns['loyalty_subscription'] = $user->loyalty_subscription;
            $returns['success'] = true;
            return response()->json($returns, 200);
        } catch (\Throwable $th) {
            $errors['success'] = false;
            $errors['message'] = Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS');
            return response()->json($errors, 500);
        }
    }
}
