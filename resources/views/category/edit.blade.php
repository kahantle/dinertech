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
          <h2>Edit Category</h2>
          </div>
          <div id="clearForm" class="clear">
            <a href="{{route('edit.category.post',$category->category_id)}}">
            <span>Clear</span>
            <i class="fa fa-repeat" aria-hidden="true"></i>
            </a>
          </div>
        </div>
      </div>
    </nav>
  </div>
  <div class="add-category content-wrapper category_main">
    <div class="container-fluid">
      @include('common.flashMessage')
      {{ Form::open(array('route' => array('update.category.post'),'id'=>'categoryForm','method'=>'POST','class'=>'','files'=>'true')) }}
      {{-- <div class="form-group">
        <span class="slt-img">
          @if($category->image)
            <img width="170" height="170" class="itemImage"  src="{{ $category->getImagePathAttribute() }}" />
          @else
            <img width="170" height="170" class="itemImage"  src="{{ $category->getDefaultImage() }}" />
          @endif
        </span>
        <input id="image" type="file" name="profile_photo" placeholder="Photo" required="" capture=""
          style="display: none;">
        <label class="label-a"><i class="fa fa-camera" aria-hidden="true"></i>Select Picture</label>
      </div> --}}

      <div class="form-group">
        <label class="label_cat">Category Name</label>
        <img src="{{ asset('assets/images/category-menu-icon.png') }}">
        <input type="text" id="name" name="name" class="form-control" value="{{$category->category_name}}"
          placeholder="Enter Category">
      </div>
      <div class="form-group">
        <label class="label_cat">Category Description <span>(optional)</span></label>
        <img src="{{ asset('assets/images/category-detail.png') }}">
        <textarea type="text" id="details" name="details" class="form-control"
          placeholder="Enter Category Details">{{$category->category_details}}</textarea>
        <input type="hidden" id="hidden_id" name="hidden_id" value="{{$category->category_id}}" />
      </div>
      <div class="form-group form-btn">
        <div class="btn-custom">
          <a href="{{route('category')}}" class="btn-grey"><span>Cancel</span></a>
        </div>
        <div class="btn-custom">
          <button class="btn-blue"><span>Update Category</span></button>
        </div>
      </div>
      </form>
    </div>
  </div>
</section>
@endsection
@section('scripts')
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
<script src="{{ asset('assets/js/common.js')}}"></script>
{!! JsValidator::formRequest('App\Http\Requests\CategoryRequest','#categoryForm'); !!}
<script>
$(document).ready(function() {
  $(document).on('click', '#clearForm', function() {
    $('#categoryForm').trigger("reset");
    $(".slt-img img").remove();
  });
});
  </script>
@endsection
