<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\MenuItem;
use App\Models\Restaurant;
use Carbon\Carbon;
use Config;
use Hash;
use DB;

class MenuItemController extends Controller
{
    public function getMenuList(Request $request)
    {


        try {
            $request_data = $request->json()->all();
            $validator = Validator::make($request_data, ['restaurant_id' => 'required', 'category_id' => 'required']);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()], 400);
            }

            $categoryList = MenuItem::where('restaurant_id', $request->post('restaurant_id'))
                ->where('category_id', $request->post('category_id'))
                ->with('modifierList')
                ->get(['menu_id',  'restaurant_id', 'category_id','item_name', 'item_details', 'item_price', 'item_img']);

            return response()->json(['menu_list' => $categoryList, 'success' => true], 200);

        }


        catch (\Throwable $th) {
            $errors['success'] = false;
            $errors['message'] = Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS');
            if ($request->debug_mode == 'ON') {
                $errors['debug'] = $th->getMessage();
            }
            return response()->json($errors, 500);
        }

    }

    public function searchMenu(Request $request)
    {
        try {
            $request_data = $request->json()->all();
            $validator = Validator::make($request_data, ['restaurant_id' => 'required']);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()], 400);
            }
            if(empty($request->post('search_value')))
            {
                $categoryList = array();
            }
            else
            {
                $categoryList = MenuItem::join('categories', 'categories.category_id', '=', 'menu_items.category_id')->where('menu_items.restaurant_id', $request->post('restaurant_id'))
                // ->where('category_id', $request->post('category_id'))
                ->where('menu_items.item_name','like','%'.$request->post('search_value').'%')
                ->with(['modifierList'])
                ->select('menu_items.menu_id',  'menu_items.restaurant_id', 'menu_items.category_id','menu_items.item_name', 'menu_items.item_details', 'menu_items.item_price', 'menu_items.item_img')
                ->get();

            }

            return response()->json(['menu_list' => $categoryList, 'success' => true], 200);
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
