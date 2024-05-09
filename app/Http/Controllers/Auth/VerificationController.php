<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\VerifyRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Notifications\Otp;
use DB;
use Config;
use Illuminate\Support\Carbon;
use Toastr;
use Validator;

class VerificationController extends Controller
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

    public function index(Request $request)
    {
        $username = $request->get('username');
//        dd($username);
        return view('auth.verify', compact('username'));
    }


    public function verify(VerifyRequest $request)
    {
        try {
            $username = $request->post('username');
//            dd($username);
            $user = User::where('role', Config::get('constants.ROLES.RESTAURANT'))
                ->where('otp', implode("", $request->post('digit')))
                ->where(function ($query) use ($username) {
                    $query->where('email_id',  $username);
                    $query->orWhere('mobile_number', $username);
                })
                ->first();
//            dd($user);
            if ($user) {
                DB::beginTransaction();
                $user->is_verified_at = Carbon::now();
                $user->otp = NULL;
                $user->otp_valid_time = NULL;
                $user->status = Config::get('constants.STATUS.ACTIVE');
                $user->save();
                DB::commit();
                Toastr::success('You have successfully verified account.','', Config::get('constants.toster'));
                return redirect()->route('login');
            } else {
                Toastr::error('Please enter valid otp.','', Config::get('constants.toster'));
                return redirect()->route('verify', ['username' =>  $request->post('username')]);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('verify', ['username' =>  $request->post('username')])->with('error',  $th->getMessage());
        }
    }


    public function resend(Request $request)
    {
        try {
            DB::beginTransaction();

            $validator = Validator::make($request->post(),[
                'username' => 'required'
            ],[
                'username.required' => 'Please enter your register email or phone number.'
            ]);

            if($validator->fails()){
                return redirect()->back()->withErrors($validator->errors());
            }

            $username = $request->post('username');
            $user = User::where('role', Config::get('constants.ROLES.RESTAURANT'))
                ->where(function ($query) use ($username) {
                    $query->where('email_id',  $username);
                    $query->orWhere('mobile_number', $username);
                })
                ->first();
            if ($user) {
                $user->otp = mt_rand(Config::get('constantsOTP_NO_OF_DIGIT'), 9999);
                //$user->otp = 1234;
                $user->otp_valid_time = Carbon::now()->addMinutes(Config::get('constants.OTP_VALID_DURATION'));
                $user->save();
                $otp = new Otp();
                $otp->sendOTP($user);
                DB::commit();
                Toastr::success('OTP sent successfully.','', Config::get('constants.toster'));
                return redirect()->route('verify', ['username' => $username]);
            }
            Toastr::error('User not found.','', Config::get('constants.toster'));
            // return redirect()->route('verify', ['username' => $username])->with('error', 'User not found');
            return redirect()->back()->withInput($request->all());
        } catch (\Throwable $th) {
            DB::rollBack();
            // return redirect()->route('verify', ['username' => $username])->with('error',  $th->getMessage());
            return redirect()->back()->with('error',  $th->getMessage());
        }
    }

    public function accountActiveRequest(){
        return view('auth.active_request');
    }
}
