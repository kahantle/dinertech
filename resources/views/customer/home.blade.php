@extends('customer-layouts.app')

@section('css')
    <!-- Rating bar css -->
    <link rel="stylesheet" href="{{ asset('assets/customer/css/rateYo/2.3.2/jquery.rateyo.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/customer/css/promotion_page.css') }}">
    <style>
        
        #testinomial{
            padding-left: 10px;
            padding-right: 10px;
        }
        #testinomial .cat1 .owl-carousel .owl-stage-outer .owl-stage .owl-item {
            width: 166px !important;
            height: 42px !important;
            border-radius: 100px !important;
        }
        #testinomial .cat1 .card-main-blog, 
           #testinomial .cat1 .card-v-inner-sys-five {
                height: 42px; /* Set height */
                font-family: 'Poppins', sans-serif;
                text-align: center;
                font-size: 12px;
                border-radius: 15px;
                padding: 5px 10px;
                display: flex;
                align-items: center;
                justify-content: center;
                min-height: 42px; /* Ensures it doesn't shrink */
                border-radius: 100px !important;
            }
        #testinomial .cat .owl-carousel .owl-stage-outer .owl-stage .owl-item {
            width: 138px !important;
            border-radius: 100px !important;
        }
        .item.category {
            cursor: pointer;
            /* border: 1px solid transparent; */
            transition: all 0.3s ease;
            width: 138px !important;
            border-radius: 100px !important;
        }

        .item h5 {
            margin: 0;
            font-weight: bold;
        } 
        .item h6{
            color: #0d6efd !important; /* Bootstrap primary blue */
        }

        /* Selected Category */
        .item.active h6{
            color: #ffffff !important;
            background: #007bff !important;
            border-radius: 100px !important;
        }

        span {
            cursor: pointer;
            font-weight: bold;
        }

        .text-secondary {
            color: #6c757d !important; /* Light grey text */
        }

        .bg-primary {
            font-weight: bold;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.2);
        }
        @media (max-width: 768px) { 
            .owl-next, .owl-prev {
                pointer-events: none; /* Disables clicking */
                opacity: 0; /* Hides the button */
                visibility: hidden; /* Ensures it's fully removed */
            }
            .card-main-blog {
                text-align: center; /* Center content */
                font-size: 14px; /* Adjust text size */
                border-radius: 50px; /* Rounded corners */
                padding: 15px; /* Padding for spacing */
                display: flex;
                flex-direction: column; /* Stack items vertically */
                align-items: center;
                justify-content: space-between;
                min-height: 120px; /* Increase height for button space */
            }

            .card-text {
                font-size: 6px;
                font-weight: 300;
                display: block;
                font-family: 'Poppins', sans-serif;
                /* margin-bottom: 10px;  */
                margin: 0;
                padding: 0;
            }

            /* Button styling */
            .rowinner {
                display: flex;
                justify-content: center;
                gap: 10px; /* Space between buttons */
                margin-top: 10px;
                width: 100%;
            }

            .cancel-btn {
                background: #6F70C2; /* Button color */
                color: #fff;
                border: none;
                border-radius: 40px; /* Rounded buttons */
                padding: 10px 15px;
                font-size: 12px;
                cursor: pointer;
                transition: 0.3s;
            }

            .cancel-btn:hover {
                background: #5a5eb5; /* Slightly darker on hover */
            }
            .wp-inner-st{
                height: 42px !important;
            }
            .card-main-blog, 
            .card-v-inner-sys-five {
                height: 42px; /* Set height */
                font-family: 'Poppins', sans-serif;
                text-align: center;
                font-size: 12px;
                border-radius: 15px;
                padding: 5px 10px;
                display: flex;
                align-items: center;
                justify-content: center;
                min-height: 42px; /* Ensures it doesn't shrink */
                border-radius: 100px !important;
            }

            /* .owl-carousel .item {
                display: block;
                width: 100%; 
                margin: 10px 0; 
            }

            .card-main-blog {
                border-radius: 10px !important; 
                padding: 15px; 
                text-align: left;
            }

            .rowinner.row-ib-blog {
                display: flex;
                justify-content: space-between;
                align-items: center;
                flex-wrap: wrap;
            }

            .rowinner .cancel-btn {
                flex: 1; 
                width: auto;
                padding: 8px 10px;
            } */
        }

    </style>
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
                                    @if (isMobile())
                                         <!-- Mobile -->
                                         <div class="cat1">
                                            <div class="owl-carousel owl-carousellx owl-first-blog  owl-theme">
                                                @foreach ($promotionLists as $promotion)
                                                    <div class="item"> 
                                                        <div
                                                            class="card-main-blog @if ( 
                                                                $promotion->promotion_type_id == 1 ||
                                                                    $promotion->promotion_type_id == 3 ||
                                                                    $promotion->promotion_type_id == 4 ||
                                                                    $promotion->promotion_type_id == 5) card-v-inner-sys-five @elseif($promotion->promotion_type_id == 2) card-v-inner-sys-first @elseif($promotion->promotion_type_id == 6) card-v-inner-sys-seven @elseif($promotion->promotion_type_id == 7) card-v-inner-sys-six @elseif ($promotion->promotion_type_id == 8) card-v-inner-sys-four @elseif ($promotion->promotion_type_id == 9) card-v-inner-sys-third @elseif ($promotion->promotion_type_id == 10) card-v-inner-sys-second @endif">
                                                            <div class="wp-inner-st">
                                                                <span class="card-text">{{ $promotion->promotion_name }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div> 
                                        </div> 
                                    @else
                                        <!-- Descktop -->
                                        <div class="owl-carousel owl-carousell owl-first-blog  owl-theme">
                                            @foreach ($promotionLists as $promotion)
                                                <div class="item"> 
                                                    <div
                                                        class="card-main-blog @if ( 
                                                            $promotion->promotion_type_id == 1 ||
                                                                $promotion->promotion_type_id == 3 ||
                                                                $promotion->promotion_type_id == 4 ||
                                                                $promotion->promotion_type_id == 5) card-v-inner-sys-five @elseif($promotion->promotion_type_id == 2) card-v-inner-sys-first @elseif($promotion->promotion_type_id == 6) card-v-inner-sys-seven @elseif($promotion->promotion_type_id == 7) card-v-inner-sys-six @elseif ($promotion->promotion_type_id == 8) card-v-inner-sys-four @elseif ($promotion->promotion_type_id == 9) card-v-inner-sys-third @elseif ($promotion->promotion_type_id == 10) card-v-inner-sys-second @endif">
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
                                    @endif
                                </div>
                                @if ($categories->count() != 0)
                                    <h2>What are you hungry for? </h2>
                                    <div id="testinomial" class="banner-container">
                                        <div class="cat">
                                            <div class="owl-carousel owl-carousell owl-first-blog  owl-theme">
                                                @foreach ($categories as $key => $category)
                                                    {{-- <div class="item category" data-category-id="{{ $category->category_id }}"> --}}
                                                        {{-- <div class="card"> --}}
                                                            {{-- <img class="card-img-top lazy"
                                                                data-src="{{ $category->getImagePathAttribute() ? $category->getImagePathAttribute() : $category->getDefaultImage() }}"
                                                                alt="Card image cap"> --}}
                                                            {{-- <div class="card-body category"> --}}
                                                                {{-- <h5 class=" card-title">{{ $category->category_name }}</h5> --}}
                                                                {{-- <p class="card-text">{{ $category->category_details ? $category->category_details : '--' }}</p> --}}
                                                            {{-- </div>
                                                        </div> --}}
                                                    {{-- </div> --}}
                                                    <div class="item category px-2 mt-4 my-2 {{ $key == 0 ? 'active' : '' }}" data-category-id="{{ $category->category_id }}" onclick="selectCategory(this)">
                                                        <h6 class="text-center py-2">
                                                            {{ $category->category_name }}
                                                        </h6>
                                                    </div>                                                
                                                @endforeach
                                                {{-- <div class="d-flex justify-content-center align-items-center gap-3 my-3">
                                                    <span class="text-secondary">Pav Bhaji</span>
                                                    <span class="bg-primary text-white px-4 py-2 rounded">Sandwiches</span>
                                                    <span class="text-secondary">Burgers</span>
                                                </div> --}}
                                                
                                            </div>
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
    <script>
        function selectCategory(element) {
            // Remove 'active' class from all categories
            document.querySelectorAll('.item').forEach(item => {
                item.classList.remove('active');
            });

            // Add 'active' class to the clicked element
            element.classList.add('active');
        }

    </script>
@endsection
