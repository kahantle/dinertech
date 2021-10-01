<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Notifications\Otp;
use Carbon\Carbon;
use Hash;
use Config;
use DB;

class ForgotpasswordController extends Controller
{
    public function forgotPasswordShow()
    {
        return view('admin.auth.forgot');
    }

    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email_phone_number' => 'required'
        ],[
            'email_phone_number.required' => 'This field is required'
        ]);
        
        $mobileNumber_email = $request->post('email_phone_number');

        $user = User::where('role',Config::get('constants.ROLES.ADMIN'))->where('email_id',$mobileNumber_email)->orWhere('mobile_number',$mobileNumber_email)->first();
        
        if($user->status == Config::get('constants.STATUS.ACTIVE'))
        {
            DB::beginTransaction();
            $user->otp = 1234;
            $user->otp_valid_time = Carbon::now()->addMinutes(Config::get('constants.OTP_VALID_DURATION'));
            $user->save();
            $otp = new Otp();
            $otp->sendOTP($user);
            DB::commit();
            session()->put('admin_id',$user->uid);
            return redirect()->route('admin.auth.forgot-password.verifyProcess');
        }
        else
        {
            return redirect()->back()->withInput()->with('error','Your account is inactive.');
        }
    }

    public function verifyProcess()
    {
        return view('admin.auth.forgot_verification');
    }

    public function verifyOtp(Request $request)
    {
        
        $number_one = $request->post('number_one');
        $number_two = $request->post('number_two');
        $number_three = $request->post('number_three');
        $number_fourth = $request->post('number_fourth');
        $uid = $request->post('admin_id');

        if(!empty($number_one) && !empty($number_two) && !empty($number_three) && !empty($number_fourth))
        {
            $otp = $number_one.$number_two.$number_three.$number_fourth;
            $user = User::where('role',Config::get('constants.ROLES.ADMIN'))->where('otp',$otp)->where('uid',$uid)->first();
            if ($user) {
                // $data['user_id'] = $user->uid; 
                DB::beginTransaction();
                $user->is_verified_at = Carbon::now();
                $user->otp = NULL;
                $user->otp_valid_time = NULL;
                $user->save();
                DB::commit();
                return redirect()->route('admin.auth.change-password.show');
                // return view('admin.auth.forgot_password',$data);
            } else {
                return redirect()->back()->with("error","Please enter valid otp.");
            }
        }
        else
        {
            return redirect()->back()->with("error","Please enter otp.");
        }
    }

    public function changePasswordShow()
    {
        $data['user_id'] = session()->get('admin_id');
        return view('admin.auth.forgot_password',$data);
    }

    public function resetPassword(Request $request)
    {
        $adminId = $request->post('admin_id');
        $user = User::where('role',Config::get('constants.ROLES.ADMIN'))->where('uid',$adminId)->first();
        if ($user) {
            DB::beginTransaction();
            $user->password = Hash::make($request->post('password'));
            $user->save();
            DB::commit();
            session()->forget('admin_id');
            return redirect()->route('admin.auth.login')->with('success','Password reset successfully.');
        } else {
            dd('hello');
            return redirect()->back()->with('error','Some error in password reset.');
        }
    }
}
