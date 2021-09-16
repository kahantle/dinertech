@extends('layouts.app')
@section('content')
    <section class="lrForm">
        <div class="container-fluid pl-0">
          <div class="back-arrow d-none d-md-block">
            <a href="#"><img src="images/back.png"></a>
          </div>
          <div class="row align-items-center">
            <div class="col-lg-5 col-md-6">
              <div class="left-pattern">
                <div class="logo">
                  <a href="#"><img src="{{ asset('assets/images/logo.png') }}" class="img-fluid"></a>
                </div>
                <div class="btm-img">
                  <img src="{{ asset('assets/images/images/mn-img.png') }}" class="img-fluid">
                </div>
              </div>
            </div>  
            <div class="col-lg-7 col-md-6">
              <div class="back-arrow d-block d-md-none">
                <a href="#"><img src="images/back.png"></a>
              </div>
              <div class="form-info">
                <h2>Verify Your Number</h2>
                {{ Form::open(array('route' => array('confirm'),'id'=>'confirmForm','method'=>'POST','class'=>'')) }}
                <div class="form-group">            
                    <input type="email" class="form-control" placeholder="Enter code">
                  <input type="hidden" id="username" name="username" value="{{$username}}" />
                  </div>                
                  <div class="form-group">
                    <div class="btn-custom">
                      <button class="btn-blue"><span>Verify Now</span></button>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="link text-center">
                    <a href="{{route('resend')}}">Resend confirmation code</a>
                    </div>
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
@endsection