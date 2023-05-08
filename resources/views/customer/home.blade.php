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
                <div class="row">
                    <div class="col-xl-8 col-lg-12 col-md-12">
                        <div id="searchItems" class="scrollbar"></div>
                        <div id="menuItems">
                            <div class="content">
                                <div id="testinomial" class="banner-container">
                                    <div class="owl-carousel owl-first-blog  owl-theme">
                                        @foreach ($promotionLists as $promotion)
                                            <div class="item">
                                                <div class="card-main-blog @if ($promotion->promotion_type_id == 1 || $promotion->promotion_type_id == 3 || $promotion->promotion_type_id == 4 || $promotion->promotion_type_id == 5) card-v-inner-sys-five @elseif($promotion->promotion_type_id == 2) card-v-inner-sys-first @elseif($promotion->promotion_type_id == 6) card-v-inner-sys-seven @elseif($promotion->promotion_type_id == 7) card-v-inner-sys-six @elseif ($promotion->promotion_type_id == 8) card-v-inner-sys-four @elseif ($promotion->promotion_type_id == 9) card-v-inner-sys-third @elseif ($promotion->promotion_type_id == 10) card-v-inner-sys-second @endif">
                                                    <div class="wp-inner-st">
                                                        <h5 class="card-title">{{ $promotion->promotion_name }}</h5>
                                                        <p class="card-text">{{ $promotion->promotion_details }}</p>
                                                    </div>
                                                    <div class="rowinner row-ib-blog">
                                                        <a href="javascript:void(0);" class="openPromotion"
                                                            data-promotion-id="{{ $promotion->promotion_id }}"
                                                            data-promotion-type="{{ $promotion->promotion_type_id }}"><button
                                                                class="cancel-btn">Learn More</button></a>
                                                        <span class="get-border"></span>
                                                        <a href="{{ route('customer.promotions.getEligibleItems', $promotion->promotion_id) }}"><button
                                                                class="cancel-btn">Get it Now</button></a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                @if ($categories->count() != 0)
                                    <h2>What are you hungry for? </h2>
                                    <div id="testinomial" class="banner-container">
                                        <div class="owl-carousel owl-theme owl-drag">
                                            @foreach ($categories as $key => $category)
                                                <div class="item category" data-category-id="{{ $category->category_id }}">
                                                    <div class="card">
                                                        <img class="card-img-top lazy"
                                                            data-src="{{ $category->getImagePathAttribute() ? $category->getImagePathAttribute() : $category->getDefaultImage() }}"
                                                            alt="Card image cap">
                                                        <div class="card-body category">
                                                            <h5 class="card-title">{{ $category->category_name }}</h5>
                                                            <p class="card-text">{{ $category->category_details }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                                <div class="scrollbar" id="style-4"></div>
                            </div>
                        </div>
                    </div>
                    @include('customer-layouts.right-sidebar')
                </div>
            </div>
    </section>
        @include('customer.guest')
    {{-- @guest
        @include('customer.guest')
    @endguest --}}

@endsection

@section('scripts')
    <script src="{{ asset('assets/customer/js/toastr.min.js') }}"></script>
    <script src="{{ asset('assets/customer/js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/customer/js/additional-methods.min.js') }}"></script>
    <!-- Rating bar js -->
    <script src="{{ asset('assets/customer/js/rateYo/2.3.2/jquery.rateyo.min.js') }}"></script>
    <script src="{{ asset('assets/customer/js/custom-js/home/index.js') }}"></script>
@endsection
