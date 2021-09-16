@extends('customer-layouts.app')

@section('content')
	{{-- <div class="container-fluid">
	    <div class="add-address-banner">
	        <div class="container">
	            <h1>
	                Payment Cards
	            </h1>
	            <a href="{{route('customer.cards.create')}}" class="place-order">ADD CARD</a>
	            @if(!empty($orderDetails))
	            	<a class="place-order pay hide" data-toggle="modal" data-target="#place-order" alt="Place Order">PAY</a>
	            @endif
	            <div class="modal fade" id="place-order" tabindex="-1" role="dialog" aria-labelledby="modifier-btn">
	                <div class="modal-dialog" role="document">
	                    <div class="modal-content">
	                        <div class="modal-header">
	                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" alt="Modal Close"><span
	                                    aria-hidden="true">&times;</span></button>
	                            <img src="{{asset('assets/customer/images/logo-blue.png')}}">
	                            <h4>Please Enter your CVV number for security purpose</h4>
	                        </div>
	                        <form action="{{route('customer.place.order')}}" method="post">
	                        	@csrf
		                        <div class="modal-body">
		                            <h3>Card Details</h3>
		                            <div>
		                                <span class="">Card Number : </span>
		                                <label class="card-font set-card-number">XXXX XXXX XXXX XXXX</label>
		                                <input type="hidden" name="card_number" id="cardNumber">
		                            </div>
		                            <div>
		                                <span class="">Exp Date : </span>
		                                <label class="card-font set-card-exp_date"></label>
		                                <input type="hidden" name="card_exp_date" id="cardExpDate">
		                            </div>
		                            <div>
		                                <span>Card Holder Name :</span>
		                                <label class="set-card-holderName"></label>
		                                <input type="hidden" name="card_holder_name" id="cardHolderName">
		                            </div>
		                            <div class="clearfix ">

		                            </div>
		                            <div class="form-group">
		                                <div class="login-form">
		                                    <div class="form-group form-group-verify-input">
		                                        <input type="password" class="form-control verify-input text-center" name="csv_no_1" aria-describedby="emailHelp" placeholder="" style="font-size: xx-large;" minlength="1" maxlength="1" required>
		                                    </div>
		                                    <div class="form-group form-group-verify-input">
		                                        <input type="password" class="form-control verify-input text-center" name="csv_no_2" aria-describedby="emailHelp" placeholder="" style="font-size: xx-large;" minlength="1" maxlength="1" required>
		                                    </div>
		                                    <div class="form-group form-group-verify-input">
		                                        <input type="password" class="form-control verify-input text-center" name="csv_no_3" aria-describedby="emailHelp" placeholder="" style="font-size: xx-large;" minlength="1" maxlength="1" required>
		                                    </div>
		                                </div>
		                            </div>
		                        </div>
		                        <div class="modal-footer">
		                            <button type="submit" class="btn btn-primary btn-block" alt="Pay Now">
		                                <h4>Pay Now</h4>
		                            </button>
		                        </div>
		                    </form>
	                    </div>
	                </div>
	            </div>
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
						Payment Cards
					</h1>
				</div>
				<div class="clearfix"></div>
				<a href="{{route('customer.cards.create')}}" class="place-order">ADD CARD</a>
				@if(!empty($orderDetails))
					<a class="place-order pay hide" data-toggle="modal" data-target="#place-order" alt="Place Order">PAY</a>
				@endif
				<div class="modal fade" id="place-order" tabindex="-1" role="dialog" aria-labelledby="modifier-btn">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close" alt="Modal Close"><span
										aria-hidden="true">&times;</span></button>
								<img src="{{asset('assets/customer/images/logo-blue.png')}}">
								<h4>Please Enter your CVV number for security purpose</h4>
							</div>
							<form action="{{route('customer.place.order')}}" method="post">
								@csrf
								<div class="modal-body">
									<h3>Card Details</h3>
									<div>
										<span class="">Card Number : </span>
										<label class="card-font set-card-number">XXXX XXXX XXXX XXXX</label>
										<input type="hidden" name="card_number" id="cardNumber">
									</div>
									<div>
										<span class="">Exp Date : </span>
										<label class="card-font set-card-exp_date"></label>
										<input type="hidden" name="card_exp_date" id="cardExpDate">
									</div>
									<div>
										<span>Card Holder Name :</span>
										<label class="set-card-holderName"></label>
										<input type="hidden" name="card_holder_name" id="cardHolderName">
									</div>
									<div class="clearfix ">

									</div>
									<div class="form-group">
										<div class="login-form">
											<div class="form-group form-group-verify-input">
												<input type="password" class="form-control verify-input text-center" name="csv_no_1" aria-describedby="emailHelp" placeholder="" style="font-size: xx-large;" minlength="1" maxlength="1" required>
											</div>
											<div class="form-group form-group-verify-input">
												<input type="password" class="form-control verify-input text-center" name="csv_no_2" aria-describedby="emailHelp" placeholder="" style="font-size: xx-large;" minlength="1" maxlength="1" required>
											</div>
											<div class="form-group form-group-verify-input">
												<input type="password" class="form-control verify-input text-center" name="csv_no_3" aria-describedby="emailHelp" placeholder="" style="font-size: xx-large;" minlength="1" maxlength="1" required>
											</div>
										</div>
									</div>
								</div>
								<div class="modal-footer">
									<button type="submit" class="btn btn-primary btn-block" alt="Pay Now">
										<h4>Pay Now</h4>
									</button>
								</div>
							</form>
						</div>
					</div>
				</div>
           </div>
        </div>
    </div>

	<div class="container list-address">
	    <div class="jumbotron">
	        <div class="row">
	        	@include('customer.messages')
	        	
	        	@foreach($cards as $card)
		            <div class="col-md-6">
		                <div class="add-payment boxShadow" style="box-shadow: none !important;" data-card-number="{{$card->card_number}}" data-exp-date="{{$card->card_expire_date}}" data-card-holder-name="{{$card->card_holder_name}}"> 
		                	@if($card->card_type == 'AMERICAN_EXPRESS')
			                    <h4>
			                        <img src="{{asset('assets/customer/images/american-express.png')}}" class="card-list-img">
			                    </h4>
		                	@elseif($card->card_type == 'DISCOVER')
		                		<h4>
		                		    <img src="{{asset('assets/customer/images/discover.png')}}" class="card-list-img">
		                		</h4>
		                	@elseif($card->card_type == 'MASTER_CARD')
		                		<h4>
		                		    <img src="{{asset('assets/customer/images/master_card.png')}}" class="card-list-img">
		                		</h4>
		                	@elseif($card->card_type == 'VISA')
		                		<h4>
		                		    <img src="{{asset('assets/customer/images/visa.png')}}" class="card-list-img">
		                		</h4>
		                	@else
		                		<h4>
		                		    <img src="{{asset('assets/customer/images/logo-payment.png')}}" class="card-list-img">
		                		</h4>
		                	@endif
		                    <label class="card-font">{{$card->card_number}}</label>
		                    <div>
		                        <div class="expdate">
		                            <label class="datetext">Exp Date</label>
		                            <label class="card-font">{{$card->card_expire_date}}</label>
		                        </div>
		                        <div class="cvv">
		                            <label class="datetext">CVV</label>
		                            <label class=" card-font ">**{{substr($card->card_cvv,-1)}}</label>
		                        </div>
		                    </div>
		                    <div class="clearfix ">

		                    </div>
		                    <label>
		                        Card Holder Name
		                    </label>
		                    <h4>
		                        {{$card->card_holder_name}}
		                    </h4>
		                    <div class="clearfix ">

		                    </div>
		                </div>
		            </div>
	            @endforeach
	        </div>
	    </div>
	</div>
@endsection

@section('scripts')
	<script src="{{asset('assets/customer/js/card/index.js')}}"></script>
@endsection
