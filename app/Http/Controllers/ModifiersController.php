<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ModifierGroupRequest;
use App\Http\Requests\ModifierItemPriceRequest;
use App\Models\ModifierGroup;
use App\Models\Restaurant;
use App\Models\ModifierGroupItem;
use App\Models\User;
use Config;
use Auth;
use Toastr;
use Session;

class ModifiersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
        */
        public function index()
        {
            $uid = Auth::user()->uid;
            $restaurant = Restaurant::where('uid', $uid)->first();
            $modifiers = ModifierGroup::where('restaurant_id', $restaurant->restaurant_id)
            ->with('modifier_item_custome')
            ->paginate(Config::get('constants.PAGINATION_PER_PAGE'));

            $user = User::where('uid', $uid)->first();
            $pinscreen = $user->pin_notifications === 'true';
            if ($pinscreen) {
                $is_verified = Session::get('is_menu_pin_verify');
                if ($is_verified) {
                    Session::put('is_menu_pin_verify', '');
                    return view('modifiers.index',compact('modifiers'));
                }

                $redirect_url = route('modifier');
                return view('account.menu_verify',compact('redirect_url'));
            }

            return view('modifiers.index',compact('modifiers'));
        }


    public function addModifierGroup(ModifierGroupRequest $request)
    {
        try {
            $uid = Auth::user()->uid;
            $restaurant = Restaurant::where('uid', $uid)->first();
            if (!$restaurant) {
                return redirect()->route('modifier')->with('error', 'Invalid users for this restaurant.');
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
            $modifier->is_required = ($request->is_required) ? 1 : 0;
            $modifier->allow_multiple = ($request->allow_multiple == Config::get('constants.MODIFIER_TYPE.MULTIPLE_MODIFIER')) ? 1 : 0;
            // $modifier->allow_multiple = ($request->allow_multiple)?1:0;
            // $modifier->minimum = $request->post('minimum');
            // $modifier->maximum = $request->post('maximum');
            $modifier->save();
            Toastr::success($message,'', Config::get('constants.toster'));
            return redirect()->route('modifier');
        } catch (\Throwable $th) {
            Toastr::error($th->getMessage(),'', Config::get('constants.toster'));
            return redirect()->route('modifier');
        }
    }


    public function addModifierGroupItem(ModifierItemPriceRequest $request)
    {
        try {
            $uid = Auth::user()->uid;
            $restaurant = Restaurant::where('uid', $uid)->first();
            if (!$restaurant) {
                return redirect()->route('modifier')->with('error', 'Invalid users for this restaurant.');
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
            Toastr::success($message,'', Config::get('constants.toster'));
            return redirect()->route('modifier');
        } catch (\Throwable $th) {
            return redirect()->route('modifier')->with('error', Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS'));
        }
    }

    /**
     * @method Modifier List
     *
     */

    public function editModifierItem(Request $request)
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

    public function editModifierGroup(Request $request)
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

    public function deleteItem(Request $request){
        try {
            ModifierGroupItem::where('modifier_item_id', $request->id)->delete();
            $alert =['Group delete successfully','', Config::get('constants.toster')];
            return response()->json(['route'=>route('modifier'),'alert'=>$alert,'success' => true], 200);
        } catch (\Throwable $th) {
            $errors['success'] = false;
            $errors['message'] = Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS');
            return response()->json($errors, 500);
        }
    }

    public function deleteGroup(Request $request){
        try {
            $alert =['Group delete successfully','', Config::get('constants.toster')];
            ModifierGroupItem::where('modifier_group_id', $request->id)->delete();
            ModifierGroup::where('modifier_group_id', $request->id)->delete();
            Session::put('is_menu_pin_verify', 1);
            return response()->json(['route'=>route('modifier'),'alert'=>$alert,'success' => true], 200);
        } catch (\Throwable $th) {
            $errors['success'] = false;
            $errors['message'] = Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS');
            return response()->json($errors, 500);
        }
    }

    // Add/Edit  New
    public function storeModifierGroup(Request $request)
    {
        try {
            $uid = Auth::user()->uid;
            $restaurant = Restaurant::where('uid', $uid)->first();
            if (!$restaurant) {
                return response()->json(['type' =>'error', 'message' => 'Invalid users for this restaurant.']);
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
            $modifier->is_required = $request->is_required;
            $modifier->allow_multiple = ($request->allow_multiple == Config::get('constants.MODIFIER_TYPE.MULTIPLE_MODIFIER')) ? 1 : 0;

            if ($request->allow_multiple === 'SINGLE') { 
                // $modifier->minimum = 0;
                // $modifier->maximum = 0;
                $modifier->type = 0;
            } else {
                // $modifier->minimum = $request->post('minimum');
                // $modifier->maximum = $request->post('maximum');
                $modifier->type = 1;
            }
            $modifier->save();

            $modifier_group_id = $modifier->modifier_group_id;

            return response()->json(['type' =>'success', 'message' => $message, 'modifier_group_id' => $modifier_group_id]);
        } catch (\Throwable $th) {
            dd($th);
            // Toastr::error($th->getMessage(),'', Config::get('constants.toster'));
            // return redirect()->route('modifier');
        }
    }

    public function editModifierGroupNew(Request $request)
    {
        $modifier_group_id = $request->id;

        /* Get Modifier Group Item Count*/
        $ModifierGroupItem = ModifierGroupItem::where('modifier_group_id', $modifier_group_id)->count();

        $checkModifierGroup = ModifierGroup::where('modifier_group_id', $modifier_group_id)->first();
        if (empty($checkModifierGroup)) {
            return response()->json(['type'=>'fail', 'message' => 'Record Not Found']);
        }
        $checkModifierGroup['ModifierGroupItemCount'] = $ModifierGroupItem;
        Session::put('is_menu_pin_verify', 1);
        return response()->json(['type'=>'success', 'message' => 'Record Found Successfully', 'data' => $checkModifierGroup]);
    }

    public function addModifierGroupItemNew(Request $request)
    {
        try {
            $btnType = $request->btnType;
            $uid = Auth::user()->uid;
            $restaurant = Restaurant::where('uid', $uid)->first();
            if (!$restaurant) {
                return response()->json(['type' =>'error', 'message' => 'Invalid users for this restaurant.']);
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

            Session::put('is_menu_pin_verify', 1);
            return response()->json(['type' =>'success', 'message' => $message, 'btnType' => $btnType, 'modifier_group_id' => $request->post('modifier_item_group_id')]);
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    public function editModifierItemNew(Request $request)
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

    public function deleteItemNew(Request $request){

        try {
            ModifierGroupItem::where('modifier_item_id', $request->id)->delete();
            $alert =['Group delete successfully','', Config::get('constants.toster')];
            Session::put('is_menu_pin_verify', 1);
            return response()->json(['route'=>route('modifier'),'alert'=>$alert,'success' => true], 200);
        } catch (\Throwable $th) {
            $errors['success'] = false;
            $errors['message'] = Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS');
            return response()->json($errors, 500);
        }
    }

    public function storeModifierSequence(Request $request)
    {
        foreach ($request->data as $key => $value) {
            $modifier_item_id = $value['modifier_item_id'];
            $sequence = $value['sequence'];
            ModifierGroupItem::where('modifier_item_id', $modifier_item_id)->update(['sequence'=>$sequence]);
        }

        return response()->json(['type' => true, 'success' => 'modifier update successfully'], 200);
    }
}
