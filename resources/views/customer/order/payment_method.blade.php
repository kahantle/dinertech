@extends('customer-layouts.app')

@section('content')
	<form action="{{route('customer.cards')}}" method="post">
		@csrf
		{{-- <div class="container-fluid">
		    <div class="add-address-banner">
		        <div class="container">
		            <h1>
		                Payment Methods
		            </h1>
		            <button type="submit" class="place-order payment-continue">Continue</button>
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
						Payment Methods
					</h1>
				</div>
				<div class="clearfix"></div>
				<button type="submit" class="place-order payment-continue">Continue</button>
			   </div>
			</div>
		</div>
	

		<div class="container list-address">
		    <div class="jumbotron" style="background-color: #fff;">
		        <h3 class="text-center">
		            ${{$orderDetails['grand_total']}}
		        </h3>
		        <hr/>
		        <div class="row">
		        	<div class="container">
		        		@include('customer.messages')
		        		<div class="col-md-12">
				            <a href="#" class="row apply-coupen-icon payment-credit-card" alt="Apply Coupen">
				            	<img src="{{asset('assets/customer/images/credit_card_lock.png')}}">
				            	<div class="apply-coupen-data">
			                    	<h4>Credit Card</h4>
	                				<input class="form-check-input pull-right method-option payment-method-radio" type="radio" name="payment_method" value="card" checked>
			                    </div>
			            		<div class="apply-coupen-data">
	                				<span>
			                            Select and pay using a saved credit or debit card (powered by stripe).
			                        </span>
		                    	</div>
			                </a>
			            </div>
			            <div class="col-md-12">
			            	<a href="#" class="row apply-coupen-icon payment-cash" alt="Apply Coupen">
			                    <img src="{{asset('assets/customer/images/money.png')}}">
			                    <div class="apply-coupen-data">
			                    	<h4>Pay At The Restaurant</h4>
									<input class="form-check-input pull-right method-option payment-method-radio" type="radio" name="payment_method" value="cash">
				                </div>
	                        	<div class="apply-coupen-data">
	    							<span>
	    							    Use cash or debit/credit card when you arrive at our location.
	    							</span>
	                        	</div>
			                </a>
			            </div>
		        	</div>
		        </div>
		    </div>
		</div>
	</form>
@endsection

@section('scripts')
	<script src="{{asset('assets/customer/js/order/payment_method.js')}}"></script>
@endsection