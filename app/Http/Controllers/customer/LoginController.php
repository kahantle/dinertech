<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Mail\CustomerForgotMail;
use App\Models\CustomerAddress;
use App\Models\Restaurant;
use App\Models\RestaurantUser;
use App\Models\User;
use App\Notifications\Otp;
use Auth;
use Carbon\Carbon;
use Config;
use DB;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{

    // use AuthenticatesUsers;
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';
    // protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function attemptLogin(Request $request)
    {
        $username = $request->post('username');
        // 
        $restaurantId = 1;
        /*$user = User::where('role', Config::get('constants.ROLES.CUSTOMER'))
            ->whereHas('restaurant_user', function ($query) use ($restaurantId) {
                $query->where('restaurant_id', $restaurantId);
            })
            ->where(function ($query) use ($username) {
                $query->where('email_id', $username);
                $query->orWhere('mobile_number', $username);
            })->first();*/
            $user = User::where('role', Config::get('constants.ROLES.CUSTOMER'))
                ->with('restaurant_user')
                ->where(function ($query) use ($username) {
                    $query->where('email_id', $username);
                    $query->orWhere('mobile_number', $username);
                })->first();
        if (!$user) {
            return "Customer does not exist.";
        }
        // dd($user);
        if (!empty($user->restaurant_user)) {
            foreach ($user->restaurant_user as $restaurant) {
                session()->put('restaurantId', $restaurant->restaurant_id);
            }
        }

        if (empty(session()->get('restaurantId'))) {
            session()->put('restaurantId', $restaurantId);
        }

        $login_array = array();
        // if ($user->mobile_number) {
        //     $login_array = (['email_id' => $user->email_id, 'password' => $request->password]);
        // }
        $login_array = (['email_id' => $user->email_id, 'password' => $request->password]);

        if (auth()->attempt($login_array)) {
            return "Success";
        } else {
            return "Please enter valid detail.";
        }

    }

    public function logout(Request $request)
    {
        $uid = Auth::user()->uid;
        User::where('uid',$uid)->update(['device_key' => NULL]);
        Auth::logout();
        return redirect()->route('customer.index');
    }

    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email_id' => 'required|unique:users',
            'password' => 'required',
            'mobile_number' => 'required|unique:users',
        ]);
        $restaurantId = session()->get('restaurantId');
        if ($validator->passes()) {

            try {
                $user = new User();
                $user->role = Config::get('constants.ROLES.CUSTOMER');
                $user->first_name = $request->first_name;
                $user->last_name = $request->last_name;
                $user->email_id = $request->email_id;
                $user->mobile_number = $request->mobile_number;
                $user->password = \Hash::make($request->password);
                $user->otp = 1234;
                $user->save();

                CustomerAddress::create([
                    'uid' => $user->uid,
                    'address' => $request->physical_address,
                    'state' => $request->state,
                    'city' => $request->city,
                    'zip' => $request->zipcode,
                ]);

                RestaurantUser::create([
                    'uid' => $user->uid,
                    'restaurant_id' => $restaurantId,
                    'status' => Config::get('constants.STATUS.ACTIVE'),
                    'created_at' => date('Y-m-d H:i:s'),
                ]);

                $restaurant_detail = Restaurant::where('restaurant_id', $restaurantId)->first();
                if ($restaurant_detail->cm_client_id) {
                    $customer = [
                        'email' => $user->email_id,
                        'name' => $user->getFullNameAttribute(),
                        'uid' => $user->uid,
                    ];
                    create_subscriber($restaurant_detail->cm_client_id, $customer, $restaurantId);
                }
                return response()->json(['success' => 'Customer register successfully.']);

            } catch (\Throwable $th) {
                return response()->json(['error' => $th->getMessage()]);
            }
        } else {
            return response()->json(['error' => $validator->errors()->toArray()]);
        }
    }

    public function forgotPassword(Request $request)
    {
        if ($request->ajax()) {
            $request->validate([
                'email_mobile_number' => 'required',
            ]);

            $email = $request->post('email_mobile_number');

            $user = User::where('role', Config::get('constants.ROLES.CUSTOMER'))->where(function ($query) use ($email) {
                $query->where('email_id', $email);
                $query->orWhere('mobile_number', $email);
            })->first();

            if ($user == null) {
                return response()->json(['success' => false, 'message' => 'User does not exist'], 200);
            }

            DB::beginTransaction();
            $user->otp = mt_rand(Config::get('constantsOTP_NO_OF_DIGIT'), 9999);
            $user->otp_valid_time = Carbon::now()->addMinutes(Config::get('constants.OTP_VALID_DURATION'));
            $user->save();

            try {

                $data = [
                    'otp' => $user->otp,
                    'customer_name' => $user->getFullNameAttribute(),
                ];

                Mail::to($user->email_id)->send(new CustomerForgotMail($data));

                $otp = new Otp();
                $otp->sendOTP($user);
                DB::commit();
                return response()->json(['success' => true, 'message' => 'Otp Send on your registered email address.', 'email_id' => $user->email_id], 200);
            } catch (\Throwable $th) {
                return response()->json(['success' => false, 'message' => 'Some error in send email.'], 200);
            }
        }
    }

    public function verifyOtp(Request $request)
    {
        $otp = implode("", $request->post("otp_digit"));
        $email = $request->post('email_id');
        $user = User::where('role', Config::get('constants.ROLES.CUSTOMER'))
            ->where('otp', $otp)
            ->where(function ($query) use ($email) {
                $query->where('email_id', $email);
                $query->orWhere('mobile_number', $email);
            })
            ->first();
        if ($user) {
            DB::beginTransaction();
            $user->is_verified_at = Carbon::now();
            $user->otp = null;
            $user->otp_valid_time = null;
            $user->save();
            DB::commit();
            return response()->json(['success' => true, 'message' => 'You have successfully verified otp.'], 200);
        } else {
            return response()->json(['success' => false, 'message' => 'Invalid otp.'], 200);
        }
    }

    public function resetPassword(Request $request)
    {
        $restaurantId = session()->get('restaurantId');
        $email = $request->post('email_id');
        $user = User::where(function ($query) use ($email) {
            $query->where('email_id', $email);
            $query->orWhere('mobile_number', $email);
        })
            ->where('role', Config::get('constants.ROLES.CUSTOMER'))
            ->whereHas('restaurant_user', function ($query) use ($restaurantId) {
                $query->where('restaurant_id', $restaurantId);
            })
            ->first();
        if ($user) {
            DB::beginTransaction();
            $user->password = Hash::make($request->post('password'));
            $user->save();
            DB::commit();
            return response()->json(['success' => true, 'message' => 'You have successfully reset password.'], 200);

        } else {
            return response()->json(['success' => false, 'message' => 'Some error in password change.'], 200);

        }

    }

    public function emailUnique(Request $request)
    {
        $email = trim($request->email);
        $user = User::where('email_id', $email)->where('role', Config::get('constants.ROLES.CUSTOMER'))->first();
        if (!$user) {
            return true;
        }
    }

    public function mobileUnique(Request $request)
    {
        $mobileNumber = trim($request->mobile);
        $user = User::where('mobile_number', $mobileNumber)->where('role', Config::get('constants.ROLES.CUSTOMER'))->first();
        if (!$user) {
            return true;
        }
    }
}
