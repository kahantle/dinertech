@extends('layouts.app')
@section('content')
<section id="wrapper">
  @include('layouts.sidebar')
  <div id="navbar-wrapper">
    <nav class="navbar navbar-inverse">
      <div class="container-fluid">
        <div class="navbar-header">
          <a href="#" class="navbar-brand" id="sidebar-toggle"><i class="fa fa-bars"></i></a>
          <h2>Add Hours</h2>
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
          <div class="time-buttons " >
            <div class="form-group" style="display: inline-block">
                <input type="time" class="add-time" id="opening_hours" name="opening_hours" placeholder="Selecting Open Hours">
                <span for="opening_hours" class="help-block"></span>
            </div>
            <div class="form-group" style="display: inline-block">
           <input type="time" class="add-time" id="closing_hours" name="closing_hours" placeholder="Selecting Closeing Hours">
           <span for="closing_hours" class="error"></span>
            </div>
         </div>
         <div class="btn-custom text-center mt-5">
          <button class="btn-blue"><span>Add Hours</span></button>
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
@endsection