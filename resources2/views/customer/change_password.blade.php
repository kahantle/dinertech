@extends('customer-layouts.app')

@section('content')
	<div class="add-address-banner wd-dr-inner-blog">
        <div class="container">
           <div class="wd-dr-chat-left">
                <div class="wd-dr-chat-inner"> 
                    <h1>
                        Change Password
                    </h1>
                </div>
                <div class="clearfix">
                </div>
           </div>
        </div>
    </div>

	<div class="container">
	    <div class="jumbotron change-pass">
	        <div class="row">
	        	@include('customer.messages')
	            <div class="col-sm-6 col-sm-offset-3">
	                <form action="{{route('customer.changepassword.submit')}}" method="post" id="changePassword">
	                	@csrf
	                    <div class="form-group">
	                        <label>Current Password</label>
	                        <input type="password" class="form-control" name="current_password">
	                        @error('current_password')
	                        	<span class="error">{{$message}}</span>
	                        @enderror
	                    </div>
	                    <div class="form-group">
	                        <label>New Password</label>
	                        <input type="password" class="form-control" name="password" id="password">
	                        @error('password')
	                        	<span class="error">{{$message}}</span>
	                        @enderror
	                    </div>
	                    <div class="form-group">
	                        <label>Confirm New Password</label>
	                        <input type="password" class="form-control" name="password_confirmation">
	                        @error('password_confirmation')
	                        	<span class="error">{{$message}}</span>
	                        @enderror
	                    </div>
	                    <button type="submit" class="btn btn-primary" alt="Update Password"><h4>Update Password</h4></button>
	                </form>
	            </div>
	        </div>
	    </div>
	</div>
@endsection

@section('scripts')
	<script src="{{asset('assets/customer/js/jquery.validate.min.js')}}"></script>
	<script src="{{asset('assets/customer/js/additional-methods.min.js')}}"></script>
	<script src="{{asset('assets/customer/js/home/changepassword.js')}}"></script>
@endsection