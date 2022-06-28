<?php

namespace App\Http\Controllers\Api\Restaurant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Restaurant;
use Validator;

class AccountController extends Controller
{
    public function updateSetting(Request $request){
        try {
            $request_data = $request->json()->all();
            
            $validator = Validator::make($request_data, [
                'restaurant_id' => 'required',
                'chat_notifications' => 'required',
                'location_tracking' =>  'required',
                'sales_tax'         => 'required'
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()], 400);
            }

            $restaurant = Restaurant::where('restaurant_id', $request->post('restaurant_id'))
                ->first();
            $restaurant->sales_tax = $request->post('sales_tax');
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
}
