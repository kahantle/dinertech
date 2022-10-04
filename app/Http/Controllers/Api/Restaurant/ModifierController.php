<?php

namespace App\Http\Controllers\Api\Restaurant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\ModifierGroup;
use App\Models\ModifierGroupItem;
use App\Models\Restaurant;
use Config;

class ModifierController extends Controller
{

    public function addModifierGroup(Request $request)
    {
        // return $request->all();
        try {
            $request_data = $request->json()->all();
            $validator = Validator::make($request_data, [
                'restaurant_id' => 'required',
                'modifier_group_name'=>'required|unique:modifier_groups,modifier_group_name,NULL,modifier_group_id,restaurant_id,'.$request->post('restaurant_id').'',
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()], 400);
            }
            $modifier = new  ModifierGroup;
            $modifier->restaurant_id = $request->post('restaurant_id');
            $modifier->modifier_group_name = $request->post('modifier_group_name');
            $modifier->save();
            return response()->json(['message' => "Modifier added successfully.", 'success' => true, 'modifier_group_id' => $modifier->modifier_group_id ], 200);
        } catch (\Throwable $th) {
            $errors['success'] = false;
            $errors['message'] = Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS');
            if ($request->debug_mode == 'ON') {
                $errors['debug'] = $th->getMessage();
            }
            return response()->json($errors, 500);
        }
    }


    public function editModifierGroup(Request $request)
    {
        try {
            $request_data = $request->json()->all();
            $validator = Validator::make($request_data, [
                'restaurant_id' => 'required',
                'modifier_group_id' => 'required',
                'modifier_group_name'=>'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()], 400);
            }
            $modifier =  ModifierGroup::where('modifier_group_id',$request->post('modifier_group_id'))->first();
            if($modifier){
                $modifier->restaurant_id = $request->post('restaurant_id');
                $modifier->modifier_group_name = $request->post('modifier_group_name');
                $modifier->save();
                return response()->json(['message' => "Modifier update successfully.", 'success' => true], 200);
            }
            return response()->json(['message' => "Invalid Modifier id.", 'success' => true], 200);
        } catch (\Throwable $th) {
            $errors['success'] = false;
            $errors['message'] = Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS');
            if ($request->debug_mode == 'ON') {
                $errors['debug'] = $th->getMessage();
            }
            return response()->json($errors, 500);
        }
    }


    public function addModifierGroupItem(Request $request)
    {
        try {
            $request_data = $request->json()->all();
            $validator = Validator::make($request_data, [
                'restaurant_id' => 'required',
                'modifier_group_item_name'=>'required|unique:modifier_groups_items,modifier_group_item_name,'.$request->post('modifier_group_id').',modifier_group_id,restaurant_id,'.$request->post('restaurant_id').'',
                'modifier_group_item_price' => 'required'
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()], 400);
            }
            $category = new  ModifierGroupItem;
            $category->restaurant_id = $request->post('restaurant_id');
            $category->modifier_group_id = $request->post('modifier_group_id');
            $category->modifier_group_item_name = $request->post('modifier_group_item_name');
            $category->modifier_group_item_price = $request->post('modifier_group_item_price');
            $category->save();
            return response()->json(['message' => "Modifier item added successfully.", 'success' => true], 200);
        } catch (\Throwable $th) {
            $errors['success'] = false;
            $errors['message'] = Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS');
            if ($request->debug_mode == 'ON') {
                $errors['debug'] = $th->getMessage();
            }
            return response()->json($errors, 500);
        }
    }


    public function editModifierGroupItem(Request $request)
    {
        try {
            $request_data = $request->json()->all();
            $validator = Validator::make($request_data, [
                'restaurant_id' => 'required',
                'modifier_group_id' =>'required',
                'modifier_item_id' => 'required',
                'modifier_group_item_name'=>'required',
                'modifier_group_item_price' => 'required'
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()], 400);
            }

            $modifier = ModifierGroupItem::where('modifier_item_id',$request->post('modifier_item_id'))->first();
            if($modifier){
                $modifier->restaurant_id = $request->post('restaurant_id');
                $modifier->modifier_group_id = $request->post('modifier_group_id');
                $modifier->modifier_group_item_name = $request->post('modifier_group_item_name');
                $modifier->modifier_group_item_price = $request->post('modifier_group_item_price');
                $modifier->save();
                return response()->json(['message' => "Modifier item update successfully.", 'success' => true], 200);
            }
            return response()->json(['message' => "Invalid Modifier id.", 'success' => true], 200);
        } catch (\Throwable $th) {
            $errors['success'] = false;
            $errors['message'] = Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS');
            if ($request->debug_mode == 'ON') {
                $errors['debug'] = $th->getMessage();
            }
            return response()->json($errors, 500);
        }
    }

    /**
     * @method Modifier List
     *
     */

    public function getModifierList(Request $request)
    {
        try {
            $request_data = $request->json()->all();
            $validator = Validator::make($request_data, ['restaurant_id' => 'required']);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()], 400);
            }
            $categoryList = ModifierGroup::where('restaurant_id', $request->post('restaurant_id'))
                ->with('modifier_item')
                ->get(['modifier_group_id','restaurant_id','modifier_group_name']);
            return response()->json(['modifier_list' => $categoryList, 'success' => true], 200);
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
                'modifier_group_id' => 'required'
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()], 400);
            }
            ModifierGroupItem::where('modifier_group_id', $request->post('modifier_group_id'))->delete();
            ModifierGroup::where('modifier_group_id', $request->post('modifier_group_id'))->delete();
            return response()->json(['message'=> "Modifier delete successfully.",'success' => true], 200);
        } catch (\Throwable $th) {
            $errors['success'] = false;
            $errors['message'] = Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS');
            if ($request->debug_mode == 'ON') {
                $errors['debug'] = $th->getMessage();
            }
            return response()->json($errors, 500);
        }
    }


    public function deleteItem(Request $request)
    {

        try {
            $request_data = $request->json()->all();
            $validator = Validator::make($request_data, [
                'modifier_group_id' => 'required',
                'restaurant_id' => 'required',
                'modifier_item_id' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()], 400);
            }
            ModifierGroupItem::where('modifier_group_id', $request->post('modifier_group_id'))
            ->where('modifier_item_id', $request->post('modifier_item_id'))
            ->delete();
            return response()->json(['message'=> "Modifier Item delete successfully.",'success' => true], 200);
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
