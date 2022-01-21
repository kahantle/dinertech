<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\ResetPasswordRequest;
use Illuminate\Support\Str;
use DB;
use Hash;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Mail\ForgotMail;

class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    public function showform()
    {
        return view('auth.forgot');
    }

    public function showPasswordResetForm(Request $request)
    {
        $token = $request->token;
        return view('auth.reset_pass',compact('token'));
    }

    public function sendPasswordResetToken(ForgotPasswordRequest $req)
    {
        $user = DB::table('users')->where('email_id', '=', $req->email)
           ->first();

        if ($user == null){
            return redirect()->back()->with(['error' => 'User does not exist']);
        }

        $token = Str::random(40);
        DB::table('password_resets')->insert([
            'email_id' => $req->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        $tokenData = DB::table('password_resets')->where('email_id', $req->email)->first();
        $data['user'] = $user;
        $data['link'] = url('reset-password'. '/' .$tokenData->token) ;
        Mail::to($req->email)->send(new ForgotMail($data));
        return redirect()->route('login')->with('success', trans('A reset link has been sent to your email address.'));
    }   

    private function sendResetEmail($email, $token)
    {
        $user = DB::table('users')->where('email_id', $email)->select('first_name','email_id')->first();

        Mail::send(
            'emails.forgot',
            ['user' => $user, 'token'=>$token],
            function($message) use ($user){
                $message->to($user->email_id);
                $message->subject("$user->first_name, reset your password");
            }
        );
        $link = config('base_url') . 'password/reset/' . $token . '?email_id=' . urlencode($user->email_id);

        try { 
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function updatePassword(ResetPasswordRequest $request)
    {
        $tokenData = DB::table('password_resets')->where('token', $request->key)->first();
        if (!$tokenData){
            return redirect()->route('status')
            ->with('error','Reset Password Link Is expired !!!');
        }
        $user = User::where('email_id', $tokenData->email_id)->first();
        if ($user) {
            $user->password = Hash::make($request->password);
                if ($user->save()) {
                DB::table('password_resets')->where('token', $request->key)->delete();
                    return redirect()->route('status')
                            ->with('success','Password Reset Sucsessfully');

                } else {
                    return redirect()->route('status')
                            ->with('error','Something Went Wrong !!!');
            }
        }
    }
}
