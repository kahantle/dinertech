<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Mail\ContactMail;
use App\Models\Contact;
use App\Models\Restaurant;
use Auth;
use Config;
use Illuminate\Support\Facades\Mail;
use Session;
use Toastr;

class ContactController extends Controller
{
    public function index()
    {
        $uid = Auth::user()->uid;
        $restaurant = Restaurant::where('uid', $uid)->first();
        if ($restaurant->is_pinprotected) {
            $is_verified = Session::get('is_pin_verify');
            if (!$is_verified) {
                return redirect()->route('account');
            }
        }
        return view('contact.index');
    }

    public function store(ContactRequest $request)
    {
        try {
            $uid = Auth::user()->uid;
            $restaurant = Restaurant::where('uid', $uid)->first();
            if (!$restaurant) {
                return redirect()->route('category')->with('error', 'Invalid users for this restaurant.');
            }

            $contact = new Contact;
            $message = 'Details added successfully.';
            $contact->restaurant_id = $restaurant->restaurant_id;
            $contact->name = $request->post('name');
            $contact->subject = $request->post('subject');
            $contact->description = $request->post('description');
            if ($contact->save()) {
                Mail::to(Config::get('constants.CONTACT_MAIL'))->send(new ContactMail($contact));
                Toastr::success($message, '', Config::get('constants.toster'));
                return redirect()->route('account');
            }
            Toastr::error($message, '', Config::get('constants.toster'));
            return redirect()->route('contact');
        } catch (\Throwable $th) {
            return redirect()->route('contact')->with('error', $th->getMessage());
        }
    }

}
