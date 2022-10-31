<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use App\Models\User;
use Auth;
use Config;
use Illuminate\Http\Request;
use Session;
use Validator;

class AccountController extends Controller
{
    public function index()
    {
        $uid = Auth::user()->uid;
        $user = User::where('uid', $uid)->first();
        $restaurant = Restaurant::where('uid', $user->uid)->first();
        if ($restaurant->is_pinprotected) {
            $is_verified = Session::get('is_pin_verify');
            if ($is_verified) {
                return view('account.index', compact('user', 'restaurant'));
            }
            return view('account.verify', compact('user', 'restaurant'));
        }
        return view('account.index', compact('user', 'restaurant'));
    }

    public function update(Request $request)
    {
        try {

            $validator = Validator::make($request->post(), ['type' => 'required', 'notification_value' => 'required']);
            if ($validator->fails()) {
                return response()->json(['success' => false, 'message' => $validator->errors()], 400);
            }

            $uid = Auth::user()->uid;
            $user = User::where('uid', $uid)->first();
            $returns = [];
            if ($request->post('type') === 'Pin') {
                $restaurant = Restaurant::where('uid', $uid)->first();
                $restaurant->is_pinprotected = false;
                $restaurant->pin = null;
                Session::forget('is_pin_verify');

                if ($restaurant->save()) {
                    $returns['success'] = true;
                    $returns['message'] = "Pin change successfully!";
                } else {
                    $returns['success'] = false;
                    $returns['message'] = "Pin does not change successfully!";
                }
            } else if ($request->post('type') === 'chat') {
                if ($request->post('notification_value') == 0) {
                    $user->chat_notifications = ($request->post('notification_value') == 0) ? 1 : 0;
                } else {
                    $user->chat_notifications = ($request->post('notification_value') == 1) ? 0 : 1;
                }

                if ($user->save()) {
                    $returns['success'] = true;
                    $returns['message'] = ucfirst($request->post('type')) . " notification change successfully!";
                } else {
                    $returns['success'] = false;
                    $returns['message'] = ucfirst($request->post('type')) . " notification does not change successfully!";
                }
            } else if ($request->post('type') === 'location') {
                if ($request->post('notification_value') == 0) {
                    $user->location_tracking = ($request->post('notification_value') == 0) ? 1 : 0;
                } else {
                    $user->location_tracking = ($request->post('notification_value') == 1) ? 0 : 1;
                }

                if ($user->save()) {
                    $returns['success'] = true;
                    $returns['message'] = ucfirst($request->post('type')) . " notification change successfully!";
                } else {
                    $returns['success'] = false;
                    $returns['message'] = ucfirst($request->post('type')) . " notification does not change successfully!";
                }
            } else if($request->post('type') === 'sales-tax'){
                $restaurant = Restaurant::where('uid', $uid)->first();
                $restaurant->sales_tax = $request->post('notification_value');

                if ($restaurant->save()) {
                    $returns['success'] = true;
                    $returns['message'] = "Sales tax change successfully!";
                } else {
                    $returns['success'] = false;
                    $returns['message'] = "Sales tax does not change successfully!";
                }
            }  else if($request->post('type') === 'receipts'){
                $restaurant = Restaurant::where('uid', $uid)->first();
                if ($request->post('notification_value') == 0) {
                    $restaurant->auto_print_receipts = ($request->post('notification_value') == 0) ? 1 : 0;
                } else {
                    $restaurant->auto_print_receipts = ($request->post('notification_value') == 1) ? 0 : 1;
                }

                if ($restaurant->save()) {
                    $returns['success'] = true;
                    $returns['message'] = "Auto print receipts Enabled successfully !";
                } else {
                    $returns['success'] = false;
                    $returns['message'] = "Error in Auto print receipts Enabling !";
                }
            }

            return response()->json($returns);
        } catch (\Throwable $th) {
            $returns['success'] = false;
            $returns['message'] = Config::get('constants.COMMON_MESSAGES.CATCH_ERRORS');
            return response()->json($returns);
        }
    }

    public function showActiveSubscription()
    {
        return view('account.active_subscription');
    }

}
