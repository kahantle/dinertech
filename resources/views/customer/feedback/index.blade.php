@extends('customer-layouts.app')


@section('css')
    <!-- Rating bar css -->
    <link rel="stylesheet" href="{{ asset('assets/customer/css/rateYo/2.3.2/jquery.rateyo.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/customer/css/promotion_page.css')}}">
@endsection

@section('content')
    <section class="dash-body-ar wd-dr-dash-inner">
        <div class="wrp-ar-nav-body">
            @include('customer-layouts.navbar')
            <div id="chatdesk" class="chart-board ">
                @include('customer.messages')
                <div class="row flex-column flex-md-row flex-nowrap">
                    <div class="col-xl-8 col-lg-12 col-md-12 dashbord-home dashbord-home-cart active">
                        <div class="content">
                            <div class="order-content order-content-second">
                                <div class="order-prof-img-par ">
                                    <a href="{{route('customer.profile')}}"
                                        class="btn bg-transparent text-dark mx-2 feedback-btn-back">
                                        <i data-feather="arrow-left"></i>
                                    </a>
                                    <h3 class="mb-5 h4 h-md-2 feedback-h3">
                                        Send us your Feedback !
                                    </h3>
                                    <p class="feedback-p">
                                        Do you have a order error or quality feedback,delivery feedback, general
                                        feedback?<br> Let us know in the fiels below
                                    </p>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mr-0 pr-0 feedback-img">
                                        <img class="col-md-d-none" src="{{asset('assets/images/email-lady.jpg')}}" alt="">
                                    </div>
                                    <div class="col-md-6 ml-0 pl-0 d-flex align-items-center">
                                        <form class="order-feedback-blog" action="{{ route('customer.feedback.store') }}" method="post" id="feedbackForm">
                                            @csrf
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1">
                                                        <img width="25px" src="{{asset('assets/images/user.png')}}" alt="">
                                                    </span>
                                                </div>
                                                <input type="text" class="form-control Profile-input " id="inputname" placeholder="Name" name="name">
                                                @error('name')
                                                    <span class="error">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1">
                                                        <img width="25px" src="{{asset('assets/images/call.png')}}" alt="">
                                                    </span>
                                                </div>
                                                <input type="text " class="form-control Profile-input " id="inputmob" placeholder="Phone" name="phone_number">
                                                @error('phone_number')
                                                    <span class="error">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1">
                                                        <img width="25px"
                                                            src="{{asset('assets/images/Screenshot 2022-11-18 163950.png')}}"
                                                            alt="">
                                                    </span>
                                                </div>
                                                <input type="text " class="form-control Profile-input " id="inputemail" placeholder="Email" name="email">
                                                @error('email')
                                                    <span class="error">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1">
                                                        <img width="25px" src="{{asset('/assets/images/feedback.png')}}"
                                                            alt="">
                                                    </span>
                                                </div>
                                                <select class="form-control" id="exampleFormControlSelect1" name="feedback_type">
                                                    <option value="">select</option>
                                                    <option value="{{ config('constants.CUSTOMER_FEEDBACK_TYPE.1') }}">
                                                        {{ config('constants.CUSTOMER_FEEDBACK_TYPE.1') }}</option>
                                                    <option value="{{ config('constants.CUSTOMER_FEEDBACK_TYPE.2') }}">
                                                        {{ config('constants.CUSTOMER_FEEDBACK_TYPE.2') }}</option>
                                                    <option value="{{ config('constants.CUSTOMER_FEEDBACK_TYPE.3') }}">
                                                        {{ config('constants.CUSTOMER_FEEDBACK_TYPE.3') }}</option>
                                                    <option value="{{ config('constants.CUSTOMER_FEEDBACK_TYPE.4') }}">
                                                        {{ config('constants.CUSTOMER_FEEDBACK_TYPE.4') }}</option>
                                                </select>
                                                @error('feedback_type')
                                                    <span class="error">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1">
                                                        <img width="25px" src="{{asset('assets/images/massege.png')}}"
                                                            alt="">
                                                    </span>
                                                </div>
                                                <input type="text " class="form-control Profile-input" id="inputmsg" placeholder="Message" name="message">
                                                @error('message')
                                                    <span class="error">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <button type="submit " class="btn btn-user-profile" alt="Send Feedback">
                                                <span class="mx-2"> Send Feedback</span>
                                                <img width="25px" src="{{asset('assets/images/send.png')}}" alt="">
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    @if (!isMobile())
                        @include('customer-layouts.right-sidebar')
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script src="{{ asset('assets/customer/js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/customer/js/additional-methods.min.js') }}"></script>
    <script src="{{ asset('assets/customer/js/custom-js/feedback/index.js') }}"></script>
@endsection
