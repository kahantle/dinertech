<?php

namespace App\Http\Controllers\Api\Restaurant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\MenuItem;
use App\Models\Restaurant;
use App\Models\Feedback;
use Carbon\Carbon;
use Config;
use Hash;
use DB;

class FeedbackController extends Controller
{

    public function add(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'restaurant_id' => 'required',
                'feedback_type' => 'required',
                //'feedback_report' => 'required',
                'name' => 'required',
                'phone' => 'required',
                'email' => 'required',
                'suggestion' => 'required'
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()], 400);
            }
             Restaurant::where('restaurant_id', $request->post('restaurant_id'))
                ->first();
            
            $contact = new Feedback;
            $message = 'Feedback sent successfully';
            
            $contact->restaurant_id = $request->post('restaurant_id');
            $contact->feedback_type = $request->post('feedback_type');
            $contact->name = $request->post('name');
            $contact->email = $request->post('email');
            $contact->phone = $request->post('phone');
           // $contact->feedback_report = $request->post('feedback_report');
            $contact->suggestion = $request->post('suggestion');
            if($contact->save()){
                return response()->json(['message' => $message, 'success' => true], 200);
            }
            return response()->json(['message' => $message, 'success' => true], 200);
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
