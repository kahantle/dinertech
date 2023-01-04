<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LoyaltyRule;
use Auth;

class LoyaltyController extends Controller
{
    public function index()
    {
        $restaurantId = 1;
        $user = $data['user'] = Auth::user();
        $uid = $user->uid;
        $data['cards'] = getUserCards($restaurantId, $uid);
        $data['title'] = 'Loyalty';
        return $data['loyalties'] = LoyaltyRule::with('rulesItems')->where('restaurant_id',$restaurantId)->get(['rules_id','restaurant_id','point']);
        return view('customer.loyalty.index',$data);
    }
}
