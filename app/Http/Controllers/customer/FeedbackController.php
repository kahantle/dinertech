<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Models\CustomerFeedback;
use Auth;
use Config;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function index()
    {
        $data['cartMenus'] = getCartItem();
        $restaurantId = session()->get('restaurantId');
        $uid = Auth::user()->uid;
        $data['cards'] = getUserCards($restaurantId, $uid);

        $data['title'] = 'Feedback';
        return view('customer.feedback.index', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone_number' => 'required',
            'email' => 'required',
            'feedback_type' => 'required',
            'message' => 'required',
        ]);

        $restaurantId = session()->get('restaurantId');
        $uid = Auth::user()->uid;

        $feedback = new CustomerFeedback;
        $feedback->restaurant_id = $restaurantId;
        $feedback->uid = $uid;
        $feedback->name = $request->name;
        $feedback->phone = $request->phone_number;
        $feedback->email = $request->email;
        $feedback->feedback_type = $request->feedback_type;
        $feedback->suggestion = $request->message;
        if ($feedback->save()) {
            return redirect()->back()->with('success', 'Feedback sent successfully.');
        } else {
            return redirect()->back()->with('error', Config('constants.COMMON_MESSAGE.COMMON_MESSAGE'));
        }
    }

}
