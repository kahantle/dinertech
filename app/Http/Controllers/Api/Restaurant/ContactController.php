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

class ContactController extends Controller
{

    public function add(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'restaurant_id' => 'required',
                'name' => 'required',
                'subject' => 'required',
                'description' => 'required'
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()], 400);
            }
            $uid = auth('api')->user()->uid;
            $restaurant = Restaurant::where('restaurant_id', $request->post('restaurant_id'))
                ->first();

            $contact = new Contact;
            $message = 'Contact sent successfully';

            $contact->restaurant_id = $request->post('restaurant_id');
            $contact->name = $request->post('name');
            $contact->subject = $request->post('subject');
            $contact->description = $request->post('description');
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
