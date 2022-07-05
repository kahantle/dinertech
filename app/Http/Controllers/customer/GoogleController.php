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
            $findUser = User::where('email_id', $user->email)->where('role',Config::get('constants.ROLES.CUSTOMER'))->first();
            if($findUser){
                $login_array = (['email_id' => $findUser->email_id, 'password' => '123456']);
                if (auth()->attempt($login_array)) {
                    return redirect()->route('customer.index');
                }
                // Auth::login($findUser);
                return redirect('/customer');
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

                $newUser = ['email_id' => $googleUser->email_id,'password' => '123456'];
                if (auth()->attempt($newUser)) {
                    return redirect()->route('customer.index');
                }
                return redirect()->route('customer.index');
                // $newUser = User::create([
                //     'role'       => Config::get('constants.ROLES.CUSTOMER'),
                //     'first_name' => $name[0],
                //     'last_name'  => $name[1],
                //     'email_id' => $user->email,
                //     'google_id'=> $user->id,
                //     'password' => \Hash::make('123456')
                // ]);
                // Auth::login($newUser);
                // return redirect('/customer');
            }
        } catch (\Throwable $th) {
            // dd($th->getMessage());
            return redirect()->route('customer.index')->with('error','This email already exists.');
        }
    }
}
