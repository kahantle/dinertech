
<div class="modal modal-sign-up" id="yourModal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel"><b>Login</b></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger" id="login-error"></div>
                <a href="javascript:;" class="sign-up-inner float-right btn-third within-third-modal">Forgot Password
                    ?</a>
                <form action="{{ route('customer.login') }}" method="post" id="loginForm">
                    @csrf
                    <div class="form-group">
                        <input type="email" class="form-control" name="username" aria-describedby="emailHelp"
                            placeholder="Enter Email">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="password" placeholder="Enter Password">
                    </div>
                    <button type="submit" class="btn btn-login-modal btn-submit-inner"><b>Login</b></button>

                    <p>Don't have account ? <a href="javascript:;"
                            class="sign-up-inner btn-second-modal within-first-modal">Sign up</a></p>
                    <a href="{{ route('customer.google.login') }}" class="google-signin-link"
                        alt="G Signin with Google"><i class="fab fa-google"></i>Signin with Google</a>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal modal-sign-up" id="second-modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><b>Sign up</b></h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger" id="register-error"></div>
                <form action="{{ route('customer.signup') }}" method="post" id="customer-signup">
                    @csrf
                    <div class="form-group row">
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="first_name" placeholder="First Name">
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="last_name" placeholder="Last Name">
                        </div>
                    </div>

                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Physical Address"
                            name="physical_address">
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <input type="text" class="form-control" placeholder="City" name="city">
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" placeholder="State" name="state">
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Zip code" name="zipcode">
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <input type="text" class="form-control" placeholder="Mobile Number" name="mobile_number">
                        </div>
                        <div class="col-md-6">
                            <input type="email" class="form-control" placeholder="Email Address" name="email_id">
                        </div>
                    </div>

                    <div class="form-group">
                        <input type="password" class="form-control" placeholder="Password" name="password">
                    </div>
                    <button type="submit" class="btn btn-login-modal btn-submit-inner"><b>Signup</b></button>
                    <p class="mt-2 text-center">Account already exists ? <a href="javascript:;"
                            class="sign-up-inner btn-second-modal-close">Login</a></p>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal modal-sign-up" id="third-modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><b>Forgot Password</b></h4>
            </div>
            <div class="modal-body text-center">
                <div class="alert alert-danger" id="forgot-error"></div>
                <form action="{{ route('customer.forgotPassword') }}" method="post" id="forget-password">
                    @csrf
                    <div class="form-group">
                        <input type="text" class="form-control" name="email_mobile_number"
                            placeholder="Enter email or Mobile number">
                    </div>
                    <button type="submit" class="btn btn-four-msg with-fourth btn-login-modal btn-submit-inner">Send
                        Verification</button>
                    <p class="mt-2">Back to ? <a href="javascript:;"
                            class="sign-up-inner btn-party-modal-close"> Login </a></p>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Otp Send Message Modal -->
<div class="modal modal-sign-up" id="four-modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body pt-0 pb-4">
                <h6 class="sucess-blog">Success</h6>
                <p class="mt-0">We've sent verification code in you registered email address, please check
                    your email address.(and possibly spam folder).</p>
                <button type="button" class="btn btn-login-modal btn-five-msg with-five">Ok</button>
            </div>
        </div>
    </div>
</div>

<!-- Enter Otp Modal -->
<div class="modal modal-sign-up" id="five-modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pt-3 pb-0">
            </div>
            <div class="modal-body pt-0 pb-4">
                <div class="alert alert-danger" id="otp-error"></div>
                <form action="{{ route('customer.verifyOtp') }}" method="POST" id="OtpVerify">
                    @csrf
                    <input type="hidden" name="email_id" id="email_id">
                    <h6 class="verify-code text-center">Enter verifiaction code</h6>
                    <div id="wrapper">
                        <div id="dialog">
                            <div id="form">
                                <input type="text" class="otpInput" maxLength="1" size="1" min="0" max="9"
                                    pattern="[0-9]{1}" required name="otp_digit[1]" />
                                <input type="text" class="otpInput" maxLength="1" size="1" min="0" max="9"
                                    pattern="[0-9]{1}" required name="otp_digit[2]" />
                                <input type="text" class="otpInput" maxLength="1" size="1" min="0" max="9"
                                    pattern="[0-9]{1}" required name="otp_digit[3]" />
                                <input type="text" class="otpInput" maxLength="1" size="1" min="0" max="9"
                                    pattern="[0-9]{1}" required name="otp_digit[4]" />
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-login-modal btn-six-msg with-six">Send Verification</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Otp verification success modal -->
<div class="modal modal-sign-up" id="six-modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pt-3 pb-0">
            </div>
            <div class="modal-body pt-0 pb-4">
                {{-- <form> --}}
                <h6 class="sucess-blog">Success</h6>
                <p class="pt-0">Your verification process has been Successfull. Please change or set you
                    new password.</p>

                <button type="button" class="btn btn-login-modal btn-seven-msg with-seven">Ok</button>
                {{-- </form> --}}
            </div>
        </div>
    </div>
</div>

<!-- Reset Password Modal -->
<div class="modal modal-sign-up" id="seven-modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">ForgotPassword</h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger" id="reset-password-error"></div>
                <form action="{{ route('customer.resetPassword') }}" method="POST" id="chage-password">
                    @csrf
                    <input type="hidden" name="email_id" id="customer_email_id">
                    <div class="form-group">
                        <input type="password" class="form-control" name="password" aria-describedby="emailHelp"
                            placeholder="Password" id="new-password">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="retype_password"
                            aria-describedby="emailHelp" placeholder="Confirm Password">
                    </div>

                    <button type="submit" class="btn btn-login-modal change-password">Change Password</button>
                    <p>Back to ? <a href="javascript:;" class="sign-up-inner btn-partyware-modal-close"> Login</a></p>
                </form>
            </div>
        </div>
    </div>
</div>

