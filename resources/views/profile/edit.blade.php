@extends('layouts.app')
@section('content')
<section id="wrapper">
  @include('layouts.sidebar')
  <div id="navbar-wrapper">
    <nav class="navbar navbar-inverse">
      <div class="container-fluid">
        <div class="navbar-header">
          <a href="#" class="navbar-brand" id="sidebar-toggle"><i class="fa fa-bars"></i></a>
          <h2>Profile</h2>
          <div class="clear">
            <span>Clear</span>
            <i class="fa fa-repeat" aria-hidden="true"></i>
          </div>
        </div>
      </div>
    </nav>
  </div>
  <div class="add-category content-wrapper">

    <div class="container-fluid">
      {{ Form::open(array('route' => array('update.profile.post'),'id'=>'update_profile_form','method'=>'POST','class'=>'','files'=>'true')) }}

      <div class="form-group">
        <span class="slt-img">
          @if($user->profile_image)
          <img width="200" height="197"  src="{{ route('display.image',[config("constants.IMAGES.RESTAURANT_USER_IMAGE_PATH"),$user->profile_image]) }}" />
          @endif
        </span>
        <input type="file" id="image" name="profile_photo" placeholder="Photo" required="" capture="" style="display: none;">
        <label class="label-a"><i class="fa fa-camera" aria-hidden="true"></i>Select Picture</label>
      </div>

      <div class="form-group">
        <img src="{{ asset('assets/images/category-menu-icon.png') }}">
        <input type="text" id="fname" name="fname" class="form-control" placeholder="Enter first Name" value="{{$user->first_name}}">
      </div>
      <div class="form-group">
        <img src="{{ asset('assets/images/category-menu-icon.png') }}">
        <input type="text" id="lname" name="lname" class="form-control"
          placeholder="Enter Last Name" value="{{$user->last_name}}">
      </div>
      <div class="form-group">
        <img src="{{ asset('assets/images/category-detail.png') }}">
        <input type="email" id="email" name="email" class="form-control"
          placeholder="Enter Email" value="{{$user->email_id}}">
      </div>
      <div class="form-group">
        <img src="{{ asset('assets/images/category-detail.png') }}">
        <input type="text" id="mobile" name="mobile" class="form-control"
          placeholder="Enter Mobile Number" value="{{$user->mobile_number }}">
      </div>
      <div class="form-group">
        <img src="{{ asset('assets/images/category-detail.png') }}">
        <input type="password" id="password" name="password" class="form-control"
          placeholder="Enter Password" value="">
      </div>

      <div class="form-group confirm_password" style="display:none">
      <img src="{{ asset('assets/images/category-detail.png') }}">
      <input type="password" id="confirm_password" name="confirm_password" class="form-control"
      placeholder="Enter confirm Password" value="">
      </div>
      <div class="form-group form-btn">
        <div class="btn-custom">
          <a href="{{route('profile')}}" class="btn-grey"><span>Cancel</span></a>
        </div>
        <div class="btn-custom">
          <button class="btn-blue"><span>Update My Profile</span></button>
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
<script src="{{ asset('assets/js/profile.js')}}"></script>
{!! JsValidator::formRequest('App\Http\Requests\ProfileRequest','#update_profile_form'); !!}
@endsection