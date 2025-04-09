<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class LoginController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }

    public function showLogin()
    {
        return view('admin.auth.login'); 
    }

    public function attemptLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $credentials = ['email_id' => $request->email,'password' => $request->password];
        if (Auth::guard('admin')->attempt($credentials))
        {
            return redirect()->intended('/admin/dashboard');
        }
        else
        {
            return redirect()->back()->with('error','Login Detail Invalid.')->withInput();
        }
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
