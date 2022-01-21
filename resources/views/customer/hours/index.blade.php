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
                            <div class="wd-hours-method">
                                <h2 class="mb-3">Hours of Operation </h2>
                                <div class="scroll-bar" id="style-4">
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <div class="row">
                                            <div class="col-xs-1 col-sm-3 col-lg-3 day-schedule">
                                                <button type="button" class="btn btn-left-blog">sunday</button>
                                                <div class="card card-inner-first card-second text-center">
                                                    <h6 class="mb-1">Breakfast</h6>
                                                    <p class="be-inner mb-1">8:00a</p>
                                                    <p class="mt-1">11:00a</p>
                                                </div>
                                                <div class="card card-inner-second card-second text-center">
                                                    <h6 class="mb-1">Brunch</h6>
                                                    <p class="be-inner mb-1">11:00a </p>
                                                    <p class="mt-1">2:00p</p>
                                                </div>
                                                <div class="card card-inner-third card-second text-center">
                                                    <h6 class="mb-1">Lunch</h6>
                                                    <p class="be-inner mb-1">11:00a </p>
                                                    <p class="mt-1">4:00p</p>
                                                </div>
                                                <div class="card card-inner-fourth card-second text-center">
                                                    <h6 class="mb-1">Dinner</h6>
                                                    <p class="be-inner mb-1">5:00p </p>
                                                    <p class="mt-1">11:00p</p>
                                                </div>
                                            </div>
                                            <div class="col-xs-1 col-sm-3 col-lg-3 day-schedule">
                                                <button type="button" class="btn btn-left-blog">monday</button>
                                                <div class="card card-inner-third card-second text-center">
                                                    <h6 class="mb-1">Lunch</h6>
                                                    <p class="be-inner mb-1">11:00a </p>
                                                    <p class="mt-1">4:00p</p>
                                                </div>
                                                <div class="card card-inner-fourth card-second text-center">
                                                    <h6 class="mb-1">Dinner</h6>
                                                    <p class="be-inner mb-1">5:00p </p>
                                                    <p class="mt-1">11:00p</p>
                                                </div>
                                            </div>
                                            <div class="col-xs-1 col-sm-3 col-lg-3 day-schedule">
                                                <button type="button" class="btn btn-left-blog">tuesday</button>
                                                <div class="card card-inner-third card-second text-center">
                                                    <h6 class="mb-1">Lunch</h6>
                                                    <p class="be-inner mb-1">11:00a </p>
                                                    <p class="mt-1">4:00p</p>
                                                </div>
                                                <div class="card card-inner-fourth card-second text-center">
                                                    <h6 class="mb-1">Dinner</h6>
                                                    <p class="be-inner mb-1">5:00p </p>
                                                    <p class="mt-1">11:00p</p>
                                                </div>
                                            </div>
                                            <div class="col-xs-1 col-sm-3 col-lg-3 day-schedule">
                                                <button type="button" class="btn btn-left-blog">wednesday </button>
                                                <div class="card card-inner-third card-second text-center">
                                                    <h6 class="mb-1">Lunch</h6>
                                                    <p class="be-inner mb-1">11:00a </p>
                                                    <p class="mt-1">4:00p</p>
                                                </div>
                                                <div class="card card-inner-fourth card-second text-center">
                                                    <h6 class="mb-1">Dinner</h6>
                                                    <p class="be-inner mb-1">5:00p </p>
                                                    <p class="mt-1">11:00p</p>
                                                </div>
                                            </div>
                                            <div class="col-xs-1 col-sm-3 col-lg-3 day-schedule">
                                                <button type="button" class="btn btn-left-blog">thursday</button>
                                                <div class="card card-inner-third card-second text-center">
                                                    <h6 class="mb-1">Lunch</h6>
                                                    <p class="be-inner mb-1">11:00a </p>
                                                    <p class="mt-1">4:00p</p>
                                                </div>
                                                <div class="card card-inner-fourth card-second text-center">
                                                    <h6 class="mb-1">Dinner</h6>
                                                    <p class="be-inner mb-1">5:00p </p>
                                                    <p class="mt-1">11:00p</p>
                                                </div>
                                            </div>
                                            <div class="col-xs-1 col-sm-3 col-lg-3 day-schedule">
                                                <button type="button" class="btn btn-left-blog">friday</button>
                                                <div class="card card-inner-third card-second text-center">
                                                    <h6 class="mb-1">Lunch</h6>
                                                    <p class="be-inner mb-1">11:00a </p>
                                                    <p class="mt-1">4:00p</p>
                                                </div>
                                                <div class="card card-inner-fourth card-second text-center">
                                                    <h6 class="mb-1">Dinner</h6>
                                                    <p class="be-inner mb-1">5:00p </p>
                                                    <p class="mt-1">11:00p</p>
                                                </div>
                                            </div>
                                            <div class="col-xs-1 col-sm-3 col-lg-3 day-schedule">
                                                <button type="button" class="btn btn-left-blog">saturday</button>
                                                <div class="card card-inner-fourth card-second text-center">
                                                    <h6 class="mb-1">Dinner</h6>
                                                    <p class="be-inner mb-1">5:00p </p>
                                                    <p class="mt-1">11:00p</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="pickup-inst mt-5">
                                    <h2 class="mb-2">Order Pickup Instructions</h2>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                                        incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices
                                        gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis. Lorem ipsum
                                        dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                                        labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus
                                        commodo viverra maecenas accumsan lacus vel facilisis. Lorem ipsum amet, consectetur
                                        adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                                        Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan
                                        lacus vel facilisis. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
                                        eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse
                                        ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis. </p>
                                </div>
                                <div class="row mt-5 contact-form">
                                    <div class="col-md-12">
                                        <h2 class="my-2">Contact Us</h2>
                                    </div>
                                    <div class="col-md-3 map-contact my-auto">
                                        <div class="d-flex flex-column text-center justify-content-center">
                                            <div class="mb-2">
                                                <button type="button" class="btn btn-dark btn-call-log">Call Us </button>
                                            </div>
                                            <span>###-###-#### </span>
                                        </div>
                                        @if ($address->restaurant_address)
                                            <div class="media">
                                                <div class="media-left">
                                                    <a href="#" alt="Map">
                                                        <img src="{{ asset('assets/customer/images/map-black.png') }}"
                                                            class="img-fluid mb-3">
                                                    </a>
                                                </div>
                                                <div class="media-body">
                                                    <p>
                                                        {{ $address->restaurant_address }}
                                                    </p>
                                                </div>
                                            </div>
                                        @endif

                                        @if ($address->restaurant_mobile_number)
                                            <div class="media">
                                                <div class="media-left">
                                                    <a href="#" alt="Mail">
                                                        <img src="{{ asset('assets/customer/images/mail.png') }}"
                                                            alt="...">
                                                    </a>
                                                </div>
                                                <div class="media-body">
                                                    <a href="mailto:{{ $address->user->email_id }}">
                                                        <p>
                                                            {{ $address->user->email_id }}
                                                        </p>
                                                    </a>
                                                </div>
                                            </div>
                                        @endif

                                        @if ($address->restaurant_mobile_number)
                                            <div class="media">
                                                <div class="media-left">
                                                    <a href="#" alt="Mail">
                                                        <img src="{{ asset('assets/customer/images/phone.png') }}"
                                                            alt="...">
                                                    </a>
                                                </div>
                                                <div class="media-body">
                                                    <a href="mailto:test.restaurat@xxx.com">
                                                        <p>
                                                            {{ $address->restaurant_mobile_number }}
                                                        </p>
                                                    </a>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-md-9 my-auto">
                                        <form action="{{ route('customer.restaurant.sendmail') }}" method="post"
                                            id="contactForm">
                                            @csrf
                                            <h3 class="message-us">Message Us</h3>
                                            <div class="row">
                                                <div class="form-group col-md-7 d-block">
                                                    <input type="text" class="form-control" placeholder="Enter Name"
                                                        name="name">
                                                    @error('name')
                                                        {{ $message }}
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-5 d-block">
                                                    <input type="text" class="form-control"
                                                        placeholder="Enter Phone Number" name="phone_number">
                                                    @error('phone_number')
                                                        {{ $message }}
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-12 d-block">
                                                    <input type="email" class="form-control" aria-describedby="emailHelp"
                                                        placeholder="Enter Email Addres" name="email"
                                                        value="{{ auth()->user()->email_id }}" readonly>
                                                    @error('email')
                                                        {{ $message }}
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group d-block">
                                                <textarea class="form-control rounded-0" rows="3"
                                                    placeholder="Enter Message" name="message"></textarea>
                                                @error('message')
                                                    {{ $message }}
                                                @enderror
                                            </div>
                                            <div class="d-flex align-items-center justify-content-center w-100">
                                                <button type="submit" class="btn btn-submit-inner-w-blog">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="embed-responsive embed-responsive-21by9 mt-5">
                                        <iframe
                                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3691.5500449191477!2d70.78865851534584!3d22.295028148719386!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3959ca19b942ac15%3A0x43959c45a1d3f88a!2sThe%20Imperial%20Palace!5e0!3m2!1sen!2sin!4v1628151306221!5m2!1sen!2sin"
                                            width="600" height="400" style="border:0;" allowfullscreen=""
                                            loading="lazy"></iframe>
                                    </div>
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

@section('scripts')
    <script src="{{ asset('assets/customer/js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/customer/js/additional-methods.min.js') }}"></script>
    <script src="{{ asset('assets/customer/js/custom-js/information/index.js') }}"></script>
@endsection
