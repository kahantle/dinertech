<?php

namespace App\Http\Controllers\Api\Restaurant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\MenuItem;
use App\Models\Restaurant;
use App\Models\MenuModifierItem;
use App\Models\ModifierGroup;
use App\Models\PromotionCategoryItem;
use Carbon\Carbon;
use Config;
use Hash;
use DB;

class MenuItemController extends Controller
{

    public function addMenuItem(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'restaurant_id' => 'required',
                // 'modifier_id' => 'required',
                'item_name' => 'required',
                'item_details' => 'required',
                'category_id' => 'required',
                'item_price' => 'required'
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()], 400);
            }
            if($request->post('menu_id')){
                $data = MenuItem::where('menu_id',$request->post('menu_id'))->first();
                if(!$data){
                    return response()->json(['message' => "Menu id not correct.", 'success' => true], 200);
                }
                $data->restaurant_id = $request->post('restaurant_id');
                $data->item_name = $request->post('item_name');
                $data->item_details = $request->post('item_details');
                $data->category_id = $request->post('category_id');
                $data->item_price = $request->post('item_price');
                if ($request->hasFile('item_img')) {
                    $image = $request->file('item_img');
                    $save_name = $data->item_name.'.'.$image->getClientOriginalExtension();
                    $image->storeAs(Config::get('constants.IMAGES.MENU_IMAGE_PATH'), $save_name);
                    $data->item_img = $save_name;
                }
                if($data->save()){
                    //  MenuModifierItem::where('modifier_id',$request->post('modifier_id'))->delete();
                    MenuModifierItem::where('menu_id',$data->menu_id)->delete();
                    $menu = new  MenuModifierItem;
                    $menuRow =array();
                    $modifiers = explode(",",$request->post('modifier_id'));
                    if(is_array($modifiers)){
                        foreach ($modifiers as $key => $value) {
                            $checkModiefier = ModifierGroup::where('modifier_group_id',$value)->first();
                            if($checkModiefier){
                                $menuRow[$key]['menu_id'] = $data->menu_id;
                               $menuRow[$key]['modifier_id'] = $value;
                            }
                        }
                     }
                    if($menu->insert($menuRow)){
                        return response()->json(['message' => "Menu updated successfully.", 'success' => true], 200);
                    }
                }
            }else{
                $data = new MenuItem;
                $data->restaurant_id = $request->post('restaurant_id');
                $data->item_name = $request->post('item_name');
                $data->item_details = $request->post('item_details');
                $data->category_id = $request->post('category_id');
                $data->item_price = $request->post('item_price');
                if ($request->hasFile('item_img')) {
                    $image = $request->file('item_img');
                    $save_name = $data->item_name.'.'.$image->getClientOriginalExtension();
                    $image->storeAs(Config::get('constants.IMAGES.MENU_IMAGE_PATH'), $save_name);
                    $data->item_img = $save_name;
                }
                if($data->save()){
                    $menu = new  MenuModifierItem;
                    $menuRow =array();
                    $modifiers = explode(",",$request->post('modifier_id'));
                    if(is_array($modifiers)){
                        foreach ($modifiers as $key => $value) {
                            $checkModiefier = ModifierGroup::where('modifier_group_id',$value)->first();
                            if($checkModiefier){
                                $menuRow[$key]['menu_id'] = $data->menu_id;
                               $menuRow[$key]['modifier_id'] = $value;
                            }
                        }
                     }
                    if($menu->insert($menuRow)){
                        return response()->json(['message' => "Menu added successfully.", 'success' => true], 200);
                    }
                }
                return response()->json(['message' => "Menu does not added successfully.", 'success' => true], 200);
            }
        } catch (\Throwable $th) {
            $errors['success'] = false;
            $errors['message'] = Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS');
            if ($request->debug_mode == 'ON') {
                $errors['debug'] = $th->getMessage();
            }
            return response()->json($errors, 500);
        }
    }


    public function getMenuList(Request $request)
    {
        try {
            $request_data = $request->json()->all();
            $validator = Validator::make($request_data, ['restaurant_id' => 'required']);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()],400);
            }
            $restaurantId = $request->post('restaurant_id');
            $categoryList = MenuItem::where('restaurant_id', $request->post('restaurant_id'))
                ->with(['modifierList'])
                ->whereHas('category')
                // ->where('modifierList',function($query)use($restaurantId){
                //     $query->where('restaurant_id',$restaurantId);
                // })
                ->get(['menu_id',
                     'restaurant_id',
                      'category_id',
                      'out_of_stock_type',
                      'item_name',
                      'item_details',
                      'item_price',
                      'start_date',
                      'end_date',
                      'item_img'])
                ->makeHidden('category');

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

    public function getMenuListByCategory(Request $request)
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
                'menu_id' => 'required'
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()], 400);
            }
            MenuItem::where('menu_id', $request->post('menu_id'))->delete();
            PromotionCategoryItem::where('item_id',$request->post('menu_id'))->delete();
            return response()->json(['message'=> "Menu delete successfully.",'success' => true], 200);
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
