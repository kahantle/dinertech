<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class SettingController extends Controller
{
    public function settingUpdate(Request $request)
    {
        if($request->ajax())
        {
            $uid = Auth::user()->uid;

            if($request->type == 'app_setting')
            {
                User::where('uid',$uid)->update(['app_notifications' => $request->value]);
            }

            if($request->type == 'chat_setting')
            {
                User::where('uid',$uid)->update(['chat_notifications' => $request->value]);
            }

            if($request->type == 'location_setting')
            {
                User::where('uid',$uid)->update(['location_tracking' => $request->value]);
            }

            return true;
        }
    }
}
