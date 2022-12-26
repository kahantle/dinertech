@extends('customer-layouts.app')

@section('content')
    <link rel="stylesheet" type="text/css" href="{{asset('assets/customer/css/promotion_page.css')}}">

    <section class="dash-body-ar wd-dr-dash-inner">
        <div class="wrp-ar-nav-body">
            @include('customer-layouts.navbar')
            <div id="chatdesk" class="chart-board">
                <div class="row flex-row flex-nowrap">
                    <div class="col-xl-8 col-lg-12 col-md-12 dashbord-home dashbord-home-cart active">
                        <div class="content">
                            <div class="container-fluid list-address">
                                <div class="row map-row order-content">
                                    <div class="col-md-6 pl-0 my-auto">
                                        <div class="ifreame-blog">
                                            <iframe
                                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3691.6172143702306!2d70.79012931432048!3d22.292485448813327!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3959cb725b62dcd5%3A0x12a67431f975754!2sDotpitch%20Technologies!5e0!3m2!1sen!2sin!4v1615270241545!5m2!1sen!2sin"
                                                width="100%" height="250" style="border:0;" allowfullscreen=""
                                                loading="lazy"></iframe>
                                        </div>
                                    </div>
                                    <div class="col-md-6 pr-0 map-contact my-auto">
                                        <div class="media">
                                            <div class="media-left">
                                                <a href="#" alt="Map">
                                                    <img src={{ asset("assets/images/chat/map-black.png") }}
                                                        class="img-fluid mb-3">
                                                </a>
                                            </div>
                                            <div class="media-body">
                                                <p>
                                                    Lorem Ipsum is simply dummy text of the printing and
                                                    typesetting industry. Lorem Ipsum has been the
                                                    industry's standard dummy text ever since the 1500s,
                                                    when an unknown printer took a galley of type and
                                                    scrambled it to make a type specimen book.
                                                </p>
                                            </div>
                                        </div>
                                        <div class="media">
                                            <div class="media-left">
                                                <a href="#" alt="Mail">
                                                    <img src={{ asset('assets/images/chat/mail.png') }} alt="...">
                                                </a>
                                            </div>
                                            <div class="media-body">
                                                <p>
                                                    test.restaurat@xxx.com
                                                </p>
                                            </div>
                                        </div>
                                        <div class="media">
                                            <div class="media-left">
                                                <a href="#" alt="Phone">
                                                    <img src={{ asset("assets/images/chat/phone.png") }} alt="...">
                                                </a>
                                            </div>
                                            <div class="media-body">
                                                <p>
                                                    +91 - 9595959595/ +91 - 9898989898
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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

@section('scripts')
    <script src="{{ asset('assets/customer/js/jquery.validate.min.js') }}"></script>
@endsection
