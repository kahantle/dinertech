@extends('admin.layouts.app_login')

@section('content')
<div class="login-backgroung">
    <div class="container">
        <div class="wd-dr-inner-login">
            <div class="jumbotron">
                <div class="row wd-dr-inner-future">
                    <div class="col-sm-5">
                        <img src="{{asset('assets/admin/images/Login-right-round.png')}}" 
                            alt="a cute kitten" class="img-login">
                    </div>
                    <div class="col-sm-7  text-margin">
                        <h2 class="forgotpassword">Verification Process</h2>
                        <p>
                            Enter Your Verification code from received Your Register Mobile number or Email Address below and click Forgot Password Button.
                        </p>
                        @if(session()->has('error'))
                            <div class="alert alert-danger">
                                {{ session()->get('error') }}
                            </div>
                        @endif
                        <form role="form " action="{{route('admin.auth.forget-passsword.verifyOtp')}}" method="POST" class="login-form forgot-password-form">
                            @csrf
                            <input type="hidden" name="admin_id" value="{{Session::get('admin_id')}}">
                            <div class="forgot-email-blog">
                                <div class="form-group">
                                    <input class="otp" type="password" name="number_one" oninput='digitValidate(this)' onkeyup='tabChange(1)' maxlength=1 >
                                </div>
                                <div class="form-group">
                                    <input class="otp" type="password" name="number_two" oninput='digitValidate(this)' onkeyup='tabChange(2)' maxlength=1 >
                                </div>
                                <div class="form-group">
                                    <input class="otp" type="password" name="number_three" oninput='digitValidate(this)' onkeyup='tabChange(3)' maxlength=1 >
                                </div>
                                <div class="form-group">
                                    <input class="otp" type="password" name="number_fourth" oninput='digitValidate(this)'onkeyup='tabChange(4)' maxlength=1 >
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="email"></label>
                                <button class="btn btn-block" type="submit">Submit</button>
                            </div>

                            <div class="form-group">
                                <label for="email"></label>
                                <a href="{{route('admin.auth.forgot-password')}}" class="backlogin">Back to Forgot Password ?</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    let digitValidate = function(ele){
        ele.value = ele.value.replace(/[^0-9]/g,'');
    }

    let tabChange = function(val){
        let ele = document.querySelectorAll('input');
        if(ele[val-1].value != ''){
            ele[val].focus()
        }else if(ele[val-1].value == ''){
            ele[val-2].focus()
        }   
    }
</script>
@endsection