<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\User;
use Config;

class UserSettingController extends Controller
{
    public function add(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'restaurant_id' => 'required',
                'app_notifications' => 'required',
                'chat_notifications' => 'required',
                'location_tracking' => 'required',

            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()], 400);
            }
            $uid = auth('api')->user()->uid;
            $setting = User::where('uid',$uid)->first();
            $setting->app_notifications = $request->post('app_notifications');
            $setting->chat_notifications = $request->post('chat_notifications');
            $setting->location_tracking = $request->post('location_tracking');
            if($setting->save()){
                return response()->json(['message' => "Setting set successfully.", 'success' => true], 200);
            }
            return response()->json(['message' => "Pin does not update successfully.", 'success' => true], 200);
        } catch (\Throwable $th) {
            $errors['success'] = false;
            $errors['message'] = Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS');
            if ($request->debug_mode == 'ON') {
                $errors['debug'] = $th->getMessage();
            }
            return response()->json($errors, 500);
        }
    }


    public function get(Request $request)
    {
        try {
            $uid = auth('api')->user()->uid;
            
            $list = User::where('uid',$uid)->first(['app_notifications','chat_notifications','location_tracking']);
            return response()->json(['setting' => $list, 'success' => true], 200);
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
