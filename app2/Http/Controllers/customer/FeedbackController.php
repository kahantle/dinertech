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
        $uid = Auth::user()->uid;
        $data['cards'] = getUserCards(1, $uid);

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

        $uid = Auth::user()->uid;

        $feedback = new CustomerFeedback;
        $feedback->restaurant_id = 1;
        $feedback->uid = $uid;
        $feedback->name = $request->name;
        $feedback->phone = $request->phone_number;
        $feedback->email = $request->email;
        $feedback->feedback_type = $request->feedback_type;
        $feedback->suggestion = $request->message;

        return $feedback->save() ? redirect()->back()->with('success', 'Feedback sent successfully.') : redirect()->back()->with('error', Config('constants.COMMON_MESSAGE.COMMON_MESSAGE'));

    }

}
