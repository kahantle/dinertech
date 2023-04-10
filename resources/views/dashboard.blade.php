@extends('layouts.app')
@section('content')
    <style type="text/css">
        .disabled {
            opacity: 0.2;
        }

    </style>
    <section id="wrapper">
        @include('layouts.sidebar')
        <div id="navbar-wrapper">
            <nav class="navbar navbar-inverse">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <div class="profile-title-new">
                            <a href="#" class="navbar-brand" id="sidebar-toggle"><i class="fa fa-bars"></i></a>
                            <h2>Recent Orders</h2>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
        <div class="dashboard category content-wrapper pt-1" id="recent-order">
            <div class="dash-second">
                <div class="container-fluid">
                    {{-- <div class="row">
                        <div class="col-lg-12"> --}}
                            @if ($orders)
                                {{-- <div class="orders order-blogs-inner"> --}}
                                    @foreach ($orders as $key => $order)
                                        <div class="recent-order-blog">
                                            <div class="row">
                                                <div class="col-md-12 d-flex justify-content-between">
                                                    <div class="order-recent-new {{($order->order_progress_status == Config::get('constants.ORDER_STATUS.ORDER_DUE')) ? 'order-recent-red' : 'order-new-green'}}" id="change-color-{{$order->order_id}}">
                                                        <h4>{{ $order->user->full_name }}</h4>
                                                        <span>ORDER:#{{ $order->order_number }}</span>
                                                    </div>
                                                    <div class="order-recent-pickup">
                                                        @if ($order->stripe_payment_id)
                                                            <button class="disabled-order-print">
                                                                <img src="{{ asset('assets/images/cash-payment.png')}}" class="img-fluid icon icon-print">
                                                                <p>Order Paid</p>
                                                            </button>
                                                        @endif
                                                        @if ($order->order_status == '')
                                                            <a href="javaScript:void(0);" data-route="{{ route('action.order', [$order->order_id, 'action' => 'ACCEPTED']) }}" class="action" data-value="Accept">
                                                                <button data-toggle="tooltip" title="Accept Order!" class="btn-success">
                                                                    <img src="{{ asset('assets/images/order-checkmark.png')}}">
                                                                    <p>Accept</p>
                                                                </button>
                                                            </a>

                                                            <a href="javaScript:void(0);" data-route="{{ route('action.order', [$order->order_id, 'action' => 'CANCEL']) }}" class="action" data-value="Cancel">
                                                                <button href="javaScript:void(0);" data-toggle="tooltip"
                                                                    title="Decline Order!" class="action btn-danger" data-value="Cancel">
                                                                        <img src="{{ asset('assets/images/order-close.png')}}">
                                                                        <p>Reject</p>
                                                                </button>
                                                            </a>
                                                        @else
                                                            @if ($order->order_progress_status != Config::get('constants.ORDER_STATUS.ORDER_DUE'))
                                                                <div class="order-timer order-time-{{$order->order_id}}" data-pickup="{{ date_format(date_create($order->pickup_time), "Y-m-d H:i:s") }}" data-pickup-minutes="{{$order->pickup_minutes}}" data-orderId="{{$order->order_id}}"></div>
                                                            @else
                                                                <button class="btn-danger btn-due-blog">
                                                                    ORDER DUE
                                                                </button>
                                                            @endif
                                                        @endif

                                                        <button class="disabled-order-print">
                                                            <img src="{{ asset('assets/images/food-delivery-hand.png')}}" class="img-fluid icon icon-print">
                                                            <p>Pickup</p>
                                                        </button>

                                                        @if ($order->order_status == '')
                                                            <button class="disabled-order-print text-disabled">
                                                                    <img src="{{ asset('assets/images/disable-food-delivery.png')}}">
                                                                    <p>Order Ready</p>
                                                            </button>
                                                        @else
                                                            <button class="disabled-order-print">
                                                                <img src="{{ asset('assets/images/food-delivery.png')}}">
                                                                <p>Order Ready</p>
                                                            </button>
                                                        @endif

                                                        @if ($order->order_status == '')
                                                            <button class="disabled-order-print text-disabled">
                                                                <img src="{{ asset('assets/images/disabl-order-msg-message.png')}}">
                                                                <p>Chat</p>
                                                            </button>
                                                        @else
                                                            <a href="{{ route('chat', ['order_number' => $order->order_number]) }}">
                                                                <button class="disabled-order-print recent-order-chat">
                                                                    <img src="{{ asset('assets/images/order-msg-message.png')}}">
                                                                    <span class="chat-count" id="chat-{{$order->order_id}}" data-orderNumber="{{$order->order_number}}" data-orderId="{{$order->order_id}}" data-userId="{{$order->uid}}">0</span>
                                                                    <p>Chat</p>
                                                                </button>
                                                            </a>
                                                        @endif

                                                        @if ($order->order_status == '')
                                                            <button class="disabled-order-print text-disabled">
                                                                <img src="{{ asset('assets/images/diasble-print.png')}}">
                                                                <p>Print</p>
                                                            </button>
                                                        @else
                                                            <a href="javaScript:void(0);"
                                                                onclick="printJS('{{ route('order.pdf', $order->order_id) }}')"
                                                                data-toggle="tooltip" title="Print Order Receipt!"
                                                                class="">
                                                                <button class="disabled-order-print">
                                                                    <img src="{{ asset('assets/images/print.png')}}">
                                                                    <p>Print</p>
                                                                </button>
                                                            </a>
                                                        @endif

                                                        <a href="{{ route('details', $order->order_id) }}">
                                                            <button  data-toggle="tooltip"
                                                            title="Order details!" class="disabled-order-print">
                                                                <p>order</p><p> details</p>
                                                            </button>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    <div class="w-100 pagination-links"> {{ $orders->links() }}</div>
                            @else
                                    <p>No records found.</p>
                                {{-- </div> --}}
                            @endif
                        {{-- </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </section>
    <div id="openTimePicker" class="openTimePickerPopUp closeAllModal overlay w-100">
        <div class="popup text-center">
            {{ Form::open(['id' => 'orderTimePickup', 'method' => 'POST', 'class' => '']) }}
            <a class="close closeModal" href="javaScript:void(0);">&times;</a>
            <div class="content">
                <h5 class="groupHeading">Pickup Time</h5>
                <div class="row m-0">
                    <div class="form-group input-group">
                        <select class="form-control sltDuration " id="sltDuration" name="sltDuration">
                            <option value="">Duration</option>
                            @for ($i = 1; $i <= 60; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                        <div class="input-group-append">
                            <span class="input-group-text">Minutes</span>
                        </div>
                    </div>
                    <input type="hidden" id="actionUrl" name="actionUrl" class="actionUrl" />
                    <input type="hidden" id="pickUpTime" name="pick_up_time" />
                </div>
            </div>
            <div class="btn-custom">
                <button class="groupBtn acceptOrder btn-blue"><span>Order Accept</span></button>
            </div>
            </form>
        </div>
    </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
    <script src="{{ asset('/assets/js/order.js') }}"></script>
    <script src="{{ asset('/assets/js/firebase.js') }}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\VerifyRequest', '#verifyForm') !!}
    {!! JsValidator::formRequest('App\Http\Requests\PickTimeRequest', '#orderTimePickup') !!}
    <script type="text/javascript">
        var db_name = "{{ Config::get('constants.FIREBASE_DB_NAME') }}";
        var restaurant_id = {!! json_encode($restaurantId) !!};

        $('document').ready(function() {

            setInterval(() => {
                chatCount();
            }, 1000);

            // Initialize Firebase
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

            function chatCount() {
                $(".chat-count").each(function() {
                    var orderId = $(this).attr('data-orderId');
                    var orderNumber = $(this).attr('data-orderNumber');
                    var customer_id = $(this).attr('data-userId');
                    var url = '/' + db_name + '/' + restaurant_id + '/' + orderNumber + '/' + customer_id;


                    firebase.database().ref(url).on('value', function(snapshot) {
                        console.log(snapshot.val());
                        var value = snapshot.val();
                        var count = 0;
                        $.each(value, function(index, value) {
                            if (value.sent_from == 'CUSTOMER' && value.isseen == false) {
                                count++;
                            }
                        });
                        $("#chat-" + orderId).html(count);
                        if (count > 0) {
                            $("#chat-" + orderId).parent().css("background-color", "#007bff");
                            $("#chat-" + orderId).parent().css("color", "#ffff");
                        }
                    });
                });
            }


        });

        / Get Unread Count /



    </script>
@endsection
