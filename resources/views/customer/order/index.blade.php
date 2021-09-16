@extends('customer-layouts.app')

@section('content')
	<div class="add-address-banner wd-dr-inner-blog">
        <div class="container">
           <div class="wd-dr-chat-left">
            <div class="wd-dr-chat-inner"> 
                <h1>
                    Orders
                </h1>
            </div>
            <div class="clearfix"></div>
           </div>
        </div>
    </div>

	<div class="container list-address">
	    <div class="jumbotron order-jumbotron">
	        <div class="row ">
	            <div class="col-md-12">
	                <!-- Tab links -->
	                <div class="tab">
	                    <h3>
	                        <button class="tablinks" onclick="openCity(event, 'London')" id="defaultOpen" alt="Current Order">Current Order</button>
	                        <button class="tablinks" onclick="openCity(event, 'Paris')" style="margin-left: -40px;" alt="Past Order">Past Order</button>
	                    </h3>
	                </div>

	                <!-- Tab content -->
	                <div id="London" class="tabcontent">
	                	@foreach($currentOrders as $currentOrder)
		                    <div class="row order-border">
		                        <div class="col-sm-3 for-right-border">
		                            {{--<img src="images/Logo-small.png">--}}
		                            <h3>{{$currentOrder->order_number}}</h3>
		                        </div>
		                        <div class="col-sm-2 for-right-border">
		                            {{--<h3>July 4,2014</h3>--}}
		                            <h3>{{date('M d,Y',strtotime($currentOrder->order_date))}}</h3>
		                        </div>
		                        <div class="col-sm-3 for-right-border">
		                        	@if($currentOrder->isPickUp == 1)
		                            	<h3>Pickup :- {{$currentOrder->pickup_time}}</h3>
		                        	@else
		                        		<h3>Pickup :- 00:00</h3>
		                        	@endif
		                        </div>
		                        <div class="col-sm-2 for-right-border">
		                            <h3>
		                                <ul>
		                                    <li>
		                                        {{$currentOrder->order_progress_status}}
		                                    </li>
		                                </ul>
		                            </h3>
		                        </div>
		                        <div class="col-sm-1 for-right-border">
		                            <h3>${{$currentOrder->grand_total}}</h3>
		                        </div>
		                        <div class="col-sm-1 info">
		                            <a href="{{route('customer.orders.details',$currentOrder->order_id)}}" alt="Information">
		                                <img src="{{asset('assets/customer/images/information.png')}}">
		                            </a>
		                        </div>
		                    </div>
	                    @endforeach
	                </div>

	                <div id="Paris" class="tabcontent">
	                	@foreach($pastOrders as $pastOrder)
		                    <div class="row order-border">
		                        <div class="col-sm-4 for-right-border">
		                            {{--<img src="images/Logo-small.png">--}}
		                            <h3>{{$pastOrder->order_number}}</h3>
		                        </div>
		                        <div class="col-sm-3 for-right-border">
		                            <h3>{{date('M d,Y',strtotime($pastOrder->order_date))}}</h3>
		                        </div>
		                        {{--<div class="col-sm-3 for-right-border">
		                            @if($pastOrder->isPickUp == 1)
		                            	<h3>Pickup :- {{$pastOrder->pickup_time}}</h3>
		                        	@else
		                        		<h3>Pickup :- 00:00</h3>
		                        	@endif
		                        </div>--}}
		                        <div class="col-sm-2 for-right-border">
		                            <h3>
		                                <ul>
		                                    <li>
		                                        {{$pastOrder->order_progress_status}}
		                                    </li>
		                                </ul>
		                            </h3>
		                        </div>
		                        <div class="col-sm-1 for-right-border">
		                            <h3>${{$pastOrder->grand_total}}</h3>
		                        </div>
		                        <div class="col-sm-1 info">
		                            <a href="{{route('customer.orders.details',$pastOrder->order_id)}}" alt="Information">
		                                <img src="{{asset('assets/customer/images/information.png')}}">
		                            </a>
		                        </div>
		                    </div>
	                    @endforeach
	                </div>
				</div>
	        </div>
	    </div>
	</div>
@endsection

@section('scripts')
	<script>
	    function openCity(evt, cityName) {
	        // Declare all variables
	        var i, tabcontent, tablinks;

	        // Get all elements with class="tabcontent" and hide them
	        tabcontent = document.getElementsByClassName("tabcontent");
	        for (i = 0; i < tabcontent.length; i++) {
	            tabcontent[i].style.display = "none";
	        }

	        // Get all elements with class="tablinks" and remove the class "active"
	        tablinks = document.getElementsByClassName("tablinks");
	        for (i = 0; i < tablinks.length; i++) {
	            tablinks[i].className = tablinks[i].className.replace(" active", "");
	        }

	        // Show the current tab, and add an "active" class to the button that opened the tab
	        document.getElementById(cityName).style.display = "block";
	        evt.currentTarget.className += " active";
	    }
	</script>
	<script>
	    // Get the element with id="defaultOpen" and click on it
	    document.getElementById("defaultOpen").click();
	</script>
@endsection