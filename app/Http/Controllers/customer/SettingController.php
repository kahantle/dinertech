<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class SettingController extends Controller
{

    public function index()
    {
        $data['title'] = 'setting';
        $data['user'] = Auth::user();
        return view('customer.settings.index',$data);
    }

    public function settingUpdate(Request $request)
    {
        if($request->ajax())
        {
            $user = Auth::user();

            if($request->type == 'app_setting')
            {
                $user->update(['app_notifications' => $user->app_notifications == 1 ? 0 : 1]);
            }

            if($request->type == 'chat_setting')
            {
                $user->update(['chat_notifications' => $user->chat_notifications == 1 ? 0 : 1]);
            }

            if($request->type == 'location_setting')
            {
                $user->update(['location_tracking' => $user->location_tracking == 1 ? 0 : 1]);
            }

            return true;
        }
    }
}
