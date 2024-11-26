<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use App\Models\Promotion;
use App\Models\Cart;
use App\Models\PromotionCategoryItem;
use Auth;
use Illuminate\Http\Request;

class PromotionController extends Controller
{

    public function index()
    {
        $restaurantId = 1;
        $data['promotions'] = Promotion::where('restaurant_id', 1)
            ->with('promotion_item')
            ->get();
        $data['title'] = 'Promotions';
        $uid = Auth::user()->uid;
        $data['cards'] = getUserCards($restaurantId, $uid);

        return view('customer.promotions.index', $data);
    }

    public function show()
    {
        if (Auth::check()) {
            $data['promotionLists'] = Promotion::where('restaurant_id', getRestaurantId())
                ->with('promotion_item')
                ->get();
            $data['title'] = 'Promotions';
            return view('customer.promotions.show', $data);
        }
    }

    public function applyPromotion($promotionId)
    {
        $promotion = Promotion::where('promotion_id', $promotionId)
            ->with('promotion_item')
            ->first();

        if (!$promotion) {
            abort('404');
        }

        $promotionArray = session()->get('promotion', []);
        $promotionArray = [
            "promotion_id" => $promotion->promotion_id,
            "promotion_code" => $promotion->promotion_code,
            "discount" => $promotion->discount,
            "discount_type" => $promotion->discount_type,
        ];

        session()->put('promotion', $promotionArray);
        return redirect()->route('customer.cart');
    }

    public function getEligibleItems($promotionId)
    {
        if (Auth::check()) {
            $uid = Auth::user()->uid;
            $data['cards'] = getUserCards(getRestaurantId(), $uid);
            $data['cartMenus'] = getCartItem();
            $menuIds = array();
            $quantityArray = array();
            foreach ($data['cartMenus']['cartItems'] as $cartItems) {
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
        $data['cartMenus'] = getCartItem();
        $data['promotion'] = Promotion::where('promotion_id', $promotionId)->first();
        $data['promotionCategoryItems'] = PromotionCategoryItem::with(['category_item' => function ($menuItem) {
            $menuItem->with('modifierList')->get();
        }])->where('promotion_id', $promotionId)->get();

        $data['title'] = 'Promotion Eligible Items';
        return view('customer.promotions.eligible_items', $data);
    }

    public function promotionMenuModifier(Request $request)
    {
        if ($request->ajax()) {
            $menuId = $request->post('menuId');
            $data['promotionId'] = $request->post('promotionId');
            $data['item'] = MenuItem::with('modifierList', 'modifierList.modifier_item')->where('restaurant_id', getRestaurantId())->where('menu_id', $menuId)->first();
            return response()->json(['view' => \View::make('customer.promotions.modifiers', $data)->render()], 200);
        }
    }

    public function promotionMenuAddCart(Request $request)
    {
        if ($request->ajax()) {
            $cart = session()->get('cart', []);
            $menuId = $request->post('menuId');
            $menuItem = MenuItem::where('menu_id', $menuId)->first();
            $promotion = Promotion::where('promotion_id', $request->post('promotionId'))->where('restaurant_id', getRestaurantId())->first();

            $itemPrice = 0;
            if ($promotion->discount_type == config('constants.DISCOUNT_TYPE.USD')) {
                $itemPrice = $menuItem->item_price - $promotion->discount;
            } else {
                $itemPrice = ($menuItem->item_price * $promotion->discount) / 100;
            }

            $modifierGroupIds = array();
            $modifierItemsArray = array();
            if (isset($request->modifierGroupId) && isset($request->modifierItems)) {
                foreach ($request->modifierGroupId as $modifierGroupId) {
                    if (isset($request->modifierItems[$modifierGroupId])) {
                        array_push($modifierGroupIds, $modifierGroupId);
                        $modifierItemsArray = $request->modifierItems;
                    }
                }

                $cart[][$menuId] = [
                    "menu_id" => $menuId,
                    "item_name" => $menuItem->item_name,
                    "quantity" => 1,
                    "item_price" => $itemPrice,
                    "item_img" => $menuItem->getMenuImgAttribute(),
                    "modifier" => $modifierGroupIds,
                    "modifier_item" => $modifierItemsArray,
                ];
            } else {
                $cart[][$menuId] = [
                    "menu_id" => $menuId,
                    "item_name" => $menuItem->item_name,
                    "quantity" => 1,
                    "item_price" => $itemPrice,
                    "item_img" => $menuItem->getMenuImgAttribute(),
                    "modifier" => [],
                    "modifier_item" => [],
                ];
            }
            session()->put('cart', $cart);

            $menuIds = array();
            $quantityArray = array();
            $cartItems = session()->get('cart');
            foreach ($cartItems as $key => $menuItems) {
                foreach ($menuItems as $key => $cartItem) {
                    array_push($menuIds, $key);
                    if (in_array($cartItem['menu_id'], call_user_func_array('array_merge', $quantityArray))) {
                        foreach ($quantityArray as $key => $oldQuantityArray) {
                            if ($oldQuantityArray['menu_id'] == $cartItem['menu_id']) {
                                $quantityArray[$key]['quantity'] += $cartItem['quantity'];
                            }
                        }
                    } else {
                        $quantityArray[] = ['menu_id' => $cartItem['menu_id'], 'quantity' => $cartItem['quantity']];
                    }
                }
            }
            return "Success";
        }

    }
}
