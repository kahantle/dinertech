@extends('customer-layouts.app')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('assets/customer/css/promotion_page.css')}}">
@endsection

@section('content')
    <section class="dash-body-ar wd-dr-dash-inner">
        <div class="wrp-ar-nav-body">
            @include('customer-layouts.navbar')
            <div id="chatdesk" class="chart-board ">
                @include('customer.messages')
                <div class="row flex-row flex-nowrap">
                    <div class="col-xl-8 col-lg-12 col-md-12 dashbord-home dashbord-home-cart active">
                        <div class="content ">
                            <div class="order-content order-content-second promotion_bg-cololr order-content-main">
                                <div class="cuv-profile">
                                    <div class="prof-img-par ">
                                        <div class="d-flex align-items-center prof-img-par-position">
                                            @if($customer->profile_image)
                                                <div class="circle">
                                                    <img src="{{ route('display.image', [Config::get('constants.IMAGES.USER_IMAGE_PATH'), $customer->profile_image]) }}" class="profile-pic">
                                                </div>
                                            @else
                                                <img src="{{asset('assets/images/user.png')}}" class="profile-pic">
                                            @endif
                                        </div>
                                        <div class="edit-circle">
                                            <button class="btn order-btn-update">
                                                <i data-feather="edit-2"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <h3 class="prof-img-par-h3 mb-0">Update Profile
                                    </h3>
                                    <p class="text-dark text-center font-weight-bold">{{$customer->mobile_number }}</p>
                                    <div class="order-user-name">
                                        <div class="manage-address promotion_text-cololr p-3 cursor-pointer">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="row align-items-center">
                                                    <div class="col-md-2 col-2">
                                                        <img width="30px" src="{{asset('assets/images/loction.png')}}"
                                                            alt="">
                                                    </div>
                                                    <div class="col-md-10 col-10">
                                                        <div>
                                                            <h4 class="promotion_text-cololr mb-0">Manage
                                                                Address
                                                            </h4>
                                                            <p class="text-dark mb-0">Select address to deliver
                                                                your food.
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <i class="fas fa-chevron-right"></i>
                                            </div>
                                        </div>
                                        <div class="change-password promotion_text-cololr p-3 cursor-pointer">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="row align-items-center">
                                                    <div class="col-md-2 col-2">
                                                        <img width="60px"
                                                            src="{{asset('assets/images/ic_password_ch.PNG')}}" alt="">
                                                    </div>
                                                    <div class="col-md-10 col-10">
                                                        <div>
                                                            <h4 class="promotion_text-cololr mb-0">Change
                                                                Password
                                                            </h4>
                                                            <p class="text-dark mb-0">Change your current
                                                                password.
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <i class="fas fa-chevron-right"></i>
                                            </div>
                                        </div>
                                        <div class="payment-method promotion_text-cololr p-3"
                                            id="payment-method">
                                            <a href="{{route('customer.cards.list')}}">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div class="row align-items-center">
                                                        <div class="col-md-2 col-2">
                                                            <img width="60px"
                                                                src="{{asset('assets/images/ic_secure_payment.PNG')}}"
                                                                alt="">
                                                        </div>
                                                        <div class="col-md-10 col-10">
                                                            <div>
                                                                <h4 class="promotion_text-cololr mb-0">Payment
                                                                    Method
                                                                </h4>
                                                                <p class="text-dark mb-0">Show your all payment
                                                                    method
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <i class="fas fa-chevron-right"></i>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="orders promotion_text-cololr p-3">
                                            <a href="{{route('customer.orders')}}">
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div class="row align-items-center">
                                                        <div class="col-md-2 col-2">
                                                            <img width="120px" src="{{asset('assets/images/ic_order.PNG')}}"
                                                                alt="">
                                                        </div>
                                                        <div class="col-md-10 col-10">
                                                            <div>
                                                                <h4 class="promotion_text-cololr mb-0">Orders
                                                                </h4>
                                                                <p class="text-dark mb-0">Show your all orders
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <i class="fas fa-chevron-right"></i>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="mt-3">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="order-content order-content-second order-content-update">
                                <div class="back-button">
                                    <button class="btn bg-white mx-2 order-btn-back">
                                        <i data-feather="arrow-left"></i>
                                    </button>
                                </div>
                                <form action="{{ route('customer.profile.update') }}" method="post"
                                    enctype="multipart/form-data" id="profile-update" class="order-user-name">
                                    @csrf
                                    <div class="d-flex justify-content-center">
                                        <div class="circle">
                                                @if($customer->profile_image)
                                                    <div class="circle">
                                                        <img src="{{ route('display.image', [Config::get('constants.IMAGES.USER_IMAGE_PATH'), $customer->profile_image]) }}" class="profile-pic">
                                                    </div>
                                                @else
                                                    <img src="{{asset('assets/images/user.png')}}" class="profile-pic">
                                                @endif
                                            <div class="p-image">
                                                <i class="fa fa-camera upload-button"></i>
                                                <input class="file-upload" type="file" name="profile_photo" accept="image/*" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="order-content p-4 my-2">
                                        <h4>Your Information</h4>
                                        <div class="row form-group">
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control Profile-input "
                                                    id="inputname" name="first_name" placeholder="first name" value="{{$customer->first_name}}">
                                            </div>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control Profile-input "
                                                    id="inputsurname" name="last_name" placeholder="last name" value="{{$customer->last_name}}">
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <input type="text " class="form-control Profile-input "
                                                id="inputemail" name="email_id" value="{{$customer->email_id}}" placeholder="email address">
                                        </div>
                                        <div class="form-group ">
                                            <input type="text " class="form-control Profile-input "
                                                id="inputmob" placeholder="mobile no" name="mobile_number" value="{{$customer->mobile_number}}">
                                        </div>
                                    </div>
                                    <input type="hidden" name="userId" value="{{ $customer->uid }}">
                                    <div class="order-content p-4 my-2">
                                        <h4>Your Address</h4>
                                        <div class="form-group ">
                                            <textarea class="form-control Profile-input " id="inputaddress"
                                                rows="3 " name="physical_address" placeholder="address">{{ $customer->address->first->address['address'] }} </textarea>
                                        </div>
                                    </div>
                                    <button type="submit " class="btn btn-user-profile px-5"
                                        alt="Update Profile">
                                        <span>Update</span>
                                        <img width="20px" src="{{asset('./assets/images/send.png')}}" alt="">
                                    </button>
                                </form>
                            </div>
                            <div class="order-content order-content-second manage-address-content-update">
                                <div class="back-button">
                                    <button class="btn bg-white mx-2 manage-address-btn-back">
                                        <i data-feather="arrow-left"></i>
                                    </button>
                                </div>
                                <div class="order-content p-2 my-2 order-user-name">
                                    <div class="input-group manage-address-search">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">
                                                <img width="30px" src="{{asset('assets/images/loction_mangeAddress.png')}}"
                                                    alt="">
                                            </span>
                                        </div>
                                        <input type="text" class="form-control" placeholder="Search Address"
                                            aria-label="Username" aria-describedby="basic-addon1">
                                        <div class="input-group-append">
                                            <button
                                                class="btn bg-white input-group-text font-weight-bold">x</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="row align-items-center ">
                                    <div class="col-md-6">
                                        <img class="col-md-d-none" src="{{asset('assets/images/address.jpg')}}" alt="">
                                    </div>
                                    <div class="col-md-6">
                                        <form action="{{route('customer.address.store')}}" method="post" id="createAddress" class="p-4 my-2 order-content-order-user-name">
                                            @csrf
                                            <div class="form-group">
                                                <input type="text" name="address" class="form-control Profile-input "
                                                    id="inputname" placeholder="additional Information">
                                            </div>
                                            <div class="form-group ">
                                                <input type="text " class="form-control Profile-input "
                                                    id="inputemail" name="address_type" placeholder="address type (home/work etc.)">
                                            </div>
                                            <div class="form-group ">
                                                <input type="text " class="form-control Profile-input "
                                                    id="inputmob" name="zipcode" placeholder="zip code">
                                            </div>
                                            <button type="submit " class="btn btn-user-profile px-5"
                                                alt="Update Address">
                                                <span>Add Address</span>
                                                <img width="20px" src="{{asset('assets/images/send.png')}}" alt="">
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                <div class="order-user-name">
                                    <h4 class="promotion_text-cololr">Recently Used</h4>
                                    @foreach ($addresses as $address)
                                        <div class="order-content p-4 my-2">
                                            <div class="d-flex align-items-end justify-content-between">
                                                <div class="row align-items-center">
                                                    <div class="col-md-2 text-center">
                                                        <img width="30px"
                                                            src="{{asset('assets/images/loction_mangeAddress.png')}}" alt="">
                                                    </div>
                                                    <div class="col-md-10">
                                                        <div>
                                                            <h4 class="mb-0">{{$address->type}}</h4>
                                                            <p class="text-dark mb-0">{{$address->address}}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- <p class="promotion_text-cololr mx-2">8.7 Mile</p> --}}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="order-content order-content-second change-password-content-update">
                                <div class="back-button">
                                    <button class="btn bg-white mx-2 change-password-btn-back">
                                        <i data-feather="arrow-left"></i>
                                    </button>
                                </div>
                                <div class="row align-items-center">
                                    <div class="col-md-6">
                                        <img class="col-md-d-none"
                                            src="{{asset('assets/images/image_2022_11_23T10_11_53_445Z.png')}}" alt="">
                                    </div>
                                    <div class="col-md-6">
                                        <form action="{{route('customer.changepassword.submit')}}" method="post" id="changePasswordForm" class="p-4 my-2 order-content-order-user-name">
                                            @csrf
                                            <h4>Change Password</h4>
                                            <div class="form-group">
                                                <input type="password" class="form-control Profile-input "
                                                    id="inputname" name="current_password" placeholder="Current Password">
                                            </div>
                                            <div class="form-group ">
                                                <input type="password" class="form-control Profile-input "
                                                    id="inputemail" name="password" placeholder="New Password">
                                            </div>
                                            <div class="form-group ">
                                                <input type="password" class="form-control Profile-input "
                                                    id="inputmob" name="password_confirmation" placeholder="Confirm Password">
                                            </div>
                                            <button type="submit " class="d-flex btn btn-user-profile px-5"
                                                alt="Update Profile">
                                                <span class="mx-2">Change Password</span>
                                                <i data-feather="lock"></i>
                                            </button>
                                        </form>
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
    <div class="text-center betty-burger">
        <img src="{{asset('/assets/images/betty burger logo/horizontal_splash_logo_primary.png')}}" alt="">
    </div>
