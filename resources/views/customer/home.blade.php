@extends('customer-layouts.app')

@section('css')
    <!-- Rating bar css -->
    <link rel="stylesheet" href="{{ asset('assets/customer/css/rateYo/2.3.2/jquery.rateyo.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/customer/css/promotion_page.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700&display=swap" rel="stylesheet">
    @if (isMobile())
        <style>
            #testinomial{
                padding-left: 0px;
                padding-right: 0px;
            }
            .owl-next, .owl-prev {
                pointer-events: none; /* Disables clicking */
                opacity: 0; /* Hides the button */
                visibility: hidden; /* Ensures it's fully removed */
            }
        </style>
    @else
        <style>
            #testinomial{
                padding-left: 10px;
                padding-right: 10px;
            }
        </style>
    @endif
<style>
      
        #testinomial .cat1 .owl-carousel .owl-stage-outer .owl-stage .owl-item {
            width: 166px !important;
            height: auto !important;
            /* height: 42px !important; */
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
                
                font-size: 12px !important; /* Slightly larger for better readability */
                font-weight: 500 !important; /* Medium weight for better contrast */
                font-family: 'Poppins', sans-serif !important;
                text-align: center;
                display: flex;
                align-items: center;
                justify-content: center;
                width: 100%;
                height: 100%;
                margin: 0;
                padding: 0;
                word-wrap: break-word;
                white-space: normal;
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
                /* height: 42px;  */
                font-family: 'Poppins', sans-serif;
                text-align: center;
                font-size: 10px;
                padding: 10px 10px;
                display: flex;
                align-items: center;
                justify-content: center;
                min-height: 42px; /* Ensures it doesn't shrink */
                height: auto;
                border-radius: 100px !important;
                white-space: normal; /* Allows text to wrap inside */
                word-wrap: break-word;
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
        .border-card {
            /* height: 67px !important; */
            border: none !important; /* Removes any existing border */
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.15); /* Uniform shadow on all sides */
            padding: 10px; /* Adds spacing inside */
            background: white; /* Ensures shadow is visible */
            border-radius: 20px !important; /* Optional: Soft rounded corners */
        }
        /* Menu item images */
        .menu-img{
            width: 470 !important;
            height: 214 !important;
            /* width: 367px;
            height: 182.77px; */
            margin: 10px;      
            object-fit: cover;
            display: block;
            border-radius: 20px !important;
        }

        /* Modifier modal css */
        /* .modifier-modal{ */
        #exampleModalCenter .modal-content{
            border: 1px solid white !important;
            border-radius: 20px !important;
        }
        #exampleModalCenter .modal-content .modal-footer .with-modifier-add{
            font-weight: 600;
            font-size: 14px;
            font-family: 'Poppins', sans-serif; /* Keeps consistency */
        }
        #exampleModalCenter .modal-content .modal-body .slct-btn{
            background-color: #636363 !important;
            color: white !important;

        }

        /* #exampleModalCenter .modal-content .modal-body input[type="radio"],
        #exampleModalCenter .modal-content .modal-body input[type="checkbox"] {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            width: 18px;
            height: 18px;
            border: 2px solid #636363;
            border-radius: 4px;
            background-color: white;
            cursor: pointer;
            position: relative;
        }

        #exampleModalCenter .modal-content .modal-body input[type="radio"]:checked,
        #exampleModalCenter .modal-content .modal-body input[type="checkbox"]:checked {
            background-color: #636363 !important;
            border-color: #636363;
            color: white !important;
        }

        #exampleModalCenter .modal-content .modal-body label {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            font-family: 'Poppins', sans-serif;
            font-size: 16px;
            color: #333;
        } */

        /* ========== */
        /* Hide default checkboxes and radio buttons */
         #exampleModalCenter .modal-content .modal-body input[type="radio"],
         #exampleModalCenter .modal-content .modal-body input[type="checkbox"] {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            width: 18px;
            height: 18px;
            border: 2px solid #636363;
            border-radius: 4px;
            background-color: white;
            cursor: pointer;
            position: relative;
            display: inline-block;
        }

        #exampleModalCenter .modal-content .modal-header .modal-title {
            font-family: 'Poppins', sans-serif;
            color: #4E4E4E;
            font-weight: 600;
            font-size: 18px;
        }
        #exampleModalCenter .modal-content .modal-header .close .closing-logo{
            display: grid;
            place-items: center;
            border-radius: 50%;
            width: 27px !important;
            height: 27px !important;
            background-color: #2B34FB;
            border-radius: 100%;
        }
        #exampleModalCenter .modal-content .modal-header .close .closing-logo span{
            color: white;
            /* width: 6px;
            height: 9px; */
            /* margin: -2px; */
        }
        .modal-second-inner h6{
            color:#007AFF;
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 16px;

        }
        .modal-second-inner .modifier-modal.sub-tile{
            color: #B4B4B4;
            font-weight: 600;
            font-size: 14px;
            font-family: 'Poppins', sans-serif;
        }

        /* Style when checked */
         #exampleModalCenter .modal-content .modal-body input[type="radio"]:checked,
         #exampleModalCenter .modal-content .modal-body input[type="checkbox"]:checked {
            background-color: #636363 !important;
            border-color: #636363;
            position: relative;
        }

        /* Add white checkmark for checkbox */
         #exampleModalCenter .modal-content .modal-body input[type="checkbox"]:checked::after {
            content: '✓'; 
            font-size: 14px;
            font-weight: bold;
            color: white;
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
        }

        /* Add a white dot for radio buttons */
         #exampleModalCenter .modal-content .modal-body input[type="radio"]:checked::after {
            content: '';
            width: 10px;
            height: 10px;
            background-color: white;
            border-radius: 50%;
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
        }

        /* Style the label to align better */
         #exampleModalCenter .modal-content .modal-body label {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            font-family: 'Poppins', sans-serif;
            font-size: 16px;
            font-weight: 600;
            color: #626262;
        }
        #exampleModalCenter .modal-content .modal-body .price {
            font-family: 'Poppins', sans-serif;
            font-size: 16px;
            font-weight: 600;
            color: #626262;
        }

        .menu-item{
            margin-right: -20px !important;
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
                                <div class="scrollbar menu-item" id="style-4"></div>
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
        document.querySelectorAll('.slct-btn').forEach(input => {
            input.addEventListener('change', function() {
                if (this.checked) {
                    this.style.backgroundColor = "#636363";
                    this.style.color = "white";
                } else {
                    this.style.backgroundColor = "white";
                    this.style.color = "#333";
                }
            });
        });

    </script>
@endsection
