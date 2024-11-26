@extends('layouts.app')
@section('content')
    <section class="lrForm">
        <div class="container-fluid p-0">
            <div class="back-arrow d-none d-md-block">
              <a href="{{route('login')}}"><img src="{{ asset('assets/images/back.png') }}"></a>
            </div>
            <div class="row align-items-center">
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
                    <div class="back-arrow d-block d-md-none">
                        <a href="#"><img src="images/back.png"></a>
                    </div>
                    <div class="form-info">
                        <h2>Active Account?</h2>
                        {{ Form::open(array('route' => array('resend'),'id'=>'sendToken_form','method'=>'POST','class'=>'','files'=>'true')) }}
                            @csrf
                            @include('common.flashMessage')
                            <div class="form-group">   
                                <i class="fa fa-envelope"></i>               
                                <input type="text" class="form-control" name="username" placeholder="Your Email or Phone" value="{{old('username')}}">
                            </div>                
                            <div class="form-group">
                                <div class="btn-custom">
                                    <button href="#" class="btn-blue"><span>Send Otp</span></button>
                                </div>
                            </div>
                        </form>
                    </div>  
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
{!! JsValidator::formRequest('App\Http\Requests\ForgotPasswordRequest','#sendToken_form'); !!}
@endsection