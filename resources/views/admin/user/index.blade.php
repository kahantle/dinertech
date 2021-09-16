@extends('admin.layouts.app')

@section('content')
    
    <section id="right-content-wrapper" class="ps-container ps-active-y" data-ps-id="c878bcb0-cdfa-ab28-2fce-7147f311d569">
        <div class="right-content-outter">
            <div class="right-content-inner" style="opacity: 1;">
                <section class="page-header alternative-header">

                    <div class="page-header_title user-page-header_title">
                        <h1>
                            <span data-i18n="dashboard1.dashboard">Restaurants</span>
                            <span class="page-header_subtitle" data-i18n="dashboard1.welcomeMsg" data-i18n-options="{&quot;username&quot;: &quot;John Doe&quot;}">Welcome back {{Auth::guard('admin')->user()->full_name}}</span>
                        </h1>
                        <!--<button type="button" class="btn btn-default btn-lg">ADD USERS +</button>-->
                        <div class="clearfix"></div>
                    </div>
                </section>

                <section class="page-content user-page-content">
                    <div class="row zmd-hierarchical-display in" data-animation="hierarchical-display">
                        
                        @forelse ($restaurants as $restaurant)
                            <div class="col-lg-4 col-sm-6 zoomIn animated" style="animation-delay: 0.12s;">
                                <div class="panel panel-default panel-user">
                                    <div class="panel-body no-padding">
                                        <div class="mini-card user-mini-card">
                                            <div class="media">
                                                <div class="media-left">
                                                    <a href="#">
                                                        <img class="media-object user-img" src="{{$restaurant->getProfileImagePathAttribute()}}" alt="">
                                                    </a>
                                                </div>
                                                <div class="media-body">
                                                    <h3 class="media-heading">{{$restaurant->restaurant->restaurant_name}}</h3>
                                                    <div class="panel-heading-tools">
                                                        <div class="btn-group">
                                                            <button type="button" class="btn" data-toggle="modal" data-target="#myModal-{{$restaurant->restaurant->restaurant_id}}">
                                                                <i class="material-icons">more_vert</i>
                                                            </button>
                                                            <div id="myModal-{{$restaurant->restaurant->restaurant_id}}" class="modal fade" role="dialog">
                                                                <div class="modal-dialog modal-sm">
                                                                    <!-- Modal content-->
                                                                    <div class="modal-content">
                                                                        <div class="modal-body">
                                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                            <div class="row" style="float: left; width: 100%;">
                                                                                <div class="col-sm-6 modal-cols">
                                                                                    <a href="{{route('admin.users.restaurant.users',$restaurant->restaurant->restaurant_id)}}">
                                                                                        <img src="{{asset('assets/admin/img/information.png')}}">
                                                                                        <h5>
                                                                                            Information
                                                                                        </h5>
                                                                                    </a>
                                                                                </div>
                                                                                <div class="col-sm-6" style="text-align: center;">
                                                                                    <a href="#">
                                                                                        <img src="{{asset('assets/admin/img/delete-2.png')}}">
                                                                                        <h5>
                                                                                            Delete Restaurants
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
                                                    @if ($restaurant->restaurant->restaurant_city != NULL && $restaurant->restaurant->restaurant_state != NULL)
                                                        <div class="person">
                                                            <span>
                                                                <img src="{{asset('assets/admin/img/icons8-visit-100.png')}}">
                                                            </span>
                                                            <span>
                                                                {{$restaurant->restaurant->restaurant_city}}, {{$restaurant->restaurant->restaurant_state}}
                                                            </span>        
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>         
                        @empty
                            
                        @endforelse
                        
                    </div>
                    <hr>
                    {{$restaurants->links('vendor.pagination.custom')}}
                    
                </section>
                <!-- /#page-content -->
            </div>
        </div>
    </section>
    <!-- /#right-content-wrapper -->
    
@endsection

@section('script')
    <script src="{{asset('assets/admin/js/user/index.js')}}"></script>
@endsection