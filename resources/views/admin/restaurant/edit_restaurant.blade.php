@extends('admin.layouts.app')

@section('content')
    <section id="right-content-wrapper" class="ps-container ps-active-y" data-ps-id="c878bcb0-cdfa-ab28-2fce-7147f311d569">
        <div class="right-content-outter">
            <div class="right-content-inner" style="opacity: 1;">
                <section class="page-header alternative-header">
                    <div class="page-header_title user-page-header_title">
                        <a href="{{route('admin.restaurants.index')}}" class="back-btn">
                            <img src="{{asset('assets/admin/img/back-white-small.png')}}">
                        </a>
                        <!--<img src="img/2-2.png" class="res-logo">-->
                        <h1>
                            <span data-i18n="dashboard1.dashboard">{{$restaurant->restaurant->restaurant_name}}</span>
                            <span class="page-header_subtitle" data-i18n="dashboard1.welcomeMsg" data-i18n-options="{&quot;username&quot;: &quot;John Doe&quot;}">{{$restaurant->restaurant->restaurant_address}}</span>
                        </h1>
                        <div class="del-ref-btn-grp">
                            <a class="btn btn-default btn-lg title-text text-white rounded-1" href="{{route('admin.restaurants.manage_menu',$restaurant->restaurant->restaurant_id)}}">Managed Menu</a>
                            <button type="button" class="btn btn-default btn-lg del-ref-btn refresh">
                                <img src="{{asset('assets/admin/img/refresh-white-small.png')}}">
                            </button>
                            <button type="button" class="btn btn-default btn-lg del-ref-btn">
                                <img src="{{asset('assets/admin/img/delete-white.png')}}">
                            </button>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </section>

                <section class="page-content res-edit-page-content">
                    @if(session()->has('success'))
                        <div class="alert alert-success">
                            {{ session()->get('success') }}
                        </div>
                    @endif
                    <div class="row zmd-hierarchical-display in" data-animation="hierarchical-display">
                        {{-- <form class="res-edit-form" method="POST" action="{{route('admin.restaurants.update')}}" enctype="multipart/form-data" id="">
                            @csrf --}}
                        {{ Form::open(array('route' => array('admin.restaurants.update'),'id'=>'restaurantDetailUpdate','method'=>'POST','class'=>'res-edit-form','files'=> true,
                            )) }}
                            <div class="col-sm-6 zoomIn animated right-border" style="animation-delay: 0.12s;">
                                {{-- <div class="res_logo">
                                    <img src="{{$restaurant->getProfileImagePathAttribute()}}">
                                </div> --}}
                                <div class="image-upload-container">
                                    <div class="image-upload-one">
                                        <div class="center">
                                            <div class="form-input">
                                                <label for="file-ip-1">
                                                    <img id="file-ip-1-preview" src="{{$restaurant->getProfileImagePathAttribute()}}" class="img-responsive">
                                                    <button type="button" class="imgRemove"></button>
                                                </label>
                                                <input type="file"  name="restaurant_image" id="file-ip-1" accept="image/*">
                                            </div>
                                            <small class="small">Use the &#8634; icon to reset the image</small>
                                        </div>
                                    </div>
                                </div>
                                
                                <input type="hidden" name="restaurantUid" value="{{$restaurant->uid}}" id="restaurantUid">
                                <input type="hidden" name="restaurantId" value="{{$restaurant->restaurant->restaurant_id}}">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="restaurant_name"  placeholder="Restaurant Name" value="{{$restaurant->restaurant->restaurant_name}}">
                                    <textarea class="form-control" rows="3" name="restaurant_address">{{$restaurant->restaurant->restaurant_address}}</textarea>
                                    <input type="text" class="form-control" name="mobile_number"  placeholder="Mobile Number" value="{{$restaurant->mobile_number}}" >
                                    <input type="text" class="form-control" name="email"  placeholder="Email" value="{{$restaurant->email_id}}" >
                                </div>
                                <div class="form-group">
                                    <input type="submit" name="submit" value="Update" class="btn btn-default btn-lg res-add-btn">
                                </div>
                            </div>
                        </form>
                        <div class="col-sm-6 zoomIn animated" style="animation-delay: 0.12s;">
                            <h1>
                                Active User
                            </h1>
                            @forelse ($activeUsers as $users)
                                <div class="well well-lg">
                                    <div class="media">
                                        <div class="media-left">
                                            <a href="#">
                                                <img class="media-object" src="{{$users->user->getImagePathAttribute()}}" alt="...">
                                            </a>
                                        </div>
                                        <div class="media-body">
                                            <label class="media-heading">{{$users->user->full_name}}</label>
                                            <span> - {{$users->address->city}}, {{$users->address->state}}</span>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="well well-lg">
                                    <p class="text-center">No User Found</p>
                                </div>
                            @endforelse
                            {{-- <div class="well well-lg">
                                <div class="media">
                                    <div class="media-left">
                                        <a href="#">
                                            <img class="media-object" src="images/UserImages/images (1).jpg" alt="...">
                                        </a>
                                    </div>
                                    <div class="media-body">
                                        <label class="media-heading">Antinol Jack</label>
                                        <span> - Canada, US</span>
                                    </div>
                                </div>
                            </div>
                            <div class="well well-lg">
                                <div class="media">
                                    <div class="media-left">
                                        <a href="#">
                                            <img class="media-object" src="images/UserImages/9.png" alt="...">
                                        </a>
                                    </div>
                                    <div class="media-body">
                                        <label class="media-heading">Deco Sethan</label>
                                        <span> - Canada, US</span>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </section>
                <!-- /#page-content -->
                
            </div>
        </div>
    </section>
    <!-- /#right-content-wrapper -->
@endsection

@section('script')
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\Admin\RestaurantRequest','#restaurantDetailUpdate'); !!}
    <script src="{{asset('assets/admin/js/restaurant/edit.js')}}"></script>
@endsection