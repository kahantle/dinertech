@extends('customer-layouts.app')

@section('content')
    <link rel="stylesheet" type="text/css" href="{{asset('assets/customer/css/promotion_page.css')}}">

    <section class="dash-body-ar wd-dr-dash-inner">
        <div class="wrp-ar-nav-body">
            @include('customer-layouts.navbar')
            <div id="chatdesk" class="chart-board">
                <div class="row flex-row flex-nowrap">
                    <div class="col-xl-8 col-lg-12 col-md-12 dashbord-home dashbord-home-cart active">
                        <div class="content ">
                            <div class="wd-hours-method wd-dr-member-program">
                                <div class="text-center wd-dr-member-dinner mt-3">
                                    <i data-feather="gift" class="mb-2"></i>
                                    <p class="mb-1">Dinertech Platinum Member</p>
                                    <h1>{{ $user->total_points }}</h1>
                                    <h5>Avilable Points</h5>
                                </div>
                                @foreach ($loyalties as $loyaltyRule)
                                    <h6 class="mt-5 mb-3">{{ $loyaltyRule->point }} Points</h6>
                                    <div class="row">

                                        @foreach ($loyaltyRule->rulesItems as $item)
                                            <div class="col-md-4">
                                                <a class="card">
                                                    <img class="card-img-top" src="{{ asset('assets/images/sandwich.jpg') }}"
                                                        alt="Card image cap">
                                                    <div
                                                        class="card-footer d-flex justify-content-between align-items-center">
                                                        <div class="card-inner-t-inner-blog">
                                                            <h5 class="card-title mb-1">Sandvich</h5>
                                                            <p class="card-text">10 Points</p>
                                                        </div>
                                                        <div class="modal-points-left">
                                                            <button type="button"
                                                                class="modal-add-button toggle addProduct">Add</button>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        @endforeach
                                        {{-- <div class="col-md-4">
                                            <a class="card">
                                                <img class="card-img-top" src="{{asset('assets/images/sandwich.jpg')}}"
                                                    alt="Card image cap">
                                                <div
                                                    class="card-footer d-flex justify-content-between align-items-center">
                                                    <div class="card-inner-t-inner-blog">
                                                        <h5 class="card-title mb-1">Sandvich</h5>
                                                        <p class="card-text">10 Points</p>
                                                    </div>
                                                    <div class="modal-points-left">
                                                        <button type="button" class="modal-add-button">Add</button>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="col-md-4">
                                            <a class="card">
                                                <img class="card-img-top" src="{{asset('assets/images/sandwich.jpg')}}"
                                                    alt="Card image cap">
                                                <div
                                                    class="card-footer d-flex justify-content-between align-items-center">
                                                    <div class="card-inner-t-inner-blog">
                                                        <h5 class="card-title mb-1">Sandvich</h5>
                                                        <p class="card-text">10 Points</p>
                                                    </div>
                                                    <div class="modal-points-left">
                                                        <button type="button" class="modal-add-button">Add</button>
                                                    </div>
                                                </div>
                                            </a>
                                        </div> --}}

                                    </div>
                                @endforeach
                                {{-- <h6 class="mt-5 mb-3">15 Points</h6>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="card card-points-blog-inner">

                                            <div class="card-body p-0">
                                                <img class="card-img-top" src="{{asset('assets/images/sandwich.jpg')}}"
                                                    alt="Card image cap">
                                                <p>Not Eligible</p>
                                            </div>
                                            <div
                                                class="card-footer d-flex justify-content-between align-items-center">
                                                <div class="card-inner-t-inner-blog">
                                                    <h5 class="card-title mb-1">Sandvich</h5>
                                                    <p class="card-text">10 Points</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card card-points-blog-inner">
                                            <div class="card-body p-0">
                                                <img class="card-img-top" src="{{asset('assets/images/sandwich.jpg')}}"
                                                    alt="Card image cap">
                                                <p>Not Eligible</p>
                                            </div>
                                            <div class="card-footer">
                                                <h5 class="card-title mb-1">Sandvich</h5>
                                                <p class="card-text">15 Points</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card card-points-blog-inner">
                                            <div class="card-body p-0">
                                                <img class="card-img-top" src="{{asset('assets/images/sandwich.jpg')}}"
                                                    alt="Card image cap">
                                                <p>Not Eligible</p>
                                            </div>
                                            <div class="card-footer">
                                                <h5 class="card-title mb-1">Sandvich</h5>
                                                <p class="card-text">15 Points</p>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                    <div class="overlay"></div>
                    @include('customer-layouts.right-sidebar')
                </div>
            </div>
        </div>
    </section>
    @endsection
