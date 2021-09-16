@extends('customer-layouts.app')

@section('content')
	<div class="add-address-banner wd-dr-inner-blog">
        <div class="container">
           <div class="wd-dr-chat-left">
            <div class="wd-dr-chat-inner"> 
                <h1>
                    Feedback
                </h1>
            </div>
            <div class="clearfix"></div>
           </div>
        </div>
    </div>

	<div class="container ">
	    <div class="jumbotron feedback-form Success-img">
	        <img src="{{asset('assets/customer/images/Success.jpg')}}">
	        <h3 class="feedback-h3">
	            Success
	        </h3>
	        <p class="feedback-p">
	            Your Payment has been succesfully done.
	        </p>
	        <p class="feedback-p">
	            Enjoy your order.
	        </p>
	        <a href="{{route('customer.index')}}" alt="Back to Home">Back To Home</a>
	    </div>
	</div>
@endsection