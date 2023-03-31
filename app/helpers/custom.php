<?php

use App\Models\Card;
use App\Models\ModifierGroup;
use App\Models\Restaurant;
use App\Models\RestaurantSubscribers;
use App\Models\RestaurantSubscription;
use App\Models\Promotion;
use App\Models\Order;
use App\Models\Cart;
use App\Models\PromotionEligibleItem;
use App\Models\PromotionCategoryItem;

use Carbon\Carbon;
use Cartalyst\Stripe\Stripe;
// use Config;



if (!function_exists('getRestaurantId')) {
    function getRestaurantId()
    {
        return session()->get('restaurantId');

    }
}

if (!function_exists('getUserCards')) {
    function getUserCards($restaurantId, $uid)
    {
        if (\Auth::check()) {
            $cards = Card::where('uid', $uid)->where('restaurant_id', $restaurantId)->orderBy('card_id', 'desc')->get(['card_id', 'card_holder_name', 'card_number', 'card_expire_date', 'card_cvv', 'card_type', 'status']);
            return $cards;
        } else {
            return null;
        }
    }
}

if (!function_exists('getCartItem')) {
    function getCartItem()
    {
        $cartItems = session()->get('cart');
        if (!empty($cartItems)) {
            // $cartMenus = array();
            foreach ($cartItems as $cartKey => $items) {
                foreach ($items as $menu) {
                    // array_push($cartMenus,$menu);
                    $modifierGroupIds = $menu['modifier'];
                    if (!empty($menu['modifier'])) {
                        $modifierGroupItems = call_user_func_array('array_merge', $menu['modifier_item']);

                        $modifierGroups = ModifierGroup::with(['modifier_item' => function ($query) use ($modifierGroupItems, $modifierGroupIds) {
                            $query->whereIn('modifier_item_id', $modifierGroupItems)->whereIn('modifier_group_id', $modifierGroupIds)->get(['modifier_item_id', 'modifier_group_id', 'modifier_group_item_name', 'modifier_group_id', 'modifier_group_item_price']);
                        }])->whereIn('modifier_group_id', $menu['modifier'])->get(['modifier_group_id', 'modifier_group_name', 'restaurant_id']);
                        $modifierItems[$cartKey][$menu['menu_id']] = $modifierGroups->toArray();
                        $data['modifierGroups'] = $modifierItems;
                    }
                }
            }
            $data['cartItems'] = $cartItems;
        } else {
            $data['cartItems'] = array();
        }
        return $data;
    }
}

if (!function_exists('getCart')) {
    function getCart($restaurant_id = 1)
    {
        $uid = auth()->user()->uid;
        return $cartItems = Cart::with(['cartMenuItems' => function($query){
            $query->select(['cart_menu_item_id','cart_id','menu_id','menu_name','menu_qty','menu_price','menu_total','modifier_total','is_loyalty','item_img'])->with(['cartMenuGroups' => function($query){
                $query->select(['cart_modifier_group_id','cart_menu_item_id','menu_id','modifier_group_id','modifier_group_name'])->with('cartMenuGroupItems')->get();
            }])->get();
        }])->where('restaurant_id',$restaurant_id)->where('uid',$uid)->select('cart_id','restaurant_id','promotion_id','uid','sub_total','discount_charge','tax_charge','total_due','is_payment')->first();
    }
}

if (!function_exists('getCartQty')) {
    function getCartQty($restaurant_id = 1)
    {
        $result = [];
        $cart = getCart($restaurant_id);
        if (!empty($cart)) {
            foreach ($cart->cartMenuItems as $item) {
                $result[$item->menu_id] = $item->menu_qty;
            }
        }
        return $result;
    }
}

