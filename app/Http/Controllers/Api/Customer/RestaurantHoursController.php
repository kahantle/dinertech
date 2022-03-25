<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Restaurant;
use App\Models\RestaurantHours;
use Config;


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
            $list  = RestaurantHours::select('restaurant_hour_id','restaurant_id',\DB::raw("GROUP_CONCAT(day) as `groupDayS`"))->with(['allTimes' => function($query){
                $query->select('restaurant_time_id','restaurant_hour_id','opening_time','closing_time');
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
}
