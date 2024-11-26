@extends('customer-layouts.app')


@section('content')
	<div class="add-address-banner wd-dr-inner-blog">
        <div class="container">
           <div class="wd-dr-chat-left">
				<div class="wd-dr-chat-inner"> 
					<h1>
						Address
					</h1>
				</div>
				<div class="clearfix"></div>
			</div>
        </div>
    </div>

	<div class="container list-address">
	    <div class="jumbotron">
	        <div class="row">
	        	<div class="col-sm-12">
	                <h3>
	                    Select Address for your order.
	                </h3>
	            </div>
	        </div>
	        <div class="row">
	        	@include('customer.messages')
	        	@foreach($addressLists as $address)
		            <div class="col-md-6">
		                <div class="add-info">
		                    <h4>
		                        <img src="{{asset('assets/customer/images/map.png')}}"> {{$address->type}} | 3.5 Km
		                    </h4>
		                    <p>
		                        {{$address->address}}
		                    </p>
		                    <button type="submit" class="btn btn-primary select-add" alt="Select">Select                            
		                    </button>
		                    <div class="clearfix">

		                    </div>
		                </div>
		            </div>
	            @endforeach
	        </div>
	    </div>
	</div>
@endsection