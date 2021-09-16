<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\CustomerAddress;
use App\Models\RestaurantUser;
use Illuminate\Support\Facades\Validator;
use App\Notifications\Otp;
use Carbon\Carbon;
use Config;
use Auth;
use Toastr;
use DB;
use Hash;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
        $restaurantId = 1;
        $user = User::where('role', Config::get('constants.ROLES.CUSTOMER'))
                ->whereHas('restaurant_user', function ($query) use($restaurantId){
                    $query->where('restaurant_id', $restaurantId);
                })
                ->where(function ($query) use ($username) {
                    $query->where('email_id',  $username);
                    $query->orWhere('mobile_number', $username);
                })->with('restaurant_user')->first();
        if(!empty($user->restaurant_user))
        {
            foreach($user->restaurant_user as $restaurant)
            {
                session()->put('restaurantId', $restaurant->restaurant_id);
            }
        }
        
        if(empty(session()->get('restaurantId')))
        {
            session()->put('restaurantId', $restaurantId);
        }
        
        if(!$user) {
            return "Customer does not exist.";
        }
        $login_array = array();
        if ($user->mobile_number) {
            $login_array = (['email_id' => $user->email_id, 'password' => $request->password]);
        }
        
        if (auth()->attempt($login_array)) {
            return "Success";
        } else {
            return "Please enter valid detail.";
        }
        
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('customer.index');
    }

    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email_id'  => 'required|unique:users',
            'password'  => 'required',
            'mobile_number' => 'required|unique:users' 
        ]);

        if ($validator->passes()) {

            // $user = User::create([
            //     'role' => Config::get('constants.ROLES.CUSTOMER'),
            //     'first_name' => $request->first_name,
            //     'last_name'  => $request->last_name,
            //     'email_id'  =>  $request->email_id,
            //     'mobile_number' => $request->mobile_number,
            //     'password'   =>  \Hash::make($request->password),
            //     'otp'        => 1234
            // ]);
            $user = new User();
            $user->role = Config::get('constants.ROLES.CUSTOMER');
            $user->first_name = $request->first_name;
            $user->last_name  = $request->last_name;
            $user->email_id   = $request->email_id;
            $user->mobile_number = $request->mobile_number;
            $user->password = \Hash::make($request->password);
            $user->otp = 1234;
            $user->save();

            CustomerAddress::create([
                'uid'  => $user->uid,
                'address'  => $request->physical_address,
                'state'  => $request->state,
                'city'   => $request->city,
                'zip'    => $request->zipcode,
            ]);

            RestaurantUser::create([
                'uid'  => $user->uid,
                'restaurant_id' => 1,
                'status'   => Config::get('constants.STATUS.ACTIVE'),
                'created_at' => date('Y-m-d H:i:s'),
            ]);
            return response()->json(['success' => 'Customer register successfuly.']);            
        }
        else
        {
            return response()->json(['error' => $validator->errors()->toArray()]);            
        }
    }

    public function forgotPassword(Request $request)
    { 
        if($request->ajax())
        {
            $request->validate([
                'email_mobile_number' =>  'required'
            ]);
            
            $restaurantId = 1;
            $email = $request->post('email_mobile_number');
            $user = User::where('role', Config::get('constants.ROLES.CUSTOMER'))
                ->where(function ($query) use ($email) {
                    $query->where('email_id',  $email);
                    $query->orWhere('mobile_number', $email);
                })
                ->whereHas('restaurant_user', function ($query) use ($restaurantId) {
                    $query->where('restaurant_id', $restaurantId);
                })->first();
            if ($user) {
                DB::beginTransaction();
                $user->otp = 1234;
                $user->otp_valid_time = Carbon::now()->addMinutes(Config::get('constants.OTP_VALID_DURATION'));
                $user->save();
                $otp = new Otp();
                $otp->sendOTP($user);
                DB::commit();
                session()->put('email_mobile_number',$email);
                return true;
            } else {
                return false;
            }
        }
    }

    public function verifyOtp(Request $request)
    {
        $restaurantId = 1;
        $otp = $request->number_one.$request->number_two.$request->number_three.$request->number_fourth;
        $email = session()->get('email_mobile_number');
        $user = User::where('role', Config::get('constants.ROLES.CUSTOMER'))
            ->where('otp', $otp)
            ->whereHas('restaurant_user', function ($query) use ($restaurantId) {
                $query->where('restaurant_id', $restaurantId);
            })
            ->where(function ($query) use ($email) {
                $query->where('email_id',  $email);
                $query->orWhere('mobile_number', $email);
            })
            ->first();
        if ($user) {
            DB::beginTransaction();
            $user->is_verified_at = Carbon::now();
            $user->otp = NULL;
            $user->otp_valid_time = NULL;
            $user->status = Config::get('constants.STATUS.ACTIVE');
            $user->save();
            session()->forget('email_mobile_number');
            DB::commit();
            return $user->uid;
        } else {
            return false;
        }
    }

    public function resetPassword(Request $request)
    {
        $restaurantId = 1;
        $user = User::where('uid', $request->post('uid'))
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
            return true;
        } else {
            return false;
        }
       
    }

    public function emailUnique(Request $request)
    {
        $email = trim($request->email);
        $user = User::where('email_id',$email)->where('role',Config::get('constants.ROLES.CUSTOMER'))->first();
        if(!$user)
        {
            return true;
        }
    }

    public function mobileUnique(Request $request)
    {
        $mobileNumber = trim($request->mobile);
        $user = User::where('mobile_number',$mobileNumber)->where('role',Config::get('constants.ROLES.CUSTOMER'))->first();
        if(!$user)
        {
            return true;
        }
    }
}
