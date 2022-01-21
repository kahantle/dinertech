<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\CustomerAddress;
use App\Models\RestaurantUser;
use Auth;
use Config;
use Socialite;

class GoogleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }
    

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
            $findUser = User::where('google_id', $user->id)->first();
            if($findUser){
                Auth::login($findUser);
                // return redirect('/customer');
                return redirect()->route('customer.index');
            }else{

                $name = explode(" ",$user->name);
                $googleUser = new User();
                $googleUser->role = Config::get('constants.ROLES.CUSTOMER');
                $googleUser->first_name = $name[0];
                $googleUser->last_name  = $name[1];
                $googleUser->email_id   = $user->email;
                $googleUser->google_id = $user->id;
                $googleUser->password = \Hash::make('123456');
                $googleUser->save();
                

                CustomerAddress::create([
                    'uid'  => $googleUser->uid,
                ]);
    
                RestaurantUser::create([
                    'uid'  => $googleUser->uid,
                    'restaurant_id' => 1,
                    'status'   => Config::get('constants.STATUS.ACTIVE'),
                    'created_at' => date('Y-m-d H:i:s'),
                ]);

                $newUser = ['email_id' => $user->email,'password' => '123456'];

                // $newUser = User::create([
                //     'role'       => Config::get('constants.ROLES.CUSTOMER'),
                //     'first_name' => $name[0],
                //     'last_name'  => $name[1],
                //     'email_id' => $user->email,
                //     'google_id'=> $user->id,
                //     'password' => \Hash::make('123456')
                // ]);
                Auth::login($newUser);
                return redirect()->route('customer.index');
                // return redirect('/customer');
            }
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }
}
