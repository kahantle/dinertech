<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Promotion;
use Auth;

class PromotionController extends Controller
{
	public function index()
	{
		
		$restaurantId = session()->get('restaurantId');
		$data['promotionLists'] = Promotion::where('restaurant_id', $restaurantId)
	        ->with('promotion_item')
	        ->get();
	    $data['title'] = 'Promotions - Dinertech';
	    return view('customer.promotions.index',$data);
    }

	public function show()
	{
		if(Auth::check())
		{
			$restaurantId = session()->get('restaurantId');
			$data['promotionLists'] = Promotion::where('restaurant_id', $restaurantId)
		        ->with('promotion_item')
		        ->get();
		    $data['title'] = 'Promotions - Dinertech';
		    return view('customer.promotions.show',$data);
		}
	}

	public function applyPromotion($promotionId)
	{
		$promotion = Promotion::where('promotion_id', $promotionId)
	        ->with('promotion_item')
	        ->first();
	    if(!$promotion)
	    {
	    	abort('404');
	    }

	    $promotionArray =  session()->get('promotion', []);
	    $promotionArray = [
	    	"promotion_id" => $promotion->promotion_id,
	    	"promotion_code" => $promotion->promotion_code,
	    	"discount"    => $promotion->discount,
	    	"discount_type" => $promotion->discount_type,
	    ];

	    session()->put('promotion', $promotionArray);
	    return redirect()->route('customer.cart');
	}
}