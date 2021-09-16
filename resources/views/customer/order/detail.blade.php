@extends('customer-layouts.app')
	
@section('content')
	{{-- <div class="container-fluid">
	    <div class="add-address-banner">
	        <div class="container">
	            <h1>
	                Order Details
	            </h1>
	            <div class="clearfix">
	            </div>
	        </div>
	    </div>
	</div> --}}
	<div class="add-address-banner wd-dr-inner-blog">
        <div class="container">
           <div class="wd-dr-chat-left">
            <div class="wd-dr-chat-inner"> 
                <h1>
                    Order Details
                </h1>
            </div>
            <div class="clearfix"></div>
           </div>
        </div>
    </div>

	<div class="container list-address">
	    <div class="jumbotron order-jumbotron">
	    	@if($order->order_progress_status == Config::get('constants.ORDER_STATUS.PREPARED') || $order->order_progress_status == Config::get('constants.ORDER_STATUS.COMPLETED') || $order->order_progress_status == Config::get('constants.ORDER_STATUS.CANCEL'))
    			<div class="row order-heading">
    		        <div class="col-md-6 order-detail-heading">
    		            <ul>
    		                <li>
    		                    <h3>{{$order->order_number}}</h3>
    		                </li>
    		            </ul>
    		            <label class="order-accepted">Order {{$order->order_progress_status}}</label>
    		        </div>
    		        <div class="col-md-6 order-detail-date">
    		            <label class="order-lable">Order Date/Time</label>
    		            <h3>{{date('M d',strtotime($order->order_date))}},{{$order->order_time}}</h3>
    		        </div>
    		    </div>
	    	@else
		    	<div class="row order-heading">
		            <div class="col-md-4 order-detail-heading">
		                <ul>
		                    <li>
		                        <h3>{{$order->order_number}}</h3>
		                    </li>
		                </ul>
		                <label class="order-accepted">Order {{$order->order_progress_status}}</label>
		            </div>
		            <div class="col-md-4 order-detail-pickup">
		                <label class="order-lable">Pickup Time</label>
		                @if($order->isPickUp == 1)
		                	<h3>{{$order->pickup_time}}</h3>
		                @else
		                	<h3>00:00</h3>
		                @endif
		            </div>
		            <div class="col-md-4 order-detail-date">
		                <label class="order-lable">Order Date/Time</label>
		                <h3>{{date('M d',strtotime($order->order_date))}},{{$order->order_time}}</h3>
		            </div>
		        </div>
	    	@endif
	        <div class="row order-detail">
	            <div class="col-sm-9">
	            	@foreach($order->orderItems as $item)
	            		<div class="media order-detail-item">
		                    <div class="media-left">
		                        <a href="#" alt="Food">
		                        	@foreach($item->menuItems as $menu)
										<img class="media-object" src="{{$menu->getMenuImgAttribute()}}" alt="...">
									@endforeach
		                        </a>
		                    </div>
		                    <div class="media-body">
		                        <h3 class="media-heading">{{$item->menu_name}}
		                            <div class="price_count">
		                                <label>${{$item->menu_total}}</label>
		                                <label class="item-count">&nbsp; X &nbsp;{{$item->menu_qty}}</label>
		                            </div>
		                        </h3>
		                        {{--<ul>
		                        	@foreach($orderMenuGroups as $modifierGroup)
		                        		@if($modifierGroup->menu_id == $item->menu_id)
			                        		@php
			                        	  		$groupItem = implode(',',$groupIteamArray[$item->menu_id][$modifierGroup->order_modifier_group_id]);
			                        		@endphp
			                        		<li>
				                                {{$modifierGroup->modifier_group_name}} : {{$groupItem}}
				                            </li>
				                        @endif
				                    @endforeach
		                        </ul>--}}
							</div>
		                </div>
		            @endforeach
	            </div>

	            <div class="col-sm-3">
	                <div class="order-border-left order-detail-left">
	                    <span class="cart-charges">
	                        Cart Charges
	                    </span>
	                    <span class="charges-price">
	                        ${{$order->cart_charge}}
	                    </span>
	                    <div class="clearfix"></div>
	                    <span class="cart-charges">
	                        Delivery Charges
	                    </span>
	                    <span class="charges-price">
	                        ${{$order->delivery_charge}}
	                    </span>
	                    <div class="clearfix"></div>
	                    <span class="cart-charges total_disc">
	                        Total Discount
	                    </span>
	                    <span class="charges-price total_disc">
	                        ${{$order->discount_charge}}
	                    </span>
	                    <div class="clearfix"></div>
	                    <span class="cart-charges">
	                        Grand Total
	                    </span>
	                    <span class="charges-price">
	                        ${{$order->grand_total}}
	                    </span>
	                    <div class="clearfix"></div>
	                    <button type="button" class="btn btn-primary btn-lg btn-block" alt="Total Amount Payable">
	                        <h4>${{$order->grand_total}}</h4>
	                        Total Amount Payable
	                    </button>

	                </div>
	            </div>
	        </div>

	    </div>
	</div>
@endsection

