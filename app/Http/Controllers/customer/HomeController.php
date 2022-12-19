<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\MenuItem;
use App\Models\Order;
use App\Models\Promotion;
use App\Models\User;
use App\Models\Cart;
use Auth;
use Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{

    public function index()
    {
        $restaurantId = 1;
        if (Auth::check()) {
            $uid = Auth::user()->uid;
            $data['cards'] = getUserCards($restaurantId, $uid);
        }
        $promotionLists = Promotion::where('restaurant_id', $restaurantId);
        $data['promotionLists'] = $promotionLists->get();
        $data['categories'] = Category::where('restaurant_id', $restaurantId)->latest()->get();
        $data['search'] = true;
        $data['title'] = 'Customer';
        return view('customer.home', $data);
    }

    public function getMenuItems(Request $request)
    {
        $categoryId = $request->post('categoryId');
        $restaurantId = 1;
        $data['cart'] = $cart = getCart($restaurantId);
        $data['cartMenuItems'] = getCartQty();
        $data['cartMenuItemIds'] = !empty($cart) ? array_column($cart->cartMenuItems->toArray(),'menu_id','cart_menu_item_id') : [];
        $data['category'] = Category::where('restaurant_id', $restaurantId)->where('category_id', $categoryId)->first();
        $data['menuItems'] = MenuItem::with('modifierList')->where('restaurant_id', $restaurantId)->where('category_id', $categoryId)->get();
        return response()->json(['view' => \View::make('customer.menu_item', $data)->render()], 200);
    }

    public function searchMenu(Request $request)
    {
        $searchItem = $request->searchItem;
        $restaurantId = 1;
        $data['cart'] = $cart = getCart($restaurantId);
        $data['cartMenuItemIds'] = !empty($cart) ? array_column($cart->cartMenuItems->toArray(),'menu_id') : [];
        $data['menuItems'] = MenuItem::where('restaurant_id', $restaurantId)->where('item_name', 'like', '%' . $searchItem . '%')->get();
        return response()->json(['view' => \View::make('customer.menu_item', $data)->render()], 200);
    }

    public function getMenumodifier(Request $request)
    {
        $menuId = $request->menuId;
        $restaurantId = 1;
        $data['item'] = MenuItem::with('modifierList', 'modifierList.modifier_item')->where('restaurant_id', $restaurantId)->where('menu_id', $menuId)->first();
        return response()->json(['view' => \View::make('customer.menu_modifier', $data)->render()], 200);
    }

}
