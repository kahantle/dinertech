<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Models\Card;
use App\Models\Cart;
use App\Models\CartMenuGroup;
use App\Models\CustomerAddress;
use App\Models\Order;
use App\Models\Loyalty;
use App\Models\LoyaltyCategory;
use App\Models\MenuItem;
use App\Models\OrderMenuGroup;
use App\Models\OrderMenuGroupItem;
use App\Models\OrderMenuItem;
use App\Models\RestaurantHours;
use App\Models\RestaurantUser;
use App\Models\User;
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
        $restaurantId = session()->get('restaurantId');
        $data['tip1'] = $restaurant ? $restaurant->tip1 : 0.0;
        $data['tip2'] = $restaurant ? $restaurant->tip2 : 0.0;
        $data['tip3'] = $restaurant ? $restaurant->tip3 : 0.0;
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

    public function emptyCart()
    {
        $cart = Cart::where('uid', auth()->id())->first();
        $cartMenuItem = $cart->cartMenuItems;
        $modifier_items = $cart->cartMenuModifierItems->where('cart_id',$cart->cart_id);
        $modifier_groups = CartMenuGroup::where('cart_id',$cart->cart_id)->get();

        // if (count($modifier_groups) > 0) {
        //     foreach ($modifier_items as $key => $item) {
        //         $item->delete();
        //     }

        //     foreach ($modifier_groups as $key => $group) {
        //         $group->delete();
        //     }
        // }

        foreach ($cartMenuItem as $item) {
            $item->delete();
        }

        $cart = Cart::where('uid', auth()->id())->first();
        count($cart->cartMenuItems) == 0 ? $cart->delete() : '';
    }

    public function placeOrder(Request $request)
    {
        if (!isset($request->order_status)) {
            return redirect()->back()->with('error', 'Please Select Order Timing.');
        }

        //Restaurant Open or Not
        $restaurantdays  = RestaurantHours::where('restaurant_id',1)->get();
        // dd($request);

        $testDay  = [];
        if($request->post("orderDate")){
            $givenDate = $request->post("orderDate"); // "26-02-2025"; // Example: dd-mm-yyyy format
            $dateObject = \DateTime::createFromFormat('j/n/Y', $givenDate);

            $currentday = lcfirst($dateObject->format('l')); 
        }else{
            $currentday=lcfirst(date('l'));
        }
        // dd($currentday);
        foreach($restaurantdays as $day) {
            $testDay[]= $day->day == $currentday;
        }

        $restaurantday  = RestaurantHours::with('allTimes')->where('restaurant_id',1)->get();
        $testResult  = [];
        // dd($testDay);
        if($request->post("orderTime")){
            $request->order_status = '1';
            $dateTime = \DateTime::createFromFormat('h:i A', $request->post("orderTime"));
            // dd($dateTime);

            $openTime = $dateTime->format('H:i A');
        }else{
            $openTime = date('H:i A', time());
        }
        // dd($openTime);
        if (in_array(true,$testDay)) {
            // dd($restaurantday);
            foreach($restaurantday as $restaurantdayTime){
                foreach($restaurantdayTime->allTimes as $time){
                    $openingtime =date('H:i A', strtotime($time->opening_time));
                    $closingtime =date('H:i A', strtotime($time->closing_time));
                    $testResult[] = $openingtime <= $openTime &&  $openTime <= $closingtime;
                }
            }
        }
        // dd($testResult);
        //testresult false to in if condiftion
        if (!in_array(true,$testResult)) {
            return redirect()->back()->with('error', 'Oops! Betty Burger is not open for orders at the time selected. Please select another time');
        }
        //Restaurant Open close code over
        $orderDetails = ['order_status' => $request->order_status, 'menu_item' => json_decode(base64_decode($request->menuItem)), 'instruction' => $request->instruction, 'cart_charge' => $request->cart_charge, 'sales_tax' => $request->sales_tax, 'discount_charge' => $request->discount_charge, 'orderDate' => $request->orderDate, 'orderTime' => $request->orderTime, 'grand_total' => $request->grand_total];

        $uid = Auth::user()->uid;
        $restaurantId = 1;


        $userPoint = auth()->user()->total_points;
        $loyalty = Loyalty::where('status',Config::get('constants.STATUS.ACTIVE'))->where('restaurant_id',$restaurantId)->first();
        if($loyalty){
            if($loyalty->loyalty_type == Config::get('constants.LOYALTY_TYPE.NO_OF_ORDERS')){
                $getOrderIds = Order::where('uid',$uid)->where('order_progress_status',Config::get('constants.ORDER_STATUS.COMPLETED'))->where('point_count',Config::get('constants.ORDER_POINT_COUNT.NO'))->limit($loyalty->no_of_orders)->get()->pluck('order_id');
                if(count($getOrderIds) == $loyalty->no_of_orders){
                    $totalPoint = $userPoint + $loyalty->point;
                    User::where('uid',$uid)->update(['total_points' => $totalPoint]);
                    Order::whereIn('order_id',$getOrderIds)->update(['point_count' => Config::get('constants.ORDER_POINT_COUNT.YES')]);
                }
            }else if($loyalty->loyalty_type == Config::get('constants.LOYALTY_TYPE.AMOUNT_SPENT')){
                $grandTotal =(float)$request->cart_charge;
                $loyaltypoint=(float)$loyalty->amount;
                if($grandTotal > $loyaltypoint){
                    $totalPoint = $userPoint + $loyalty->point;
                    User::where('uid',$uid)->update(['total_points' => $totalPoint]);
                }

            }else if($loyalty->loyalty_type == Config::get('constants.LOYALTY_TYPE.CATEGORY_BASED')){
                $loyaltyCategories = LoyaltyCategory::where('loyalty_id',$loyalty->loyalty_id)->where('restaurant_id',$restaurantId)->get()->pluck('category_id')->toArray();
                foreach ($orderDetails['menu_item'] as $key => $menuItem) {
                    $category_menu = MenuItem::where('menu_id',$menuItem->menu_id)->first();
                    $addPoint = false;
                    if($category_menu && in_array($category_menu->category_id,$loyaltyCategories)){
                        $addPoint = true;
                        break;
                    }
                }
                if($addPoint == true){
                    $totalPoint = $userPoint + $loyalty->point;
                    User::where('uid',$uid)->update(['total_points' => $totalPoint]);
                }

            }else{

            }
        }
        // dd($loyalty);
        $address = CustomerAddress::where('uid', $uid)->first();
        if ($address) {
            $addressId = $address->customer_address_id;
        } else {
            $addressId = null;
        }
// dd($request);
        if ($request->paymentType == 'Credit Card') {
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

                // dd($orderDetails);

                if ($charge['status'] == 'succeeded') {
                    DB::beginTransaction();
                    $order = new Order;
                    $order->uid = $uid;
                    $order->restaurant_id = $restaurantId;
                    $order->order_number = random_int(1000, 1000000000000000);
                    $order->payment_card_id = $cardId;
                    $order->isCash = Config::get('constants.ORDER_PAYMENT_TYPE.CARD_PAYMENT');
                    $order->stripe_payment_id = $charge['created'];
                    $order->promotion_id = $request->promotion_id;
                    $order->cart_charge = $orderDetails['cart_charge'];
                    $order->delivery_charge = '0.00';
                    $order->discount_charge =$request->discount_charge;
                    $order->tip_amount =$request->newtips;
                    $order->sales_tax=$request->sales_tax;
                    $order->platform='W';
                    $order->is_feature = ($orderDetails['order_status'] == 1) ? 1 : 0;
                    $order->order_status = null;
                    $order->order_progress_status = Config::get('constants.ORDER_STATUS.INITIAL');
                    $order->address_id = $addressId;

                    if ($orderDetails['order_status'] == 1) {
                        $order->order_date = date('Y-m-d');
                        $order->order_time = date('h:m:A');
                        $order->feature_date = \DateTime::createFromFormat('d/m/Y', $orderDetails['orderDate'])->format('Y-m-d');
                        // $order->feature_date = date("Y-m-d", strtotime($orderDetails['orderDate']));
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
                            $menuItemData->menu_qty = $menuItem->menu_qty;
                            $menuItemData->menu_price = $menuItem->menu_price;
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
                        $this->emptyCart();
                        $data['title'] = 'Success Order';
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
                $order->isCash = Config::get('constants.ORDER_PAYMENT_TYPE.CASH_PAYMENT');
                $order->discount_charge = $orderDetails['discount_charge'];
                $order->is_feature = ($orderDetails['order_status'] == 1) ? 1 : 0;
                $order->order_status = null;
                $order->order_progress_status = Config::get('constants.ORDER_STATUS.INITIAL');
                $order->address_id = $addressId;

                if ($orderDetails['order_status'] == 1) {
                    $order->order_date = date('Y-m-d');
                    $order->order_time = date('h:m:A');
                    $order->feature_date = \DateTime::createFromFormat('d/m/Y', $orderDetails['orderDate'])->format('Y-m-d');
                    // $order->feature_date = date("Y-m-d", strtotime($orderDetails['orderDate']));
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
                    $data['title'] = 'Success Order';
                    $data['cards'] = getUserCards($restaurantId, $uid);
                    $this->emptyCart();
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
