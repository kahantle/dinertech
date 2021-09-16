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
            <h2>Payment</h2>
            {{ Form::open(array('route' => array('post.pay'),'id'=>'paymentForm','method'=>'POST','class'=>'')) }}
                <div class="code">
                  <ul>
                    <li class="codeblock" style="width: 100px">
                      <input type="text" id="digit-1" name="digit[1]" data-next="digit-2" class="form-control digit-card-input" ></li>
                    <li class="codeblock" style="width: 100px">
                      <input type="text" id="digit-2" name="digit[2]" data-next="digit-3" data-previous="digit-2" class="form-control digit-card-input" ></li>
                    <li class="codeblock" style="width: 100px">
                      <input type="text" id="digit-3" name="digit[3]" data-next="digit-4" data-previous="digit-3" class="form-control digit-card-input" ></li>
                    <li class="codeblock" style="width: 100px">
                      <input type="text" id="digit-4" name="digit[4]"  data-next="digit-5" data-previous="digit-4" class="form-control digit-card-input" ></li>
                  </ul>
                </div>
              <div class="form-group select-input">   
                <select id="ccExpiryMonth" name="ccExpiryMonth" class="form-control ">
                  <option value="">Select Month</option>
                  <option value="01">Jan</option>
                  <option value="02">Feb</option>
                  <option value="03">Mar</option>
                  <option value="04">Apr</option>
                  <option value="05">May</option>
                  <option value="06">Jun</option>
                  <option value="07">Jul</option>
                  <option value="08">Aug</option>
                  <option value="09">Sep</option>
                  <option value="10">Oct</option>
                  <option value="11">Nov</option>
                  <option value="12">Dec</option>
              </select>
              </div>
              <div class="form-group">   
                <select id="ccExpiryYear" class="form-control select-input" name="ccExpiryYear">
                  <option value="">Select Year</option>
                  @for ($i = date('y'); $i <= date('y')+10 ; $i++) <option value="{{ $i }}">
                      {{date('y').$i }}</option>
                      @endfor
              </select>
              </div>
              <div class="form-group">   
                <i class="fa fa-envelope"></i>               
                <input type="email" class="form-control" id="cvvNumber" name="cvvNumber" placeholder="Cvv">
              <input type="hidden" class="form-control" id="username" name="username" value="{{$username}}" placeholder="username">
              </div>
              <div class="form-group">
                <div class="btn-custom">
                  <button class="btn-blue"><span>Pay Now</span></button>
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
{!! JsValidator::formRequest('App\Http\Requests\PaymentRequest','#paymentForm'); !!}
@endsection