<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Models\CustomerAddress;
use App\Models\User;
use Auth;
use Config;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function profile()
    {
        if (Auth::check()) {
            $data['customer'] = User::with('address')->findOrFail(Auth::user()->uid);
            $restaurantId = session()->get('restaurantId');
            $uid = Auth::user()->uid;
            $data['cards'] = getUserCards($restaurantId, $uid);
            $data['title'] = 'Profile';
            return view('customer.profile', $data);
        }
        return redirect()->route('customer.index');
    }

    public function update(Request $request)
    {
        $messages = [
            'first_name.required' => 'This field is required.',
            'last_name.required' => 'This field is required.',
            'physical_address.required' => 'This field is required.',
        ];

        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'physical_address' => 'required',
        ], $messages);

        $customer = User::findOrFail($request->userId);

        if ($request->hasFile('profile_photo')) {
            $profile_image = $request->file('profile_photo');
            $save_name = $request->first_name . '_' . $request->userId . '.' . $profile_image->getClientOriginalExtension();
            $profile_image->storeAs(Config::get('constants.IMAGES.USER_IMAGE_PATH'), $save_name);
        } else {
            $save_name = $customer->profile_image;
        }

        $customer->first_name = $request->first_name;
        $customer->last_name = $request->last_name;
        $customer->profile_image = $save_name;
        $customer->save();

        CustomerAddress::where('uid', $request->userId)->update(['address' => $request->physical_address]);

        return redirect()->back()->with('success', 'Profile update succesfully.');
    }

    public function changePassword()
    {
        $data['title'] = 'Change Password - Dinertech';
        return view('customer.change_password', $data);
    }

    public function changePasswordSubmit(Request $request)
    {
        $messages = [
            'current_password.required' => 'This field is required.',
            'password.required' => 'This field is required.',
            'password_confirmation.required' => 'This field is required.',
        ];

        $request->validate([
            'current_password' => 'required',
            'password' => 'required|confirmed|min:6',
            'password_confirmation' => 'required|min:6',
        ], $messages);

        $uid = Auth::user()->uid;
        $user = User::where('uid', $uid)->first();
        if ($user) {
            if (password_verify($request->current_password, $user->password)) {
                $newpassword = \Hash::make($request->password);
                User::where('uid', $uid)->Update(['password' => $newpassword]);
                return redirect()->back()->with('success', 'Password updated successfully.');
            } else {
                return redirect()->back()->with('error', 'Current password does not match.');
            }
        }
    }
}
