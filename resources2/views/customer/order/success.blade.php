@extends('customer-layouts.app')

@section('content')
    <section class="dash-body-ar wd-dr-dash-inner">
        <div class="wrp-ar-nav-body">
            @include('customer-layouts.navbar')
            <div id="chatdesk" class="chart-board ">
                <div class="row">
                    <div class="col-xl-8 col-lg-12 col-md-12">
                        <div class="content">
                            <div class="order-content order-content-second">
                                <div class="order-prof-img-par order-party-wear">
                                    <img src="{{ asset('assets/customer/images/Success.jpg') }}" class="img-fluid">
                                    <h3 class="feedback-h3">
                                        Success
                                    </h3>
                                    <p class="feedback-p mb-0">
                                        Your Payment has been succesfully done.
                                    </p>
                                    <p class="feedback-p">
                                        Enjoy your order.
                                    </p>
                                    <a href="{{ route('customer.index') }}" alt="Back to Home" class="back-to-home">Back
                                        To Home</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @include('customer-layouts.right-sidebar')
                </div>
            </div>
        </div>
    </section>
@endsection
