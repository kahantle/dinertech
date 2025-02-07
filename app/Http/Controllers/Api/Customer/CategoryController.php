<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CustomerFcmTokens;
use App\Models\RestaurantHours;
use Validator;
use App\Models\Category;
use App\Models\User;
use App\Models\MenuItem;
use Config;
use Carbon\Carbon;

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
            if (auth('api')->user()) {
                $uid = auth('api')->user()->uid;
                $user = User::find($uid);
                if ($request->post('fcm_id')) {
                    $fcmId = $request->post('fcm_id');
                    $customerFcmToken = CustomerFcmTokens::where('uid', $uid)->where('fcm_id', $fcmId)->first();
                    if (!$customerFcmToken) {
                        $customerFcmToken = new CustomerFcmTokens();
                        $customerFcmToken->uid = $uid;
                        $customerFcmToken->fcm_id = $fcmId;
                        if ($request->post('device')) {
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
                ->get(['category_id', 'restaurant_id', 'category_name', 'category_details', 'image']);
            // check if the retaurant is open or not

            // Time check
            $current_dt = Carbon::now();
            $day = $current_dt->format('l');
            $data = RestaurantHours::with('allTimes')
                ->where('restaurant_id', $request->restaurant_id)
                ->where('day', 'like', '%' . $day ?? $request->day . '%')
                ->first();

            $testResult = [];
            if (($data)) {


                foreach ($data->allTimes as $time) {
                    // Convert times to timestamps
                    $openingTimeTimestamp = strtotime($time->opening_time);
                    $closingTimeTimestamp = strtotime($time->closing_time);
                    $currentTimestamp = strtotime($current_dt->format('H:i'));

                    // Handle cases where closing time is after midnight
                    if ($closingTimeTimestamp < $openingTimeTimestamp) {
                        $closingTimeTimestamp += 86400; // Add 24 hours to closing time
                    }

                    // Check if the current time is within the opening and closing times
                    $testResult[] = $openingTimeTimestamp <= $currentTimestamp && $currentTimestamp <= $closingTimeTimestamp;
                }

            }
            // Determine if the restaurant is open
            $restaurant = in_array(true, $testResult, true);

            return response()->json(['restaurantopen' => $restaurant, 'category_list' => $categoryList, 'success' => true], 200);
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
