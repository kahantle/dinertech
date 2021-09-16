<?php

namespace App\Http\Controllers\Api\Restaurant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\MenuItem;
use App\Models\Restaurant;
use App\Models\Feedback;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Config;
use Hash;
use DB;

class StockController extends Controller
{

    public function index(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'restaurant_id' => 'required',
                'item_id' => 'required',
                'item_available_type' =>'required'
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()], 400);
            }
            $result = MenuItem::where('menu_id',$request->item_id)->first();
            $result->out_of_stock_type = $request->item_available_type;
            if($request->has('start_date')){
                $result->start_date = $request->start_date;
            }
            if($request->has('end_date')){
                $result->end_date = $request->end_date;
            }
            $result->save();
            return response()->json(['message' => 'Menu update successfully.', 'success' => true], 200);
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
