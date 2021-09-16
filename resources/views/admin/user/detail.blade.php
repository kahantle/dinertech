@extends('admin.layouts.app')

@section('content')
    <section id="right-content-wrapper" class="ps-container ps-active-y" data-ps-id="c878bcb0-cdfa-ab28-2fce-7147f311d569">
        <div class="right-content-outter">
            <div class="right-content-inner" style="opacity: 1;">
                <section class="page-header alternative-header">
                    <div class="page-header_title user-page-header_title">
                        <a href="{{route('admin.users.restaurant.users',$restaurant->restaurant_id)}}" class="back-btn">
                            <img src="{{asset('assets/admin/img/back-white-small.png')}}">
                        </a>
                        <img src="{{$restaurantProfile->getProfileImagePathAttribute()}}" class="res-logo">
                        <h1>
                            <span data-i18n="dashboard1.dashboard">{{$restaurant->restaurant_name}}</span>
                            <span class="page-header_subtitle" data-i18n="dashboard1.welcomeMsg" data-i18n-options="{&quot;username&quot;: &quot;John Doe&quot;}">{{$restaurant->restaurant_address}}</span>
                        </h1>
                        <div class="del-ref-btn-grp">
                            <!--<button type="button" class="btn btn-default btn-lg del-ref-btn" onclick="window.location.href='Add User.html'">
                                <img src="img/user-(1).png">
                            </button>-->
                            <button type="button" class="btn btn-default btn-lg del-ref-btn">
                                <img src="{{asset('assets/admin/img/refresh-white-small.png')}}">
                            </button>
                            <button type="button" class="btn btn-default btn-lg del-ref-btn" onclick="window.location.href='DeleteUser.html'">
                                <img src="{{asset('assets/admin/img/delete-white.png')}}">
                            </button>
                            <!--<button type="button" class="btn btn-default btn-lg">ADD USERS +</button>-->
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </section>
                
                @foreach ($restaurant->restaurant_user->users as $user)
                    <section class="row captureImgParent">
                        <div class="col-sm-3 col-sm-offset-4 captureImgIcon">
                            @if ($user->getImagePathAttribute() == null)
                                <img src="{{asset('assets/admin/img/avatar_square_blue.png')}}" class="img-responsive">
                            @else
                                <img src="{{$user->getImagePathAttribute()}}" class="img-responsive">
                            @endif
                            <h2 class="user_name">{{$user->first_name}} {{$user->last_name}}</h2>
                            <label class="city">Canada U.S.A.</label>
                        </div>
                    </section>
                    <section class="page-content user-page-content">
                        <div class="row">
                            <div class="col-sm-4">
                                <h3 class="basic_information">Basic Information</h3>
                                <p class="text-left">
                                    <table class="table-responsive user-info">
                                        <tr>
                                            <td>Name</td>
                                            <td>{{$user->full_name}}</td>
                                        </tr>
                                        <tr>
                                            <td>Status</td>
                                            <td>{{$user->status}}</td>
                                        </tr>
                                    </table>
                                </p>
                            </div>
                            <div class="col-sm-4 col-sm-offset-4">
                                <h3 class="basic_information">Contact Information</h3>
                                <p class="text-right">
                                    <table class="table-responsive user-info">
                                        <tr>
                                            <td>Contact</td>
                                            <td>{{$user->mobile_number}}</td>
                                        </tr>
                                        <tr>
                                            <td>Email ID</td>
                                            <td>{{$user->email_id}}</td>
                                        </tr>
                                        
                                        <tr>
                                            <td>Address</td>
                                            <td>{{$user->address->first()->city}},{{$user->address->first()->state}}</td>
                                        </tr>        
                                        
                                    </table>
                                </p>
                            </div>
                        </div>
                    </section>
                    <!-- /#page-content -->        
                @endforeach
            </div>
        </div>
    </section>
    <!-- /#right-content-wrapper -->
@endsection