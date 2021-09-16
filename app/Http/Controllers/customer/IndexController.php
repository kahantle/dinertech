<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function homepage()
    {
        $data['title'] = 'Customer - Dinertech';
        return view('customer.home',$data);   
    }

    public function profile()
    {
        
    }
}
