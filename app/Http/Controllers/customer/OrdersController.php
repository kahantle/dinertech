<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Models\Card;
use App\Models\CustomerAddress;
use App\Models\Order;
use App\Models\OrderMenuGroup;
use App\Models\OrderMenuGroupItem;
use App\Models\OrderMenuItem;
use App\Models\RestaurantUser;
use Auth;
use Cartalyst\Stripe\Stripe;
use Config;
use DB;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function index()
    {
        $uid = Auth::user()->uid;
        $restaurant = RestaurantUser::where('uid', $uid)->first();
        $data['currentOrders'] = Order::with('user')->where('uid', $uid)->where('restaurant_id', $restaurant->restaurant_id)
            ->where('order_progress_status', Config::get('constants.ORDER_STATUS.INITIAL'))
            ->orWhere('order_progress_status', Config::get('constants.ORDER_STATUS.ACCEPTED'))
            ->orderBy('order_date', 'desc')
            ->get();

        $data['pastOrders'] = Order::with('user')->where('uid', $uid)->where('restaurant_id', $restaurant->restaurant_id)
            ->where('order_progress_status', Config::get('constants.ORDER_STATUS.CANCEL'))
            ->orWhere('order_progress_status', Config::get('constants.ORDER_STATUS.COMPLETED'))
            ->orWhere('order_progress_status', Config::get('constants.ORDER_STATUS.PREPARED'))
            ->orderBy('order_date', 'desc')
            ->get();
        $data['cartMenus'] = getCartItem();
        $restaurantId = session()->get('restaurantId');
        $data['cards'] = getUserCards($restaurantId, $uid);
        $data['title'] = 'Orders';
        return view('customer.order.index', $data);
    }

    public function orderDetail($orderId)
    {
        $uid = Auth::user()->uid;
        $restaurantId = session()->get('restaurantId');
        $order = Order::where('restaurant_id', $restaurantId)
            ->where('order_id', $orderId)
            ->with(['orderItems' => function ($query) use ($orderId) {
                $query->with('menuItems')->where('order_id', $orderId);
            }])
            ->first();
        if (empty($order)) {
            abort('404');
        }
        $data['order'] = $order;
        $orderMenuGroups = OrderMenuGroup::with('orderMenuGroupItem')->where('order_id', $orderId)->get();
        $groupIteamArray = [];
        foreach ($orderMenuGroups as $modifierGroup) {
            foreach ($modifierGroup->orderMenuGroupItem as $groupIteam) {
                $groupIteamArray[$groupIteam->menu_id][$modifierGroup->order_modifier_group_id][] = $groupIteam->modifier_group_item_name;
            }
        }

        $data['groupIteamArray'] = $groupIteamArray;
        $data['orderMenuGroups'] = $orderMenuGroups;
        $data['cards'] = getUserCards($restaurantId, $uid);
        $data['cartMenus'] = getCartItem();
        $data['title'] = 'Order Detail';
        return view('customer.order.detail', $data);
    }

    public function submitToOrder(Request $request)
    {
        if (!isset($request->order_status)) {
            return redirect()->back()->with('error', 'Please Select Order Timing.');
        }
        $orderArray = ['order_status' => $request->order_status, 'menu_item' => json_decode(base64_decode($request->menuItem)), 'instruction' => $request->instruction, 'cart_charge' => $request->cart_charge, 'sales_tax' => $request->sales_tax, 'discount_charge' => $request->discount_charge, 'orderDate' => $request->orderDate, 'orderTime' => $request->orderTime, 'grand_total' => $request->grand_total];
        session()->put('orderDetails', $orderArray);
        $orderDetails = session()->get('orderDetails');
        $uid = Auth::user()->uid;
        $restaurantId = session()->get('restaurantId');
        $card = Card::where('card_id', $request->card_id)->where('uid', $uid)->where('restaurant_id', $restaurantId)->first();

        $this->placeOrder($orderDetails, $card);
        // $data['title'] = 'Payment Methods - Dinertech';
        // return view('customer.order.payment_method', $data);
    }

    public function convertNumberFormat($amount)
    {
        return number_format($amount, '2');
    }

    public function placeOrder(Request $request)
    {
        if (!isset($request->order_status)) {
            return redirect()->back()->with('error', 'Please Select Order Timing.');
        }
        $orderDetails = ['order_status' => $request->order_status, 'menu_item' => json_decode(base64_decode($request->menuItem)), 'instruction' => $request->instruction, 'cart_charge' => $request->cart_charge, 'sales_tax' => $request->sales_tax, 'discount_charge' => $request->discount_charge, 'orderDate' => $request->orderDate, 'orderTime' => $request->orderTime, 'grand_total' => $request->grand_total];
        // session()->put('orderDetails', $orderArray);
        // $orderDetails = session()->get('orderDetails');
        $uid = Auth::user()->uid;
        $restaurantId = session()->get('restaurantId');

        $address = CustomerAddress::where('uid', $uid)->first();
        if ($address) {
            $addressId = $address->customer_address_id;
        } else {
            $addressId = null;
        }

        if ($request->paymentType == 'card') {
            $card = Card::where('card_id', $request->card_id)->where('uid', $uid)->where('restaurant_id', $restaurantId)->first();

            $cardExp = explode('/', $card->card_expire_date);
            $cardId = $card->card_id;

            try {

                $stripe = Stripe::make(env('STRIPE_SECRET'));

                $cardExp = explode('/', $card->card_expire_date);

                $token = $stripe->tokens()->create([
                    'card' => [
                        'number' => $card->card_number,
                        'exp_month' => $cardExp[0],
                        'exp_year' => $cardExp[1],
                        'cvc' => $card->card_cvv,
                    ],
                ]);

                if (!isset($token['id'])) {
                    return redirect()->back()->with('error', 'Invalid card details please try again.');
                }

                $charge = $stripe->charges()->create([
                    'source' => $token['id'],
                    'currency' => 'USD',
                    'amount' => $orderDetails['grand_total'],
                    'description' => random_int(1000, 1000000000000000),
                ]);

                if ($charge['status'] == 'succeeded') {
                    DB::beginTransaction();
                    $order = new Order;
                    $order->uid = $uid;
                    $order->restaurant_id = $restaurantId;
                    $order->order_number = random_int(1000, 1000000000000000);
                    $order->payment_card_id = $cardId;
                    $order->isCash = Config::get('constants.ORDER_TYPE.CARD');
                    $order->stripe_payment_id = $charge['created'];
                    $order->cart_charge = $orderDetails['cart_charge'];
                    $order->delivery_charge = '0.00';
                    $order->discount_charge = $orderDetails['discount_charge'];
                    $order->is_feature = ($orderDetails['order_status'] == 1) ? 1 : 0;
                    $order->order_status = null;
                    $order->order_progress_status = Config::get('constants.ORDER_STATUS.INITIAL');
                    $order->address_id = $addressId;

                    if ($orderDetails['order_status'] == 1) {
                        $order->order_date = date('Y-m-d');
                        $order->order_time = date('h:m:A');
                        $order->feature_date = date("Y-m-d", strtotime($orderDetails['orderDate']));
                        $order->feature_time = date("h:m:A", strtotime($orderDetails['orderTime']));
                    } else {
                        $order->order_date = date('Y-m-d');
                        $order->order_time = date('h:m:A');
                        $order->feature_date = null;
                        $order->feature_time = null;
                    }

                    $order->action_time = date('Y-m-d m:i:s');
                    $order->isPickUp = 0;
                    $order->comments = (empty($orderDetails['instruction'])) ? '' : $orderDetails['instruction'];
                    $order->grand_total = $this->convertNumberFormat($orderDetails['grand_total']);
                    $order->order_progress_status = Config::get('constants.ORDER_STATUS.INITIAL');
                    if ($order->save()) {
                        foreach ($orderDetails['menu_item'] as $key => $menuItem) {
                            $menuItemData = new OrderMenuItem;
                            $menuItemData->menu_id = $menuItem->menu_id;
                            $menuItemData->menu_name = $menuItem->menu_name;
                            $menuItemData->menu_total = $menuItem->menu_total;
                            $menuItemData->menu_qty = $menuItem->menu_qty;
                            $menuItemData->menu_total = $menuItem->menu_total;
                            $menuItemData->modifier_total = $menuItem->modifier_total;
                            $menuItemData->order_id = $order->order_id;
                            if ($menuItemData->save()) {
                                if (isset($menuItem->modifier_list)) {
                                    foreach ($menuItem->modifier_list as $modifierGroupKey => $modifierGroup) {
                                        $menuModifier = new OrderMenuGroup;
                                        $menuModifier->modifier_group_id = $modifierGroup->modifier_group_id;
                                        $menuModifier->modifier_group_name = $modifierGroup->modifier_group_name;
                                        $menuModifier->order_menu_item_id = $menuItemData->order_menu_item_id;
                                        $menuModifier->menu_id = $menuItem->menu_id;
                                        $menuModifier->order_id = $order->order_id;
                                        if ($menuModifier->save()) {
                                            if ($menuModifier->menu_id == $menuItem->menu_id) {
                                                foreach ($modifierGroup->modifier_item as $modierMenuKey => $modierMenu) {

                                                    $menuModifierMenu = new OrderMenuGroupItem;
                                                    $menuModifierMenu->order_menu_item_id = $menuItemData->order_menu_item_id;
                                                    $menuModifierMenu->order_modifier_group_id = $menuModifier->order_modifier_group_id;
                                                    $menuModifierMenu->modifier_item_id = $modierMenu->modifier_item_id;
                                                    $menuModifierMenu->modifier_group_id = $modierMenu->modifier_group_id;
                                                    $menuModifierMenu->menu_id = $menuItem->menu_id;
                                                    $menuModifierMenu->order_id = $order->order_id;
                                                    $menuModifierMenu->modifier_group_item_name = $modierMenu->modifier_group_item_name;
                                                    $menuModifierMenu->modifier_group_item_price = $modierMenu->modifier_group_item_price;
                                                    $menuModifierMenu->save();
                                                }
                                            }
                                        } else {
                                            DB::rollBack();
                                            return redirect()->back()->with('error', 'Order does not added successfully.');
                                        }
                                    }
                                }
                            } else {
                                DB::rollBack();
                                return redirect()->back()->with('error', 'Order does not added successfully.');
                            }
                        }
                        DB::commit();
                        session()->forget('cart');
                        session()->forget('promotion');
                        session()->forget('orderDetails');
                        $data['title'] = 'Success Order';
                        $data['cartMenus'] = getCartItem();
                        $data['cards'] = getUserCards($restaurantId, $uid);

                        return view('customer.order.success', $data);
                    } else {
                        DB::rollBack();
                        return redirect()->back()->with('error', 'Order does not added successfully.');
                    }
                } else {
                    DB::rollBack();
                    return redirect()->back()->with('error', Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS'));
                }
            } catch (\Throwable $th) {
                DB::rollBack();
                return redirect()->back()->with('error', $th->getMessage());
            }
        } else {
            try {

                DB::beginTransaction();
                $order = new Order;
                $order->uid = $uid;
                $order->restaurant_id = $restaurantId;
                $order->order_number = random_int(1000, 1000000000000000);
                $order->cart_charge = $orderDetails['cart_charge'];
                $order->delivery_charge = '0.00';
                $order->isCash = Config::get('constants.ORDER_TYPE.CASH');
                $order->discount_charge = $orderDetails['discount_charge'];
                $order->is_feature = ($orderDetails['order_status'] == 1) ? 1 : 0;
                $order->order_status = null;
                $order->order_progress_status = Config::get('constants.ORDER_STATUS.INITIAL');
                $order->address_id = $addressId;

                if ($orderDetails['order_status'] == 1) {
                    $order->order_date = date('Y-m-d');
                    $order->order_time = date('h:m:A');
                    $order->feature_date = date("Y-m-d", strtotime($orderDetails['orderDate']));
                    $order->feature_time = date("h:m:A", strtotime($orderDetails['orderTime']));
                } else {
                    $order->order_date = date('Y-m-d');
                    $order->order_time = date('h:m:A');
                    $order->feature_date = null;
                    $order->feature_time = null;
                }

                $order->action_time = date('Y-m-d m:i:s');
                $order->isPickUp = 0;
                $order->comments = (empty($orderDetails['instruction'])) ? '' : $orderDetails['instruction'];
                $order->grand_total = $this->convertNumberFormat($orderDetails['grand_total']);
                $order->order_progress_status = Config::get('constants.ORDER_STATUS.INITIAL');
                if ($order->save()) {
                    foreach ($orderDetails['menu_item'] as $key => $menuItem) {
                        $menuItemData = new OrderMenuItem;
                        $menuItemData->menu_id = $menuItem->menu_id;
                        $menuItemData->menu_name = $menuItem->menu_name;
                        $menuItemData->menu_total = $menuItem->menu_total;
                        $menuItemData->menu_qty = $menuItem->menu_qty;
                        $menuItemData->menu_total = $menuItem->menu_total;
                        $menuItemData->modifier_total = $menuItem->modifier_total;
                        $menuItemData->order_id = $order->order_id;
                        if ($menuItemData->save()) {
                            if (isset($menuItem->modifier_list)) {
                                foreach ($menuItem->modifier_list as $modifierGroupKey => $modifierGroup) {
                                    $menuModifier = new OrderMenuGroup;
                                    $menuModifier->modifier_group_id = $modifierGroup->modifier_group_id;
                                    $menuModifier->modifier_group_name = $modifierGroup->modifier_group_name;
                                    $menuModifier->order_menu_item_id = $menuItemData->order_menu_item_id;
                                    $menuModifier->menu_id = $menuItem->menu_id;
                                    $menuModifier->order_id = $order->order_id;
                                    if ($menuModifier->save()) {
                                        if ($menuModifier->menu_id == $menuItem->menu_id) {
                                            foreach ($modifierGroup->modifier_item as $modierMenuKey => $modierMenu) {

                                                $menuModifierMenu = new OrderMenuGroupItem;
                                                $menuModifierMenu->order_menu_item_id = $menuItemData->order_menu_item_id;
                                                $menuModifierMenu->order_modifier_group_id = $menuModifier->order_modifier_group_id;
                                                $menuModifierMenu->modifier_item_id = $modierMenu->modifier_item_id;
                                                $menuModifierMenu->modifier_group_id = $modierMenu->modifier_group_id;
                                                $menuModifierMenu->menu_id = $menuItem->menu_id;
                                                $menuModifierMenu->order_id = $order->order_id;
                                                $menuModifierMenu->modifier_group_item_name = $modierMenu->modifier_group_item_name;
                                                $menuModifierMenu->modifier_group_item_price = $modierMenu->modifier_group_item_price;
                                                $menuModifierMenu->save();
                                            }
                                        }
                                    } else {
                                        DB::rollBack();
                                        return redirect()->back()->with('error', 'Order does not added successfully.');
                                    }
                                }
                            }
                        } else {
                            DB::rollBack();
                            return redirect()->back()->with('error', 'Order does not added successfully.');
                        }
                    }
                    DB::commit();
                    session()->forget('cart');
                    session()->forget('promotion');
                    session()->forget('orderDetails');
                    $data['title'] = 'Success Order';
                    $data['cartMenus'] = getCartItem();
                    $data['cards'] = getUserCards($restaurantId, $uid);

                    return view('customer.order.success', $data);
                } else {
                    DB::rollBack();
                    return redirect()->back()->with('error', 'Order does not added successfully.');
                }

            } catch (\Throwable $th) {
                DB::rollBack();
                return redirect()->back()->with('error', $th->getMessage());
            }

        }
    }
}
