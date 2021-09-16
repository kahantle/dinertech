@extends('layouts.app')
@section('content')
    <section class="lrForm">
      <div class="container-fluid p-0">
        <div class="back-arrow d-none d-md-block">
          <a href="{{route('login')}}"><img src="{{ asset('assets/images/back.png') }}"></a>
        </div>
        <div class="row align-items-center m-0">
          <div class="col-lg-5 col-md-6 p-0">
            <div class="left-pattern">
              <div class="logo">
                <a href="{{route('login')}}"><img src="{{ asset('assets/images/logo.png') }}"></a>
              </div>
              <div class="btm-img">
                <img  src="{{ asset('assets/images/mn-img.png') }}"  class="img-fluid">
              </div>
            </div>
          </div>
          <div class="col-lg-7 col-md-6 p-0">
            <div class="back-arrow d-block d-md-none">
              <img  src="{{ asset('assets/images/mn-img.png') }}"  class="img-fluid">
            </div>
            <div class="form-info">
              <h2>Verification</h2>
              @include('common.flashMessage')   

              {{ Form::open(array('route' => array('verify'),'id'=>'verifyForm','name'=>'verifyForm','method'=>'POST')) }}
              <div class="text">
                <p>Enter the verification code we send to<br>  
                  {{$username}}</p>
                <div class="code">
                  <ul>
                    <li class="codeblock"><input type="text" id="digit-1" name="digit[1]" data-next="digit-2" class="form-control digit-group-input" ></li>
                    <li class="codeblock"><input type="text" id="digit-2" name="digit[2]" data-next="digit-3" data-previous="digit-2" class="form-control digit-group-input" ></li>
                    <li class="codeblock"><input type="text" id="digit-3" name="digit[3]" data-next="digit-4" data-previous="digit-3" class="form-control digit-group-input" ></li>
                    <li class="codeblock"><input type="text" id="digit-4" name="digit[4]"  data-next="digit-5" data-previous="digit-4" class="form-control digit-group-input" ></li>
                  </ul>
                </div>
                <div class="btn-custom">
                  {{ Form::close() }}
                  <input type="hidden" id="username" name="username" value="{{$username}}" />
                  <button class="btn-blue"><span>Verify Now</span></button>
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
    {!! JsValidator::formRequest('App\Http\Requests\VerifyRequest','#verifyForm'); !!}
    @endsection