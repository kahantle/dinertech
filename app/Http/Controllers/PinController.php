<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Restaurant;
use Config;
use Hash;
use Auth;
use Toastr;
use Session;

class PinController extends Controller
{
    public function index(){
       	$uid = Auth::user()->uid;
    	$user = User::where('uid', $uid)->first();
        return view('pin.index',compact('user'));
    }

    public function set_pin(Request $request)
    {
        try {
            $uid = Auth::user()->uid;   
            $user = User::where('uid', $uid)->first();
            $restaurant = Restaurant::where('uid',$user->uid)->first();
            $restaurant->is_pinprotected = true;
            $restaurant->pin = $request->pin;
            if ($restaurant->save()) {
                $returns['success'] = true;
                $returns['message'] = "Pin set successfully!";
            }else{
                $returns['success'] = false;
                $returns['message'] = "Pin does not set successfully!";
            }
            return response()->json($returns);
        }
        catch (\Throwable $th) {
            $returns['success'] = false;
            $returns['message'] = Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS');
            return response()->json($returns); 
        }              
    }


    public function verfiy_pin(Request $request)
    {
        try {
            $uid = Auth::user()->uid;   
            $user = User::where('uid', $uid)->first();
            $restaurant = Restaurant::where('uid',$user->uid)->where('pin',$request->pin)->first();
            if ($restaurant) {
                Session::put('is_pin_verify', 1);
                $returns['success'] = true;
                $returns['message'] = "Pin verify successfully!";
            }else{
                $returns['success'] = false;
                $returns['message'] = "Pin enter valid pin.";
            }
            return response()->json($returns);
        }
        catch (\Throwable $th) {
            $returns['success'] = false;
            $returns['message'] = Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS');
            return response()->json($returns); 
        }              
    }
}
