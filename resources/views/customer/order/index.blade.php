@extends('customer-layouts.app')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('assets/customer/css/promotion_page.css')}}">
    <style>
        .orer-btn {
            width: 100%;
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-bottom: 10px;
        }

        .orer-btn h3 {
            width: 100%;
            display: flex;
            justify-content: space-between;
        }

        .btn-current-event {
            flex: 1; /* Each button takes equal width */
            padding: 12px 20px;
            border-radius: 50px;
            border: none;
            font-size: 12px;
            font-weight: 500;
            font-family: 'Poppins', sans-serif; /* Keeps consistency */
            font-weight: bold;
            cursor: pointer;
        }

        .btn-current-event.active {
            background-color: blue;
            color: white;
        }

        .btn-current-event:not(.active) {
            background-color: white;
            color: #6F70C2; /* Adjusted color */
            border: 2px solid #E5E7EB; /* Light border for unselected */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .btn-current-event:first-child {
            margin-right: 10px; /* Adds space only between buttons */
        }

        /* Order history css */
        .tabcontent{
            position: relative;  
            background: white;
            padding: 5px 5px;
            border-radius: 12px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            width: 100%;  /* Ensures it takes full width */
            margin-bottom: 15px;    
            display: flex;
            flex-direction: column;
            align-items: center; /* Centers children */
        }
        .tabcontent .order-border1{
            background: white;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0px 2px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 10px;
            position: relative;
            width: 100%; /* Restrict width */
            box-sizing: border-box; /* Ensures padding doesn't increase width */
        }
        /* Fix Bootstrap .row behavior */
        .row1 {
            display: flex;
            flex-direction: column; /* Ensures items stay stacked */
            align-items: center; /* Centers children */
            width: 100%;
        }

        /* --- */
        /* Container */
        .order-card {
            background-color: white;
            box-shadow: 0px 2px 8px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            display: flex;
            flex-direction: column;
            gap: 4px;
            padding: 10px;
            font-family: "Poppins", sans-serif;
            width: 100%; /* Adjust width */
        }

        /* Header */
        .order-header {
            display: flex;
            justify-content: space-between;
            font-size: 14px;
            color: #666;
        }

        .order-payment a {
            color: #007bff;
            text-decoration: none;
            font-weight: 500;
        }

        /* Body */
        .order-body {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .order-number {
            color: #6F70C2;
            text-decoration: none;
            font-weight: bold;
            font-size: 14px;
            font-family: 'Poppins', sans-serif;
        }

        .order-price {
            font-weight: bold;
            font-size: 16px;
        }

        /* Footer */
        .order-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .order-status {
            font-family: 'Poppins', sans-serif; /* Keeps consistency */
            display: flex;
            align-items: center;
            color: #438F00;
            font-weight: bold;
            font-size: 12px;
            /* text-transform: lowercase; */
        }
        .order-status-danger {
            font-family: 'Poppins', sans-serif; /* Keeps consistency */
            display: flex;
            align-items: center;
            color: #FC0000;
            font-weight: bold;
            font-size: 12px;
            /* text-transform: lowercase; */
        }

        .status-dot {
            width: 8px;
            height: 8px;
            background-color: #4caf50;
            border-radius: 50%;
            display: inline-block;
            margin-right: 5px;
        }
        .status-dot-danger {
            width: 8px;
            height: 8px;
            background-color: #FC0000;
            border-radius: 50%;
            display: inline-block;
            margin-right: 5px;
        }

        .order-details {
            font-family: 'Poppins', sans-serif; /* Keeps consistency */
            font-size: 12px;
            font-weight: bold;
            color: #007bff;
            text-decoration: none;
        }

        /* Responsive */
        @media (max-width: 480px) {
            .order-card {
                max-width: 100%;
            }
            .order-body, .order-footer {
                flex-direction: row;
                align-items: flex-start;
            }
        }

    </style>
@endsection

@section('content')
    <section class="dash-body-ar wd-dr-dash-inner">
        <div class="wrp-ar-nav-body">
            @include('customer-layouts.navbar')
            <div id="chatdesk" class="chart-board ">
                <div class="row">
                    @include('customer.messages')
                    <div class="col-xl-8 col-lg-12 col-md-12">
                        <div class="content">
                            <!-- Tab links --> 
                                <h3 class="orer-btn mb-4">
                                    <button class="tablinks btn-current-event active" onclick="openCity(event, 'Current')" id="defaultOpen">
                                        Current Order
                                    </button>
                                    <button class="tablinks btn-current-event" onclick="openCity(event, 'Past')">
                                        Past Order
                                    </button>
                                </h3> 
                            
                            <!-- Tab links -->
                            <!-- Tab content -->
                            <div id="Current" class="tabcontent">
                                @foreach ($currentOrders as $currentOrder)
                                <div class="order-card mb-3">
                                    <div class="order-header">
                                        <span class="order-date">{{ date('M d, Y', strtotime($currentOrder->order_date)) }} | <span class="order-payment"> <a href="#">{{ !isset($currentOrder->payment_card_id) ? 'Cash' : 'Card'}}</a> </span></span>
                                        <span class="pickup-time">Pickup : {{ $currentOrder->isPickUp == 1 ? date("h:i A", strtotime($currentOrder->pickup_time)) : '00:00' }}</span>
                                    </div>
                                    <div class="order-body">
                                        <a href="#" class="order-number">{{ $currentOrder->order_number }}</a>
                                        <span class="order-price">${{ $currentOrder->grand_total }}</span>
                                    </div>
                                    <div class="order-footer">
                                        @if($currentOrder->order_progress_status == 'CANCEL')
                                            <span class="order-status-danger">
                                                <span class="status-dot-danger"></span> {{ ucfirst(strtolower($currentOrder->order_progress_status)) }}
                                            </span>
                                        @else
                                            <span class="order-status">
                                                <span class="status-dot"></span> {{ ucfirst(strtolower($currentOrder->order_progress_status)) }}
                                            </span>
                                        @endif
                                        {{-- <span class="order-status">
                                            <span class="status-dot"></span> {{ $currentOrder->order_progress_status }}
                                        </span> --}}
                                        <a href="{{ route('customer.orders.details', $currentOrder->order_id) }}" class="order-details">Details</a>
                                    </div>
                                </div> 
                                @endforeach
                            </div>

                            <div id="Past" class="tabcontent">
                                @foreach ($pastOrders as $pastOrder)
                                    <div class="order-card mb-3">
                                        <div class="order-header">
                                            <span class="order-date">{{ date('M d, Y', strtotime($pastOrder->order_date)) }} | <span class="order-payment"> <a href="#">{{ !isset($pastOrder->payment_card_id) ? 'Cash' : 'Card'}}</a> </span></span>
                                            <span class="pickup-time">Pickup : {{ $pastOrder->isPickUp == 1 ? date("h:i A", strtotime($pastOrder->pickup_time)) : '00:00' }}</span>
                                        </div>
                                        <div class="order-body">
                                            <a href="#" class="order-number">{{ $pastOrder->order_number }}</a>
                                            <span class="order-price">${{ $pastOrder->grand_total }}</span>
                                        </div>
                                        <div class="order-footer">
                                                @if($pastOrder->order_progress_status == 'CANCEL')
                                                    <span class="order-status-danger">
                                                        <span class="status-dot-danger"></span> {{ ucfirst(strtolower($pastOrder->order_progress_status)) }}
                                                    </span>
                                                @else
                                                    <span class="order-status">
                                                        <span class="status-dot"></span> {{ ucfirst(strtolower($pastOrder->order_progress_status)) }}
                                                    </span>
                                                @endif
                                            <a href="{{ route('customer.orders.details', $pastOrder->order_id) }}" class="order-details">Details</a>
                                        </div>
                                    </div> 
                                    {{-- <div class="row order-border" style="top:-16px !important;">
                                        <div class="col-sm-4 for-right-border">
                                            <h3>{{ $pastOrder->order_number }}</h3>
                                        </div>
                                        <div class="col-sm-3 for-right-border">
                                            <h3>{{ date('M d,Y', strtotime($pastOrder->order_date)) }}</h3>
                                        </div>
                                        <div class="col-sm-2 for-right-border">
                                            <h3 class="orderi-no">
                                                <ul>
                                                    <li>
                                                        {{ $pastOrder->order_progress_status }}
                                                    </li>
                                                </ul>
                                            </h3>
                                        </div>
                                        <div class="col-sm-1 for-right-border">
                                            <h3 class="orderi-no">${{ $pastOrder->grand_total }}</h3>
                                        </div>
                                        <div class="col-sm-1 info">
                                            <a href="{{ route('customer.orders.details', $pastOrder->order_id) }}"
                                                alt="Information">
                                                <img src="{{ asset('assets/customer/images/information.png') }}">
                                            </a>
                                        </div>
                                    </div> --}}
                                @endforeach
                            </div>
                        </div>
                    </div>
                    {{-- @include('customer-layouts.right-sidebar') --}}
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        function openCity(evt, cityName) {
            
            let tabs = document.querySelectorAll(".tablinks");
            tabs.forEach(btn => btn.classList.remove("active"));

            evt.currentTarget.classList.add("active");
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
    <script src="{{ asset('/assets/js/firebase.js') }}"></script>
    <script>
    $('document').ready(function() {
            var config = {
                apiKey: "{{config('services.firebase.apiKey')}}",
                authDomain: "{{config('services.firebase.authDomain')}}",
                databaseURL: "{{config('services.firebase.databaseURL')}}",
                projectId: "{{config('services.firebase.projectId')}}",
                storageBucket: "{{config('services.firebase.storageBucket')}}",
                messagingSenderId: "{{config('services.firebase.messagingSenderId')}}",
                appId : "{{config('services.firebase.appId')}}",
                measurementId : "{{config('services.firebase.measurementId')}}",
            };
            firebase.initializeApp(config);


            const messaging = firebase.messaging();


            messaging.onMessage(function(payload) {
                console.log("Message received.", payload);
                const noteTitle = payload.notification.title;
                const noteOptions = {
                    body: payload.notification.body,
                    icon: payload.notification.icon,
                };

                new Notification(noteTitle, noteOptions);
            });
    });

    </script>
@endsection
