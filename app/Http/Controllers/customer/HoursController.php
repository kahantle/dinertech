<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Mail\CustomerContactMail;
use App\Models\Restaurant;
use App\Models\RestaurantHours;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use DB;

class HoursController extends Controller
{
    public function index()
    {
        $uid = Auth::user()->uid ?? 0;
        if(!$uid){
            return redirect()->back();
        }

        $restaurantId = session()->get('restaurantId');
        $restaurant = Restaurant::where('restaurant_id', $restaurantId)->with('user')
            ->first();
        // $data['hoursdata']=RestaurantHours::select('restaurant_hours.*','times.opening_time','times.closing_time','times.hour_type')
        // ->join('restaurant_hours_times as times','restaurant_hours.restaurant_hour_id','times.restaurant_hour_id')
        // ->where('restaurant_hours.restaurant_id', $restaurantId)
        // ->get();

        $data['hoursdata'] = RestaurantHours::where('restaurant_id', $restaurantId)->with('allTimes')->orderBy('restaurant_hour_id', 'ASC')->get();
        $data['address'] = $restaurant;
        $data['cards'] = getUserCards($restaurantId, $uid);
        $data['title'] = 'Information';
        $restaurant = Restaurant::where('restaurant_id', $restaurantId)->first();
        $data['tip1'] = $restaurant ? $restaurant->tip1 : 0.0;
        $data['tip2'] = $restaurant ? $restaurant->tip2 : 0.0;
        $data['tip3'] = $restaurant ? $restaurant->tip3 : 0.0;
        $data['restaurant_phone'] = 'Information';
        // dd($data);
        return view('customer.hours.index', $data);
    }

    public function sendMail(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required|string',
            'phone_number' => 'required|numeric',
            'email' => 'required|email',
            'message' => 'required',
        ]);
        $restaurantId = session()->get('restaurantId');
        $restaurant = Restaurant::with('user')->where('restaurant_id', $restaurantId)->first();

        try {

            $data = [
                // 'restaurant_name' => $restaurant->restaurant_name,
                'customer_name' => $request->name,
                'customer_phone' => $request->phone_number,
                'message' => $request->message,
            ];

            Mail::to($restaurant->user->email_id)->send(new CustomerContactMail($data));

           return redirect()->back()->with('success', 'Mail send successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
