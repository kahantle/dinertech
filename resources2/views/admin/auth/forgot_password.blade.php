@extends('admin.layouts.app_login')

@section('content')
<div class="login-backgroung">
    <div class="container">
        <div class="wd-dr-inner-login">
            <div class="jumbotron">
                <div class="row wd-dr-inner-future">
                    <div class="col-sm-5">
                        <img src="{{asset('assets/admin/images/Login-right-round.png')}}" alt="a cute kitten" class="img-login">
                    </div>
                    <div class="col-sm-7  text-margin">
                        <h2 class="forgotpassword">Forgot Password ?</h2>
                        <form role="form" action="{{route('admin.auth.change-password')}}" method="POST" class="login-form">
                            @csrf
                            <input type="hidden" name="admin_id" value="{{$user_id}}">
                            <div class="form-group">
                                <label></label>
                                <input type="password" class="form-control"  name="password" placeholder="Password" required>
                                <span class="icon fa fa-lock fa-lg"></span>
                            </div>
                            <div class="form-group">
                                <label></label>
                                <input type="password" class="form-control"  name="confirm_password" placeholder="Confirm Password" required>
                                <span class="icon fa fa-lock fa-lg"></span>
                            </div>

                            <div class="form-group">
                                <label></label>
                                <button class="btn btn-block" type="submit">Forgot password</button>
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