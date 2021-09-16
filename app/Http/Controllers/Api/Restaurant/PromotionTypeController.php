<?php

namespace App\Http\Controllers\Api\Restaurant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\PromotionType;
use Config;

class PromotionTypeController extends Controller
{

    public function getRecords(Request $request)
    {   
        try {    
            $request_data = $request->json()->all();
                $validator = Validator::make($request_data, []);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()], 400);
            }
            $promotion_type = PromotionType::get(['promotion_type_id','promotion_name', 'promotion_details', 'promotion_icon', 'status']);
            return response()->json(['promotion_type' => $promotion_type, 'success' => true], 200);
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
