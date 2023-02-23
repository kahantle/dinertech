<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CustomerAddress;
use App\Models\Restaurant;
use App\Models\RestaurantUser;
use Config;
use Auth;

class AddressController extends Controller
{
    public function index()
    {
        $uid = Auth::user()->uid;
        $data['addressLists'] = CustomerAddress::where('uid',$uid)->get();
        $data['title'] = 'List Address - Dinertech';
        return view('customer.address.index',$data);
    }

    public function create()
    {
        $data['title'] = 'Add New Address - Dinertech';
        return view('customer.address.create',$data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'address' => 'required',
            'address_type'  => 'required',
            'zipcode' => 'required',
        ]);

        $uid = Auth::user()->uid;
        $customerAddress = New CustomerAddress;
        $customerAddress->uid = $uid;
        $customerAddress->address = $request->address;
        $customerAddress->state = $request->state;
        $customerAddress->city  = $request->city;
        $customerAddress->zip   = $request->zipcode;
        $customerAddress->lat   = $request->lat;
        $customerAddress->long  = $request->long;
        $customerAddress->type  = $request->address_type;
        if($customerAddress->save())
        {
            return redirect()->back()->with('success','Address add sucessfully.');
        }
        else
        {
            return redirect()->back()->with('error',Config('constants.COMMON_MESSAGE.COMMON_MESSAGE'));
        }
    }
}
