<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MenuItem;
use App\Http\Requests\MenuItemRequest;
use App\Models\Restaurant;
use App\Models\Category;
use App\Models\ModifierGroup;
use App\Models\MenuModifierItem;
use App\Models\PromotionCategoryItem;
use Config;
use Toastr;
use DB;
use Auth;
use Storage;

class MenuController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth:web');
        // $this->middleware(function ($request, $next) {
        //     $this->id = Auth::user()->uid;
        //     $this->global = "some value";
        // });
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request){
        $uid = Auth::user()->uid;
        $restaurant = Restaurant::where('uid', $uid)->first();
        $menu = MenuItem::where('restaurant_id', $restaurant->restaurant_id);
        $params = $request->get('searchText');
        if($params){
            $menu = $menu->where('item_name', 'like', '%' . $params . '%');
            $menu = $menu->orWhere('item_details', 'like', '%' . $params . '%');
        }
        $menu = $menu->whereHas('category')->paginate(Config::get('constants.PAGINATION_PER_PAGE'));
        return view('menu.index',compact('menu','params'));
    }

    public function add(){
        $uid = Auth::user()->uid;
        $restaurant = Restaurant::where('uid', $uid)->first();
        $categories = Category::where('restaurant_id', $restaurant->restaurant_id)->get();
        $modifiers = ModifierGroup::where('restaurant_id', $restaurant->restaurant_id)->get();
        return view('menu.add',compact('categories','modifiers'));
    }

    public function edit(Request $request)
    {
        $uid = Auth::user()->uid;
        $restaurant = Restaurant::where('uid', $uid)->first();
        $categories = Category::where('restaurant_id', $restaurant->restaurant_id)->get();
        $menuItem = MenuItem::where('menu_id', $request->id)->with('modifiers')->first();
        $modifiers = ModifierGroup::where('restaurant_id', $restaurant->restaurant_id)->get();
        return view('menu.edit',compact('menuItem','categories','modifiers'));
    }


    public function store(MenuItemRequest $request)
    {
        try {
            $uid = Auth::user()->uid;
            $restaurant = Restaurant::where('uid', $uid)->first();
            if (!$restaurant) {
                return redirect()->route('modifier')->with('error', 'Invalid users for this restaurant.');
            }
            $removeDollarSign = explode(" ",$request->post('item_price'));
            $menu = new  MenuItem;
            $menu->restaurant_id = $restaurant->restaurant_id;
            $menu->category_id = $request->post('category_id');
            $menu->item_name = $request->post('item_name');
            $menu->item_details = ($request->post('item_details'))? $request->post('item_details') : null;
            $menu->item_price = (int)$removeDollarSign[1];
            if ($request->hasFile('item_img')) {
                $image = $request->file('item_img');
                $save_name =  $request->post('item_name') ."_".$restaurant->restaurant_id. '.' . $image->getClientOriginalExtension();
                $image->storeAs(Config::get('constants.IMAGES.MENU_IMAGE_PATH'), $save_name);
                $menu->item_img = $save_name;
            }
            if($menu->save()){
                $menu_modifier_item = new  MenuModifierItem;
                $menuRow =array();
                $modifiers = $request->post('modifier_group_id');
                if(is_array($modifiers)){
                    foreach ($modifiers as $key => $value) {
                        $checkModiefier = ModifierGroup::where('modifier_group_id',$value)->first();
                        if($checkModiefier){
                           $menuRow[$key]['menu_id'] = $menu->menu_id;
                           $menuRow[$key]['modifier_id'] = $value;
                        }
                    }
                 }
                if($menu_modifier_item->insert($menuRow)){
                    Toastr::success('Menu item added successfully','', Config::get('constants.toster'));
                    return redirect()->route('menu');
                }
            }
        } catch (\Throwable $th) {
            return($th);
            return redirect()->route('menu')->with('error', Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS'));
        }
    }


    public function delete($id)
    {
       try {
            $alert =['Menu does not delete successfully','', Config::get('constants.toster')];
            $category = MenuItem::where('menu_id', $id)->first();
            if($category){
                $category->delete();
                PromotionCategoryItem::where('item_id',$id)->delete();
                $alert =['Menu delete successfully','', Config::get('constants.toster')];
            }
            return response()->json(['route'=>route('menu'),'alert'=>$alert,'success' => true], 200);
        }catch (\Throwable $th) {
            $errors['success'] = false;
            $errors['message'] = Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS');
            return response()->json($errors, 500);
        }
    }

    public function update(MenuItemRequest $request)
    {
        $menu_id  = MenuItem::findOrFail($request->hidden_id);
        $uid = Auth::user()->uid;
        $restaurant = Restaurant::where('uid', $uid)->first();
        if (!$restaurant) {
            return redirect()->route('menu')->with('error', 'Invalid users for this restaurant.');
        }
        $removeDollarSign = explode(" ",$request->post('item_price'));
        $menu_id->category_id = $request->post('category_id');
        $menu_id->item_name = $request->post('item_name');
        $menu_id->item_details = $request->post('item_details');
        $menu_id->item_price = (int)$removeDollarSign[1];
        if ($request->hasFile('item_img')) {
            $image = $request->file('item_img');
            $save_name =  $request->post('item_name') ."_".$restaurant->restaurant_id. '.' . $image->getClientOriginalExtension();
            $image->storeAs(Config::get('constants.IMAGES.MENU_IMAGE_PATH'), $save_name);
            $menu_id->item_img = $save_name;
        }
        if ($menu_id->save()) {
            MenuModifierItem::where('menu_id',$menu_id->menu_id)->delete();
            $menu_modifier_item = new  MenuModifierItem;
            $menuRow =array();
            $modifiers = $request->post('modifier_group_id');
            if(is_array($modifiers)){
                foreach ($modifiers as $key => $value) {
                    $checkModiefier = ModifierGroup::where('modifier_group_id',$value)->first();
                    if($checkModiefier){
                       $menuRow[$key]['menu_id'] = $menu_id->menu_id;
                       $menuRow[$key]['modifier_id'] = $value;
                    }
                }
             }
            if($menu_modifier_item->insert($menuRow)){
                Toastr::success('Menu item update successfully','', Config::get('constants.toster'));
                return redirect()->route('menu');
            }
        } else {
            Toastr::success('Menu item does not update successfully.','', Config::get('constants.toster'));
            return redirect()->route('menu');
        }
    }

    public function removeMenuImage(Request $request) {
         $menuItem  = MenuItem::findOrFail($request->post('menuId'));
         if($menuItem->item_img) {
            Storage::delete(Config::get('constants.IMAGES.MENU_IMAGE_PATH').'/'.$menuItem->item_img);
            $menuItem->item_img = null;
            $menuItem->save();
            return response()->json(['alert' => 'Photo remove successfully.']);
         } else {
            return response()->json(['error' => 'Photo does not remove successfully.']);
         }
    }

    public function storeStockUntil(Request $request)
    {
        $selectedType = $request->selectedType;
        $menuId = $request->menuId;
        $start = $request->start;
        $end = $request->end;

        if($selectedType === 'rest_of_day'){
            $out_of_stock_type = 'Rest Of Day';
        } else if  ($selectedType === 'indefinitely') {
            $out_of_stock_type = 'Indefinitely';
        } else if  ($selectedType === 'custom_date') {
            $out_of_stock_type = 'Custom Date';
        } else {
            $out_of_stock_type = 'Available';
        };

        $menuData = MenuItem::where('menu_id', $menuId)->first();
        if(!empty($menuData)){

            if($out_of_stock_type === 'Custom Date'){
                $data = array(
                    'out_of_stock_type' => $out_of_stock_type,
                    'start_date' => $start,
                    'end_date' => $end,
                );

                $modalclose = 'customDateModal';
            } else {
                $data = array(
                    'out_of_stock_type' => $out_of_stock_type,
                    'start_date' => NULL,
                    'end_date' => NULL,
                );

                $modalclose = 'outOfStockModal';
            }

            MenuItem::where('menu_id', $menuId)->update($data);
            return response()->json(['type' => true, 'message' => 'Stock Update Successfulluy', 'modalclose' => $modalclose ]);
        }

    }
}
