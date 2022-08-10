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
          <h2>Add Hours</h2>
          </div>
        </div>
      </div>
    </nav>
  </div>
  <div class="error">
    @if($errors->all())
    <ul class="alert alert-danger">
      @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
    </ul>
    @endif
  </div>

  <div class="dashboard orders content-wrapper">
    @include('common.flashMessage')
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="add-hours">
            {{ Form::open(array('route' => array('add.hour.post'),'id'=>'hourForm','method'=>'POST','files'=>'true',   'class'=>'')) }}

            <div class="check-buttons">
              @for ($i=0; $i<7; $i++)
                @php
                    $day = \Carbon\Carbon::now()->startOfWeek(\Carbon\Carbon::MONDAY)->addDays($i)->isoFormat('dddd','D');
                @endphp
                <div class="form-check">
                  @if(in_array(strtolower($day),$restaurantHours))
                    <input type="checkbox" class="hours-disable" title="It's already selected for this resturant" disabled name="day[]" value="{{$day}}">
                    <label for="{{$day}}">{{$day}}</label>
                  @else
                      <input type="checkbox"  name="day[]" value="{{$day}}">
                      <label for="{{$day}}">{{$day}}</label>
                  @endif
                </div>
              @endfor 
          </div>
          <div class="time-buttons">
            <div class="row">
                <div class="col-xl-2 col-md-3 col-sm-4 col-5">
                  <div class="form-group" style="display: inline-block">
                      <input type="time" class="add-time opening_time" id="opening_hours" name="opening_hours[]" placeholder="Selecting Open Hours">
                      <span for="opening_hours" class="help-block"></span>
                  </div>
                </div>
                <div class="col-xl-2 col-md-3 col-sm-4 col-5">
                  <div class="form-group" style="display: inline-block">
                      <input type="time" class="add-time closing_time" id="closing_hours" name="closing_hours[]" placeholder="Selecting Closeing Hours">
                      <span for="closing_hours" class="error"></span>
                  </div>
                </div>
                <div class="col-xl-2 col-md-2 col-sm-3 mt-3">
                  <button class="btn btn-primary" id="add-more" type="button">Add More</button>
                </div>
            </div>
            <div class="add-more-times"></div>
         </div>
         <div class="btn-custom text-center mt-5">
          <button class="btn-blue" id="submit_form"><span>Add Hours</span></button>
        </div>
      </form>
      </div>
    </div>
  </div>
     
</div>
</div>
</section>
@endsection
@section('scripts')
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
{!! JsValidator::formRequest('App\Http\Requests\HourRequest','#hourForm'); !!} 
<script src="{{asset('/assets/js/add-hours.js')}}"></script>
@endsection