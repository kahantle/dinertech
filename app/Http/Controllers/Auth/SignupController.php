<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Restaurant;
use App\Models\RestaurantPayment;
use App\Http\Requests\SignupRequest;
use App\Http\Requests\PaymentRequest;
use Illuminate\Http\Request;
use Config;
use App\Notifications\Otp;
use Carbon\Carbon;
use Hash;
use DB;
use Cartalyst\Stripe\Stripe;


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
        return view('auth.register');
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
            $restaurant->save();
            DB::commit();
            return redirect()->route('show.pay', ['username' => ($user->email) ? $user->email : $user->mobile_number])->with('success', 'Please make payment for complete signup.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('register')->with('error',  $th->getMessage());
        }
    }


    public function showPayment(Request $request)
    {
        $username = $request->post('username');
        return view('auth.payment',compact('username'));
    }

    protected function payment(Request $request)
    {
        $username = $request->post('username');
        $user = User::where(function ($query) use ($username) {
            $query->where('email_id',  $username);
            $query->orWhere('mobile_number', $username);
        })->first();

        if(!$username) {
            return redirect()->route('register')->with('success', 'Does not have successfully signup please try again.');
        }

        try {
            DB::beginTransaction();
            $stripe = Stripe::make(env('STRIPE_SECRET'));
            $token = $stripe->tokens()->create([
                'card' => [
                'number' => implode("", $request->post('digit')),
                'exp_month' => $request->get('ccExpiryMonth'),
                'exp_year' => $request->get('ccExpiryYear'),
                'cvc' => $request->get('cvvNumber'),
                ],
            ]);
           if (!isset($token['id'])) {
                return redirect()->route('show.pay');
            }
            $charge = $stripe->charges()->create([
                'card' => $token['id'],
                'currency' => 'USD',
                'amount' => Config::get('constants.RESTAURANT_CHARGE'),
                'description' => 'restaurants initial changes',
            ]);
            $username = $request->post('username');
            $user = User::where(function ($query) use ($username) {
                $query->where('email_id',  $username);
                $query->orWhere('mobile_number', $username);
            })->first();
            if($charge['status'] == 'succeeded') {
                $payment = New RestaurantPayment;
                $payment->uid = $user->uid;
                $payment->restaurant_id = $user->restaurant->restaurant_id;
                $payment->status = 'SUCCESS';
                $payment->amount =  Config::get('constants.RESTAURANT_CHARGE');
                $payment->currency = 'USD';
                $payment->response = json_encode($charge);
                $payment->save();
                DB::commit();
                return redirect()->route('verify', ['username' => ($user->email) ? $user->email : $user->mobile_number])->with('success', 'You have successfully paid please verify by otp.');
            } 
            return redirect()->route('show.pay', ['username' => ($user->email) ? $user->email : $user->mobile_number])->with('error', 'Signup does not successfully please try again.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('show.pay', ['username' => ($user->email) ? $user->email : $user->mobile_number])->with('error',  $th->getMessage());
       }
    }
}
