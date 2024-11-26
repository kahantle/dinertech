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
                        {{-- <img src="img/2-2.png" class="res-logo"> --}}
                        <h1>
                            <span data-i18n="dashboard1.dashboard">{{$restaurant->restaurant_name}}</span>
                            <span class="page-header_subtitle" data-i18n="dashboard1.welcomeMsg" data-i18n-options="{&quot;username&quot;: &quot;John Doe&quot;}">{{$restaurant->restaurant_address}}</span>
                        </h1>
                        <div class="del-ref-btn-grp">
                            <button type="button" class="btn btn-default btn-lg del-ref-btn">
                                <img src="{{asset('assets/admin/img/refresh-white-small.png')}}">
                            </button>
                            <button type="button" class="btn btn-default btn-lg del-ref-btn">
                                <img src="{{asset('assets/admin/img/delete-white.png')}}">
                            </button>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </section>

                <section class="page-content res-manage-menu">
                    <div class="row zmd-hierarchical-display in" data-animation="hierarchical-display">
                        <div>
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs" role="tablist">
                                @foreach ($categories as $key => $category)
                                    @if ($key == 0)
                                        <li role="presentation" class="category-{{\Str::slug($category->category_name)}} active"><a href="#{{\Str::lower($category->category_name)}}" aria-controls="{{$category->category_name}}" role="tab" data-toggle="tab" data-category-id="{{$category->category_id}}" class="category">{{$category->category_name}}</a></li>
                                    @else
                                        <li role="presentation" class="category-{{\Str::slug($category->category_name)}}"><a href="#{{\Str::lower($category->category_name)}}" aria-controls="{{$category->category_name}}" role="tab" data-toggle="tab" data-category-id="{{$category->category_id}}" class="category">{{$category->category_name}}</a></li>
                                    @endif
                                @endforeach
                            </ul>
                            {{-- <button type="button" class="btn btn-default btn-lg tab-btn" onclick="window.location.href='{{route('admin.restaurants.dashboard',[$restaurant->restaurant_name,$restaurant->restaurant_id])}}'">View Restaurant</button> --}}
                            <a href="{{route('admin.restaurants.dashboard',[$restaurant->restaurant_name,$restaurant->restaurant_id])}}" class="btn btn-default btn-lg tab-btn" target="_blank">View Restaurant</a>
                            <button type="button" class="btn btn-default btn-lg tab-btn" onclick="window.location.href='{{route('admin.restaurants.menu.create',$restaurant->restaurant_id)}}'">Add Menu</button>
                            <div style="clear: both;">

                            </div>
                            <!-- Tab panes -->
                        </div>
                    </div>
                </section>

                <section class="page-content">
                    <div class="tab-content" id="loadmenu"></div>
                </section>

            </div>
        </div>
    </section>
@endsection

@section('script')
    <script src="{{asset('assets/admin/js/menuItem/menuItem.js')}}"></script>
@endsection