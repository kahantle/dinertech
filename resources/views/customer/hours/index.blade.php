@extends('customer-layouts.app')

@section('content')
	<div class="add-address-banner wd-dr-inner-blog">
        <div class="container">
           <div class="wd-dr-chat-left">
            <div class="wd-dr-chat-inner"> 
                <h1>
                    Hours
                </h1>
            </div>
            <div class="clearfix"></div>
           </div>
        </div>
    </div>

	<div class="container list-address">
	    <div class="jumbotron hours-jumbotron">
	        <div class="row ">
	            <div class="col-md-12">

	                <div class="row order-border">
	                    <h3 class="day">
	                        Day
	                    </h3>
	                    <h3 class="hours">
	                        Opening Hours
	                    </h3>
	                </div>
	                @foreach($hoursdata as $hours)
		                @if($hours->day == 'sunday')
		                	<div class="row day-hour sunday">
		                	    <label>Sunday</label>
		                	    <label>Closed</label>
		                	</div>
		                @else
			                <div class="row day-hour">
			                    <label>{{ucfirst($hours->day)}}</label>
			                    <label>{{$hours->opening_time}} To {{$hours->closing_time}}</label>
			                </div>
			            @endif
	                @endforeach
	            </div>
	        </div>
	    </div>
	</div>
@endsection