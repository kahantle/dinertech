<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\MenuItem;
use App\Models\Order;
use App\Models\Promotion;
use App\Models\User;
use Auth;
use Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{

    public function index(Request $request)
    {

        \Cache::forget('cart');
        session()->put('restaurantId', 47);
        $restaurantId = session()->get('restaurantId');
        if (Auth::check()) {
            $uid = Auth::user()->uid;
            $data['cards'] = getUserCards($restaurantId, $uid);
            $data['cartMenus'] = getCartItem();
            $promotionLists = Promotion::where('restaurant_id', $restaurantId);
            $orders = Order::where('uid', $uid)->where('restaurant_id', $restaurantId)->get();
            if (!empty($orders)) {
                if ($orders->count() > 1) {
                    $promotionLists = $promotionLists->OrWhere('client_type', Config::get('constants.PROMOTION_STATUS.OneOrder'));
                } elseif ($orders->count() == 0) {
                    $promotionLists = $promotionLists->OrWhere('client_type', Config::get('constants.PROMOTION_STATUS.NewClient'));
                }
            }
            $data['promotionLists'] = $promotionLists->get();
        } else {
            $data['promotionLists'] = Promotion::where('restaurant_id', $restaurantId)->get();
        }
        $data['categories'] = Category::where('restaurant_id', $restaurantId)->latest()->get();
        $data['search'] = true;
        $data['title'] = 'Customer';
        return view('customer.home', $data);
    }

    public function getMenuItems(Request $request)
    {
        if ($request->ajax()) {
            $categoryId = $request->post('categoryId');
            $restaurantId = session()->get('restaurantId');
            if (\Auth::check()) {
                $data['cartMenus'] = getCartItem();
                $menuIds = array();
                $quantityArray = array();
                foreach ($data['cartMenus']['cartItems'] as $cartKey => $cartItems) {
                    foreach ($cartItems as $menuId => $item) {
                        array_push($menuIds, $menuId);
                        if (in_array($item['menu_id'], call_user_func_array('array_merge', $quantityArray))) {
                            foreach ($quantityArray as $key => $oldQuantityArray) {
                                if ($oldQuantityArray['menu_id'] == $item['menu_id']) {
                                    $quantityArray[$key]['quantity'] += $item['quantity'];
                                }
                            }
                        } else {
                            $quantityArray[] = ['menu_id' => $item['menu_id'], 'quantity' => $item['quantity']];
                        }
                    }
                }
                $data['menuIds'] = $menuIds;
                $data['quantities'] = $quantityArray;
            } else {
                $data['menuIds'] = array();
            }

            $data['category'] = Category::where('restaurant_id', $restaurantId)->where('category_id', $categoryId)->first();
            $data['menuItems'] = MenuItem::with('modifierList')->where('restaurant_id', $restaurantId)->where('category_id', $categoryId)->get();
            return response()->json(['view' => \View::make('customer.menu_item', $data)->render()], 200);
        }
    }

    public function getMenumodifier(Request $request)
    {
        if ($request->ajax()) {
            $menuId = $request->menuId;
            $restaurantId = session()->get('restaurantId');
            $data['item'] = MenuItem::with('modifierList', 'modifierList.modifier_item')->where('restaurant_id', $restaurantId)->where('menu_id', $menuId)->first();
            return response()->json(['view' => \View::make('customer.menu_modifier', $data)->render()], 200);
        }
    }

    public function searchMenu(Request $request)
    {
        if ($request->ajax()) {
            $searchItem = $request->searchItem;
            $restaurantId = session()->get('restaurantId');
            $data['menuItems'] = MenuItem::with('modifierList')->join('categories', 'categories.category_id', '=', 'menu_items.category_id')->where('menu_items.restaurant_id', $restaurantId)->where('menu_items.item_name', 'like', '%' . $searchItem . '%')->get();
            $data['cartMenus'] = getCartItem();
            $menuIds = array();
            $quantityArray = array();
            foreach ($data['cartMenus']['cartItems'] as $cartKey => $cartItems) {
                foreach ($cartItems as $menuId => $item) {
                    array_push($menuIds, $menuId);
                    if (in_array($item['menu_id'], call_user_func_array('array_merge', $quantityArray))) {
                        foreach ($quantityArray as $key => $oldQuantityArray) {
                            if ($oldQuantityArray['menu_id'] == $item['menu_id']) {
                                $quantityArray[$key]['quantity'] += $item['quantity'];
                            }
                        }
                    } else {
                        $quantityArray[] = ['menu_id' => $item['menu_id'], 'quantity' => $item['quantity']];
                    }
                }
            }
            $data['menuIds'] = $menuIds;
            $data['quantities'] = $quantityArray;

            return response()->json(['view' => \View::make('customer.search_item', $data)->render()], 200);
        }
    }

    public function setSystemTime(Request $request)
    {
        if ($request->ajax()) {
            session()->put('sys_timezone', $request->get('sys_timezone'));
        }
    }
}
