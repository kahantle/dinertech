<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubscriptionPaymentRequest;
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
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $checkSubscription = auth()->user()->email_subscription;
            if ($checkSubscription == Config::get("constants.SUBSCRIPTION.INACTIVE")) {
                $data['subscriptions'] = Subscription::where('subscription_plan', Config::get('constants.SUBSCRIPTION_PLAN.2'))->get();
                $data['upgrade_subscription'] = false;
                return view('subscription.index', $data);
            } else {
                return redirect()->route('campaigns');
            }
        } else {
            abort('404');
        }
    }

    public function payment(Request $request)
    {
        try {

            $subscription = Subscription::where('subscription_id', $request->post('subscriptionId'))->first();
            if (Config::get('constants.SUBSCRIPTION_TYPE.MONTH') == $subscription->subscription_type) {
                $data['sub_type'] = \Str::lower(Config::get('constants.SUBSCRIPTION_TYPE.MONTH'));
            } else {
                $data['sub_type'] = \Str::lower(Config::get('constants.SUBSCRIPTION_TYPE.YEAR'));
            }
            $data['subscription'] = $subscription;
            $uid = Auth::user()->uid;
            $data['upgrade'] = ($request->post('upgrade') == 'true') ? true : false;

            $restaurant = Restaurant::where('uid', $uid)->first();
            $stripe = Stripe::make(env('STRIPE_SECRET'));
            $data['paymentMethods'] = $stripe->paymentMethods()->all([
                'type' => 'card',
                'customer' => $restaurant->stripe_customer_id,
            ]);

            $view = view('subscription.payment', $data)->render();
            return response()->json(['status' => 'success', 'view' => $view], 200);

        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()], 500);
        }

    }

    public function subscriptionPayment(SubscriptionPaymentRequest $request)
    {

        $uid = Auth::user()->uid;
        $restaurant = Restaurant::where('uid', $uid)->first();
        // campaignMonitorClient($restaurant);

        $restaurantData = [
            'restaurant_name' => $restaurant->restaurant_name,
            'country' => $restaurant->restaurant_country,
            'timeZone' => $restaurant->timezone,
            'restaurant_id' => $restaurant->restaurant_id,
        ];

        $subscription = Subscription::where('subscription_id', $request->post('subscription_id'))->first();
        $res_subscription = RestaurantSubscription::where('restaurant_id', $restaurant->restaurant_id)->where('uid', $uid)->first();
        $subscription_payment = RestaurantPayment::where('id', $res_subscription->restaurant_payment_id)->first();

        /* Registration Subscription */
        $restaurantSubscription = json_decode($subscription_payment->response);
        $registrationStartDate = new Carbon($restaurantSubscription->current_period_start);
        $startDate = $registrationStartDate->format('Y-m-d');

        $today = Carbon::now()->format('Y-m-d');

        try {
            if (empty($request->post('upgrade'))) {
                DB::beginTransaction();

                if ($startDate == $today || Auth::user()->email_subscription == Config::get('constants.STATUS.INACTIVE')) {
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
                        $subscription_save->start_date = \Carbon\Carbon::parse($stripe_subscription['current_period_start'])->format('Y-m-d');
                        $subscription_save->end_date = \Carbon\Carbon::parse($stripe_subscription['current_period_end'])->format('Y-m-d');
                        $subscription_save->status = Config::get('constants.STATUS.ACTIVE');
                        $subscription_save->restaurant_payment_id = $last_paymentId->id;
                        $subscription_save->save();

                        User::where('uid', $uid)->update(['email_subscription' => Config::get('constants.SUBSCRIPTION.ACTIVE')]);

                        // Create Campaign monitor client
                        if ($restaurant->cm_client_id == null) {
                            campaignMonitorClient($restaurantData);
                        }

                        return redirect()->route('campaigns')->with('success', Config::get('constants.SUBSCRIPTION.ACTIVE_MESSAGE'));
                    }
                } else {

                    $stripe = Stripe::make(env('STRIPE_SECRET'));
                    $registrationEndDate = new Carbon($restaurantSubscription->current_period_end);
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

                    $charge = $stripe->charges()->create([
                        'card' => $paymentMethodId,
                        'customer' => $restaurant->stripe_customer_id,
                        'currency' => 'USD',
                        'amount' => number_format($totalAmount, 2),
                        'description' => 'Email Subscription charge',
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

                        User::where('uid', $uid)->update(['email_subscription' => Config::get('constants.SUBSCRIPTION.ACTIVE')]);

                        // Create Campaign monitor client
                        if ($restaurant->cm_client_id == null) {
                            campaignMonitorClient($restaurantData);
                        }
                    }

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

                    if ($scheduleSubscription['status'] == 'not_started') {
                        // $payment = new RestaurantPayment;
                        // $payment->uid = $uid;
                        // $payment->restaurant_id = $restaurant->restaurant_id;
                        // $payment->subscription_id = $subscription->subscription_id;
                        // $payment->stripe_subscription_id = $scheduleSubscription['id'];
                        // $payment->status = Config::get('constants.PAYMENT_STATUS.NOT_STARTED');
                        // $payment->amount = $subscription->price;
                        // $payment->currency = 'USD';
                        // $payment->response = json_encode($scheduleSubscription);
                        // $payment->save();

                        $subscription_save = new RestaurantSubscription;
                        $subscription_save->restaurant_id = $restaurant->restaurant_id;
                        $subscription_save->uid = $uid;
                        $subscription_save->subscription_id = $subscription->subscription_id;
                        $subscription_save->stripe_subscription_id = $scheduleSubscription['id'];
                        $subscription_save->stripe_payment_method = $paymentMethodId;
                        $subscription_save->start_date = \Carbon\Carbon::parse($scheduleSubscription['current_period_start'])->format('Y-m-d');
                        $subscription_save->end_date = \Carbon\Carbon::parse($scheduleSubscription['current_period_end'])->format('Y-m-d');
                        $subscription_save->status = Config::get('constants.STATUS.SCHEDULE');
                        $subscription_save->save();

                    }

                    DB::commit();
                    return redirect()->route('campaigns')->with('success', Config::get('constants.SUBSCRIPTION.ACTIVE_MESSAGE'));
                }
            } else {

                // $currentPlan = RestaurantPayment::with('subscription')->where('restaurant_id', $restaurant->restaurant_id)->where('stripe_subscription_id', $restaurant->stripe_subscription_id)->where('status', Config::get('constants.PAYMENT_STATUS.SUCCESS'))->first();
                $currentPlan = RestaurantSubscription::with('payment', 'subscription')->where('restaurant_id', $restaurant->restaurant_id)->where('status', Config::get('constants.STATUS.ACTIVE'))->orderBy('restaurant_subscription_id', 'desc')->first();

                if ($request->post('payment_method')) {
                    $paymentMethodId = $request->post('payment_method');
                    $next_subscription = upgrade_subscription(json_decode($currentPlan->payment->response), $paymentMethodId, $restaurant, $subscription);

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

                    $next_subscription = upgrade_subscription(json_decode($currentPlan->payment->response), $paymentMethodId, $restaurant, $subscription);
                }

                if ($next_subscription == true) {
                    return redirect()->route('campaigns')->with('success', Config::get('constants.SUBSCRIPTION.UPGRADE_MESSAGE'));
                } else {
                    return redirect()->back()->with('error', $next_subscription);
                }
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function upgradeSubscription()
    {
        if (Auth::check()) {
            $data['subscriptions'] = Subscription::where('subscription_plan', Config::get('constants.SUBSCRIPTION_PLAN.2'))->get();
            $data['upgrade_subscription'] = true;
            return view('subscription.index', $data);
        } else {
            abort('404');
        }
    }

    public function cancel_subscription($subscriptionId)
    {
        try {
            DB::beginTransaction();

            $uid = Auth::user()->uid;
            $restaurant = Restaurant::where('uid', $uid)->first();
            $stripe = Stripe::make(env('STRIPE_SECRET'));

            $subscription = $stripe->subscriptions()->cancel($restaurant->stripe_customer_id, $subscriptionId);
            if ($subscription['status'] == 'canceled') {
                $subscription_update = RestaurantSubscription::where('stripe_subscription_id', $subscriptionId)->first();
                $subscription_update->status = Config::get('constants.STATUS.INACTIVE');
                $subscription_update->save();

                User::where('uid', $uid)->update(['email_subscription' => Config::get('constants.SUBSCRIPTION.INACTIVE')]);
            }
            DB::commit();

            Toastr::success('Subscription cancel successfully.', '', Config::get('constants.toster'));
            return redirect()->route('subscriptions');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
