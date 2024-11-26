<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Http\Requests\ProfileRequest;
use Config;
use Hash;
use Auth;
use Toastr;


class ProfileController extends Controller
{
    public function index(){
       	$uid = Auth::user()->uid;
    	$user = User::where('uid', $uid)->first();
        return view('profile.edit',compact('user'));
    }

    public function update(ProfileRequest $request)
    {
        try {
            $uid = Auth::user()->uid;   
            $user = User::where('uid', $uid)->first();
            $user->first_name = $request->post('fname');
            $user->last_name = $request->post('lname');
            $user->email_id = $request->post('email');
            $user->mobile_number = $request->post('mobile');
            //$user->physical_address = $request->post('physical_address');
            if($request->password){
                $user->password = Hash::make($request->password);
            }
            if ($request->hasFile('profile_photo')) {
                $profile_image = $request->file('profile_photo');
                $save_name = $request->post('fname') .'_'. $uid .'.' . $profile_image->getClientOriginalExtension();
                $profile_image->storeAs(Config::get('constants.IMAGES.RESTAURANT_USER_IMAGE_PATH'), $save_name);
                $user->profile_image = $save_name;
            }

            if ($user->save()){
                Toastr::success('Profile updated successfully.','', Config::get('constants.toster'));
                return redirect()->route('profile');
            }
            else{
                Toastr::error('Profile updated not successfully.','', Config::get('constants.toster'));
                return redirect()->route('profile');   
            }
        }
        catch (\Throwable $th) {
            Toastr::error(Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS'),'', Config::get('constants.toster'));
            return redirect()->route('profile');   
        }              
    }
}
