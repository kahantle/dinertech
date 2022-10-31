<?php

namespace App\Http\Controllers\Api\Restaurant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\MenuItem;
use App\Models\Restaurant;
use App\Models\Contact;
use Carbon\Carbon;
use Config;
use Hash;
use DB;

class PinController extends Controller
{

    public function add(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'restaurant_id' => 'required',
                'pin' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()], 400);
            }
            $uid = auth('api')->user()->uid;
            $restaurant = Restaurant::where('restaurant_id', $request->post('restaurant_id'))
                ->first();
            $restaurant->pin = $request->post('pin');
            $restaurant->is_pinprotected = 1;
            if($restaurant->save()){
                return response()->json(['message' => "Pin set successfully.", 'success' => true], 200);
            }
            return response()->json(['message' => "Pin does not set successfully.", 'success' => true], 200);
        } catch (\Throwable $th) {
            $errors['success'] = false;
            $errors['message'] = Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS');
            if ($request->debug_mode == 'ON') {
                $errors['debug'] = $th->getMessage();
            }
            return response()->json($errors, 500);
        }
    }


    public function status(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'restaurant_id' => 'required',
                'pin' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()], 400);
            }
            $restaurant = Restaurant::where('restaurant_id', $request->post('restaurant_id'))
                ->first();
            $restaurant->is_pinprotected = 0;
            if($restaurant->save()){
                return response()->json(['message' => "Your Pin Disable Successfully.", 'success' => true], 200);
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
}
