@extends('layouts.app')
@section('content')
<section class="lrForm">
    <div class="container-fluid pl-0">
      <div class="row align-items-center align-items-lg-start">
        <div class="col-lg-5 col-md-6">
          <div class="left-pattern">
            <div class="logo">
              <a href="#"><img src="{{ asset('assets/images/logo.png') }}" class="img-fluid"></a>
            </div>
            <div class="btm-img">
              <img src="{{ asset('assets/images/mn-img.png') }}" class="img-fluid">
            </div>
          </div>
        </div>
        <div class="col-lg-7 col-md-6">
            @include('common.flashMessage')
          <div class="form-info">
            <h2>Sign Up</h2>
            {{ Form::open(array('route' => array('register'),'id'=>'signupForm','method'=>'POST','class'=>'')) }}
            <div class="form-group">   
                <i class="fa fa-user"></i>               
                <input type="text" class="form-control" id="first_name" name="first_name" value="{{ old('first_name') }}" placeholder="Owner First Name">
              </div>
              <div class="form-group">   
                <i class="fa fa-user"></i>               
                <input type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name') }}" placeholder="Owner Last Name">
              </div>
              <div class="form-group">   
                <i class="fa fa-cutlery"></i>               
                <input type="text" class="form-control" id="restaurant_name" name="restaurant_name" value="{{ old('restaurant_name') }}"placeholder="Restaurant Name">
              </div>
              <div class="form-group">   
                <i class="fa fa-map-marker"></i>               
                <input type="text" class="form-control" id="address" name="address" value="{{ old('address') }}"placeholder="Address">
              </div>
              <div class="form-group">   
                <i class="fa fa-mobile"></i>               
                <input type="text" class="form-control" id="mobile_number" name="mobile_number" value="{{ old('mobile_number') }}"placeholder="Mobile Number">
              </div>
              <div class="form-group">   
                <i class="fa fa-envelope"></i>               
                <input type="email" class="form-control" id="email_id" name="email_id"value="{{ old('email_id') }}" placeholder="Email">
              </div>
              <div class="form-group">   
                <i class="fa fa-lock"></i>               
                <input type="password" class="form-control"  id="password" name="password" placeholder="Password">
                <a href="#" class="toggle-password"  toggle="#password"><i class="fa fa-eye psw"></i></a>
              </div>
              <div class="form-group">   
                <i class="fa fa-lock"></i>               
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm Password">
                <a href="#" class="toggle-password" toggle="#confirm_password"><i class="fa fa-eye psw"></i></a>
              </div>
              <div class="form-group">
                <div class="btn-custom">
                  <button class="btn-blue"><span>Sign Up</span></button>
                </div>
              </div>
              <div class="form-group">
              <p>Don’t have an account? <a href="{{route('login')}}">Sign In</a></p>
              </div>
              {{ Form::close() }}
            </div>  
        </div>
      </div>
    </div>
  </section>
@endsection
@section('scripts')
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
{!! JsValidator::formRequest('App\Http\Requests\SignupRequest','#signupForm'); !!}
<script src="https://js.stripe.com/v3/"></script>
<script>
  
</script>
@endsection