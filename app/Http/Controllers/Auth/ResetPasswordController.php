<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use App\Http\Requests\Frontend\ResetPasswordRequest;
use App\Models\User;
use Hash;
use DB;

class ResetPasswordController extends Controller
{
    public function updatePassword(ResetPasswordRequest $request)
    {
        $tokenData = DB::table('password_resets')->where('token', $request->token)->first();
        if (!$tokenData) return response()->json([
            'status' => false,
            'message' => 'Invalid link please try again.'
        ]);
        $user = User::where('email', $tokenData->email)->first();
        if ($user) {
            $user->password = Hash::make($request->password);
            if ($user->save()) {
                DB::table('password_resets')->where('token', $request->token)->delete();
                return response()->json([
                    'status' => true,
                    'user_id' => $user->id,
                    'message' => 'Password reset successfully.'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Password reset does not successfully.'
                ]);
            }
        }
    }
}
