<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Loyalty;
use App\Models\LoyaltyCategory;
use App\Models\LoyaltyRule;
use App\Models\Restaurant;
use App\Models\RestaurantPayment;
use App\Models\RestaurantSubscription;
use App\Models\Subscription;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use Cartalyst\Stripe\Stripe;
use Config;
use DB;
use Toastr;
use Illuminate\Http\Request;

class LoyaltyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            if(Auth::user()->loyalty_subscription == Config::get('constants.SUBSCRIPTION.ACTIVE')){
                return redirect()->route('loyalty.list');
            }else{
                $uid = Auth::user()->uid;
                $restaurant = Restaurant::where('uid', $uid)->first();
                $restaurantSubscription = RestaurantSubscription::where('restaurant_id',$restaurant->restaurant_id)->where('subscription_plan',Config::get('constants.SUBSCRIPTION_PLAN.1'))->first();
                if($restaurantSubscription){
                    $data['startDate'] = Carbon::parse($restaurantSubscription->start_date)->format('d');
                    $registrationEndDate = new Carbon($restaurantSubscription->end_date);
                    $endDate             = $registrationEndDate->format('Y-m-d');
                    $totalSubscriptionDays = $registrationEndDate->diff($restaurantSubscription->start_date);
                    $today = Carbon::now()->format('Y-m-d');
                    $diff = $registrationEndDate->diff($today);
                    $data['totalAmount'] = number_format(($diff->days * Config::get('constants.LOYALTY_CHARGE')) / $totalSubscriptionDays->days,2);
                    $stripe = Stripe::make(env('STRIPE_SECRET'));
                    $data['paymentMethods'] = $stripe->paymentMethods()->all([
                        'type' => 'card',
                        'customer' => $restaurant->stripe_customer_id,
                    ]);
                    return view('loyalty.index', $data);
                }else{
                    return back()->with('error','Restaurant Registration subscription not create.');
                }
            }
        } catch (\Throwable $th) {
            return back()->with('error',$th->getMessages());
        }
    }

    public function loyalty_list()
    {
        if (Auth::user()->loyalty_subscription == Config::get('constants.SUBSCRIPTION.ACTIVE')) {
            $uid = Auth::user()->uid;
            $restaurant = Restaurant::with(['subscriptions' => function($subscription){
                $subscription->with('subscription')->where('subscription_plan',Config::get('constants.SUBSCRIPTION_PLAN.3'))->first();
            }])->where('uid', $uid)->first();
            // dd($restaurant);
            $data['subscription'] = array();
            foreach($restaurant->subscriptions as $subscription){
                $data['subscription']['stripe_subscription_id'] = $subscription->stripe_subscription_id;
                $data['subscription']['price'] = $subscription->subscription->price;
                $data['subscription']['type'] = $subscription->subscription->subscription_type;
                if($subscription->status == Config::get('constants.STATUS.SCHEDULE')){
                    $data['subscription']['start_date'] = \Carbon\Carbon::parse($subscription->start_date)->subMonths()->format('M d Y');
                    $data['subscription']['end_date'] = \Carbon\Carbon::parse($subscription->start_date)->format('M d Y');
                }else{
                    $data['subscription']['start_date'] = \Carbon\Carbon::parse($subscription->start_date)->format('M d Y');
                    $data['subscription']['end_date'] = \Carbon\Carbon::parse($subscription->end_date)->format('M d Y');
                }
            }
            $data['categories'] = Category::with('category_item')->where('restaurant_id', $restaurant->restaurant_id)->get();
            $data['loyalties'] = Loyalty::where('restaurant_id',$restaurant->restaurant_id)->get();
            $loyaltyRules = LoyaltyRule::with('rulesItems')->where('restaurant_id', $restaurant->restaurant_id)->get();
            // dd($loyaltyRules);
            foreach($loyaltyRules as $loyaltyItems)
            {
                foreach($loyaltyItems->rulesItems as $items)
                {
                    foreach ($items->menuItems as $menu)
                    {
                        if($items->category_id == $menu->category_id)
                        {
                            $menus[$items->loyalty_rule_id][$items->categories->category_name][] = $menu->item_name;
                            $menuItems = $menus;
                        }
                    }
                }
            }
            // dd($menuItems);
            $data['loyaltyRules'] = $loyaltyRules;
            $data['rulesItems'] = (isset($menuItems)) ? $menuItems : [] ;
            return view('loyalty.list',$data);
        } else {
            return redirect()->route('loyalty.index')->with('error', 'Please purchase loyalty subscription.');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $uid = Auth::user()->uid;
        $restaurant = Restaurant::where('uid', $uid)->first();
        $data['categories'] = Category::with('category_item')->where('restaurant_id', $restaurant->restaurant_id)->get();
        return view('loyalty.rules', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {

            $uid = Auth::user()->uid;
            $restaurant = Restaurant::where('uid', $uid)->first();

            if($request->post('loyaltyId') != null){
                $loyalty = Loyalty::where('loyalty_id',$request->post('loyaltyId'))->where('restaurant_id',$restaurant->restaurant_id)->first();
                $loyalty->point = $request->post('point');
                $message = 'Loyalty update successfully.';

                if($request->post('loyalty_type') == Config::get('constants.LOYALTY_TYPE.NO_OF_ORDERS')){
                    $loyalty->no_of_orders = $request->post('no_of_order');
                    $loyalty->save();
                    Toastr::success($message, '', Config::get('constants.toster'));
                }

                if($request->post('loyalty_type') == Config::get('constants.LOYALTY_TYPE.AMOUNT_SPENT')){
                    $loyalty->amount = $request->post('amount');
                    $loyalty->save();
                    Toastr::success($message, '', Config::get('constants.toster'));
                }

                if($request->post('loyalty_type') == Config::get('constants.LOYALTY_TYPE.CATEGORY_BASED')){
                    $loyalty->point = $request->post('point');
                    $loyalty->save();
                    $categories = $request->post('categories');
                    LoyaltyCategory::where('loyalty_id',$request->post('loyaltyId'))->delete();
                    foreach ($categories as $key => $value) {
                        $loyaltyCategory = new LoyaltyCategory;
                        $loyaltyCategory->restaurant_id = $restaurant->restaurant_id;
                        $loyaltyCategory->uid = $uid;
                        $loyaltyCategory->loyalty_id = $request->post('loyaltyId');
                        $loyaltyCategory->category_id = $value;
                        $loyaltyCategory->save();
                    }
                    Toastr::success($message, '', Config::get('constants.toster'));
                }
            }else{
                $loyalty = new Loyalty;
                $loyalty->restaurant_id = $restaurant->restaurant_id;
                $loyalty->uid = $uid;
                $loyalty->status = Config::get('constants.STATUS.INACTIVE');
                $loyalty->point = $request->post('point');
                $message = 'Loyalty add successfully.';
                if($request->post('loyalty_type') == Config::get('constants.LOYALTY_TYPE.NO_OF_ORDERS')){
                    $loyalty->loyalty_type = Config::get('constants.LOYALTY_TYPE.NO_OF_ORDERS');
                    $loyalty->no_of_orders = $request->post('no_of_order');
                    $loyalty->save();
                    Toastr::success($message, '', Config::get('constants.toster'));
                }

                if ($request->post('loyalty_type') == Config::get('constants.LOYALTY_TYPE.AMOUNT_SPENT')) {
                    $loyalty->loyalty_type = Config::get('constants.LOYALTY_TYPE.AMOUNT_SPENT');
                    $loyalty->amount = $request->post('amount');
                    $loyalty->save();
                    Toastr::success($message, '', Config::get('constants.toster'));
                }

                if ($request->post('loyalty_type') == Config::get('constants.LOYALTY_TYPE.CATEGORY_BASED')) {
                    $loyalty->loyalty_type = Config::get('constants.LOYALTY_TYPE.CATEGORY_BASED');
                    $loyalty->save();

                    $categories = $request->post('categories');
                    foreach ($categories as $key => $value) {
                        $loyaltyCategory = new LoyaltyCategory;
                        $loyaltyCategory->restaurant_id = $restaurant->restaurant_id;
                        $loyaltyCategory->uid = $uid;
                        $loyaltyCategory->loyalty_id = $loyalty->loyalty_id;
                        $loyaltyCategory->category_id = $value;
                        $loyaltyCategory->save();
                    }
                    Toastr::success($message, '', Config::get('constants.toster'));
                }
            }
            return redirect()->route('loyalty.list');
        } catch (\Throwable $th) {
            // $errors['success'] = false;
			// $errors['message'] = $th->getMessage();
			// return response()->json($errors, 500);
            return redirect()->route('loyalty.list')->with('error', $th->getMessage());
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Loyalty  $loyalty
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        try {

            $uid = Auth::user()->uid;
            $restaurant = Restaurant::where('uid', $uid)->first();

            $loyaltyId = $request->post('loyaltyId');
            $loyaltyType = $request->post('loyaltyType');
            $loyalty = Loyalty::where('loyalty_id',$loyaltyId)->where('loyalty_type',$loyaltyType)->where('restaurant_id',$restaurant->restaurant_id);
            if($loyaltyType == Config::get('constants.LOYALTY_TYPE.CATEGORY_BASED')){
                $loyalty = $loyalty->with('categories')->first();
            }else{
                $loyalty = $loyalty->first();
            }
            $data = ['success' => true,'loyalty' => $loyalty];
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            $data['success'] = false;
			$data['message'] = $th->getMessage();
            return response()->json($data, 500);
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Loyalty  $loyalty
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try {
            $loyaltyId = $request->post('loyaltyId');
            $loyalty = Loyalty::where('loyalty_id',$loyaltyId)->first();
            if($loyalty->status == Config::get('constants.STATUS.ACTIVE')){
                Toastr::error('This loyalty program is active.Please inactive first.', '', Config::get('constants.toster'));
            }else{
                if($loyalty->loyalty_type == Config::get('constants.LOYALTY_TYPE.CATEGORY_BASED')){
                    if($loyalty->delete()){
                        $message = 'Loyalty delete successfully.';
                        LoyaltyCategory::where('loyalty_id',$loyaltyId)->delete();
                    }
                }else{
                    if($loyalty->delete()){
                        $message = 'Loyalty delete successfully.';
                    }
                }
                Toastr::success($message, '', Config::get('constants.toster'));
            }
            return redirect()->route('loyalty.list');
        } catch (\Throwable $th) {
            Toastr::error('Some error in loyalty delete.', '', Config::get('constants.toster'));
            return redirect()->route('loyalty.list');
        }
    }

    public function payment(Request $request)
    {
        $uid = Auth::user()->uid;
        $subscription = Subscription::where('subscription_plan', Config::get('constants.SUBSCRIPTION_PLAN.3'))->first();
        $restaurant = Restaurant::where('uid', $uid)->first();
        try {

            $res_subscription = RestaurantSubscription::where('restaurant_id', $restaurant->restaurant_id)->where('subscription_plan', Config::get('constants.SUBSCRIPTION_PLAN.1'))->where('uid', $uid)->first();
            $startDate = Carbon::parse($res_subscription->start_date)->format('Y-m-d');
            $today = Carbon::now()->format('Y-m-d');

            DB::beginTransaction();

            if ($startDate == $today) {
                $stripe = Stripe::make(env('STRIPE_SECRET'));
                if ($request->post('payment_method')) {
                    $paymentMethodId = $request->post('payment_method');
                } else {
                    $cardExp = explode('/', $request->post('exp_card'));

                    $data = [
                        'number' => $request->post('card_number'),
                        'exp_month' => $cardExp[0],
                        'exp_year' => $cardExp[1],
                        'cvc' => $request->post('cvv'),
                    ];

                    // Add New card
                    $paymentMethodId = stripeAddCard($data, $restaurant->stripe_customer_id);
                }
                if ($subscription->stripe_plan_id == null) {
                    return redirect()->back()->with('error', Config::get('constants.COMMON_MESSAGES.COMMON_MESSAGE'));
                } else {
                    $stripe_subscription = $stripe->subscriptions()->create($restaurant->stripe_customer_id, [
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
                        'default_payment_method' => $paymentMethodId,
                    ]);
                    if ($stripe_subscription['status'] == 'active') {
                        $payment = new RestaurantPayment;
                        $payment->uid = $uid;
                        $payment->restaurant_id = $restaurant->restaurant_id;
                        $payment->status = Config::get('constants.PAYMENT_STATUS.SUCCESS');
                        $payment->amount = $subscription->price;
                        $payment->currency = 'USD';
                        $payment->response = json_encode($stripe_subscription);
                        $payment->save();
                        DB::commit();

                        $last_paymentId = RestaurantPayment::where('restaurant_id', $restaurant->restaurant_id)->where('uid', $uid)->orderBy('id', 'desc')->first();
                        $subscription_save = new RestaurantSubscription;
                        $subscription_save->restaurant_id = $restaurant->restaurant_id;
                        $subscription_save->uid = $uid;
                        $subscription_save->subscription_id = $subscription->subscription_id;
                        $subscription_save->stripe_subscription_id = $stripe_subscription['id'];
                        $subscription_save->stripe_payment_method = $paymentMethodId;
                        $subscription_save->start_date = \Carbon\Carbon::parse($stripe_subscription['current_period_start'])->format('Y-m-d H:i:s');
                        $subscription_save->end_date = \Carbon\Carbon::parse($stripe_subscription['current_period_end'])->format('Y-m-d H:i:s');
                        $subscription_save->status = Config::get('constants.STATUS.ACTIVE');
                        $subscription_save->restaurant_payment_id = $last_paymentId->id;
                        $subscription_save->subscription_plan = Config::get('constants.SUBSCRIPTION_PLAN.3');
                        $subscription_save->save();

                        User::where('uid', $uid)->update(['loyalty_subscription' => Config::get('constants.SUBSCRIPTION.ACTIVE')]);
                    }
                    return redirect()->route('loyalty.list')->with('success', Config::get('constants.SUBSCRIPTION.ACTIVE_MESSAGE'));
                }
            } else {

                $stripe = Stripe::make(env('STRIPE_SECRET'));
                $registrationEndDate = new Carbon($res_subscription->end_date);
                $endDate = $registrationEndDate->format('Y-m-d');
                $totalSubscriptionDays = $registrationEndDate->diff($startDate);

                $diff = $registrationEndDate->diff($today);
                $totalAmount = ($diff->days * $subscription->price) / $totalSubscriptionDays->days;

                if ($request->post('payment_method')) {
                    $paymentMethodId = $request->post('payment_method');
                } else {
                    $cardExp = explode('/', $request->post('exp_card'));

                    $data = [
                        'number' => $request->post('card_number'),
                        'exp_month' => $cardExp[0],
                        'exp_year' => $cardExp[1],
                        'cvc' => $request->post('cvv'),
                    ];

                    // Add New card
                    $paymentMethodId = stripeAddCard($data, $restaurant->stripe_customer_id);
                }

                if ($subscription->stripe_plan_id == null) {
                    return redirect()->back()->with('error', Config::get('constants.COMMON_MESSAGES.COMMON_MESSAGE'));
                } else {

                    $charge = $stripe->charges()->create([
                        'card' => $paymentMethodId,
                        'customer' => $restaurant->stripe_customer_id,
                        'currency' => 'USD',
                        'amount' => number_format($totalAmount, 2),
                        'description' => 'Loyalty Subscription charge',
                    ]);

                    if ($charge['status'] == 'succeeded') {
                        $payment = new RestaurantPayment;
                        $payment->uid = $uid;
                        $payment->restaurant_id = $restaurant->restaurant_id;
                        $payment->status = Config::get('constants.PAYMENT_STATUS.SUCCESS');
                        $payment->amount = number_format($totalAmount, 2);
                        $payment->currency = 'USD';
                        $payment->response = json_encode($charge);
                        $payment->save();

                        User::where('uid', $uid)->update(['loyalty_subscription' => Config::get('constants.SUBSCRIPTION.ACTIVE')]);

                    }

                    $stripeClient = new \Stripe\StripeClient(env('STRIPE_SECRET'));

                    $scheduleSubscription = $stripeClient->subscriptionSchedules->create([
                        'customer' => $restaurant->stripe_customer_id,
                        'start_date' => \Carbon\Carbon::parse($res_subscription->end_date)->timestamp,
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

                    if ($scheduleSubscription['status'] == 'not_started') {
                        $last_paymentId = RestaurantPayment::where('restaurant_id', $restaurant->restaurant_id)->where('uid', $uid)->orderBy('id', 'desc')->first();

                        $subscription_save = new RestaurantSubscription;
                        $subscription_save->restaurant_id = $restaurant->restaurant_id;
                        $subscription_save->uid = $uid;
                        $subscription_save->subscription_id = $subscription->subscription_id;
                        $subscription_save->stripe_subscription_id = $scheduleSubscription['id'];
                        $subscription_save->stripe_payment_method = $paymentMethodId;
                        $subscription_save->start_date = \Carbon\Carbon::parse($scheduleSubscription['current_period_start'])->format('Y-m-d H:i:s');
                        $subscription_save->end_date = \Carbon\Carbon::parse($scheduleSubscription['current_period_end'])->format('Y-m-d H:i:s');
                        $subscription_save->status = Config::get('constants.STATUS.SCHEDULE');
                        $subscription_save->restaurant_payment_id = $last_paymentId->id;
                        $subscription_save->subscription_plan = Config::get('constants.SUBSCRIPTION_PLAN.3');
                        $subscription_save->save();
                    }
                    DB::commit();
                    return redirect()->route('loyalty.list')->with('success', Config::get('constants.SUBSCRIPTION.ACTIVE_MESSAGE'));
                }
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function changeStatus(Request $request){
        try {
            $loyaltyId = $request->post('loyaltyId');
            $uid = Auth::user()->uid;
            $restaurant = Restaurant::where('uid', $uid)->first();
            Loyalty::where('loyalty_id',$loyaltyId)->where('restaurant_id',$restaurant->restaurant_id)->update(['status' => Config::get('constants.STATUS.ACTIVE')]);
            Loyalty::where('loyalty_id','!=',$loyaltyId)->where('restaurant_id',$restaurant->restaurant_id)->update(['status' => Config::get('constants.STATUS.INACTIVE')]);
            return response()->json(['success' => true,'message' => 'Status Change Successfully.'],200);
        } catch (\Throwable $th) {
            return response()->json(['success' => false,'message' => Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS')],500);
        }
    }

    public function cancelPlan($planId){
        try {
            $uid = Auth::user()->uid;
            $restaurant = Restaurant::where('uid', $uid)->first();
            $plan = RestaurantSubscription::where('stripe_subscription_id',$planId)->where('restaurant_id',$restaurant->restaurant_id)->first();
            $stripe = Stripe::make(env('STRIPE_SECRET'));
            $cancel_subscription = $stripe->subscriptions()->cancel($restaurant->stripe_customer_id, $plan->stripe_subscription_id);
            if($cancel_subscription){
                User::where('uid',$uid)->update(['loyalty_subscription' => Config::get('constants.SUBSCRIPTION.INACTIVE')]);
                Toastr::success('Loyalty plan cancel successfully.', '', Config::get('constants.toster'));
                return redirect()->route('loyalty.index');
            }
        } catch (\Throwable $th) {
            // Toastr::error('Some error in loyalty plan cancel.', '', Config::get('constants.toster'));
            return redirect()->back()->with('error',$th->getMessage());
        }
    }
}
