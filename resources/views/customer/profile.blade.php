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
                                <form action="{{ route('customer.profile.update') }}" method="post"
                                    enctype="multipart/form-data" id="profile-update">
                                    @csrf
                                    <div class="prof-img-par ">
                                        <div class="row">
                                            <div class="col-lg-12 mb-2">
                                                @if($customer->profile_image)
                                                    <div class="circle">
                                                        <img src="{{ route('display.image', [Config::get('constants.IMAGES.USER_IMAGE_PATH'), $customer->profile_image]) }}"
                                                            class="profile-pic">
                                                    </div>
                                                @else
                                                    <img src="{{asset('assets/images/user.png')}}" class="profile-pic">
                                                @endif
                                                <div class="p-image d-none">
                                                    <i class="fa fa-camera upload-button"></i>
                                                    <input class="file-upload" type="file" accept="image/*"
                                                        name="profile_photo" />
                                                </div>
                                            </div>
                                        </div>
                                        <h3 class="mb-5 update-profile">Update Profile</h3>
                                    </div>
                                    <div class="order-user-name">
                                        <input type="hidden" name="userId" value="{{ $customer->uid }}">
                                        <div class="row form-group">
                                            <div class="col-sm-6 form-group">
                                                <input type="text" class="form-control Profile-input" name="first_name"
                                                    id="inputname" placeholder="first name"
                                                    value="{{ $customer->first_name }}" disabled="disabled">
                                                @error('first_name')
                                                    {{ $message }}
                                                @enderror
                                            </div>
                                            <div class="col-sm-6 ">
                                                <input type="text" class="form-control Profile-input" name="last_name"
                                                    id="inputsurname" placeholder="last name"
                                                    value="{{ $customer->last_name }}" disabled="disabled">
                                                @error('last_name')
                                                    {{ $message }}
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <input type="text " class="form-control Profile-input" name="email_id"
                                                id="inputemail" placeholder="email address"
                                                value="{{ $customer->email_id }}" readonly>
                                        </div>
                                        <div class="form-group ">
                                            <input type="text " class="form-control Profile-input" name="mobile_number"
                                                id="inputmob" placeholder="mobile no"
                                                value="{{ $customer->mobile_number }}" readonly>
                                        </div>
                                        <div class="form-group ">
                                            @if ($customer->address->first->address)
                                                <textarea class="form-control Profile-input" name="physical_address"
                                                id="inputaddress" rows="3 " placeholder="Address"
                                                disabled="disabled">{{ $customer->address->first->address['address'] }}</textarea>
                                            @else
                                                <textarea class="form-control Profile-input" name="physical_address"
                                                id="inputaddress" rows="3 " placeholder="Address"
                                                disabled="disabled"></textarea>
                                            @endif

                                        </div>
                                        <button type="submit " class="btn btn-user-profile submitProfile"
                                            alt="Update Profile" disabled>
                                            <h4 class="m-0">Update Profile</h4>
                                        </button>
                                    </div>
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
    <script src="{{ asset('assets/customer/js/custom-js/profile/profile.js') }}"></script>
@endsection
