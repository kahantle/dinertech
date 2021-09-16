<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Restaurant;
use App\Models\RestaurantUser;
use App\Models\MenuItem;
use Auth;

class HomeController extends Controller
{
    public function index(Request $request)
    {   
        // \Cache::forget('cart');
        if(Auth::check())
        {
            $uid = Auth::user()->uid;
            // $restaurantId = RestaurantUser::where('uid',$uid)->first();
            $restaurantId = session()->get('restaurantId');
            $data['categories'] = Category::where('restaurant_id',$restaurantId)->get();
        }
        else
        {
            $restaurantId = 1;
            session()->put('restaurantId', $restaurantId);
            $data['categories'] = Category::where('restaurant_id',$restaurantId)->get();
        }

        $menuIds = array();
        $quantityArray = array();
        if(session()->get('cart', []))
        {
            $cartItems =  session()->get('cart', []);
            foreach($cartItems as $key => $menuItems)
            {
               foreach($menuItems as $key => $cartItem)
               {
                    array_push($menuIds,$key);
                    if(in_array($cartItem['menu_id'],call_user_func_array('array_merge',$quantityArray)))
                    {
                        foreach($quantityArray as $key => $oldQuantityArray)
                        {
                            if($oldQuantityArray['menu_id'] == $cartItem['menu_id'])
                            {
                                $quantityArray[$key]['quantity'] += $cartItem['quantity'];
                            }
                        }
                    }
                    else
                    {
                        $quantityArray[] = ['menu_id' => $cartItem['menu_id'],'quantity' => $cartItem['quantity']];
                    }
               }
            }
        }
        

        if($request->ajax())
        {
            $categoryId = $request->categoryId;
            $restaurantId = $request->restaurantId;
            $data['menuItems'] = MenuItem::with('modifierList')->where('restaurant_id',$restaurantId)->where('category_id',$categoryId)->get();
            $data['quantityArray'] = $quantityArray;
            $data['menuIds'] = $menuIds;
            return view('customer.menu_item',$data)->render();
        }
        else
        {
            if(Auth::check())
            {
                $uid = Auth::user()->uid;
                $restaurantId = RestaurantUser::where('uid',$uid)->first();
                $restaurantId = $restaurantId->restaurant_id;
            }
            $categoryId = Category::where('restaurant_id',$restaurantId)->first();
            $data['menuItems'] = MenuItem::with('modifierList')->where('restaurant_id',$restaurantId)->where('category_id',$categoryId->category_id)->get();
        }

        $data['quantityArray'] = $quantityArray;
        $data['menuIds'] = $menuIds;
        $data['title'] = 'Customer - Dinertech';
        return view('customer.home',$data);
    }

    // public function getItems(Request $request)
    // {
    //     if($request->ajax())
    //     {
    //         $categoryId = $request->categoryId;
    //         $restaurantId = $request->restaurantId;
    //         $data['menuItems'] = MenuItem::where('restaurant_id',$restaurantId)->where('category_id',$categoryId)->get();
    //         return view('customer.menu_item',$data);
    //     }
    // }

    public function getMenumodifier(Request $request)
    {
        if($request->ajax())
        {
             $menuId = $request->menuId;
             $data['menuItem'] = MenuItem::with('modifierList','modifierList.modifier_item')->whereHas('modifierList')->where('menu_id',$menuId)->first();
             return view('customer.menu_modifier',$data);
        }
    }

    public function searchMenu(Request $request)
    {
        if($request->ajax())
        {
            $searchItem = $request->searchItem;
            $restaurantId = session()->get('restaurantId');
            $data['menuItems'] = MenuItem::with('modifierList')->join('categories','categories.category_id','=','menu_items.category_id')->where('menu_items.restaurant_id',$restaurantId)->where('menu_items.item_name','like','%'.$searchItem.'%')->get();
            return view('customer.search_item',$data);
        }
    }
}