if (!function_exists('convertNumberToWord')) {
    function convertNumberToWord($num = false)
    {
        $num = str_replace(array(',', ' '), '', trim($num));
        if (!$num) {
            return false;
        }
        $num = (int) $num;
        $words = array();
        $list1 = array('', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'eleven',
            'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen',
        );
        $list2 = array('', 'ten', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety', 'hundred');
        $list3 = array('', 'thousand', 'million', 'billion', 'trillion', 'quadrillion', 'quintillion', 'sextillion', 'septillion',
            'octillion', 'nonillion', 'decillion', 'undecillion', 'duodecillion', 'tredecillion', 'quattuordecillion',
            'quindecillion', 'sexdecillion', 'septendecillion', 'octodecillion', 'novemdecillion', 'vigintillion',
        );
        $num_length = strlen($num);
        $levels = (int) (($num_length + 2) / 3);
        $max_length = $levels * 3;
        $num = substr('00' . $num, -$max_length);
        $num_levels = str_split($num, 3);
        for ($i = 0; $i < count($num_levels); $i++) {
            $levels--;
            $hundreds = (int) ($num_levels[$i] / 100);
            $hundreds = ($hundreds ? ' ' . $list1[$hundreds] . ' hundred' . ' ' : '');
            $tens = (int) ($num_levels[$i] % 100);
            $singles = '';
            if ($tens < 20) {
                $tens = ($tens ? ' ' . $list1[$tens] . ' ' : '');
            } else {
                $tens = (int) ($tens / 10);
                $tens = ' ' . $list2[$tens] . ' ';
                $singles = (int) ($num_levels[$i] % 10);
                $singles = ' ' . $list1[$singles] . ' ';
            }
            $words[] = $hundreds . $tens . $singles . (($levels && (int) ($num_levels[$i])) ? ' ' . $list3[$levels] . ' ' : '');
        } //end for loop
        $commas = count($words);
        if ($commas > 1) {
            $commas = $commas - 1;
        }
        return trim(implode('-', $words));
    }
}

if (!function_exists('getCartKey')) {
    function getCartKey($type = null, $menuId)
    {
        if ($type != null) {
            $cartItems = getCartItem();
            $key = '';

            if ($type == 'without-modifier') {
                foreach ($cartItems['cartItems'] as $cartKey => $value) {
                    if (empty($value[$menuId]['modifier']) && empty($value[$menuId]['modifier_item'])) {
                        $key = $cartKey;
                    }
                }
                return $key;
            }

            if ($type == 'with-modifier') {
                foreach ($cartItems['cartItems'] as $cartKey => $value) {
                    if (!empty($value[$menuId]['modifier']) && !empty($value[$menuId]['modifier_item'])) {

                        if ($value[$menuId]['repeat'] == 0) {
                            $key = $cartKey;
                        }

                        if ($value[$menuId]['repeat'] == 1) {
                            $key = $cartKey;
                        }
                    }
                }
                return $key;
            }
        }
    }
}

if (!function_exists('isMobile')) {
    function isMobile()
    {
        return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
    }
}

if (!function_exists('stripeAddCard')) {
    function stripeAddCard($cardData, $customerId)
    {
        $stripe = Stripe::make(env('STRIPE_SECRET'));
        $token = $stripe->tokens()->create([
            'card' => [
                'number' => $cardData['number'],
                'exp_month' => $cardData['exp_month'],
                'cvc' => $cardData['cvc'],
                'exp_year' => $cardData['exp_year'],
            ],
        ]);

        $card = $stripe->cards()->create($customerId, $token['id']);
        return $card['id'];
    }
}

if (!function_exists('campaignMonitorClient')) {
    function campaignMonitorClient($restaurant)
    {
        $clientCreate = \CampaignMonitor::clients()->create([
            "CompanyName" => $restaurant['restaurant_name'],
            "Country" => $restaurant['country'],
            "TimeZone" => $restaurant['timeZone'],
        ]);

        Restaurant::where('restaurant_id', $restaurant['restaurant_id'])->Update(['cm_client_id' => $clientCreate->response]);

    }
}

if (!function_exists('timezone')) {
    function timezone($userTimeZone)
    {
        $timezones = array(
            "GMT" => "(GMT) Coordinated Universal Time",
            "GMT+00:00" => "(GMT+00:00) Dublin, Edinburgh, Lisbon, London",
            "GMT+00:00" => "(GMT+00:00) Monrovia, Reykjavik",
            "GMT+01:00" => "(GMT+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna",
            "GMT+01:00" => "(GMT+01:00) Belgrade, Bratislava, Budapest, Ljubljana, Prague",
            "GMT+01:00" => "(GMT+01:00) Brussels, Copenhagen, Madrid, Paris",
            "GMT+01:00" => "(GMT+01:00) Casablanca",
            "GMT+01:00" => "(GMT+01:00) Sarajevo, Skopje, Warsaw, Zagreb",
            "GMT+01:00" => "(GMT+01:00) West Central Africa",
            "GMT+02:00" => "(GMT+02:00) Amman",
            "GMT+02:00" => "(GMT+02:00) Athens, Bucharest",
            "GMT+02:00" => "(GMT+02:00) Beirut",
            "GMT+02:00" => "(GMT+02:00) Cairo",
            "GMT+02:00" => "(GMT+02:00) Chisinau",
            "GMT+02:00" => "(GMT+02:00) Damascus",
            "GMT+02:00" => "(GMT+02:00) Gaza, Hebron",
            "GMT+02:00" => "(GMT+02:00) Harare, Pretoria",
            "GMT+02:00" => "(GMT+02:00) Helsinki, Kyiv, Riga, Sofia, Tallinn, Vilnius",
            "GMT+02:00" => "(GMT+02:00) Jerusalem",
            "GMT+02:00" => "(GMT+02:00) Kaliningrad",
            "GMT+02:00" => "(GMT+02:00) Tripoli",
            "GMT+02:00" => "(GMT+02:00) Windhoek",
            "GMT+03:00" => "(GMT+03:00) Baghdad",
            "GMT+03:00" => "(GMT+03:00) Istanbul",
            "GMT+03:00" => "(GMT+03:00) Kuwait, Riyadh",
            "GMT+03:00" => "(GMT+03:00) Minsk",
            "GMT+03:00" => "(GMT+03:00) Moscow, St. Petersburg",
            "GMT+03:00" => "(GMT+03:00) Nairobi",
            "GMT+03:30" => "(GMT+03:30) Tehran",
            "GMT+04:00" => "(GMT+04:00) Abu Dhabi, Muscat",
            "GMT+04:00" => "(GMT+04:00) Astrakhan, Ulyanovsk",
            "GMT+04:00" => "(GMT+04:00) Baku",
            "GMT+04:00" => "(GMT+04:00) Izhevsk, Samara",
            "GMT+04:00" => "(GMT+04:00) Port Louis",
            "GMT+04:00" => "(GMT+04:00) Tbilisi",
            "GMT+04:00" => "(GMT+04:00) Yerevan",
            "GMT+04:30" => "(GMT+04:30) Kabul",
            "GMT+05:00" => "(GMT+05:00) Ashgabat, Tashkent",
            "GMT+05:00" => "(GMT+05:00) Ekaterinburg",
            "GMT+05:00" => "(GMT+05:00) Islamabad, Karachi",
            "GMT+05:30" => "(GMT+05:30) Chennai, Kolkata, Mumbai, New Delhi",
            // "GMT+05:30" => "(GMT+05:30) Sri Jayawardenepura",
            "GMT+05:45" => "(GMT+05:45) Kathmandu",
            "GMT+06:00" => "(GMT+06:00) Astana",
            "GMT+06:00" => "(GMT+06:00) Dhaka",
            "GMT+06:30" => "(GMT+06:30) Yangon (Rangoon)",
            "GMT+07:00" => "(GMT+07:00) Bangkok, Hanoi, Jakarta",
            "GMT+07:00" => "(GMT+07:00) Barnaul, Gorno-Altaysk",
            "GMT+07:00" => "(GMT+07:00) Krasnoyarsk",
            "GMT+07:00" => "(GMT+07:00) Novosibirsk",
            "GMT+07:00" => "(GMT+07:00) Tomsk",
            "GMT+08:00" => "(GMT+08:00) Beijing, Chongqing, Hong Kong, Urumqi",
            "GMT+08:00" => "(GMT+08:00) Irkutsk",
            "GMT+08:00" => "(GMT+08:00) Kuala Lumpur, Singapore",
            "GMT+08:00" => "(GMT+08:00) Perth",
            "GMT+08:00" => "(GMT+08:00) Taipei",
            "GMT+08:00" => "(GMT+08:00) Ulaanbaatar",
            "GMT+09:00" => "(GMT+09:00) Chita",
            "GMT+09:00" => "(GMT+09:00) Osaka, Sapporo, Tokyo",
            "GMT+09:00" => "(GMT+09:00) Seoul",
            "GMT+09:00" => "(GMT+09:00) Yakutsk",
            "GMT+09:30" => "(GMT+09:30) Adelaide",
            "GMT+09:30" => "(GMT+09:30) Darwin",
            "GMT+10:00" => "(GMT+10:00) Brisbane",
            "GMT+10:00" => "(GMT+10:00) Canberra, Melbourne, Sydney",
            "GMT+10:00" => "(GMT+10:00) Guam, Port Moresby",
            "GMT+10:00" => "(GMT+10:00) Hobart",
            "GMT+10:00" => "(GMT+10:00) Vladivostok",
            "GMT+10:30" => "(GMT+10:30) Lord Howe Island",
            "GMT+11:00" => "(GMT+11:00) Bougainville Island",
            "GMT+11:00" => "(GMT+11:00) Chokurdakh",
            "GMT+11:00" => "(GMT+11:00) Magadan",
            "GMT+11:00" => "(GMT+11:00) Solomon Is., New Caledonia",
            "GMT+12:00" => "(GMT+12:00) Anadyr, Petropavlovsk-Kamchatsky",
            "GMT+12:00" => "(GMT+12:00) Auckland, Wellington",
            "GMT+12:00" => "(GMT+12:00) Coordinated Universal Time+12",
            "GMT+12:00" => "(GMT+12:00) Fiji",
            "GMT+12:00" => "(GMT+12:00) Petropavlovsk-Kamchatsky - Old",
            "GMT+13:00" => "(GMT+13:00) Nuku'alofa",
            "GMT+13:00" => "(GMT+13:00) Samoa",
            "GMT+14:00" => "(GMT+14:00) Kiritimati Island",
            "GMT-01:00" => "(GMT-01:00) Azores",
            "GMT-01:00" => "(GMT-01:00) Cabo Verde Is.",
            "GMT-02:00" => "(GMT-02:00) Coordinated Universal Time-02",
            "GMT-02:00" => "(GMT-02:00) Mid-Atlantic - Old",
            "GMT-03:00" => "(GMT-03:00) Araguaina",
            "GMT-03:00" => "(GMT-03:00) Brasilia",
            "GMT-03:00" => "(GMT-03:00) Cayenne, Fortaleza",
            "GMT-03:00" => "(GMT-03:00) City of Buenos Aires",
            "GMT-03:00" => "(GMT-03:00) Greenland",
            "GMT-03:00" => "(GMT-03:00) Montevideo",
            "GMT-03:00" => "(GMT-03:00) Salvador",
            "GMT-03:30" => "(GMT-03:30) Newfoundland",
            "GMT-04:00" => "(GMT-04:00) Asuncion",
            "GMT-04:00" => "(GMT-04:00) Atlantic Time (Canada)",
            "GMT-04:00" => "(GMT-04:00) Caracas",
            "GMT-04:00" => "(GMT-04:00) Cuiaba",
            "GMT-04:00" => "(GMT-04:00) Georgetown, La Paz, Manaus, San Juan",
            "GMT-04:00" => "(GMT-04:00) Santiago",
            "GMT-05:00" => "(GMT-05:00) Bogota, Lima, Quito, Rio Branco",
            "GMT-05:00" => "(GMT-05:00) Chetumal",
            "GMT-05:00" => "(GMT-05:00) Eastern Time (US & Canada)",
            "GMT-05:00" => "(GMT-05:00) Haiti",
            "GMT-05:00" => "(GMT-05:00) Indiana (East)",
            "GMT-05:00" => "(GMT-05:00) Turks and Caicos",
            "GMT-06:00" => "(GMT-06:00) Central America",
            "GMT-06:00" => "(GMT-06:00) Central Time (US & Canada)",
            "GMT-06:00" => "(GMT-06:00) Guadalajara, Mexico City, Monterrey",
            "GMT-06:00" => "(GMT-06:00) Saskatchewan",
            "GMT-07:00" => "(GMT-07:00) Arizona",
            "GMT-07:00" => "(GMT-07:00) Chihuahua, La Paz, Mazatlan",
            "GMT-07:00" => "(GMT-07:00) Mountain Time (US & Canada)",
            "GMT-08:00" => "(GMT-08:00) Baja California",
            "GMT-08:00" => "(GMT-08:00) Coordinated Universal Time-08",
            "GMT-08:00" => "(GMT-08:00) Pacific Time (US & Canada)",
            "GMT-09:00" => "(GMT-09:00) Alaska",
            "GMT-09:00" => "(GMT-09:00) Coordinated Universal Time-09",
            "GMT-10:00" => "(GMT-10:00) Hawaii",
            "GMT-11:00" => "(GMT-11:00) Coordinated Universal Time-11",
            "GMT-12:00" => "(GMT-12:00) International Date Line West",
        );

        if ($timezones[$userTimeZone]) {
            return $timezones[$userTimeZone];
        }
        return false;
    }
}

if (!function_exists('upgrade_subscription')) {
    function upgrade_subscription($current_subscription, $paymentMethodId, $restaurant, $subscription)
    {
        try {
            dd($subscription->stripe_plan_id);
            $stripe = Stripe::make(env('STRIPE_SECRET'));

            $plan_start_date = new Carbon($current_subscription->current_period_start);
            $startDate = $plan_start_date->format('Y-m-d');
            $plan_end_date = new Carbon($current_subscription->current_period_end);

            $today = Carbon::now()->format('Y-m-d');
            $diff = $plan_end_date->diff($today);
            $totalSubscriptionDays = $plan_end_date->diff($startDate);
            $totalAmount = ($diff->days * $subscription->price) / $totalSubscriptionDays->days;

            // $charge = $stripe->charges()->create([
            //     'card' => $paymentMethodId,
            //     'customer' => $restaurant->stripe_customer_id,
            //     'currency' => 'USD',
            //     'amount' => number_format($totalAmount, 2),
            //     'description' => 'Upgrade Email Subscription charge',
            // ]);

            // if ($charge['status'] == 'succeeded') {
            //     $payment = new RestaurantPayment;
            //     $payment->uid = $uid;
            //     $payment->restaurant_id = $restaurant->restaurant_id;
            //     $payment->status = Config::get('constants.PAYMENT_STATUS.SUCCESS');
            //     $payment->amount = number_format($totalAmount, 2);
            //     $payment->currency = 'USD';
            //     $payment->response = json_encode($charge);
            //     $payment->save();
            // }
            // $current_subscription->id

            $cancel_subscription = $stripe->subscriptions()->cancel($restaurant->stripe_customer_id, $current_subscription->id);
            if ($subscription['status'] == 'canceled') {
                $stripeClient = new \Stripe\StripeClient(env('STRIPE_SECRET'));
                $scheduleSubscription = $stripeClient->subscriptionSchedules->create([
                    'customer' => $restaurant->stripe_customer_id,
                    'start_date' => $restaurantSubscription->current_period_end,
                    'end_behavior' => 'release',
                    'phases' => [
                        [
                            'items' => [
                                [
                                    'price_data' => [
                                        'unit_amount' => $subscription->price * 100,
                                        'currency' => 'usd',
                                        'product' => $subscription->stripe_plan_id,
                                        'recurring' => [
                                            'interval' => 'month',
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                    'default_settings' => [
                        'default_payment_method' => $paymentMethodId,
                    ],
                ]);

                // $stripe_subscription = $stripe->subscriptions()->($restaurant->stripe_customer_id, [
                //     'items' => [
                //         [
                //             'price_data' => [
                //                 'unit_amount' => $subscription->price * 100,
                //                 'currency' => 'usd',
                //                 'product' => $subscription->stripe_plan_id,
                //                 'recurring' => [
                //                     'interval' => 'month',
                //                 ],
                //             ],
                //         ],
                //     ],
                //     'default_payment_method' => $paymentMethodId,
                // ]);

                if ($stripe_subscription['status'] == 'active') {
                    // $last_paymentId = RestaurantPayment::where('restaurant_id', $restaurant->restaurant_id)->where('uid', Auth::user()->uid)->orderBy('id', 'desc')->first();

                    $subscription_update = RestaurantSubscription::where('stripe_subscription_id', $current_subscription->id)->first();
                    $subscription_update->restaurant_id = $restaurant->restaurant_id;
                    $subscription_update->uid = Auth::user()->uid;
                    $subscription_update->subscription_id = $subscription->subscription_id;
                    $subscription_update->stripe_subscription_id = $stripe_subscription['id'];
                    $subscription_update->stripe_payment_method = $paymentMethodId;
                    $subscription_update->start_date = \Carbon\Carbon::parse($scheduleSubscription['current_period_start'])->format('Y-m-d');
                    $subscription_update->end_date = \Carbon\Carbon::parse($scheduleSubscription['current_period_end'])->format('Y-m-d');
                    $subscription_update->status = Config::get('constants.STATUS.ACTIVE');
                    $subscription_update->restaurant_payment_id = $last_paymentId->id;
                    $subscription_update->save();
                }
            }
            // $stripe_subscription = $stripe->subscriptions()->update($restaurant->stripe_customer_id, [
            //     'items' => [
            //         [
            //             'price_data' => [
            //                 'unit_amount' => $subscription->price * 100,
            //                 'currency' => 'usd',
            //                 'product' => $subscription->stripe_plan_id,
            //                 'recurring' => [
            //                     'interval' => 'month',
            //                 ],
            //             ],
            //         ],
            //     ],
            //     'default_payment_method' => $paymentMethodId,
            // ]);

            // if ($stripe_subscription['status'] == 'active') {
            //     // $last_paymentId = RestaurantPayment::where('restaurant_id', $restaurant->restaurant_id)->where('uid', Auth::user()->uid)->orderBy('id', 'desc')->first();

            //     $subscription_update = RestaurantSubscription::where('stripe_subscription_id', $current_subscription->id)->first();
            //     $subscription_update->restaurant_id = $restaurant->restaurant_id;
            //     $subscription_update->uid = Auth::user()->uid;
            //     $subscription_update->subscription_id = $subscription->subscription_id;
            //     $subscription_update->stripe_subscription_id = $stripe_subscription['id'];
            //     $subscription_update->stripe_payment_method = $paymentMethodId;
            //     $subscription_update->start_date = \Carbon\Carbon::parse($scheduleSubscription['current_period_start'])->format('Y-m-d');
            //     $subscription_update->end_date = \Carbon\Carbon::parse($scheduleSubscription['current_period_end'])->format('Y-m-d');
            //     $subscription_update->status = Config::get('constants.STATUS.ACTIVE');
            //     $subscription_update->restaurant_payment_id = $last_paymentId->id;
            //     $subscription_update->save();
            // }
            DB::commit();

            return true;

        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}

if (!function_exists('create_subscriber')) {
    function create_subscriber($clientId, $customer, $restaurantId)
    {
        $listId = Restaurant::where('restaurant_id', $restaurantId)->first();
        if ($listId->cm_list_id != null) {
            $listId = $listId->cm_list_id;
        } else {
            $list_create = \CampaignMonitor::lists()->create($clientId, [
                "Title" => "Default List",
                "UnsubscribePage" => "http://www.example.com/unsubscribed.html",
                "UnsubscribeSetting" => "AllClientLists",
                "ConfirmedOptIn" => false,
                "ConfirmationSuccessPage" => "http://www.example.com/joined.html",
            ]);

            $listId = $list_create->response;
            Restaurant::where('restaurant_id', $restaurantId)->update(['cm_list_id' => $listId]);
        }
        $create_subscriber = \CampaignMonitor::subscribers($listId)->add([
            'EmailAddress' => $customer['email'],
            'Name' => $customer['name'],
            'ConsentToTrack' => 'yes',
            'Resubscribe' => true,
        ]);

        if ($create_subscriber->response) {
            $subscriber = new RestaurantSubscribers;
            $subscriber->restaurant_id = $restaurantId;
            $subscriber->uid = $customer['uid'];
            $subscriber->cm_subscriber_email = $create_subscriber->response;
            $subscriber->cm_list_id = $listId;
            $subscriber->save();
        }
        return true;
    }
}


if(!function_exists('get_menuItems'))
{
    function get_menuItems($rulesItemsArray,$loyaltyPoint)
    {
        $totalPoints = Auth::user()->total_points;
        $menus = array();
        foreach($rulesItemsArray as $items){
            foreach($items->menuItems as $item){
                if($loyaltyPoint > $totalPoints){
                    $item['loyalty_status'] = Config::get('constants.LOYALTY_MENU_STATUS.NOT_ELIGIBLE');
                }else{
                    $item['loyalty_status'] = Config::get('constants.LOYALTY_MENU_STATUS.ELIGIBLE');
                }
                array_push($menus,$item);
            }
        }
        return $menus;
    }
}

if(!function_exists('apply_promotion'))
{
    function apply_promotion($promotionType,$promotion,$uid,$restaurantId,$cart){
        switch($promotionType){
            case Config::get('constants.PROMOTION_TYPES.FIRST'):
                $promotions = Promotion::with('promotion_category')->where('promotion_id',$promotion->promotion_id)->where('promotion_type_id',1)->where('status',Config::get('constants.STATUS.ACTIVE'))->get();
                $promotionsCount = $promotions;
                if($promotionsCount->count() > 0){
                    if(promotion_filter($promotion,$promotions,$uid,$restaurantId,$cart) == true){
                        return true;
                    }
                    return false;
                }else{
                    return false;
                }
                break;

            default:
                return false;
                break;
        }
    }
}

if(!function_exists('promotion_filter')){
    function promotion_filter($promotion,$promotions,$uid,$restaurantId,$cart){
        if($promotion->availability == Config::get('constants.AVAILABILITY.2'))
        {
            if($promotion->promotion_function == Config::get('constants.PROMOTION_FUNCTION.3') )
            {
                if($promotion->client_type == Config::get('constants.CLIENT_TYPE.1'))
                {
                    if($cart->is_payment == Config::get('constants.ORDER_PAYMENT_TYPE.CARD_PAYMENT')) {
                        $promotions = $promotion->where('only_selected_cash_delivery_person',"1");
                    }
            
                    if($cart->is_payment == Config::get('constants.ORDER_PAYMENT_TYPE.CASH_PAYMENT')) {
                        $promotions = $promotion->where('only_selected_cash',"1");
                    }
            
                }
                elseif($promotion->client_type == Config::get('constants.CLIENT_TYPE.2'))
                {
                    if($cart->is_payment == Config::get('constants.ORDER_PAYMENT_TYPE.CARD_PAYMENT')) {
                        $promotions = $promotion->where('only_selected_cash_delivery_person',"1");
                    }
            
                    if($cart->is_payment == Config::get('constants.ORDER_PAYMENT_TYPE.CASH_PAYMENT')) {
                        $promotions = $promotion->where('only_selected_cash',"1");
                    }
            
                }
                elseif($promotion->client_type == Config::get('constants.CLIENT_TYPE.3'))
                {
                    if($cart->is_payment == Config::get('constants.ORDER_PAYMENT_TYPE.CARD_PAYMENT')) {
                        $promotions = $promotion->where('only_selected_cash_delivery_person',"1");
                    }
            
                    if($cart->is_payment == Config::get('constants.ORDER_PAYMENT_TYPE.CASH_PAYMENT')) {
                        $promotions = $promotion->where('only_selected_cash',"1");
                    }
                }
                else{
                    return false;
                }
            }
            else{
                return false;
            }
        }
        else{
            return false;
        }
    }
}







