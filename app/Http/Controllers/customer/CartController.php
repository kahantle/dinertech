<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MenuItem;
use App\Models\ModifierGroup;
use App\Models\RestaurantHours;

class CartController extends Controller
{
    public function index()
    {
        $cart =  session()->get('cart', []);
        if(!empty($cart))
        {
            $cartItems = array();
            $modifierdata = array();
            foreach($cart as $cartKey => $menuItems)
            {
                foreach($menuItems as $menu)
                {
                    array_push($cartItems,$menu);
                    $modifierGroupIds = $menu['modifier'];
                    if(!empty($menu['modifier']))
                    {
                        $modifierGroupItems = call_user_func_array('array_merge', $menu['modifier_item']);
                                     
                        $modifierGroups = ModifierGroup::with(['modifier_item' => function($query) use($modifierGroupItems,$modifierGroupIds){
                            $query->whereIn('modifier_item_id',$modifierGroupItems)->whereIn('modifier_group_id',$modifierGroupIds)->get(['modifier_item_id','modifier_group_id','modifier_group_item_name','modifier_group_id','modifier_group_item_price']);
                        }])->whereIn('modifier_group_id',$menu['modifier'])->get(['modifier_group_id','modifier_group_name','restaurant_id']);
                        $modifierItems[$cartKey][$menu['menu_id']] = $modifierGroups->toArray();
                        $data['modifierGroups'] = $modifierItems;
                    }
                    // else
                    // {
                    //     $modifierItems[][$menu['menu_id']] = array();
                    // }
                }
            }
            $data['cartItems'] = $cart;
        }
        else
        {
            $data['cartItems'] = array();
        }
        $data['promotions'] =  session()->get('promotion');
        $data['title'] = 'Cart - Dinertech';
        return view('customer.cart.index',$data);
    }

    public function addToCart(Request $request)
    {
        if($request->ajax())
        {
            $cart = session()->get('cart', []);
            $menuId = $request->menuId;
            $menuName = $request->menuName;
            $categoryId = $request->categoryId;
            $menuItem = MenuItem::where('menu_id',$menuId)->first();
            $modifierGroupIds = array();
            $modifierItemsArray = array();
            if(isset($request->modifierGroupId) && isset($request->modifierItems))
            {
                foreach($request->modifierGroupId as $modifierGroupId)
                {
                    if(isset($request->modifierItems[$modifierGroupId]))
                    {
                        array_push($modifierGroupIds,$modifierGroupId);
                        $modifierItemsArray = $request->modifierItems;
                    }
                }
                $cart[][$menuId] = [
                    "menu_id"  => $menuId,
                    "item_name" => $menuItem->item_name,
                    "quantity" => 1,
                    "item_price"  => $menuItem->item_price,
                    "item_img"    => $menuItem->getMenuImgAttribute(),
                    "modifier" => $modifierGroupIds,
                    "modifier_item" => $modifierItemsArray  
                ];
            }
            else
            {
                $cart[][$menuId] = [
                    "menu_id"  => $menuId,
                    "item_name" => $menuItem->item_name,
                    "quantity" => 1,
                    "item_price"  => $menuItem->item_price,
                    "item_img"    => $menuItem->getMenuImgAttribute(),
                    "modifier" => [],
                    "modifier_item" => []  
                ];
            }
            session()->put('cart', $cart);
            // return count(session()->get('cart', []));
            $menuIds = array();
            $quantityArray = array();
            $cartItems =  session()->get('cart');
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
            $data['menuIds'] = $menuIds;
            $data['quantityArray'] = $quantityArray;
            $restaurantId = session()->get('restaurantId');
            $data['menuItems'] = MenuItem::withcount('modifierList')->where('restaurant_id',$restaurantId)->where('category_id',$categoryId)->where('menu_id',$menuId)->first();
            $data['menuId'] = $menuId;
            $data['menuName'] = $menuName;
            $data['cartCount'] = count($cartItems);
            $data['cartItems'] = $cartItems;
            // $data = ['cartItems' => $cartItems];    
            // return response()->json($data, 200);
            return view('customer.cart.quantityCounter',$data);
        }
    }

    public function removeItem($removeKey,$menuId)
    {
        $cartItems = session()->get('cart');
        
        // foreach ($cartItems as $key => $items) {

            if(isset($cartItems[$removeKey])) {
                unset($cartItems[$removeKey]);
                session()->put('cart', $cartItems);
            }
        // }
        return redirect()->back();
    }

