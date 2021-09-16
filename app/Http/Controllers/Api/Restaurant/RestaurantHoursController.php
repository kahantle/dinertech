<?php

namespace App\Http\Controllers\Api\Restaurant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Restaurant;
use App\Models\RestaurantHours;
use Config;
use DB;
class RestaurantHoursController extends Controller
{

    public function add(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'restaurant_id' => 'required',
                'opening_time' => 'required',
                'days'=>'required',
                'closing_time' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()], 400);
            }

            $days='';
            $menuRow =array();
            $requestDays = explode(",",$request->post('days'));
            if(is_array($requestDays)){
                foreach ($requestDays as $key => $value) {
                    $countRestaurantHours = RestaurantHours::where('day',strtolower($value))
                    ->where('restaurant_id',$request->post('restaurant_id'))
                    ->first();
                    if($countRestaurantHours){
                        $days .= ($days=='')? $value : ",".$value;
                    }
                }
            }else{
                return response()->json(['success' => false, 'message' => 'Please enter valid .'], 400);
            }

            if($days){
                return response()->json(['success' => false, 'message' => 'Please enter unique '.$days.' days'], 400);
            }

            $countRestaurantHours = RestaurantHours::where('restaurant_id',$request->post('restaurant_id'))
                                    ->orderBy('hours_group_id','desc')
                                    ->get();
                                   
            $groupId = ($countRestaurantHours)?$countRestaurantHours->count()+1:1;
            $data=array();
            foreach ($requestDays as $key => $value) {
                $data[$key]['restaurant_id'] = $request->post('restaurant_id');
                $data[$key]['hours_group_id'] = $groupId;
                $data[$key]['day'] =  strtolower($value);
                $data[$key]['opening_time'] = $request->post('opening_time');
                $data[$key]['closing_time'] = $request->post('closing_time');
            }
            $hour = new RestaurantHours;
            if($hour->insert($data)){
                return response()->json(['message' => 'Hours added successfully.', 'success' => true], 200);
            }
        } catch (\Throwable $th) {
            $errors['success'] = false;
            $errors['message'] = Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS');
            if ($request->debug_mode == 'ON') {
                $errors['debug'] = $th->getMessage();
            }
            print_r($th->getMessage());
            return response()->json($errors, 500);
        }
    }


    public function update(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'restaurant_id' => 'required',
                'opening_time' => 'required',
                'hours_group_id'=>'required',
                'days'=>'required',
                'closing_time' => 'required'
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()], 400);
            }

            $days='';
            $menuRow =array();
            $requestDays = explode(",",$request->post('days'));
            if(is_array($requestDays)){
                foreach ($requestDays as $key => $value) {
                    $countRestaurantHours = RestaurantHours::where('day',strtolower($value))
                    ->where('restaurant_id',$request->post('restaurant_id'))
                    ->where('hours_group_id','!=',$request->post('hours_group_id'))
                    ->first();
                    if($countRestaurantHours){
                        $days .= ($days=='')? $value : ",".$value;
                    }
                }
            }else{
                return response()->json(['success' => false, 'message' => 'Please enter valid days.'.$days], 400);
            }

            if($days){
                return response()->json(['success' => false, 'message' => 'Please enter unique '.$days.' days'], 400);
            }

            RestaurantHours::where('hours_group_id', $request->post('hours_group_id'))->delete();
            $data=array();
            foreach ($requestDays as $key => $value) {
                $data[$key]['restaurant_id'] = $request->post('restaurant_id');
                $data[$key]['hours_group_id'] = $request->post('hours_group_id');
                $data[$key]['day'] =  strtolower($value);
                $data[$key]['opening_time'] = $request->post('opening_time');
                $data[$key]['closing_time'] = $request->post('closing_time');
            }
            $hour = new RestaurantHours;
            if($hour->insert($data)){
                return response()->json(['message' => 'Hours update successfully.', 'success' => true], 200);
            }
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
            $request_data = $request->json()->all();
            $validator = Validator::make($request_data, ['restaurant_id' => 'required']);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()], 400);
            }
            $list = RestaurantHours::
            select('restaurant_hours.*',DB::raw('group_concat(day) as days'))
            ->where('restaurant_id', $request->post('restaurant_id'))
            ->groupBy('restaurant_hours.hours_group_id')
            ->get();
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

    public function delete(Request $request)
    {

        try {
            $request_data = $request->json()->all();
            $validator = Validator::make($request_data, [
                'restaurant_id' => 'required',
                'hours_group_id' => 'required',
                'restaurant_hour_id' => 'required'
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()], 400);
            }
            RestaurantHours::where('hours_group_id', $request->post('hours_group_id'))->delete();
            return response()->json(['message'=> "Hours delete successfully.",'success' => true], 200);
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
