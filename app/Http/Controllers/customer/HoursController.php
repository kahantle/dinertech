<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Mail\CustomerContactMail;
use App\Models\Restaurant;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class HoursController extends Controller
{
    public function index()
    {
        $uid = Auth::user()->uid;
        $restaurantId = session()->get('restaurantId');
        $restaurant = Restaurant::where('restaurant_id', $restaurantId)->with('user')
            ->first();
        $data['address'] = $restaurant;

        $data['cards'] = getUserCards($restaurantId, $uid);
        $data['cartMenus'] = getCartItem();
        $data['title'] = 'Information';
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
                'message' => $request->message,
            ];

            Mail::to($restaurant->user->email_id)->send(new CustomerContactMail($data));

           return redirect()->back()->with('success', 'Mail send successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}
