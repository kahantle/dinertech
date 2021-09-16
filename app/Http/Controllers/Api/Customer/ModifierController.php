<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\MenuItem;
use Config;

class ModifierController extends Controller
{

    public function getModifierList(Request $request)
    {
        try {
            $request_data = $request->json()->all();
            $validator = Validator::make($request_data, ['restaurant_id' => 'required', 'menu_id' => 'required']);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()], 400);
            }
            $menuList = MenuItem::where('restaurant_id', $request->post('restaurant_id'))
                ->where('menu_id', $request->post('menu_id'))
                ->with('modifierList','modifierList.modifier_item')
                ->whereHas('modifierList')
                ->first();
            return response()->json(['modifier_list' => ($menuList && $menuList->modifierList)?$menuList->modifierList:[], 'success' => true], 200);
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
