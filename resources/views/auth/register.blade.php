@extends('layouts.app')
@section('content')
    <section class="lrForm">
        <div class="w-100">
            <div class="row align-items-center align-items-xl-start no-gutters">
                <div class="col-lg-6 col-xl-5 col-md-6">
                    <div class="left-pattern">
                        <div class="logo">
                            <a href="#"><img src="{{ asset('assets/images/logo.png') }}" class="img-fluid"></a>
                        </div>
                        <div class="btm-img">
                            <img src="{{ asset('assets/images/mn-img.png') }}" class="img-fluid">
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-xl-7 col-md-6">
                    @include('common.flashMessage')
                    <div class="form-info">
                        <h2>Sign Up</h2>
                        {{ Form::open(['route' => ['register'], 'id' => 'signupForm', 'method' => 'POST', 'class' => '']) }}
                        <div class="form-group">
                            <i class="fa fa-user"></i>
                            <input type="text" class="form-control" id="first_name" name="first_name"
                                value="{{ old('first_name') }}" placeholder="Owner First Name">
                        </div>
                        <div class="form-group">
                            <i class="fa fa-user"></i>
                            <input type="text" class="form-control" id="last_name" name="last_name"
                                value="{{ old('last_name') }}" placeholder="Owner Last Name">
                        </div>
                        <div class="form-group">
                            <i class="fa fa-cutlery"></i>
                            <input type="text" class="form-control" id="restaurant_name" name="restaurant_name"
                                value="{{ old('restaurant_name') }}" placeholder="Restaurant Name">
                        </div>
                        <div class="form-group">
                            <i class="fa fa-map-marker"></i>
                            <input type="text" class="form-control" id="address" name="address"
                                value="{{ old('address') }}" placeholder="Address">
                        </div>
                        <div class="form-group">
                            <i class="fa fa-flag" aria-hidden="true"></i>
                            <select class="form-select" aria-label="Default select example" name="country">
                                <option value="" selected>Select Country</option>
                                @foreach ($countries as $key => $country)
                                    <option value="{{ $country }}">{{ $country }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <i class="fa fa-phone"></i>
                            <input type="text" class="form-control" id="mobile_number" name="mobile_number"
                                value="{{ old('mobile_number') }}" placeholder="Mobile Number">
                        </div>

                        <div class="form-group">
                            <i class="fa fa-envelope"></i>
                            <input type="email" class="form-control" id="email_id" name="email_id"
                                   value="{{ old('email_id') }}" placeholder="Email">
                            <span id="emailMessage" class="text" style="display:none;">Please enter a valid or real email address.</span>
                        </div>


                        <div class="form-group">
                            <i class="fa fa-lock"></i>
                            <input type="password" class="form-control" id="password" name="password"
                                placeholder="Password">
                            <a href="#" class="toggle-password" toggle="#password"><i class="fa fa-eye psw"></i></a>
                        </div>
                        <div class="form-group">
                            <i class="fa fa-lock"></i>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password"
                                placeholder="Confirm Password">
                            <a href="#" class="toggle-password" toggle="#confirm_password"><i
                                    class="fa fa-eye psw"></i></a>
                        </div>
                        <input type="hidden" name="timezone" id="setTimeZone">
                        <div class="form-group">
                            <div class="btn-custom">
                                <button class="btn-blue"><span>Sign Up</span></button>
                            </div>
                        </div>
                        <div class="form-group">
                            <p>Don’t have an account? <a href="{{ route('login') }}">Sign In</a></p>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\SignupRequest', '#signupForm') !!}
    <script src="https://js.stripe.com/v3/"></script>
    <script src="{{ asset('assets/js/moment/moment.js') }}"></script>
    <script src="{{ asset('assets/js/moment/moment-timezone.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            var timezoneFormat = Intl.DateTimeFormat().resolvedOptions().timeZone;
            var timeZone = moment().tz(timezoneFormat).format('Z');
            $("#setTimeZone").val("GMT" + timeZone);
            // $('#setTimeZone').val(new Date().toTimeString().match(/([A-Z]+[\+-][0-9]+)/)[1]);
        });
    </script>
    @section('scripts')
        <script>
            $(document).ready(function() {
                $('#email_id').on('focus', function() {
                    $('#emailMessage').show();
                });

                $('#email_id').on('blur', function() {
                    $('#emailMessage').hide();
                });
            });
        </script>
    @endsection

@endsection
