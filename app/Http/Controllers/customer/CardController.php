<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Card;
use Auth;

class CardController extends Controller
{
    public function index(Request $request)
    {
        $orderDetails = session()->get('orderDetails');
        if(!empty($orderDetails))
        {
            $request->validate([
                'payment_method' => 'required'
            ]);

            $uid = Auth::user()->uid;
            $restaurantId = session()->get('restaurantId');
            $data['cards'] = Card::where('uid',$uid)->where('restaurant_id',$restaurantId)->get(['card_id','card_holder_name','card_number','card_expire_date','card_cvv','card_type','status']);
            $data['orderDetails'] = $orderDetails;
            $data['title'] = 'Payment Cards - Dinertech';
            return view('customer.card.index',$data);
        }
        else
        {
            return redirect()->route('customer.cart');
        }
    }

    public function getCardsList()
    {
        
        $uid = Auth::user()->uid;
        $restaurantId = session()->get('restaurantId');
        $data['cards'] = Card::where('uid',$uid)->where('restaurant_id',$restaurantId)->get(['card_id','card_holder_name','card_number','card_expire_date','card_cvv','card_type','status']);
        $data['orderDetails'] = array();
        $data['title'] = 'Payment Cards - Dinertech';
        return view('customer.card.index',$data);
        
    }

    public function create()
    {
        $data['title'] = 'Add Card - Dinertech';
        return view('customer.card.create',$data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'card_holder_name' => 'required|string',
            'card_number'  => 'required',
            'card_expire_date' => 'required',
            'card_cvv' => 'required|numeric',
        ]);

        $uid = Auth()->user()->uid;
        $restaurantId = session()->get('restaurantId');

        if(isset($request->card_type))
        {
            if($request->card_type == 'Visa')
            {
                $cardType = 'VISA';
            }
            elseif($request->card_type == 'Mastercard')
            {
                $cardType = 'MASTER_CARD';   
            }
            elseif ($request->card_type == 'Discover') 
            {
                $cardType = 'DISCOVER'; 
            }
            elseif($request->card_type == 'AMEX')
            {
                $cardType = 'AMERICAN_EXPRESS';   
            }
            else
            {
                $cardType = 'UNKNOWN';
            }
        }
        else
        {
            $cardType = 'UNKNOWN';
        }


        $card = new Card();
        $card->uid = $uid;
        $card->restaurant_id = $restaurantId;
        $card->card_holder_name = $request->card_holder_name;
        $card->card_number = $request->card_number;
        $card->card_expire_date = $request->card_expire_date;
        $card->card_cvv = $request->card_cvv;
        $card->card_type = $cardType;
        $card->save();

        return redirect()->route('customer.cards');
    }

    
}
