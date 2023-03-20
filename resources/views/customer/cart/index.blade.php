@extends('customer-layouts-old.app')

@section('css')
	<link rel="stylesheet" href="{{asset('assets/customer/css/bootstrap-datetimepicker.min.css')}}">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.2/css/font-awesome.min.css">
@endsection

@section('content')
	<div class="add-address-banner wd-dr-inner-blog">
        <div class="container">
           <div class="wd-dr-chat-left">
            <div class="wd-dr-chat-inner">
                <h1>
                    Your Cart
                </h1>
            </div>
            <div class="clearfix"></div>
           </div>
        </div>
    </div>

	<div class="container list-address">
	    <div class="jumbotron">
	        <div class="row">
	        	@if(!empty($cartItems))
					<div class="customize-menu"></div>
					<form action="{{route('customer.cart.submit.order')}}" method="post">
						@csrf
						<div class="col-sm-9">
							<h3>
								Cart Items
							</h3>
							@include('customer.messages')
							@php
								$cartTotal = 0;
								$finalMenuTotal = 0;
								$modifierItamTotal = array();
							@endphp
							@foreach($cartItems as $key => $items)
								@foreach($items as $itemKey => $item)
									<div class="row">
										<div class="cart-item">
											<div class="col-sm-2">
												<img src="{{$item['item_img']}}">
											</div>
											<div class="col-sm-4 cart-section">
												<h4 class="cart-item-title">{{$item['item_name']}}</h4>
												@if(empty($item['modifier_item']))
													<div class="cart-item-extra"></div>
												@else
													@if(isset($modifierGroups[$key]))
														@foreach(call_user_func_array('array_merge',$modifierGroups[$key]) as $modifireItemKey => $modifierItems)
															<div class="cart-item-extra">
																<ul style="margin-bottom: 0px !important;">
																	{{-- @foreach($modifierItems as $modifierGroup) --}}
																		<li>{{$modifierItems['modifier_group_name']}}</li>
																		@foreach($modifierItems['modifier_item'] as $menuIteamKey => $modifierItem)
																			@php
																				$modifierItamTotal[$key][] = $modifierItem['modifier_group_item_price'];
																			@endphp

																			<span class="extra-name">
																				@if($menuIteamKey == 0)
																					{{$modifierItem['modifier_group_item_name']}}
																				@else
																					,{{$modifierItem['modifier_group_item_name']}},
																				@endif
																			</span>
																		@endforeach
																		<div class="clearfix"></div>
																	{{-- @endforeach --}}
																</ul>
															</div>

															@php
																$modifierList = [$modifierGroups[$key][$item['menu_id']]];
															@endphp
														@endforeach
													@endif
												@endif
											</div>
											@if(isset($modifierItamTotal[$key]))
												@php
													$finalMenuTotal = array_sum($modifierItamTotal[$key]) + $item['item_price'];
													$menuTotal = $finalMenuTotal * $item['quantity'];
													$cartTotal += $menuTotal;

													$menuItem[] = ['menu_id' => $item['menu_id'],'menu_name' => $item['item_name'],'menu_total' => $menuTotal,'menu_qty' => $item['quantity'],'modifier_total' => array_sum($modifierItamTotal[$key]),'modifier_list' => call_user_func_array('array_merge',$modifierList)];
												@endphp
											@else
												@php
													$menuTotal = $item['item_price'] * $item['quantity'];
													$cartTotal += $menuTotal;

													$menuItem[] = ['menu_id' => $item['menu_id'],'menu_name' => $item['item_name'],'menu_total' => $menuTotal,'menu_qty' => $item['quantity'],'modifier_total' => 0];
												@endphp
											@endif
											<div class="col-sm-3 cart-section">
												<div class="cart-info quantity">
													<div class="btn-increment-decrement decrement" data-menu-id="{{$item['menu_id']}}" data-menu-key="{{$key}}">-</div>
													<input class="input-quantity" name="quantity[]" id="quantity-{{$item['menu_id']}}" value="{{$item['quantity']}}" min="1" max="10">
													<div class="btn-increment-decrement increment" data-menu-id="{{$item['menu_id']}}" data-menu-total="{{$menuTotal}}" data-menu-key="{{$key}}">+</div>
												</div>
											</div>
											<div class="col-sm-3">
												<div class="text-center cart-menu-total">
													$<span class="menuTotal-{{$item['menu_id']}}">{{number_format($menuTotal,2)}}</span>
												</div>
												@if(!empty($item['modifier']) && !empty($item['modifier_item']))
													<a class="cart-customize" data-menu-id="{{$item['menu_id']}}" data-cart-key="{{$key}}">Customize</a>
												@endif
												<a href="{{route('customer.cart.remove.item',[$key,$item['menu_id']])}}" class="cart-delete" alt="Delete">Delete</a>
											</div>
										</div>
									</div>
								@endforeach
							@endforeach

							{{--<input type="hidden" name="modifierList" value="{{base64_encode(json_encode($modifierList))}}">
							<input type="hidden" name="modifierItemArray" value="{{base64_encode(json_encode($modifierItemArray))}}">--}}
							<input type="hidden" name="menuItem" value="{{base64_encode(json_encode($menuItem))}}">
							@if(empty($promotions))
								<a href="{{route('customer.show.promotions')}}" class="row apply-coupen-icon" alt="Apply Coupen">
									<img src="{{asset('assets/customer/images/sale.png')}}">
									<div class="apply-coupen-data">
										<h4>Promotions & Coupons</h4>
										<span>
											Add promotions and get some exited discount.
										</span>
									</div>
								</a>
							@else
								<a href="{{route('customer.show.promotions')}}" class="row apply-coupen-icon" alt="Apply Coupen">
									<img src="{{asset('assets/customer/images/sale.png')}}">
									<div class="apply-coupen-data">
										<h4>{{$promotions['promotion_code']}}</h4>
										<span>
											Add promotions and get some exited discount.
										</span>
									</div>
								</a>
							@endif 
							<div class="row apply-coupen-icon instruction">
								<img src="{{asset('assets/customer/images/instruction.png')}}">
								<input type="text" name="instruction" placeholder="Additional Order Instructions" class="apply-coupen-data form-control additional-instruction">
							</div>
							<a class="row apply-coupen-icon">
								<img src="{{asset('assets/customer/images/clock_cart.png')}}">
								<div class="apply-coupen-data selectTiming">
									<h4>Order Timing</h4>
									<span class="oreder-text">
										When would you like your order?
									</span>
									<div class="options hide">

										<div class="col-md-12">
											<div class="col-md-2">
												<span>Now</span>
											</div>
											<div class="col-md-8">
												<input class="form-check-input timingDropDown" type="radio" name="order_status" value="0">
											</div>
										</div>
										<div class="col-md-12 border-top">
											<div class="col-md-2">
												<span>Future</span>
											</div>
											<div class="col-md-8">
												<input class="form-check-input timingDropDown" type="radio" name="order_status" value="1">
											</div>
										</div>
									</div>
								</div>
							</a>
						</div>

						<div class="col-sm-3">
							<h3>
								Order Charges
							</h3>
							@php
								$finalTotal = ($cartTotal + 0);
							@endphp
							<div class="order-border-left">
								<span class="cart-charges">
									Sub Total
								</span>
								<span class="charges-price">
									${{number_format($cartTotal,'2')}}
									<input type="hidden" name="cart_charge" value="{{number_format($cartTotal,'2')}}">
								</span>
								<div class="clearfix"></div>
								<span class="cart-charges">
									Sales Tax
								</span>
								<span class="charges-price">
									$0.00
									<input type="hidden" name="sales_tax" value="0.00">
								</span>
								<div class="clearfix"></div>
								<span class="cart-charges total_disc @if(empty($promotions)) hide @else show @endif">
									Total Discount
								</span>
								<span class="charges-price total_disc @if(empty($promotions)) hide @else show @endif">
									@php $discountPrice = 0; @endphp
									@if(isset($promotions['discount']))
										@if($promotions['discount_type'] == 'USD')
											${{number_format($promotions['discount'],'2')}}
											@php
												$finalTotal = $finalTotal - $promotions['discount'];
												$discountPrice = $promotions['discount'];
											@endphp
										@elseif($promotions['discount_type'] == 'PER')
											@php
												$discountPrice = ($finalTotal * $promotions['discount'] / 100);
												$finalTotal = $finalTotal - $discountPrice;
											@endphp
											${{number_format($discountPrice,'2')}}
										@endif
									@endif
									<input type="hidden" name="discount_charge" value="{{number_format($discountPrice,'2')}}">
								</span>
								<div class="clearfix"></div>
								<span class="cart-charges">
									Total Due
								</span>
								<span class="charges-price">
									${{number_format($finalTotal,'2')}}
								</span>
								<div class="clearfix"></div>
								<input type="hidden" name="orderDate" id="orderDate">
								<input type="hidden" name="orderTime" id="orderTime">
								<button type="button" class="btn btn-primary btn-lg btn-block">
									<h4>${{number_format($finalTotal,'2')}}</h4>
									Total Amount Payable
									<input type="hidden" name="grand_total" value="{{number_format($finalTotal,'2')}}">
								</button>
								<button type="submit" class="btn btn-primary btn-lg btn-block" alt="Place Order">
									<h4>Place Order</h4>
								</button>
							</div>
						</div>
			        </form>
			        <div class="modal fade" id="future-order" tabindex="-1" role="dialog" aria-labelledby="modifier-btn">
			            <div class="modal-dialog" role="document">
			                <div class="modal-content">
			                    <div class="modal-header">
			                        <button type="button" class="close order-modal" data-dismiss="modal" aria-label="Close"><span
			                                aria-hidden="true">&times;</span></button>
			                        <img src="{{asset('assets/customer/images/logo-blue.png')}}">
			                        <h4>Select Date or Time for Future</h4>
			                    </div>
			                    <div class="modal-body">
			                        <form class="form-group">
			                            <div class='input-group datepicker' id='datepicker'>
			                                <span class="input-group-addon">
			                                    <span class="fa fa-calendar">
			                                    </span>
			                                </span>
			                                <input type='text' class="form-control input-lg select-date" placeholder="Select Date" />
			                            </div>
			                            <div class='input-group date timepicker' id='timepicker'>
			                                <span class="input-group-addon">
			                                    <span class="fa fa-clock-o">
			                                    </span>
			                                </span>
			                                <input type='text' class="form-control input-lg select-time" placeholder="Select Time" />
			                            </div>
			                        </form>
			                    </div>
			                    <div class="modal-footer">
			                        <button type="button" class="btn btn-primary btn-block set-order-time">
			                            <h4>
			                                Add
			                            </h4>
			                        </button>
			                    </div>
			                </div>
			            </div>
			        </div>
		        @else
		        	<div class="col-md-12 text-center">
	        			<img src="{{asset('assets/customer/images/cart-image.jpg')}}" style="height: 87px;"><br>
	        			<span style="color:#ADB3BF;">Cart is empty</span>
		        	</div>
		        @endif
	        </div>
	    </div>
	</div>
@endsection

@section('scripts')
	<script src="{{asset('assets/customer/js/moment.min.js')}}"></script>
	<script src="{{asset('assets/customer/js/nl.js')}}"></script>
	<script src="{{asset('assets/customer/js/moment-with-locales.min.js')}}"></script>
	<script src="{{asset('assets/customer/js/bootstrap-datetimepicker.min.js')}}"></script>
	<script src="{{asset('assets/customer/js/cart/index.js')}}"></script>
@endsection
