<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ModifierGroupRequest;
use App\Http\Requests\ModifierItemPriceRequest;
use App\Models\ModifierGroup;
use App\Models\Restaurant;
use App\Models\ModifierGroupItem;
use Illuminate\Routing\AbstractRouteCollection;
use Config;
use Auth;
use Toastr;

class MenuModifierController extends Controller
{
	public function addMenuModifierGroup(ModifierGroupRequest $request)
	{
		try {
			$uid = Auth::user()->uid;
			$restaurant = Restaurant::where('uid', $uid)->first();
			if (!$restaurant) {
				$errors['success'] = false;
				$errors['message'] = Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS');
				return response()->json($errors, 500);
			}
			if($request->modifier_group_id){
				$modifier = ModifierGroup::where('modifier_group_id',$request->modifier_group_id)->first();
				$message = 'Group update successfully.';
			}else{
				$modifier = new  ModifierGroup;
				$message = 'Group added successfully.';
			}
			$modifier->restaurant_id = $restaurant->restaurant_id;
			$modifier->modifier_group_name = $request->post('modifier_group_name');
			$modifier->allow_multiple = ($request->allow_multiple)?1:0;
			$modifier->save();
			$alert = [$message,'', Config::get('constants.toster')];
			$modifiers = ModifierGroup::where('restaurant_id', $restaurant->restaurant_id)->get();
			$returnHTML = view('menu.modifier-ajax')->with(['modifiers' => $modifiers])->render();
			return response()->json(array('success' => true,'modifier_group_id'=>$modifier->modifier_group_id,'modifier_group_name'=>$modifier->modifier_group_name,'alert' =>$alert, 'html' => $returnHTML));
		} catch (\Throwable $th) {
			$errors['success'] = false;
			$errors['message'] = Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS');
			return response()->json($errors, 500);
		}
	}

	public function editMenuModifierGroup(Request $request)
	{
		try {
			$result = ModifierGroup::where('modifier_group_id', $request->id)->first();
			return response()->json(['data' => $result, 'success' => true], 200);
		} catch (\Throwable $th) {
			$errors['success'] = false;
			$errors['message'] = Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS');
			return response()->json($errors, 500);
		}
	}

	public function deleteGroup(Request $request){
		try {
			$uid = Auth::user()->uid;
			$restaurant = Restaurant::where('uid', $uid)->first();
			$alert =['Group delete successfully','', Config::get('constants.toster')];
			ModifierGroupItem::where('modifier_group_id', $request->id)->delete();
			ModifierGroup::where('modifier_group_id', $request->id)->delete();

			$modifiers = ModifierGroup::where('restaurant_id', $restaurant->restaurant_id)->get();
			$returnHTML = view('menu.modifier-ajax')->with(['modifiers' => $modifiers])->render();
			return response()->json(array('success' => true,'alert' =>$alert, 'html' => $returnHTML));
		} catch (\Throwable $th) {
			$errors['success'] = false;
			$errors['message'] = Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS');
			return response()->json($errors, 500);
		}
	}

	public function addMenuModifierGroupItem(ModifierItemPriceRequest $request)
	{
		try {
			$uid = Auth::user()->uid;
			$restaurant = Restaurant::where('uid', $uid)->first();
			if (!$restaurant) {
				$errors['success'] = false;
				$errors['message'] = Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS');
				return response()->json($errors, 500);
			}
			if($request->post('modifier_item_id')){
				$modifierItem = ModifierGroupItem::where('modifier_item_id',$request->post('modifier_item_id'))->first();
				$message = 'Group item updated successfully.';
			}else{
				$modifierItem = new  ModifierGroupItem;
				$message = 'Group item added successfully.';
			}
			$modifierItem->restaurant_id = $restaurant->restaurant_id;
			$modifierItem->modifier_group_id = $request->post('modifier_item_group_id');
			$modifierItem->modifier_group_item_name = $request->post('modifier_group_item_name');
			$modifierItem->modifier_group_item_price = $request->post('modifier_group_item_price');
			$modifierItem->save();
			$alert = [$message,'', Config::get('constants.toster')];
			$modifiers = ModifierGroup::where('restaurant_id', $restaurant->restaurant_id)->get();
			$returnHTML = view('menu.modifier-ajax')->with(['modifiers' => $modifiers])->render();
			return response()->json(array('success' => true,'alert' =>$alert, 'html' => $returnHTML));
		} catch (\Throwable $th) {
			$errors['success'] = false;
			$errors['message'] = Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS');
			return response()->json($errors, 500);
		}
	}

	public function editMenuModifierItem(Request $request)
	{
		try {
			$modifierItem = ModifierGroupItem::where('modifier_item_id', $request->id)->first();
			return response()->json(['data' => $modifierItem, 'success' => true], 200);
		} catch (\Throwable $th) {
			$errors['success'] = false;
			$errors['message'] = Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS');
			return response()->json($errors, 500);
		}
	}

	public function deleteItem(Request $request){
		try {
			$uid = Auth::user()->uid;
			$restaurant = Restaurant::where('uid', $uid)->first();
			ModifierGroupItem::where('modifier_item_id', $request->id)->delete();
			$alert =['Group item delete successfully','', Config::get('constants.toster')];
			$modifiers = ModifierGroup::where('restaurant_id', $restaurant->restaurant_id)->get();
			$returnHTML = view('menu.modifier-ajax')->with(['modifiers' => $modifiers])->render();
			return response()->json(array('success' => true,'alert' =>$alert, 'html' => $returnHTML));
		} catch (\Throwable $th) {
			$errors['success'] = false;
			$errors['message'] = Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS');
			return response()->json($errors, 500);
		}
	}

	public function GetModifierList(Request $request){
		try {
			$uid = Auth::user()->uid;
			$restaurant = Restaurant::where('uid', $uid)->first();
			$modifiers = ModifierGroup::where('restaurant_id', $restaurant->restaurant_id)->get();
			$returnHTML = view('menu.modifier-ajax')->with(['modifiers' => $modifiers])->render();
			return response()->json(array('success' => true,'modifiers'=>$modifiers, 'html' => $returnHTML));
		} catch (\Throwable $th) {
			return $th;
			$errors['success'] = false;
			$errors['message'] = Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS');
			return response()->json($errors, 500);
		}
	}
}
