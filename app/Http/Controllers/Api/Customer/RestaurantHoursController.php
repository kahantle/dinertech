<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Restaurant;
use App\Models\RestaurantHours;
use Config;
use DateTime;
use Carbon\Carbon;


class RestaurantHoursController extends Controller
{
    public function get(Request $request)
    {
        try {
            $request_data = $request->json()->all();
            $validator = Validator::make($request_data, ['restaurant_id' => 'required']);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()], 400);
            }
            // $list = RestaurantHours::where('restaurant_id', $request->post('restaurant_id'))
            //     ->get(['restaurant_hour_id',
            //          'restaurant_id',
            //           'day',
            //           'opening_time',
            //           'closing_time']);
            $list  = RestaurantHours::select('restaurant_hour_id','hours_group_id','restaurant_id',\DB::raw("GROUP_CONCAT(day) as `groupDayS`"))->with(['allTimes' => function($query){
                $query->select('restaurant_time_id','restaurant_hour_id','opening_time','closing_time','hour_type');
            }])->groupBy('hours_group_id')->where('restaurant_id', $request->post('restaurant_id'))->get();

            return response()->json(['list' => $list, 'success' => true], 200);
        } catch (\Throwable $th) {
            $errors['success'] = false;
            $errors['message'] = Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS');
            if ($request->debug_mode == 'ON') {
                $errors['debug'] = $th->getMessage();
            }
            return response()->json($errors, 500);
        }
    }
    public function checkAvailability(Request $request)
    {
        $data  = RestaurantHours::with('allTimes')->where('restaurant_id', $request->restaurant_id)->where('day', 'like', '%' . $request->day . '%')->first();

        if (empty($data)) {
            return response()->json(['success' => false, 'message' => 'Oops! Betty Burger is not open for orders at the time selected. Please select another time']);
        }

        $testResult  = [];

        foreach($data->allTimes as $time) {
            $openingtime =date('H:i A', strtotime($time->opening_time));
            $closingtime =date('H:i A', strtotime($time->closing_time));
            $openTime =date('H:i A', strtotime($request->time));
            $testResult[] =$openingtime <= $openTime &&  $openTime <= $closingtime;
        }

        if (!in_array(true,$testResult)) {
            return response()->json(['success' => false, 'message' => 'Oops! Betty Burger is not open for orders at the time selected. Please select another time']);
        }

        $restaurant = Restaurant::where('restaurant_id', $request->restaurant_id)->first();

        $tip1=0;
        $tip2=0;
        $tip3=0;
        if ($restaurant) {
            // Ensure tip values are properly formatted as strings with two decimal places
            $tip1 = sprintf("%.2f", (float) $restaurant->tip1);
            $tip2 = sprintf("%.2f", (float) $restaurant->tip2);
            $tip3 = sprintf("%.2f", (float) $restaurant->tip3);
        }
        if($restaurant->online_order_status == 0){
            return response()->json(['success' => false, 'message' => "Restaurant can't able to accept online order in this time !"]);
        }

        // if($data->restaurant->online_order_status == 0)
        // {
        //     return response()->json(['success' => false, 'message' => "Restaurant can't able to accept online order in this time !"]);
        // }
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

        return response()->json(['restaurantopen' => $restaurant, 'tip1'=>$tip1, 'tip2'=>$tip2, 'tip3'=>$tip3, 'success' => true, 'message' => 'Restaurant founded successfully..']);

    }
}
