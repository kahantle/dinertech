@extends('customer-layouts.app')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('assets/customer/css/promotion_page.css')}}">
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
                            <div class="tab">
                                <h3>
                                    <button class="tablinks btn-current-event" onclick="openCity(event, 'Current')"
                                        id="defaultOpen" alt="Current Order">Current Order</button>
                                    <button class="tablinks btn-current-event" onclick="openCity(event, 'Past')"
                                        style="margin-left: -40px;" alt="Past Order">Past Order</button>
                                </h3>
                            </div>
                            <!-- Tab links -->
                            <!-- Tab content -->
                            <div id="Current" class="tabcontent">
                                @foreach ($currentOrders as $currentOrder)
                                    <div class="row order-border" style="top:-16px !important;">
                                        <div class="col-sm-3 for-right-border">
                                            {{-- <img src="images/Logo-small.png"> --}}
                                            <h3 class="orderi-no">{{ $currentOrder->order_number }}</h3>
                                        </div>
                                        <div class="col-sm-2 for-right-border">
                                            {{-- <h3>July 4,2014</h3> --}}
                                            <h3 class="orderi-no">
                                                {{ date('M d,Y', strtotime($currentOrder->order_date)) }}</h3>
                                        </div>
                                        <div class="col-sm-3 for-right-border">
                                            @if ($currentOrder->isPickUp == 1)
                                                <h3 class="orderi-no">Pickup :- {{ $currentOrder->pickup_time }}</h3>
                                            @else
                                                <h3 class="orderi-no">Pickup :- 00:00</h3>
                                            @endif
                                        </div>
                                        <div class="col-sm-2 for-right-border">
                                            <h3>
                                                <ul>
                                                    <li>
                                                        {{ $currentOrder->order_progress_status }}
                                                    </li>
                                                </ul>
                                            </h3>
                                        </div>
                                        <div class="col-sm-1 for-right-border">
                                            <h3 class="orderi-no">${{ $currentOrder->grand_total }}</h3>
                                        </div>
                                        <div class="col-sm-1 info">
                                            <a href="{{ route('customer.orders.details', $currentOrder->order_id) }}"
                                                alt="Information">
                                                <img src="{{ asset('assets/customer/images/information.png') }}">
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div id="Past" class="tabcontent">
                                @foreach ($pastOrders as $pastOrder)
                                    <div class="row order-border" style="top:-16px !important;">
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
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @include('customer-layouts.right-sidebar')
                </div>
            </div>
        </div>
    </section>
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
