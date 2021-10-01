@extends('admin.layouts.app_login')

@section('content')
    <div class="login-backgroung">
        <div class="container">
            <div class="wd-dr-inner-login">
                <div class="jumbotron">
                    <div class="row wd-dr-inner-future">
                        <div class="col-sm-5">
                            <img src="{{asset('assets/admin/images/Login-right-round.png')}}" class="img-login">
                        </div>
                        <div class="col-sm-7">
                            <h2 class="forgotpassword">Forgot Password ?</h2>
                            <p>
                                Enter Your Mobile Number or Email Address below and click Confirm Button.
                            </p>
                            <p>
                                You get received Your password from your Register Mobile Number or Email Address.
                            </p>
                            @if(session()->has('error'))
                                <div class="alert alert-danger">
                                    {{ session()->get('error') }}
                                </div>
                            @endif
                            <form role="form " action="{{route('admin.auth.forget-passsword.getcode')}}" method="POST" class="login-form">
                                @csrf
                                <div class="form-group">
                                    <label></label>
                                    <input type="text" class="form-control" name="email_phone_number" placeholder="Mobile Number / Email Address" value="{{old('email_phone_number')}}" required>
                                    <!--placing icon using a span element-->
                                    <span class="icon fa fa-user fa-lg"></span>
                                    @error('email_phone_number')
                                        <span class="error">{{$message}}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label></label>
                                    <button class="btn btn-block" type="submit">Confirm</button>
                                </div>

                                <div class="form-group">
                                    <label></label>
                                    <a href="{{route('admin.auth.login')}}" class="backlogin">Back to Login</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection