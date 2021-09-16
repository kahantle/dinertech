<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CustomerFeedback;
use Config;
use Auth;

class FeedbackController extends Controller
{
    public function index()
    {
        $data['title'] = 'Feedback - Dinertech';
        return view('customer.feedback.index',$data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone_number'  => 'required',
            'email' => 'required',
            'feedback_type' => 'required',
            'message'   => 'required'
        ]);

        $restaurantId = session()->get('restaurantId');
        $uid = Auth::user()->uid;

        $feedback = New CustomerFeedback;
        $feedback->restaurant_id = $restaurantId;
        $feedback->uid = $uid;
        $feedback->name = $request->name;
        $feedback->phone = $request->phone_number;
        $feedback->email = $request->email;
        $feedback->feedback_type = $request->feedback_type;
        $feedback->suggestion = $request->message;
        if($feedback->save())
        {
            return redirect()->back()->with('success','Feedback sent successfully.');
        }
        else
        {
            return redirect()->back()->with('error',Config('constants.COMMON_MESSAGE.COMMON_MESSAGE'));
        }
    }

}
