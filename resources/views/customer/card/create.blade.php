@extends('customer-layouts.app')

@section('content')
	{{-- <div class="container-fluid">
	    <div class="add-address-banner">
	        <div class="container">
	            <h1>
	                Payment Cards
	            </h1>
	            <a href="{{route('customer.cards.list')}}" class="place-order">View Cards</a>
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
                    Add Card
                </h1>
            </div>
            <div class="clearfix"></div>
			<a href="{{route('customer.cards.list')}}" class="place-order">View Cards</a>
           </div>
        </div>
    </div>

	<div class="container list-address">
	    <div class="jumbotron">
	        <div class="row">
	            <div class="col-sm-12">
	                <h3>
	                    Add card details for your payment.
	                </h3>
	            </div>
	            <div class="col-md-6">
	            	<input type="hidden" value="{{asset('assets/customer/images/')}}" id="card-image-path">
	                <div class="add-payment">
	                    <h4>
	                    	<img src="#" class="show-card-image hide">
	                    </h4>
	                    <label class="card-font card-number">XXXX XXXX XXXX XXXX</label>
	                    <div>
	                        <div class="expdate">
	                            <label class="datetext">Exp Date</label>
	                            <label class="card-font card-exp-date">MM / YY</label>
	                        </div>
	                        <div class="cvv">
	                            <label class="datetext">CVV</label>
	                            <label class=" card-font card-cvv">***</label>
	                        </div>
	                    </div>
	                    <div class="clearfix ">

	                    </div>
	                    <label>
	                        Card Holder Name
	                    </label>
	                    <h4 class="card-holder-name">
	                        XXXX XXXX XXXX.
	                    </h4>
	                    <div class="clearfix ">

	                    </div>
	                </div>
	            </div>
	            <div class="col-md-6 card-detail">
	                <h3>
	                    Card Details
	                </h3>
	                <form action="{{route('customer.cards.store')}}" method="post" id="addCardForm">
	                	@csrf
	                	<input type="hidden" name="card_type" id="cardType">
	                    <div class="form-group">
	                        <input id="card-number" type="tel" class="form-control address" inputmode="numeric" pattern="[0-9\s]{13,19}" autocomplete="cc-number" maxlength="19" placeholder="Card Number">
	                        @error('card_number')
	                        	{{$message}}
	                        @enderror
	                    </div>
	                    <div class="row form-group">
	                        <div class="col-sm-6">
	                            <input type="text" class="form-control address" name="card_expire_date" id="card-exp-date" placeholder="Exp Date" maxlength="5">
	                            @error('card_expire_date')
		                        	{{$message}}
		                        @enderror
	                        </div>
	                        <div class="col-sm-6">
	                            <input type="text" class="form-control address" name="card_cvv" id="card-cvv" placeholder="CVV" maxlength="3">
	                            @error('card_cvv')
		                        	{{$message}}
		                        @enderror
	                        </div>
	                    </div>
	                    <div class="form-group">
	                        <input type="text" class="form-control address" name="card_holder_name" id="card-holder-name" placeholder="Card Holder Name">
	                        @error('card_holder_name')
	                        	{{$message}}
	                        @enderror
	                    </div>
	                    <div class="row form-group">
	                        <div class="col-md-6 col-md-offset-3">
	                            <button type="submit" class="btn btn-primary btn-lg add-address" alt="Add Card"><h4>Add Card</h4>
	                                
	                            </button>
	                        </div>
	                    </div>
	                </form>
	            </div>
	        </div>
	    </div>
	</div>

	<div class="container list-address">
		<div class="col-sm-12">
			<div class="row">
				<div class="col-md-3 col-sm-3 text-center">
					<img src="{{asset('assets/customer/images/visa.png')}}" class="card-image">
				</div>
				<div class="col-md-3 col-sm-3 text-center">
					<img src="{{asset('assets/customer/images/master_card.png')}}" class="card-image">
				</div>
				<div class="col-md-3 col-sm-3 text-center">
					<img src="{{asset('assets/customer/images/american-express_1.png')}}" class="card-image">
				</div>
				<div class="col-md-3 col-sm-3 text-center">
					<img src="{{asset('assets/customer/images/discover.png')}}" class="card-image">
				</div>
			</div>
		</div>
	</div>
@endsection

@section('scripts')
	<script src="{{asset('assets/customer/js/jquery.validate.min.js')}}"></script>
	<script src="{{asset('assets/customer/js/additional-methods.min.js')}}"></script>
	<script src="{{asset('assets/customer/js/card/create.js')}}"></script>
@endsection