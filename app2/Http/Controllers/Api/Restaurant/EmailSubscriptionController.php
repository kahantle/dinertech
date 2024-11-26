<?php

namespace App\Http\Controllers\Api\Restaurant;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubscriptionPaymentRequest;
use App\Models\Restaurant;
use App\Models\RestaurantPayment;
use App\Models\RestaurantSubscription;
use App\Models\Subscription;
use App\Models\User;
use Carbon\Carbon;
use Cartalyst\Stripe\Stripe;
use Config;
use DB;
use Illuminate\Http\Request;

class EmailSubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($uid = null)
    {
        $data['subscriptions'] = Subscription::where('subscription_plan', Config::get('constants.SUBSCRIPTION_PLAN.2'))->get();
        $data['uid'] = $uid;
        $data['upgrade_subscription'] = false;

        return view('subscription-webview.index', $data);
    }

    public function paymentModal(Request $request)
    {
        if ($request->ajax()) {

            try {
                $uid = $request->post('userId');
                $subscription = Subscription::where('subscription_id', $request->post('subscriptionId'))->first();
                if (Config::get('constants.SUBSCRIPTION_TYPE.MONTH') == $subscription->subscription_type) {
                    $data['sub_type'] = \Str::lower(Config::get('constants.SUBSCRIPTION_TYPE.MONTH'));
                } else {
                    $data['sub_type'] = \Str::lower(Config::get('constants.SUBSCRIPTION_TYPE.YEAR'));
                }
                $data['subscription'] = $subscription;
                $data['upgrade'] = ($request->post('upgrade') == 'true') ? true : false;

                $restaurant = Restaurant::where('uid', $uid)->first();
                $stripe = Stripe::make(env('STRIPE_SECRET'));
                $data['paymentMethods'] = $stripe->paymentMethods()->all([
                    'type' => 'card',
                    'customer' => $restaurant->stripe_customer_id,
                ]);
                $data['userId'] = $uid;
                $view = view('subscription-webview.payment', $data)->render();
                return response()->json(['status' => 'success', 'view' => $view], 200);

            } catch (\Throwable $th) {
                return response()->json(['status' => 'error', 'message' => $th->getMessage()], 500);
            }
        }
    }

    public function subscriptionPayment(SubscriptionPaymentRequest $request)
    {
        $uid = $request->post('userId');
        $restaurant = Restaurant::where('uid', $uid)->first();
        $user = User::where('uid', $uid)->first();
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
        $registrationEndDate = new Carbon($restaurantSubscription->current_period_end);
        $endDate = $registrationEndDate->format('Y-m-d');
        $totalSubscriptionDays = $registrationEndDate->diff($startDate);

        $today = Carbon::now()->format('Y-m-d');

        try {
            if ($request->post('upgrade') == false) {
                DB::beginTransaction();

                if ($startDate == $today || $user->email_subscription == Config::get('constants.STATUS.INACTIVE')) {
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

                        $last_paymentId = RestaurantPayment::orderBy('id', 'desc')->first();
                        $subscription_save = new RestaurantSubscription;
                        $subscription_save->restaurant_id = $restaurant->restaurant_id;
                        $subscription_save->uid = $uid;
                        $subscription_save->subscription_id = $subscription->subscription_id;
                        $subscription_save->stripe_subscription_id = $stripe_subscription['id'];
                        $subscription_save->stripe_payment_method = $paymentMethodId;
                        $subscription_save->status = Config::get('constants.STATUS.ACTIVE');
                        $subscription_save->restaurant_payment_id = $last_paymentId->id;
                        $subscription_save->save();

                        User::where('uid', $uid)->update(['email_subscription' => Config::get('constants.SUBSCRIPTION.ACTIVE')]);

                        // Create Campaign monitor client
                        if ($restaurant->cm_client_id == null) {
                            campaignMonitorClient($restaurantData);
                        }

                    }
                    return redirect()->route('restaurant.email.campaigns', $uid);

                } else {
                    $stripe = Stripe::make(env('STRIPE_SECRET'));

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
                        // $payment->subscription_id = $subscription->subscription_id;
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
                        // $payment->status = 'NOT STARTED';
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
                        $subscription_save->status = Config::get('constants.STATUS.SCHEDULE');
                        $subscription_save->save();
                    }

                    DB::commit();

                    // return response()->json(['campaigns_webview_url' => route('restaurant.email.campaigns'), 'message' => Config::get('constants.SUBSCRIPTION.ACTIVE_MESSAGE'), 'success' => true], 200);
                    return redirect()->route('restaurant.email.campaigns', $uid);
                }
            } else {
                $currentPlan = RestaurantSubscription::with('payment')->where('restaurant_id', $restaurant->restaurant_id)->where('status', Config::get('constants.STATUS.ACTIVE'))->orderBy('restaurant_subscription_id', 'desc')->first();

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
                    return redirect()->route('restaurant.email.campaigns', $uid);
                } else {
                    return redirect()->back()->with('error', $next_subscription);
                }
            }

        } catch (\Throwable $th) {
            DB::rollBack();
            $errors['success'] = false;
            $errors['message'] = Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS');
            $errors['debug'] = $th->getMessage();
            return response()->json($errors, 500);
        }
    }

    public function campaigns($uid = null)
    {
        try {
            $restaurant = Restaurant::withCount('subscribers')->where('uid', $uid)->first();
            if ($restaurant) {
                $data['uid'] = $uid;
                $data['restaurant_subscribers'] = $restaurant->subscribers_count;
                $currentPlan = RestaurantSubscription::with(['payment', 'subscription'])->where('restaurant_id', $restaurant->restaurant_id)->where('status', Config::get('constants.STATUS.ACTIVE'))->orderBy('restaurant_subscription_id', 'desc')->first();
                $data['currentPlan'] = $currentPlan->subscription;
                $data['stripeSubscription'] = json_decode($currentPlan->payment->response);

                if ($restaurant->cm_client_id != null) {
                    $draftCampaigns = \CampaignMonitor::clients($restaurant->cm_client_id)->get_drafts();
                    if (!empty($draftCampaigns->response)) {
                        $data['draftCampaigns'] = $draftCampaigns->response;
                    } else {
                        $data['draftCampaigns'] = array();
                    }

                    $sentCampaigns = \CampaignMonitor::clients($restaurant->cm_client_id)->get_campaigns();
                    if (!empty($sentCampaigns->response)) {
                        $data['sentCampaigns'] = $sentCampaigns->response;
                    } else {
                        $data['sentCampaigns'] = array();
                    }
                } else {
                    $data['sentCampaigns'] = array();
                    $data['draftCampaigns'] = array();
                }
                return view('campaign-webview.index', $data);

            }
        } catch (\Throwable $th) {
            $errors['success'] = false;
            $errors['message'] = Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS');
            $errors['debug'] = $th->getMessage();
            return response()->json($errors, 500);
        }
    }

    public function createCampaigns($uid)
    {
        try {
            $restaurant = Restaurant::where('uid', $uid)->first();
            $data = array(
                'Email' => Config::get('constants.CAMPAIGN_MONITOR.EMAIL'),
                'Chrome' => Config::get('constants.CAMPAIGN_MONITOR.CHROME'),
                'Url' => '/campaigns/',
                'IntegratorID' => env('CAMPAIGNMONITOR_INTEGRATOR_ID'),
                'ClientID' => $restaurant->cm_client_id,
            );
            $clientCreate = \CampaignMonitor::getExternalSession($data);
            return redirect($clientCreate->response->SessionUrl);
        } catch (\Throwable $th) {
            $errors['success'] = false;
            $errors['message'] = Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS');
            $errors['debug'] = $th->getMessage();
            return response()->json($errors, 500);
        }
    }

    public function getReport(Request $request)
    {
        $campaignId = $request->post('campaignId');
        try {
            $summary = \CampaignMonitor::campaigns($campaignId)->get_summary();
            $data['summary'] = $summary->response;
            $view = view('campaign-webview.report', $data)->render();
            return response()->json(['success' => true, 'view' => $view], 200);
        } catch (\Throwable $th) {
            $errors['success'] = false;
            $errors['message'] = Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS');
            $errors['debug'] = $th->getMessage();
            return response()->json($errors, 500);
        }
    }

    public function destroy(Request $request)
    {
        $campaignId = $request->post('campaignId');
        try {
            $delete = \CampaignMonitor::campaigns($campaignId)->delete();
            if ($delete->was_successful()) {
                $alert = ['Campaign delete successfully', '', Config::get('constants.toster')];
            }
            return response()->json(['alert' => $alert, 'success' => true], 200);
        } catch (\Throwable $th) {
            $errors['success'] = false;
            $errors['message'] = Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS');
            return response()->json($errors, 500);
        }
    }

    public function upgradeSubscription($uid = null)
    {
        $data['subscriptions'] = Subscription::where('subscription_plan', Config::get('constants.SUBSCRIPTION_PLAN.2'))->get();
        $data['upgrade_subscription'] = true;
        $data['uid'] = $uid;
        return view('subscription-webview.index', $data);
    }

    public function cancel_subscription($subscriptionId, $uid)
    {
        try {
            DB::beginTransaction();

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

            return redirect()->route('restaurant.email.subscriptions.list', $uid);
        } catch (\Throwable $th) {
            DB::rollBack();
            $errors['success'] = false;
            $errors['message'] = Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS');
            $errors['debug'] = $th->getMessage();
            return response()->json($errors, 500);
        }
    }
}
