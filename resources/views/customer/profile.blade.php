@extends('customer-layouts.app')

@section('content')
	{{-- <div class="container-fluid">
        <div class="add-address-banner">
            <div class="container">
                <h1 class="profile-heading-text">
                    Profile
                </h1>
                <div class="profile-heading">
                	@if($customer->profile_image)
                    	<img src="{{route('display.image',[Config::get('constants.IMAGES.USER_IMAGE_PATH'),$customer->profile_image])}}">
                    @endif
                    <h3>
                        {{$customer->first_name}} {{$customer->last_name}}
                    </h3>
                    <span>{{$customer->email_id}}</span>
                    <span>{{$customer->mobile_number}}</span>
                    <div class="clearfix">

                    </div>
                </div>
                <div class="clearfix">

                </div>
            </div>
        </div>
    </div> --}}
    <div class="add-address-banner">
        <div class="container">
            <h1 class="profile-heading-text">
                Profile
            </h1>
            <div class="profile-heading">
                @if($customer->profile_image)
                    <img src="{{route('display.image',[Config::get('constants.IMAGES.USER_IMAGE_PATH'),$customer->profile_image])}}">
                @endif
                <h3>
                    {{$customer->first_name}} {{$customer->last_name}}
                </h3>
                <span>{{$customer->email_id}}</span>
                <span>{{$customer->mobile_number}}</span>
                <div class="clearfix">

                </div>
            </div>
            <div class="clearfix">

            </div>
        </div>
    </div>

    <div class="container update-prof">
        <div class="jumbotron">
            <div class="row ">
            	@include('customer.messages')
                <div class="col-sm-6 col-sm-offset-3 ">
                    <div class="row ">
                        <div class="col-md-12 prof-img-par ">
                        	@if($customer->profile_image)
                            	<img src="{{route('display.image',[Config::get('constants.IMAGES.USER_IMAGE_PATH'),$customer->profile_image])}}" class="profile-img ">
                            @endif
                            <!-- <h3 class="update-profile " onclick="disableTxt()">
                                Update Profile
                            </h3> -->
                            <h3 class="update-profile">
                                Update Profile
                            </h3>

                        </div>
                    </div>

                    <form action="{{route('customer.profile.update')}}" method="post" enctype="multipart/form-data" id="profile-update">
                    	@csrf
                    	<input type="hidden" name="userId" value="{{$customer->uid}}">
                        <div class="row form-group">
                            <div class="col-sm-6 form-group">
                                <input type="text" class="form-control Profile-input inputname" name="first_name" disabled="disabled" value="{{$customer->first_name}}">
                                @error('first_name')
                                    {{$message}}
                                @enderror
                            </div>
                            <div class="col-sm-6 ">
                                <input type="text" class="form-control Profile-input inputsurname" name="last_name" disabled="disabled" value="{{$customer->last_name}}">
                                @error('last_name')
                                    {{$message}}
                                @enderror
                            </div>
                        </div>
                        <div class="form-group ">
                            <input type="email " class="form-control Profile-input inputemail" name="email_id" disabled="disabled" value="{{$customer->email_id}}" readonly>
                        </div>
                        <div class="form-group ">
                            <input type="text " class="form-control Profile-input inputmob" name="mobile_number" disabled="disabled" value="{{$customer->mobile_number}}" readonly>
                        </div>
                        <div class="form-group ">
                            <textarea class="form-control Profile-input inputaddress" name="physical_address" rows="3" disabled="disabled">{{$customer->address->first->address['address']}}</textarea>
                        </div>
                        <div class="form-group ">
                        	<input type="file" name="profile_photo" class="form-control profile_pic_upload" disabled>
                        </div>
                        <button type="submit" class="btn btn-primary submitProfile" style="width: 100%;" alt="Update Profile" alt="Update Profile" disabled><h4>Update Profile</h4></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{asset('assets/customer/js/jquery.validate.min.js')}}"></script>
    <script src="{{asset('assets/customer/js/additional-methods.min.js')}}"></script>
    <script src="{{asset('assets/customer/js/home/profile.js')}}"></script>
@endsection