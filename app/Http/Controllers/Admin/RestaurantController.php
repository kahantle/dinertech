<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Restaurant;
use App\Models\RestaurantUser;
use App\Models\Category;
use App\Models\MenuItem;
use App\Models\MenuModifierItem;
use App\Models\ModifierGroup;
use App\Models\Order;
use App\Http\Requests\Admin\RestaurantRequest;
use Config;
use Auth;

class RestaurantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['restaurants'] = User::with('restaurant')->where('role',Config::get('constants.ROLES.RESTAURANT'))->latest()->paginate(12);
        $data['title'] = 'Restaurants';
        return view('admin.restaurant.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($restaurantId)
    {
        $data['categories'] = Category::where('restaurant_id',$restaurantId)->latest()->get();
        $data['modifierGroups'] = ModifierGroup::where('restaurant_id',$restaurantId)->latest()->get();
        $data['restaurantId'] = $restaurantId;
        $data['restaurant'] = Restaurant::find($restaurantId);
        $data['title'] = 'Add Menu';
        return view('admin.restaurant.add_menu',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $request->validate([
            'category' => 'required',
            'menu_img' => 'required|mimes:jpeg,png',
            'item_name' => 'required',
            'item_price' => 'required',
            'item_details' => 'required',
            // 'modifier.*'   => 'required'
        ]);

        $menu = new MenuItem;
        $menu->restaurant_id = $request->post('restaurant_id');
        $menu->category_id = $request->post('category');
        if ($request->hasFile('menu_img')) 
        {
            $image = $request->file('menu_img');
            $save_name =  $request->post('item_name').'.'.$image->getClientOriginalExtension();
            $image->storeAs(Config::get('constants.IMAGES.MENU_IMAGE_PATH'), $save_name);
            $menu->item_img = $save_name;
        }

        if($request->post('date'))
        {
            $date = explode(' ',$request->post('date'));
            $menu->start_date = $date[0];
            $menu->end_date = $date[2];
        }
        $menu->item_name = $request->post('item_name');
        $menu->item_price = $request->post('item_price');
        $menu->item_details = $request->post('item_details');
        $menu->out_of_stock_type = $request->post('stockType');
        if($menu->save())
        {
            $menuModifiers = $request->post('modifier');
            if($menuModifiers)
            {
                foreach($menuModifiers as $value)
                {
                    $menuModifierItem = new MenuModifierItem;
                    $menuModifierItem->menu_id = $menu->menu_id;
                    $menuModifierItem->modifier_id = $value;
                    $menuModifierItem->save();
                }
            }
            return redirect()->route('admin.restaurants.manage_menu',$request->post('restaurant_id'));
        }
        return back()->with('error','Some Error in add menu.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function manageMenu($restaurantId)
    {
        $restaurant = Restaurant::where('restaurant_id',$restaurantId)->first();
        if(!$restaurant)
        {
            abort('404');
        }
        $data['restaurant'] = $restaurant;
        $data['categories'] = Category::where('restaurant_id',$restaurantId)->get();
        $data['title'] = 'Manage Menu';
        return view('admin.restaurant.manage_menu',$data);
    }

    public function categoryMenu(Request $request)
    {
        if($request->ajax())
        {
            $categoryId = $request->categoryId;
            $data['category'] = Category::where('category_id',$categoryId)->first();
            $data['menuItems'] = MenuItem::where('category_id',$categoryId)->get();
            return view('admin.restaurant.get_menu', $data)->render();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($menuId)
    {
        $menu = MenuItem::with(['modifiers','restaurant'])->where('menu_id',$menuId)->first();
        $data['modifierIds'] = array_column($menu->modifiers->toArray(),'modifier_id');
        $data['categories'] = Category::where('restaurant_id',$menu->restaurant_id)->latest()->get();
        $data['modifierGroups'] = ModifierGroup::where('restaurant_id',$menu->restaurant_id)->latest()->get();
        $data['menuItem'] = $menu;
        $data['title'] = 'Edit Menu';
        return view('admin.restaurant.edit_menu',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'category' => 'required',
            'menu_img' => 'mimes:jpeg,png',
            'item_name' => 'required',
            'item_price' => 'required',
            'item_details' => 'required',
            // 'modifier.*'   => 'required'
        ]);


        $menu = MenuItem::find($request->post('menuId'));
        $menu->restaurant_id = $request->post('restaurant_id');
        $menu->category_id = $request->post('category');
        if ($request->hasFile('menu_img')) {
            $image = $request->file('menu_img');
            $save_name =  $request->post('item_name').'.'.$image->getClientOriginalExtension();
            $image->storeAs(Config::get('constants.IMAGES.MENU_IMAGE_PATH'), $save_name);
            $menu->item_img = $save_name;
        }
        
        if($request->post('date'))
        {
            $date = explode(' ',$request->post('date'));
            $menu->start_date = $date[0];
            $menu->end_date = $date[2];
        }
        else
        {
            $menu->start_date = null;
            $menu->end_date = null;
        }
        $menu->item_name = $request->post('item_name');
        $menu->item_price = $request->post('item_price');
        $menu->item_details = $request->post('item_details');
        $menu->out_of_stock_type = $request->post('stockType');
        if($menu->save())
        {
            $menuModifiers = $request->post('modifier');
            if($menuModifiers)
            {
                MenuModifierItem::where('menu_id',$request->post('menuId'))->delete();
                foreach($menuModifiers as $value)
                {
                    $menuModifierItem = new MenuModifierItem;
                    $menuModifierItem->menu_id = $request->post('menuId');
                    $menuModifierItem->modifier_id = $value;
                    $menuModifierItem->save();
                }
            }
            return redirect()->route('admin.restaurants.manage_menu',$request->post('restaurant_id'));
        }
        return back()->with('error','Some Error in update menu.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function menuDetail($menuId)
    {
        $menuDetail = MenuItem::with(['restaurant','category'])->where('menu_id',$menuId)->first();
        if(!$menuDetail)
        {
            abort('404');
        }
        $data['title'] = $menuDetail->item_name;
        $data['menuItem'] = $menuDetail;
        return view('admin.restaurant.menu_detail',$data);
    }

    public function menuChangeType(Request $request)
    {
        $menuId = $request->menuId;
        $type = trim($request->type);
        if($request->ajax())
        {   
            $menu = MenuItem::find($menuId);
            $menu->start_date = null;
            $menu->end_date = null;
            $menu->out_of_stock_type = $type;
            if($menu->save())
            {
                return true;
            }
        }
        else
        {
            $menu = MenuItem::find($menuId);
            $menu->start_date = $request->start_date;
            $menu->end_date = $request->end_date;
            $menu->out_of_stock_type = $type;
            if($menu->save())
            {
                return redirect()->route('admin.restaurants.menu.detail',$menuId);
            }
        }
    }

    public function restaurantEdit($userId)
    {
        $restaurant = User::with('restaurant')->where('uid',$userId)->first();
        if(!$restaurant)
        {
            abort('404');
        }
        $data['activeUsers'] = Order::with(['user','address'])->where('restaurant_id',$restaurant->restaurant->restaurant_id)->orderBy('order_id','desc')->groupBy('uid')->paginate(3);
        $data['title'] = $restaurant->restaurant->restaurant_name;
        $data['restaurant'] = $restaurant;
        return view('admin.restaurant.edit_restaurant',$data);
    }

    public function updateDetail(RestaurantRequest $request,$uid)
    {
        $user = User::find($uid);
        $user->mobile_number = $request->mobile_number;
        $user->email_id = $request->email_id;

        if ($request->hasFile('restaurant_image')) {
            $image = $request->file('restaurant_image');
            $save_name =  $request->post('restaurant_name').'.'.$image->getClientOriginalExtension();
            $image->storeAs(Config::get('constants.IMAGES.RESTAURANT_USER_IMAGE_PATH'), $save_name);
            $user->profile_image = $save_name;
        }
        $user->save();

        $restaurantId = $request->restaurantId;
        $restaurant = Restaurant::find($restaurantId);
        $restaurant->restaurant_name = $request->post('restaurant_name');
        $restaurant->restaurant_address = $request->post('restaurant_address');
        $restaurant->save();
        
        return redirect()->back()->with('success','Detail Update Successfully.');
    }

    public function ResDashboard($restaurantName = null,$restaurantId = null)
    {
        if(Auth::guard('web')->loginUsingId($restaurantId))
        {
            return redirect()->route('dashboard');
        }
    }
}
