<div class="container-fluid">
    <header>
        <nav class="navbar navbar-default">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" alt="Toggle navigation" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{route('customer.index')}}" alt="Navigation Bar">
                    <img alt="Brand" src="{{asset('assets/customer/images/logo.jpg')}}">
                </a>
            </div>

            <!--w3 collapse menu-->
            <div class="w3-sidebar w3-bar-block w3-border-right" style="display:none" id="LoginSidebar">
                <img src="{{asset('assets/customer/images/logo.jpg')}}">
                <button onclick="closeLogin()" class="w3-bar-item w3-large close-btn" alt="Close Login">&times;</button>
                <div style="clear: both;"></div>
                <h1>
                    Login
                </h1>
                <p id="login-error" class="error"></p>
                <a href="#" class="forgot-pass-link" onclick="openForgotPassword()" alt="Forgot Password">Forgot Password ?</a>
                <form class="login-form" action="{{route('customer.login')}}" method="post" id="login">
                    {!! csrf_field() !!}
                    <div class="form-group">
                        <input type="text" class="form-control" name="username" aria-describedby="emailHelp" placeholder="Enter email or Mobile number">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="password" placeholder="Enter Password">
                    </div>
                    <button type="submit" class="btn btn-primary loginbtntooltip" alt="Login">Login
                        <div class="tooltiptext">
                            <h4>Login</h4>
                            <span>
                                Enter your email or password and login in Dinertech
                            </span>
                        </div>
                    </button>

                    <div class="form-group signup-link">
                        <label>Don't have account ? </label><a href="#" class="signin-link" onclick="openSignup()" alt="SignUp">Signup</a>
                    </div>
                    <button type="submit" class="btn btn-default google-signin-link" alt="G Signin with Google"> G Signin with Google</button>
                </form>
            </div>

            @if(Auth::check())
            <!--menu-logedin-->
            <div class="w3-sidebar w3-bar-block w3-border-right" style="display:none" id="menu-icon-menu">
                <img src="{{asset('assets/customer/images/logo.jpg')}}">
                
                <button onclick="closeMenu()" class="w3-bar-item w3-large close-btn" alt="Close Menu">&times;</button>
                <div style="clear: both;"></div>
                <div class="collapse-user-name">
                    @if(Auth::user()->profile_image)
                        <img src="{{route('display.image',[Config::get('constants.IMAGES.USER_IMAGE_PATH'),Auth::user()->profile_image])}}" class="collapse-boy">
                    @endif
                    <label style="display: block;">{{\Auth::user()->first_name}} {{\Auth::user()->last_name}}</label>
                    <span>{{Auth::user()->mobile_number}}</span>
                </div>
                <ul class="collapse-menu">
                    <li>
                        <a href="{{route('customer.orders')}}" alt="Orders"><span class="collapse-icon-order"></span>Orders</a>
                    </li>
                    <li>
                        <a href="{{route('customer.restaurant.hours')}}" alt="Hours"><span class="collapse-icon-hour"></span>Hours</a>
                    </li>
                    <li>
                        <a href="{{route('customer.contacts')}}" alt="Contact Us"><span class="collapse-icon-contact"></span>Contact Us</a>
                    </li>
                    <li>
                        <a href="{{route('customer.feedback.index')}}" alt="Send Feedback"><span class="menu-icon-chat"></span>Send Feedback</a>
                    </li>
                    <li>
                        <a href="#" alt="Rate Us"><span class="collapse-icon-rate"></span>Rate Us</a>
                    </li>
                    <li>
                        <a href="#" onclick="openSettingMenu()" alt="Setting"><span class="collapse-icon-setting"></span>Setting</a>
                    </li>
                    <li>
                        <a href="{{route('customer.profile',Auth::user()->uid)}}" alt="User Profile"><span class="collapse-icon-user"></span>User Profile</a>
                    </li>
                    <li>
                        <form method="POST" action="{{ route('customer.logout') }}">
                        @csrf
                        <a  href="{{ route('customer.logout') }}"
                                   onclick="event.preventDefault();
                                    this.closest('form').submit();" class="logouttooltip" alt="Logout">
                            <div class="tooltiptext">
                                <h4>Logout</h4>
                                <span>
                                    Enter your email or password and login in Dinertech
                                </span>
                            </div>
                            <span class="collapse-icon-logout "></span>Logout
                        </a>
                        </form>
                    </li>
                </ul>
                <div class="version">
                    <span>0.0.12.V</span>
                </div>
            </div>
            @endif
            @auth
                <!--menu-setting-->
                <div class="w3-sidebar w3-bar-block w3-border-right" style="display:none" id="settingmenu">
                    <img src="{{asset('assets/customer/images/logo.jpg')}}">
                    <button onclick="closeSettingMenu()" class="w3-bar-item w3-large close-btn" alt="Close Setting Menu">&times;</button>
                    <div style="clear: both;"></div>
                    <div class="collapse-user-name">
                        @if(Auth::user()->profile_image)
                            <img src="{{route('display.image',[Config::get('constants.IMAGES.USER_IMAGE_PATH'),Auth::user()->profile_image])}}" class="collapse-boy" width="30">
                        @endif
                        <label style="display: block;">{{Auth::user()->first_name}} {{Auth::user()->last_name}}</label>
                        <span>+91-{{Auth::user()->mobile_number}}</span>
                    </div>
                    <button type="button" class="btn btn-default btn-back" onclick="closeSettingMenu()" alt="Back to Menu">
                        <img src="{{asset('assets/customer/images/back.png')}}">back to menu
                    </button>
                    <ul class="collapse-menu-setting">
                        <li>
                            <label class="setting-icon-notification"></label>
                            <div class="notification-text">
                                <label>App Notification</label><br>
                                <span>Get Application Notifications.</span>
                            </div>
                            <label class="switch">
                                <input type="checkbox" id="app_notification" @if(Auth::user()->app_notifications == 1) checked @endif>
                                <span class="slider round"></span>
                            </label>
                        </li>
                        <li class="setting-padding">
                            <label class="setting-icon-chat"></label>
                            <div class="notification-text">
                                <label>Chat Notification</label><br>
                                <span>Get Application Notifications.</span>
                            </div>
                            <label class="switch">
                                <input type="checkbox" id="chat_notification" @if(Auth::user()->chat_notifications == 1) checked @endif>
                                <span class="slider round"></span>
                            </label>
                        </li>
                        <li class="setting-padding">
                            <label class="setting-icon-location"></label>
                            <div class="notification-text">
                                <label>Location Tracking</label><br>
                                <span>Get Application Notifications.</span>
                            </div>
                            <label class="switch">
                                <input type="checkbox" id="location_tracking" @if(Auth::user()->location_tracking == 1) checked @endif>
                                <span class="slider round"></span>
                            </label>
                        </li>
                    </ul>
                    <div class="version">
                        <span>0.0.12.V</span>
                    </div>
                </div>
            @endauth
            <!--verification-->
            <div class="w3-sidebar w3-bar-block w3-border-right" style="display:none" id="verification">
                <img src="{{asset('assets/customer/images/logo.jpg')}}">
                <button onclick="closeVerification()" class="w3-bar-item w3-large close-btn" alt="Close Verification">&times;</button>
                <div style="clear: both;"></div>
                <h1>
                    Verification
                </h1>
                <span>Enter Verification code from recieved In you email xxx@xxx.com</span>
                <form class="login-form" action="{{route('customer.verifyOtp')}}" method="post" id="verifyOtp">
                    @csrf
                    <div class="form-group form-group-verify-input">
                        <input type="password" class="form-control verify-input" name="number_one" aria-describedby="emailHelp" placeholder="">
                    </div>
                    <div class="form-group form-group-verify-input">
                        <input type="password" class="form-control verify-input" name="number_two" aria-describedby="emailHelp" placeholder="">
                    </div>
                    <div class="form-group form-group-verify-input">
                        <input type="password" class="form-control verify-input" name="number_three" aria-describedby="emailHelp" placeholder="">
                    </div>
                    <div class="form-group form-group-verify-input">
                        <input type="password" class="form-control verify-input" name="number_fourth" aria-describedby="emailHelp" placeholder="">
                    </div>
                    {{--<button class="btn btn-primary" data-toggle="modal" data-target="#verification-success" alt="Send">Send
                        Verification</button> --}}
                    <span class="error otp-error hide">Please Enter OTP.</span>
                    <button class="btn btn-primary" id="submitOtp" alt="Send">Send
                        Verification</button>
                </form>
            </div>
            <div class="modal fade" id="verification-success" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" alt="Modal Close"><span
                                    aria-hidden="true">&times;</span></button>
                            <img src="{{asset('assets/customer/images/logo.jpg')}}">
                        </div>
                        <div class="modal-body">
                            <h3> Success </h3>
                            <p>
                                Your verification process has been Successfull. Please change or set you new password.
                            </p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary btn-block" alt="Okay" onclick="openForgotPasswordForm()">Okay</button>
                        </div>
                    </div>
                </div>
            </div>
            <!--Forgot Password Form-->
            <div class="w3-sidebar w3-bar-block w3-border-right" style="display:none" id="forgotPasswordForm">
                <img src="{{asset('assets/customer/images/logo.jpg')}}">
                <button onclick="closeForgotPassword()" class="w3-bar-item w3-large close-btn" alt="Close Forgot Password">&times;</button>
                <div style="clear: both;"></div>
                <h1>
                    Forgot Password ?
                </h1>
                <form class="login-form" action="{{route('customer.resetPassword')}}" method="post" id="reset-password">
                    @csrf
                    <input type="hidden" name="uid" id="uid">
                    <div class="form-group">
                        <input type="password" class="form-control" name="password"  placeholder="Enter New Password" id="password">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="password_confirmation" placeholder="Enter Confirmation Password">
                    </div>
                    <!-- <button type="submit" class="btn btn-primary" data-toggle="modal" data-target="#verification-btn" alt="Send Verification">Send Verification</button> -->
                    <button type="submit" class="btn btn-primary" alt="Change Password">Change Password</button>
                </form>
            </div>
            <!--Forgot Password-->
            <div class="w3-sidebar w3-bar-block w3-border-right" style="display:none" id="forgotPassword">
                <img src="{{asset('assets/customer/images/logo.jpg')}}">
                <button onclick="closeForgotPassword()" class="w3-bar-item w3-large close-btn" alt="Close Forgot Password">&times;</button>
                <div style="clear: both;"></div>
                <h1>
                    Forgot Password ?
                </h1>
                <form class="login-form" action="{{route('customer.forgotPassword')}}" method="post" id="forget-password">
                    @csrf
                    <div class="form-group">
                        <input type="text" class="form-control" name="email_mobile_number"  aria-describedby="emailHelp" placeholder="Enter email or Mobile number">
                    </div>
                    <!-- <button type="submit" class="btn btn-primary" data-toggle="modal" data-target="#verification-btn" alt="Send Verification">Send Verification</button> -->
                    <button type="submit" class="btn btn-primary" alt="Send Verification">Send Verification</button>
                </form>
            </div>
            <div class="modal fade" id="verification-btn" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                            <img src="{{asset('assets/customer/images/logo.jpg')}}">
                        </div>
                        <div class="modal-body">
                            <h3> Success </h3>
                            <p>
                                We've sent verification code in you registered email address, please check your email address.(and possibly spam folder).
                            </p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary btn-block" onclick="openVerification()" alt="Okay">Okay</button>
                        </div>
                    </div>
                </div>
            </div>
            <!--Signup collapsed-->
            <div class="w3-sidebar w3-bar-block w3-border-right" style="display:none" id="SignupSidebar">
                <img src="{{asset('assets/customer/images/logo.jpg')}}">
                <button onclick="closeSignup()" class="w3-bar-item w3-large close-btn">&times;</button>
                <div style="clear: both;"></div>
                <h1>
                    Signup
                </h1>
                <p id="register-error" class="error"></p>
                <form class="login-form" id="customer-signup" method="post" action="{{route('customer.signup')}}">
                    @csrf
                    <div class="form-group">
                        <label>Your Information </label>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="first_name" aria-describedby="emailHelp" placeholder="First Name" id="firstname">
                        @error('first_name')
                            {{$message}}
                        @enderror
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="last_name" placeholder="Last Name" id="lastname">
                        @error('last_name')
                            {{$message}}
                        @enderror
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="physical_address" placeholder="Physical Address" id="physicaladdress">
                        @error('physical_address')
                            {{$message}}
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="city" placeholder="City" id="city">
                                @error('city')
                                    {{$message}}
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="state" placeholder="state" id="state">
                                @error('state')
                                    {{$message}}
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="zipcode" placeholder="Zip code" id="zipcode">
                        @error('zipcode')
                            {{$message}}
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Contact Information </label>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="mobile_number" aria-describedby="emailHelp" placeholder="Mobile Number" id="mobilenumber">
                        @error('mobile_number')
                            {{$message}}
                        @enderror
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control" name="email_id"  aria-describedby="emailHelp" placeholder="Email Address" id="email">
                        @error('email')
                            {{$message}}
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Password </label>
                        <small class="password-validation-text">
                            Password must contain 8 charactor or more, one uppercase letter and one number
                        </small>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="password" id="exampleInputPassword1" placeholder="Password" id="password">
                        @error('password')
                            {{$message}}
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary" alt="Sign Up" id="signup-submit">Signup</button>
                    <div class="form-group signup-link">
                        <label>You have allready account ? <a href="#" class="signin-link"
                                onclick="closeSignup()" alt="Login">Login</a></label>
                    </div>
                    <button type="button" class="btn btn-default google-signin-link" alt="G Signin with Google"> G Signin with Google</button>
                </form>
            </div>
            <!--Signup collapsed-->
            <!--w3 collapse menu over-->

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right dropdown">
                    @guest
                        <li onclick="openLogin()">
                            <a href="#" alt="Chat"><span class="menu-icon-chat"></span>Chat</a>
                        </li>
                    @endguest
                    @auth
                        <li>
                            <a href="{{route('customer.chat.index')}}" alt="Chat"><span class="menu-icon-chat"></span>Chat</a>
                        </li>
                    @endauth
                    <li>
                        <a href="{{route('customer.promotions')}}" alt="Promotions"><span class="menu-icon-promo"></span>Promotions</a>
                    </li>
                    @guest
                        <li onclick="openLogin()">
                            <a href="#" alt="Cart"><span class="menu-icon-cart"></span>Cart <span class='badge badge-warning' id='lblCartCount'>@if(!empty(session()->get('cart'))) {{count(session()->get('cart'))}} @endif</span></a>
                        </li>
                        <li class="menu_line">
                            |
                        </li>
                        <li onclick="openLogin()">
                            <a href="#" alt="Login/Signin"><span class="menu-icon-login"></span>Login / Signin</a>
                        </li>
                    @endguest
                    @auth
                        <li>
                            <a href="{{route('customer.cart')}}" alt="Cart"><span class="menu-icon-cart"></span>Cart <span class='badge badge-warning' id='lblCartCount'>@if(!empty(session()->get('cart'))) {{count(session()->get('cart'))}} @endif</span></a>
                        </li>
                        <li class="menu_line">
                            |
                        </li>
                        <li class="dropdown">
                            <a href="#" aria-haspopup="true" class="dropdown-toggle" data-toggle="dropdown" role="button"aria-expanded="true">
                                @if(Auth::user()->profile_image)
                                    <img src="{{route('display.image',[Config::get('constants.IMAGES.USER_IMAGE_PATH'),Auth::user()->profile_image])}}" class="rounded-circle" width="30">
                                @endif
                                {{Auth::user()->first_name}} {{Auth::user()->last_name}}
                            </a>
                            <ul class="dropdown-menu">
                               <li><a href="{{route('customer.address.index')}}"><img src="{{asset('assets/customer/images/map_icon.png')}}"> Manage Address</a></li>
                               <li><a href="{{route('customer.changepassword')}}"><img src="{{asset('assets/customer/images/padlock.png')}}"> Change Password</a></li>
                               <li><a href="{{route('customer.cards')}}"><img src="{{asset('assets/customer/images/credit-card.png')}}"> Payment Method</a></li>
                               <li><a href="{{route('customer.orders')}}"><img src="{{asset('assets/customer/images/order-icon.png')}}"> Orders</a></li>
                           </ul>
                        </li>
                        <li onclick="openMenu()">
                            <a href="#"><span class="menu-icon-menu"><span class="menu-icon-data">More</span></a>
                        </li>
                    @endauth
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>
    </header>
</div>