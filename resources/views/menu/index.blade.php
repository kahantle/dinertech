@extends('layouts.app')
@section('content')
<section id="wrapper">
  @include('layouts.sidebar')
  @include('common.flashMessage')
  <div id="navbar-wrapper">
    <nav class="navbar navbar-inverse">
      <div class="container-fluid">
        <div class="navbar-header">
          <div class="profile-title-new">
          <a href="#" class="navbar-brand" id="sidebar-toggle"><i class="fa fa-bars"></i></a>
          <h2>Menu</h2>
          </div>
          <div class="form-group">
            <i class="fa fa-search" aria-hidden="true"></i>
            <input type="text" name="item-name" id="searchText" class="form-control searchText" value="{{$params}}" placeholder="Search Menu">
            <i class="fa fa-times searchTextBtn" aria-hidden="true"></i>
          </div>
          <div class="plus">              
            <a href="{{route('add.menu')}}"><i class="fa fa-plus" aria-hidden="true"></i></a>
          </div>
        </div>
      </div>
    </nav>
  </div>
  <div class="menu content-wrapper">
    <div class="container-fluid">
      @if($menu)

      <div class="row">

        @foreach ($menu as $item)
        <div class="col-xl-4 col-md-6">
          <div class="menu-item">
            <div class="img">
              @if(!$item->item_img)
              <img src="{{ asset('assets/images/mi-3.png') }}" class="img-fluid">
              @else
              <img width="200" height="197" src="{{ route('display.image',[config("constants.IMAGES.MENU_IMAGE_PATH"),$item->item_img]) }}">
              @endif
            </div>
            <div class="menu-content">
              <div class="menu-title">
                <h4>{{$item->item_name}} | <span>{{$item->category->category_name}}</span></h4>&nbsp;

                <div class="menu-actions-ctm">
                <a href="{{route('edit.menu',$item->menu_id)}}" class="" data-route=""><p>Edit<i class="fa fa-pencil" aria-hidden="true"></i></p></a>

                &nbsp;<a  data-route="{{route('delete.menu.post',[$item->menu_id])}}" class="delete " href="javaScript:void(0);"><p>Delete<i class="fa fa-trash " aria-hidden="true"></i></p></a>             
              </div>
              </div>
              <p>{{$item->item_details}}</p>
              <div class="price">
                <p>${{number_format($item->item_price,2)}}</p>
                {{-- <a href="#0">Out Of Stock</a> --}}
              </div>
            </div>
          </div>
        </div>
        @endforeach
        
      </div>
      <div class="w-100 pagination-links"> {{ $menu->links() }}</div>
      @else
      <p>No records found.</p>
      @endif
    </div>
  </div>
</section>
@endsection
@section('scripts')
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>  
<script src="{{ asset('assets/js/menu.js')}}"></script>
@endsection