@endsection

@section('scripts')
        <script>
            $(document).ready(function () {
                $(".order-btn-update").click(function () {
                    $(".order-content-update").css("display", "block");
                    $(".order-content-main").css("display", "none");
                })
                $(".order-btn-back").click(function () {
                    $(".order-content-update").css("display", "none");
                    $(".order-content-main").css("display", "block");
                })
                $(".change-password").click(function () {
                    $(".change-password-content-update").css("display", "block");
                    $(".order-content-main").css("display", "none");
                })
                $(".change-password-btn-back").click(function () {
                    $(".change-password-content-update").css("display", "none");
                    $(".order-content-main").css("display", "block");
                })
                $(".manage-address").click(function () {
                    $(".manage-address-content-update").css("display", "block");
                    $(".order-content-main").css("display", "none");
                })
                $(".manage-address-btn-back").click(function () {
                    $(".manage-address-content-update").css("display", "none");
                    $(".order-content-main").css("display", "block");
                })
            })
        </script>
    <script src="{{ asset('assets/customer/js/jquery.validate.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"> </script>
    <script src="{{ asset('assets/customer/js/additional-methods.min.js') }}"></script>
    <script src="{{ asset('assets/customer/js/custom-js/profile/profile.js') }}"></script>
    <script>
        $(document).ready(function () {
            $("#changePasswordForm").validate({
                rules: {
                    current_password: 'required',
                    password: 'required',
                    password_confirmation: 'required',
                },
                messages: {
                    current_password: '	Please enter your current password.',
                    password: 'New password should not be empty.',
                    password_confirmation: 'Password should be same as New password',
                },
            });

            $("#createAddress").validate({
                rules: {
                    address: 'required',
                    address_type: 'required',
                    zipcode: 'required',
                },
                messages: {
                    address: 'This field is required !',
                    address_type: 'This field is required !',
                    zipcode: 'This field is required !',
                },
            });
        });
    </script>
@endsection
