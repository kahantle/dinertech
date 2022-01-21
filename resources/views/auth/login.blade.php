@extends('layouts.app')
@section('content')
    <section class="lrForm">
        <div class="w-100">
            <div class="row align-items-center no-gutters">
                <div class="col-md-6 col-lg-6 col-xl-5">
                    <div class="left-pattern">
                        <div class="logo">
                            <a href="#"><img src="{{ asset('assets/images/logo.png') }}" class="img-fluid"></a>
                        </div>
                        <div class="btm-img">
                            <img src="{{ asset('assets/images/mn-img.png') }}" class="img-fluid">
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-xl-7">

                    <div class="form-info">
                        @include('common.flashMessage')
                        <h2>Sign In</h2>
                        {{ Form::open(['route' => ['login'], 'id' => 'loginForm', 'method' => 'POST', 'class' => '']) }}
                        <div class="form-group">
                            <i class="fa fa-envelope"></i>
                            <input type="email" class="form-control" id="username" name="username"
                                placeholder="Your Email or Phone">
                        </div>
                        <div class="form-group">
                            <i class="fa fa-lock"></i>
                            <input type="password" class="form-control" id="password" name="password"
                                placeholder="Password">
                            <a href="#" class="toggle-password" toggle="#password"><i class="fa fa-eye psw"></i></a>
                        </div>
                        <div class="form-group">
                            <a href="forgot-pass">Forgot Password ?</a>
                        </div>
                        <div class="form-group">
                            <div class="btn-custom">
                                <button class="btn-blue"><span>Sign In</span></button>

                            </div>
                        </div>
                        <div class="form-group">
                            <p>Don’t have an account? <a href="{{ route('register') }}">Sign Up</a></p>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\LoginRequest', '#loginForm') !!}

@endsection
