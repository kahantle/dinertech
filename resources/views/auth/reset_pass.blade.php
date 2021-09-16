@extends('layouts.app')
@section('content')

<style type="text/css">
  .success{
              height: 40px;
              width: auto;
              background: lightgreen;
              font-size: 25px;
              text-align: center;
              color: green;
            }
</style>

    <section class="lrForm">
        <div class="container-fluid pl-0">
            <div class="back-arrow d-none d-md-block">
              <a href="#"><img src="{{ asset('assets/images/back.png') }}"></a>
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
              <h2>Reset Password</h2>
            {{ Form::open(array('route' => array('updatePassword.post'),'id'=>'update_profile_form','method'=>'POST','class'=>'','files'=>'true')) }}

                @csrf
                @include('common.flashMessage')

                <div class="form-group"> 
                <input type="hidden" name="key" value="{{$token}}">  
                  <i class="fa fa-lock"></i>               
                  <input type="password" class="form-control" name="password" id="password" placeholder="New Password">
                  <a href="#" class="toggle-password" toggle="#password"><i class="fa fa-eye psw"></i></a>
                </div>
                <div class="form-group">   
                  <i class="fa fa-lock"></i>               
                  <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password">
                  <a href="#" class="toggle-password" toggle="#password_confirmation"><i class="fa fa-eye psw"></i></a>
                </div>
                <div class="form-group">
                  <div class="btn-custom">
                    <button type="submit" href="#" class="btn-blue"><span>Reset Password</span></button>
                  </div>
                </div>
                <div class="form-group text-center">
                  <a href="#">Cancel</a>
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
{!! JsValidator::formRequest('App\Http\Requests\Frontend\ResetPasswordRequest','#update_profile_form'); !!}
@endsection