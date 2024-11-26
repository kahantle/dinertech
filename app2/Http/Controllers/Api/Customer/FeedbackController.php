<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CustomerFeedback;
use App\Models\Restaurant;
use Validator;
use Config;
use DB;

class FeedbackController extends Controller
{
    public function addFeedback(Request $request)
    {
        try {
            // $request_data = $request->json()->all();
            $validator = Validator::make($request->all(), [
                'restaurant_id' => 'required',
                'name' => 'required',
                'phone' => 'required',
                'email' => 'required',
                'feedback_type' => 'required',
                'suggestion' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()], 400);
            }
            $uid = auth('api')->user()->uid;
            $restaurant = Restaurant::where('restaurant_id', $request->post('restaurant_id'))
            ->whereHas('restaurant_user', function($query)use($uid){
                $query->where('uid',$uid);
            })
            ->first();
            if (!$restaurant) {
                return response()->json(['success' => false, 'message' => "Invalid user for this restaurant."], 400);
            }
            DB::beginTransaction();
            $user_feedback = new CustomerFeedback;
            $user_feedback->uid = $uid;
            $user_feedback->restaurant_id = $restaurant->restaurant_id;
            $user_feedback->name = $request->post('name');
            $user_feedback->phone = $request->post('phone');
            $user_feedback->email = $request->post('email');
            $user_feedback->feedback_type = $request->post('feedback_type');
            $user_feedback->suggestion = $request->post('suggestion');
            if($user_feedback->save()){
                DB::commit();
                return response()->json(['message' => "Feedback sent successfully.", 'success' => true], 200);
            }else{
                DB::rollBack();
                return response()->json(['message' => "Feedback does not sent successfully.", 'success' => true], 401);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            $errors['success'] = false;
            $errors['message'] = Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS');
            if ($request->debug_mode == 'ON') {
                $errors['debug'] = $th->getMessage();
            }
            return response()->json($errors, 500);
        }
    }
}
