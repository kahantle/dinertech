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
          <h2>Edit Hours</h2>
          </div>
        </div>
      </div>
    </nav>
  </div>



  <div class="dashboard orders content-wrapper">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="add-hours">
            {{ Form::open(array('route' => array('update.hours.post'),'id'=>'hourForm','method'=>'POST','files'=>'true',    'class'=>'')) }}

            <div class="check-buttons">
          
              <div class="form-group">
                @for ($i =0; $i<7; $i++)
                @php
              $day = \Carbon\Carbon::now()->startOfWeek(\Carbon\Carbon::MONDAY)->addDays($i)->isoFormat('dddd','D');
                @endphp
                @if(in_array(strtolower($day),$days))
                <div class="form-check">
                  <input type="checkbox" name="day[]" value="{{$day}}" checked>
                  <label for="{{$day}}">{{$day}}</label>
                </div>
                @elseif(in_array(strtolower($day),$restaurantHours))
                <div class="form-check">
                  <input type="checkbox" class="hours-disable" title="It's already selected for this resturant" disabled name="day[]" value="{{$day}}">
                  <label for="{{$day}}">{{$day}}</label>
                </div>
                @else 
                <div class="form-check">
                  <input type="checkbox" name="day[]" value="{{$day}}">
                  <label for="{{$day}}">{{$day}}</label>
                </div>
                @endif
                @endfor
              </div>
              @foreach($hoursdata as $hours)
              <input type="hidden" name="hidden_id" value="{{$hours->hours_group_id}}">
              <div class="time-buttons">                
                <input type="time" class="add-time" id="opening_hours" name="opening_hours" placeholder="Time" value="{{$hours->opening_time}}">
                <span> -- </span>
                <span> 
                  <input type="time" class="add-time" id="closing_hours" name="closing_hours" placeholder="Time" value="{{$hours->closing_time}}">
                </span>
              </div>
              @endforeach
              <div class="error">
                @if($errors->all())
                <ul class="alert alert-danger">
                  @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                  @endforeach
                </ul>
                @endif
              </div>
              <div class="btn-custom text-center mt-5">
                <button class="btn-blue"><span>Update Hours</span></button>
              </div>
     
          </div>
        </form>

        </div>
      </div>
    </div>
  </div>
</section>
@endsection
@section('scripts')
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
{!! JsValidator::formRequest('App\Http\Requests\HourRequest','#hourForm'); !!} 
@endsection