@extends('layouts.app')
@section('content')
<section id="wrapper">
  @include('layouts.sidebar')
  <div id="navbar-wrapper">
        <nav class="navbar navbar-inverse">
          <div class="container-fluid">
            <div class="navbar-header">
              <div class="profile-title-new">
              <a href="#" class="navbar-brand" id="sidebar-toggle"><i class="fa fa-bars"></i></a>
              <h2>Category</h2>
              </div>
              <div class="form-group">
                <i class="fa fa-search searchTextBtn" aria-hidden="true"></i>
                <input type="text" name="searchText" id="searchText" value="{{$params}}" class="form-control searchText" placeholder="Search Here">
                <i class="fa fa-times" aria-hidden="true"></i>
              </div>
              <div class="plus">
                <a href="{{route('add.category')}}" class="fa fa-plus" aria-hidden="true"></a>
              </div>
            </div>
          </div>
        </nav>
      </div>
  <div class="dashboard category content-wrapper">
    @include('common.flashMessage')
    <div class="container-fluid">
      @if($categories)
        @foreach($categories as $key=>$item)
        <div class="row">
          <div class="col-lg-12">
            <div class="orders">
              <div class="order">
                <div class="order-name">
                  <div class="img">
                    @if(!$item->image)
                      <img src="{{ asset('assets/images/mi-3.png') }}" class="img-fluid">
                    @else
                      <img src="{{ route('display.image',[config("constants.IMAGES.CATEGORY_IMAGE_PATH"),$item->image]) }}" class="img-fluid">
                    @endif
                  </div>
                <h4>{{$item->category_name}}</h4>
                </div>
                <div class="order-detail">
                  <div class="text">
                    <p>{{$item->category_details}}</p>
                  </div>
                  <div class="order-icons">
                    <a class="action-edit" href="{{route('edit.category.post',$item->category_id)}}"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                    <a class="action-delete delete" href="javascript:void(0);" data-route="{{route('delete.category.post',$item->category_id)}}"><i class="fa fa-trash" aria-hidden="true"></i></a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>    
        @endforeach
        <div class="w-100 pagination-links"> {{ $categories->links() }}</div>
    @else
        <p>No records found.</p>
    @endif
    </div>
  </div>
</section>
@endsection
@section('scripts')
<script src="{{asset('/assets/js/category.js')}}"></script>    
@endsection