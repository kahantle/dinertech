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
	    <div class="jumbotron feedback-form">
	        <h3 class="feedback-h3">
	            Send us you Feedback!
	        </h3>
	        <p class="feedback-p">
	            Do you have a order error or quality feedback,delivery feedback, general feedback?
	        </p>
	        <p class="feedback-p">
	            Let us know in the field below.
	        </p>
	        <div class="row">
	        	@include('customer.messages')
	            <div class="col-sm-6 col-sm-offset-3">
	                <form class="from-margin" action="{{route('customer.feedback.store')}}" method="post" id="feedbackForm">
	                	@csrf
	                    <div class="form-group ">
	                        <input type="text" class="form-control address " placeholder="Name" name="name">
	                        @error('name')
	                        	<span class="error">{{$message}}</span>
	                        @enderror
	                    </div>
	                    <div class="form-group ">
	                        <input type="text" class="form-control address " placeholder="Phone" name="phone_number">
	                        @error('phone_number')
	                        	<span class="error">{{$message}}</span>
	                        @enderror
	                    </div>
	                    <div class="form-group ">
	                        <input type="text" class="form-control address " placeholder="Email" name="email">
	                        @error('email')
	                        	<span class="error">{{$message}}</span>
	                        @enderror
	                    </div>
	                    <div class="form-group select">
	                        <select class="form-control" name="feedback_type">
	                            <option value="{{config('constants.CUSTOMER_FEEDBACK_TYPE.1')}}">{{config('constants.CUSTOMER_FEEDBACK_TYPE.1')}}</option>
	                            <option value="{{config('constants.CUSTOMER_FEEDBACK_TYPE.2')}}">{{config('constants.CUSTOMER_FEEDBACK_TYPE.2')}}</option>
	                            <option value="{{config('constants.CUSTOMER_FEEDBACK_TYPE.3')}}">{{config('constants.CUSTOMER_FEEDBACK_TYPE.3')}}</option>
	                            <option value="{{config('constants.CUSTOMER_FEEDBACK_TYPE.4')}}">{{config('constants.CUSTOMER_FEEDBACK_TYPE.4')}}</option>
	                        </select>
	                        @error('feedback_type')
	                        	<span class="error">{{$message}}</span>
	                        @enderror
	                    </div>
	                    <div class="form-group ">
	                        <input type="text" class="form-control" placeholder="Message" name="message">
	                        @error('message')
	                        	<span class="error">{{$message}}</span>
	                        @enderror
	                    </div>
	                    <div class=" form-group ">
	                        <div class="">
	                            <button type="submit " class="btn btn-primary btn-lg add-address " alt="Send Feedback">Send Feedback
	                                
	                            </button>
	                        </div>
	                    </div>
	                </form>
	            </div>
	        </div>
	    </div>
	</div>
@endsection

@section('scripts')
	<script src="{{asset('assets/customer/js/jquery.validate.min.js')}}"></script>
	<script src="{{asset('assets/customer/js/additional-methods.min.js')}}"></script>
	<script src="{{asset('assets/customer/js/feedback/index.js')}}"></script>
@endsection