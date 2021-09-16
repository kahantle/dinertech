<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Config;
use Auth;
use App\Models\User;
use Session;

class LoginController extends Controller
{
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = 'web/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => ['logout', 'userLogout']]);
    }

    public function show(Request $request)
    {
        return view('auth.login');
    }


    public function login(LoginRequest $request)
    {
        $username = $request->post('username');
        $user = User::where('role', Config::get('constants.ROLES.RESTAURANT'))
            ->where(function ($query) use ($username) {
                $query->where('email_id',  $username);
                $query->orWhere('mobile_number', $username);
            })->with('restaurant')->first();
        if(!$user) {
            return redirect()->route('login')->with('error', 'User not found.');
        }
        else if (!$user->is_verified_at) {
            return redirect()->route('login')->with('error', 'Please verify this account.');
        }
        $login_array = array();
        if ($user->mobile_number) {
            Session::put('resturant_id', $user->restaurant->restaurant_id);
            $login_array = (['mobile_number' => $user->mobile_number, 'password' => $request->password]);
        }
        if (Auth::attempt($login_array)) {
            return redirect()->route('dashboard')->with('success', 'Login Successfully.');
        } else {
            return redirect()->route('login')->with('error', 'Please enter valid email and password.');
        }
    }

    public function logout()
    {
        Auth::guard('web')->logout();
        Session::forget('is_pin_verify');
        return redirect()->route('login');
    }
}
