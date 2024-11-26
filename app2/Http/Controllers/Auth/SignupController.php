<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\SignupRequest;
use App\Models\Restaurant;
use App\Models\RestaurantPayment;
use App\Models\Subscription;
use App\Models\RestaurantSubscription;
use App\Models\User;
use App\Notifications\Otp;
use Carbon\Carbon;
use Cartalyst\Stripe\Stripe;
use Config;
use DB;
use Hash;
use Illuminate\Http\Request;

class SignupController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function show()
    {
        $countries = new \CS_REST_General($this->getAuthTokens());
        if($countries->get_countries()->http_status_code == 200){
            $data['countries'] = $countries->get_countries()->response;
            return view('auth.register', $data);
        }else{
            return back()->with('error', 'Countries api error.');
        }
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(SignupRequest $request)
    {
        try {
            DB::beginTransaction();
            $user = new User();
            $user->first_name = $request->post('first_name');
            $user->last_name = $request->post('last_name');
            $user->email_id = $request->post('email_id');
            $user->mobile_number = $request->post('mobile_number');
            $user->password = Hash::make($request->post('password'));
            $user->role = Config::get('constants.ROLES.RESTAURANT');
            $user->otp = mt_rand(Config::get('constantsOTP_NO_OF_DIGIT'), 9999);
            //$user->otp = 1234;
            $user->otp_valid_time = Carbon::now()->addMinutes(Config::get('constants.OTP_VALID_DURATION'));
            $user->status = Config::get('constants.STATUS.INACTIVE');
            $user->save();
            $otp = new Otp();
            $otp->sendOTP($user);
            $restaurant = new Restaurant;
            $restaurant->uid = $user->uid;
            $restaurant->restaurant_name = $request->post('restaurant_name');
            $restaurant->restaurant_state = $request->post('restaurant_state');
            $restaurant->restaurant_city = $request->post('restaurant_city');
            $restaurant->restaurant_zip = $request->post('restaurant_zip');
            $restaurant->restaurant_address = $request->post('restaurant_address');
            $restaurant->restaurant_country = $request->post('country');
            $restaurant->timezone = ($request->post('timezone')) ? timezone($request->post('timezone')) : null;
            $restaurant->save();
            DB::commit();
            return redirect()->route('show.pay', ['username' => ($user->email) ? $user->email : $user->mobile_number])->with('success', 'Please make payment for complete signup.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('register')->with('error', $th->getMessage());
        }
    }

    public function showPayment(Request $request)
    {
        $username = $request->post('username');
        return view('auth.payment', compact('username'));
    }

    protected function payment(Request $request)
    {
        $username = $request->post('username');
        $user = User::where(function ($query) use ($username) {
            $query->where('email_id', $username);
            $query->orWhere('mobile_number', $username);
        })->first();

        if (!$username) {
            return redirect()->route('register')->with('success', 'Does not have successfully signup please try again.');
        }

        $subscription = Subscription::where('subscription_plan', Config::get('constants.SUBSCRIPTION_PLAN.1'))->first();
        $stripe = Stripe::make(env('STRIPE_SECRET'));
        try {
            DB::beginTransaction();

            $customer = $stripe->customers()->create([
                'email' => $user->email_id,
                'name' => $user->restaurant->restaurant_name,
            ]);

            $customerId = $customer['id'];

            $data = [
                'number' => implode("", $request->post('digit')),
                'exp_month' => $request->get('ccExpiryMonth'),
                'exp_year' => $request->get('ccExpiryYear'),
                'cvc' => $request->get('cvvNumber'),
            ];

            // $paymentMethodId = $paymentMethod['id'];
            // Add New card
            $paymentMethodId = stripeAddCard($data, $customerId);

            // $attachPayment = $stripe->paymentMethods()->attach($paymentMethodId, $customerId);

            $stripe_subscription = $stripe->subscriptions()->create($customerId, [
                'items' => [
                    [
                        'price_data' => [
                            'unit_amount' => Config::get('constants.RESTAURANT_CHARGE') * 100,
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

            $username = $request->post('username');
            $user = User::where(function ($query) use ($username) {
                $query->where('email_id', $username);
                $query->orWhere('mobile_number', $username);
            })->first();
            if ($stripe_subscription['status'] == 'active') {

                $restaurant = Restaurant::where('uid', $user->restaurant->uid)->first();
                $restaurant->stripe_customer_id = $customerId;
                // $restaurant->stripe_subscription_id = $subscription['id'];
                // $restaurant->stripe_payment_method = $paymentMethodId;
                $restaurant->save();

                $payment = new RestaurantPayment;
                $payment->uid = $user->uid;
                $payment->restaurant_id = $user->restaurant->restaurant_id;
                $payment->stripe_subscription_id = $stripe_subscription['id'];
                $payment->status = 'SUCCESS';
                $payment->amount = Config::get('constants.RESTAURANT_CHARGE');
                $payment->currency = 'USD';
                $payment->response = json_encode($subscription);
                $payment->save();
                DB::commit();

                $last_paymentId = RestaurantPayment::where('restaurant_id', $user->restaurant->restaurant_id)->where('uid', $user->uid)->orderBy('id', 'desc')->first();
                $subscription_save = new RestaurantSubscription;
                $subscription_save->restaurant_id = $user->restaurant->restaurant_id;
                $subscription_save->uid = $user->uid;
                $subscription_save->subscription_id = $subscription->subscription_id;
                $subscription_save->stripe_subscription_id = $stripe_subscription['id'];
                $subscription_save->stripe_payment_method = $paymentMethodId;
                $subscription_save->start_date = \Carbon\Carbon::parse($stripe_subscription['current_period_start'])->format('Y-m-d H:i:s');
                $subscription_save->end_date = \Carbon\Carbon::parse($stripe_subscription['current_period_end'])->format('Y-m-d H:i:s');
                $subscription_save->status = Config::get('constants.STATUS.ACTIVE');
                $subscription_save->restaurant_payment_id = $last_paymentId->id;
                $subscription_save->subscription_plan = Config::get('constants.SUBSCRIPTION_PLAN.1');
                $subscription_save->save();

                return redirect()->route('verify', ['username' => ($user->email) ? $user->email : $user->mobile_number])->with('success', 'You have successfully paid please verify by otp.');
            }
            return redirect()->route('show.pay', ['username' => ($user->email) ? $user->email : $user->mobile_number])->with('error', 'Signup does not successfully please try again.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('show.pay', ['username' => ($user->email) ? $user->email : $user->mobile_number])->with('error', $th->getMessage());
        }

    }

    protected function getAuthTokens()
    {
        return [
            'api_key' => Config::get('campaignmonitor.api_key'),
        ];
    }
}
