@extends('admin.layouts.app')

@section('content')

    <section id="right-content-wrapper" class="ps-container ps-active-y" data-ps-id="c878bcb0-cdfa-ab28-2fce-7147f311d569">
        <div class="right-content-outter">
            <div class="right-content-inner" style="opacity: 1;">
                <section class="page-header alternative-header">
                    <div class="page-header_title user-page-header_title">
                        <a href="{{route('admin.users.index',$restaurant->restaurant_id)}}" class="back-btn">
                            <img src="{{asset('assets/admin/img/back-white-small.png')}}">
                        </a>
                        <img src="{{$restaurantProfile->getProfileImagePathAttribute()}}" class="res-logo">
                        <h1>

                            <span data-i18n="dashboard1.dashboard">{{$restaurant->restaurant_name}}</span>
                            <span class="page-header_subtitle" data-i18n="dashboard1.welcomeMsg" data-i18n-options="{&quot;username&quot;: &quot;John Doe&quot;}">{{$restaurant->restaurant_address}}</span>
                        </h1>
                        <div class="del-ref-btn-grp">
                            <!--<button type="button" class="btn btn-default btn-lg del-ref-btn" onclick="window.location.href='User_Detail.html'">
                                <img src="img/user-(1).png">
                            </button>-->
                            <a href="{{route('admin.users.restaurant.users',$restaurant->restaurant_id)}}" class="btn btn-lg del-ref-btn">
                                <img src="{{asset('assets/admin/img/refresh-white-small.png')}}">
                            </a>
                            <!--<button type="button" class="btn btn-default btn-lg del-ref-btn" onclick="window.location.href='DeleteUser.html'">
                                <img src="img/delete-white.png">
                            </button>-->
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </section>
                <section class="banner">
                    <div class="page-header_title user-page-header_title">
                        <img src="{{$restaurantProfile->getProfileImagePathAttribute()}}" class="res-logo">
                        <h1>
                            <span data-i18n="dashboard1.dashboard">{{$restaurant->restaurant_name}}</span>
                            <span class="page-header_subtitle" data-i18n="dashboard1.welcomeMsg" data-i18n-options="{&quot;username&quot;: &quot;John Doe&quot;}">{{$restaurant->restaurant_city}}, {{$restaurant->restaurant_state}}</span>
                        </h1>
                        <div class="clearfix"></div>
                    </div>
                </section>
                @if ($restaurantUsers->count() > 1)
                    <section class="page-content user-page-content">
                        <div class="row">
                            <div class="col-md-8">
                                <h2>Restaurant Users</h2>
                            </div>
                            <div class="col-md-4">
                                <a class="btn btn-default tab-btn pull-right" href="{{ route('admin.users.export',$restaurant->restaurant_id) }}">Export Users</a>
                            </div>
                        </div>
                        <hr>
                        <div class="row zmd-hierarchical-display in" data-animation="hierarchical-display">
                            @foreach ($restaurantUsers as $restaurantUser)
                                @foreach ($restaurantUser->users as $user)
                                    <div class="col-lg-4 col-sm-6 zoomIn animated" style="animation-delay: 0.12s;">
                                        <div class="panel panel-default panel-user">
                                            <div class="panel-body no-padding">
                                                <div class="mini-card user-mini-card">
                                                    <div class="media">
                                                        <div class="media-left">
                                                            @if ($user->profile_image == NUll)
                                                                <a href="#">
                                                                    <img class="media-object user-img" src="{{asset('assets/admin/img/avatar_square_blue.png')}}" alt="">
                                                                </a>
                                                            @else
                                                                <a href="#">
                                                                    <img class="media-object user-img" src="{{$user->getImagePathAttribute()}}" alt="">
                                                                </a>
                                                            @endif
                                                        </div>
                                                        <div class="media-body">
                                                            <h3 class="media-heading">{{$user->first_name}} {{$user->last_name}}.</h3>
                                                            <div class="panel-heading-tools">
                                                                <div class="btn-group">
                                                                    <button type="button" class="btn" data-toggle="modal" data-target="#myModal-user-{{$user->uid}}">
                                                                        <i class="material-icons">more_vert</i>
                                                                    </button>
                                                                    <div id="myModal-user-{{$user->uid}}" class="modal fade" role="dialog">
                                                                        <div class="modal-dialog modal-sm">
                                                                            <!-- Modal content-->
                                                                            <div class="modal-content">
                                                                                <div class="modal-body">
                                                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                                    <div class="row" style="float: left; width: 100%;">
                                                                                        <div class="col-sm-6 modal-cols">
                                                                                            <a href="{{route('admin.users.detail',[$restaurant->restaurant_id,$user->uid])}}">
                                                                                                <img src="{{asset('assets/admin/img/information.png')}}">
                                                                                                <h5>
                                                                                                    Information
                                                                                                </h5>
                                                                                            </a>
                                                                                        </div>
        
                                                                                        <div class="col-sm-6" style="text-align: center;">
                                                                                            <a href="User_Delete.html">
                                                                                                <img src="{{asset('assets/admin/img/delete-2.png')}}">
                                                                                                <h5>
                                                                                                    Delete User
                                                                                                </h5>
                                                                                            </a>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="clearfix"></div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="clearfix">
        
                                                            </div>
                                                            @foreach ($user->address as $address)
                                                                <div class="person">
                                                                    <span>
                                                                        <img src="{{asset('assets/admin/img/icons8-visit-100.png')}}">
                                                                    </span>
                                                                    <span>
                                                                        {{$address->city}}, {{$address->state}}
                                                                    </span>
                                                                </div>        
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endforeach
                        </div>
                        <hr>
                        {{$restaurantUsers->links('vendor.pagination.custom')}}    
                    </section>
                    <!-- /#page-content -->    
                @else

                @endif
            </div>
        </div>
    </section>
    <!-- /#right-content-wrapper -->

@endsection

@section('script')
    <script src="{{asset('assets/admin/js/user/index.js')}}"></script>
@endsection