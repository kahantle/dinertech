<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CustomerFcmTokens;
use Validator;
use App\Models\Category;
use App\Models\User;
use App\Models\MenuItem;
use Config;

class CategoryController extends Controller
{
    public function getCategoryList(Request $request)
    {
        try {
            $request_data = $request->json()->all();
            $validator = Validator::make($request_data, ['restaurant_id' => 'required']);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()], 400);
            }
            if(auth('api')->user()){
                $uid = auth('api')->user()->uid;
                $user = User::find($uid);
                if($request->post('fcm_id')){
                    $fcmId = $request->post('fcm_id');
                    $customerFcmToken = CustomerFcmTokens::where('uid', $uid)->where('fcm_id', $fcmId)->first();
                    if (!$customerFcmToken) {
                        $customerFcmToken = new CustomerFcmTokens();
                        $customerFcmToken->uid = $uid;
                        $customerFcmToken->fcm_id = $fcmId;
                        if($request->post('device')){
                            $device = $request->post('device');
                            $customerFcmToken->device = $device;
                        }
                        $customerFcmToken->save();
                    }
                    $user->fcm_id = $fcmId;
                    $user->save();
                }
            }
            $categoryList = Category::where('restaurant_id', $request->post('restaurant_id'))
            ->get(['category_id','restaurant_id', 'category_name', 'category_details', 'image']);
            return response()->json(['category_list' => $categoryList, 'success' => true], 200);
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