    public function cartAlert(Request $request)
    {
        if($request->ajax())
        {
            $menuId = $request->menuId;
            $cartItems = session()->get('cart');
            $modifierGroupIds = array();
            $modifierGroupItems = array();
            $cartArray = array_column($cartItems,$menuId);
            $data['cartKey'] = key(array_slice($cartItems, -1, 1, true));
           
            // echo "<pre>";
            // print_r($cartArray);
            // die;
            // foreach (end($cartArray) as $key => $menuItems) {
                // foreach($menuItems as $item)
                // {
                    // array_push($modifierGroupIds,$menuItems['modifier']);
                    array_push($modifierGroupIds,end($cartArray)['modifier']);
                    foreach (end($cartArray)['modifier_item'] as $modifierGroup) {
                        foreach ($modifierGroup as $key => $modifieritem) {
                            array_push($modifierGroupItems,$modifieritem);
                        }
                    }
                // }   
            // }
            
            $modifierGroupIds = call_user_func_array('array_merge', $modifierGroupIds);
            $data['menuItem'] = MenuItem::where('menu_id',$menuId)->first();
            $data['modifierGroups'] = ModifierGroup::with(['modifier_item' => function($query) use($modifierGroupItems,$modifierGroupIds){
                $query->whereIn('modifier_item_id',$modifierGroupItems)->whereIn('modifier_group_id',$modifierGroupIds)->get();
            }])->whereIn('modifier_group_id',$modifierGroupIds)->get();
            return view('customer.cart.open_alert',$data);
        }
    }

    public function addToRepeatLast(Request $request)
    {
        if($request->ajax())
        {
            $cartItems = session()->get('cart', []);
            $menuId = $request->menuId;
            $cartKey = $request->cartKey;
            // foreach($cartItems as $key => $items)
            // {
                if(isset($cartItems[$cartKey][$menuId]))
                {
                    $cartItems[$cartKey][$menuId]['quantity']++;
                }
                // break;
            // }
            session()->put('cart', $cartItems);
            return true;
        }
    }

    public function quantityDecrease(Request $request)
    {
        if($request->ajax())
        {
            $cartItems = session()->get('cart', []);
            $menuId = $request->menuId;
            foreach($cartItems as $key => $items)
            {
                if(isset($cartItems[$key][$menuId]))
                {
                    $cartItems[$key][$menuId]['quantity']--;
                }
                // break;
            }
            session()->put('cart', $cartItems);
            return true;
        }
    }

    public function cartCustomize(Request $request)
    {
        if($request->ajax())
        {
             $menuId = $request->menuId;
             $data['menuItem'] = MenuItem::with('modifierList','modifierList.modifier_item')->whereHas('modifierList')->where('menu_id',$menuId)->first();
             $cartItems =  session()->get('cart', []);
             $cartKey = $request->cartKey;
             if(!empty($cartItems))
             {
                // $cartArray = array_column($cartItems[$cartKey],$menuId);
                foreach($cartItems[$cartKey] as $menuItems)
                {
                    // foreach($menuItems as $menu)
                    // {
                        if($menuItems['menu_id'] == $menuId)
                        {
                            $modifierGroupIds = $menuItems['modifier'];
                            $modifierGroupItems = call_user_func_array('array_merge',$menuItems['modifier_item']);
                            // foreach($modifierGroupIds as $key => $modifierGroupId)
                            // {
                            //     $modifierGroupItems = array_column($menuItems['modifier_item'],$modifierGroupId);
                            //     // $modifierGroupItems = $modifieritem;
                            // }
                        }
                    // }
                }
             }
            $data['modifierGroupItems'] = $modifierGroupItems;
            $data['cartKey'] = $request->cartKey;
            return view('customer.cart.customize',$data);
        }
    }

    public function cartCustomizeUpdate(Request $request)
    {
        $cartItems = session()->get('cart', []);
        $menuId = $request->menuId;
        $cartKey = $request->cartKey;
        $modifierGroupIds = array();
        $modifierItemsArray = array();
        foreach($request->modifierGroupId as $modifierGroupId)
        {
            if(isset($request->modifierItems[$modifierGroupId]))
            {
                array_push($modifierGroupIds,$modifierGroupId);
                $modifierItemsArray = $request->modifierItems;
            }
        }
        // foreach($cartItems as $key => $items)
        // {
            if(isset($cartItems[$cartKey][$menuId]))
            {
                $cartItems[$cartKey][$menuId]['modifier'] = $modifierGroupIds;
                $cartItems[$cartKey][$menuId]['modifier_item'] = $modifierItemsArray;
            }
            // break;
        // }
        session()->put('cart', $cartItems);
        return redirect()->back();
        // return "Success";
    }

    public function quantityIncrement(Request $request)
    {
        $cartItems = session()->get('cart', []);
        $menuId = $request->menuId;
        $menuKey = $request->menuKey;
        if(isset($cartItems[$menuKey][$menuId]))
        {
            if($cartItems[$menuKey][$menuId]['quantity'] == 10)
            {
                $cartItems[$menuKey][$menuId]['quantity'] = 10;
            }
            else
            {
                $cartItems[$menuKey][$menuId]['quantity']++;
            }
        }
        session()->put('cart', $cartItems);
        return true;
    }

    public function quantityDecrement(Request $request)
    {
        $cartItems = session()->get('cart', []);
        $menuId = $request->menuId;
        $menuKey = $request->menuKey;
        if(isset($cartItems[$menuKey][$menuId]))
        {
            $cartItems[$menuKey][$menuId]['quantity']--;
            if($cartItems[$menuKey][$menuId]['quantity'] == 0)
            {
                $cartItems[$menuKey][$menuId]['quantity'] = 1;
            }
        }
        session()->put('cart', $cartItems);
        return true;
    }
}
