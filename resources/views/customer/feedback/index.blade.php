@extends('customer-layouts.app')

@section('content')
    <section class="dash-body-ar wd-dr-dash-inner">
        <div class="wrp-ar-nav-body">
            @include('customer-layouts.navbar')
            <div id="chatdesk" class="chart-board ">
                @include('customer.messages')
                <div class="row">
                    <div class="col-xl-8 col-lg-12 col-md-12">
                        <div class="content ">
                            <div class="order-content order-content-second">
                                <div class="order-prof-img-par ">
                                    <h3 class="feedback-h3">
                                        Send us you Feedback!
                                    </h3>
                                    <p class="feedback-p">
                                        Do you have a order error or quality feedback,delivery feedback, general
                                        feedback?<br> Let us know in the fiels below
                                    </p>
                                </div>
                                <form class=" order-feedback-blog" action="{{ route('customer.feedback.store') }}"
                                    method="post" id="feedbackForm">
                                    @csrf
                                    <div class="form-group">
                                        <input type="text" class="form-control Profile-input " id="inputname"
                                            placeholder="Name" name="name">
                                        @error('name')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group ">
                                        <input type="text " class="form-control Profile-input " id="inputmob"
                                            placeholder="Phone" name="phone_number">
                                        @error('phone_number')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group ">
                                        <input type="text " class="form-control Profile-input " id="inputemail"
                                            placeholder="Email" name="email">
                                        @error('email')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <select class="form-control" id="exampleFormControlSelect1" name="feedback_type">
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
                                    <div class="form-group ">
                                        <input type="text " class="form-control Profile-input " id="inputmsg"
                                            placeholder="Message" name="message">
                                        @error('message')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <button type="submit " class="btn btn-user-profile" alt="Send Feedback">
                                        <h4 class="m-0">Send Feedback</h4>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @include('customer-layouts.right-sidebar')
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
