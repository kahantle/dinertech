<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\RestaurantUser;
use App\Models\Restaurant;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;
use Config;

class UserController extends Controller
{
    public function index()
    {
        // $data['restaurants'] = User::with('restaurant')->where('role',Config::get('constants.ROLES.RESTAURANT'))->latest()->get(['uid', 'first_name', 'last_name',
        // 'email_id', 'profile_image','location_tracking']);
        $data['restaurants'] = User::with('restaurant')->where('role',Config::get('constants.ROLES.RESTAURANT'))->latest()->paginate(12);
        $data['title'] = 'Restaurants';
        return view('admin.user.index',$data);
    }

    public function restaurantUsers($restaurantId)
    {
        $restaurant = Restaurant::where('restaurant_id',$restaurantId)->first();
        $data['restaurantProfile'] = User::where('uid',$restaurant->uid)->first();
        $data['restaurantUsers'] = RestaurantUser::with(['users' => function($query){
            $query->with(['address' => function($address){
                $address->groupBy('uid');
            }])->get();
        }])->where('restaurant_id',$restaurantId)->latest()->paginate(12);
        $data['restaurant'] = $restaurant;
        $data['title'] = 'Restaurant Users';
        return view('admin.user.restaurant_users',$data);
    }

    public function userDetail($restaurantId,$uid)
    {
        $restaurant = Restaurant::with(['restaurant_user' => function ($restaurant) use($uid){
            $restaurant->with(['users' => function($query) use($uid){
                $query->with('address')->where('uid',$uid)->first();
            }])->where('uid',$uid)->first();
        }])->where('restaurant_id',$restaurantId)->first();
        $data['restaurantProfile'] = User::where('uid',$restaurant->uid)->first();
        $fullName = array_column($restaurant->restaurant_user->users->toArray(),'full_name');
        if(isset($fullName[0]))
        {
            $customerFullName = $fullName[0];
        }
        else
        {
            $customerFullName = '';
        }
        $data['title'] = $customerFullName;
        $data['restaurant'] = $restaurant;
        return view('admin.user.detail',$data);
    }

    public function userExport($restaurantId)
    {
        return Excel::download(new UsersExport($restaurantId), 'users.xlsx');
    }
}
