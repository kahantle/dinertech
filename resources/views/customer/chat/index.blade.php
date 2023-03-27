@extends('customer-layouts.app')

@section('css')

@endsection

@section('content')
    <section class="dash-body-ar wd-dr-dash-inner">
        <div class="wrp-ar-nav-body">
            @include('customer-layouts.navbar')
            @if (isMobile())
                <!-- Mobile -->
                <div id="chatdesk" class="chart-board chat-mobile">
                    <div class="row">
                        <div class="col-xl-8 col-lg-12 col-md-12 chatting-u-blog">
                            <div class="content">
                                <div class="container-fluid">
                                    <h2 class="mb-3">Chat</h2>
                                    @empty(!$orderIds)
                                        <div class="row">
                                            <div class="col-lg-5 chat-inner-left-blog scrollbar-first wd-sl-left-wrapper"
                                                id="style-4">
                                                <ul class="nav nav-tabs tabs-left sideways">
                                                    @foreach ($orderIds as $key => $orderId)
                                                        @php
                                                            if ($key == 0) {
                                                                $active = 'active';
                                                            } else {
                                                                $active = '';
                                                            }
                                                        @endphp
                                                        <li>
                                                            <a href="#chat-{{ $orderId['order_id'] }}" data-toggle="tab"
                                                                class="{{ $active }} click-chat odrdetail"
                                                                data-orderid="{{ $orderIds['order_id'] }}">
                                                                <img src="{{ empty(Auth::user()->profile_image) ? asset('assets/customer/images/Logo-Round.png') : route('display.image', [Config::get('constants.IMAGES.USER_IMAGE_PATH'), Auth::user()->profile_image]) }}"
                                                                    class="img-fluid">
                                                                <div class="d-flex flex-column">
                                                                    <span>{{ $orderId['order_id'] }}</span>
                                                                    <span>{{ $orderId['message_date'] }}</span>
                                                                </div>
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                            <div class="col-lg-7 chatting-u-left order-bxx-gn">
                                                <div class="back-icon">
                                                    <i class="fas fa-arrow-left bkorderdetail"></i>
                                                    <p class="order-no"></p>
                                                </div>
                                                <!-- Tab panes -->
                                                <div class="tab-content">
                                                    @foreach ($orderIds as $key => $orderId)
                                                        @php
                                                            if ($key == 0) {
                                                                $active = 'active';
                                                            } else {
                                                                $active = '';
                                                            }
                                                        @endphp
                                                        <div class="tab-pane {{ $active }}"
                                                            id="chat-{{ $orderId['order_id'] }}">
                                                            <div class="messages" id="style-4">
                                                                <ul class="chats"></ul>
                                                            </div>
                                                            <div class="message-input">
                                                                <div class="wrap">
                                                                    <input type="text" placeholder="Input Message"
                                                                        class="form-control mobileMessage-{{ $orderId['order_id'] }} voice-message{{ $orderId['order_id'] }}"
                                                                        id="message-output"
                                                                        data-orderid="{{ $orderId['order_id'] }}">
                                                                    <button class="submit sendMessage" alt="Submit"
                                                                        data-orderid="{{ $orderId['order_id'] }}"><i
                                                                            class="fa fa-paper-plane"
                                                                            aria-hidden="true"></i></button>
                                                                    <button class="submit micro start" alt="Micro"
                                                                        data-orderid="{{ $orderId['order_id'] }}"
                                                                        id="start{{ $orderId['order_id'] }}"><i
                                                                            class="fa fa-microphone"
                                                                            aria-hidden="true"></i></button>
                                                                    <button class="submit micro pause d-none" alt="Micro"
                                                                        data-orderid="{{ $orderId['order_id'] }}"
                                                                        id="stop{{ $orderId['order_id'] }}"><i
                                                                            class="fa fa-pause"
                                                                            aria-hidden="true"></i></button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                    @endempty
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <!-- Descktop -->
                <div id="chatdesk" class="chart-board chat-desktop">
                    @include('customer.messages')
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 chatting-u-blog">
                            <div class="content">
                                <div class="container-fluid">
                                    <h2 class="mb-3">Chat</h2>
                                    @empty(!$orderIds)
                                        <div class="row">
                                            <div class="col-lg-5 chat-inner-left-blog scrollbar-first" id="style-4">
                                                <ul class="nav nav-tabs tabs-left sideways">
                                                    @foreach ($orderIds as $key => $orderId)
                                                        @php
                                                            if ($key == 0) {
                                                                $active = 'active';
                                                                $class = 'getChat';
                                                            } else {
                                                                $active = '';
                                                                $class = '';
                                                            }
                                                        @endphp
                                                        <li>
                                                            <a href="#chat-{{ $orderId['order_id'] }}" data-toggle="tab"
                                                                class="{{ $active }} {{ $class }} click-chat"
                                                                data-orderid="{{ $orderId['order_id'] }}">
                                                                <img src="{{ empty(Auth::user()->profile_image) ? asset('assets/customer/images/Logo-Round.png') : route('display.image', [Config::get('constants.IMAGES.USER_IMAGE_PATH'), Auth::user()->profile_image]) }}"
                                                                    class="img-fluid">
                                                                <div class="d-flex flex-column">
                                                                    <span>{{ $orderId['order_id'] }}</span>
                                                                    <span>{{ $orderId['message_date'] }}</span>
                                                                </div>
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                            <div class="col-lg-7 chatting-u-left">
                                                <!-- Tab panes -->
                                                <div class="tab-content">
                                                    @foreach ($orderIds as $key => $orderId)
                                                        @php
                                                            if ($key == 0) {
                                                                $active = 'active';
                                                            } else {
                                                                $active = '';
                                                            }
                                                        @endphp
                                                        <div class="tab-pane {{ $active }}"
                                                            id="chat-{{ $orderId['order_id'] }}">
                                                            <div class="messages" id="style-4">
                                                                <ul class="chats"></ul>
                                                            </div>
                                                            <div class="message-input">
                                                                <div class="wrap">
                                                                    <input type="text" value="" placeholder="Input Message"
                                                                        class="form-control desktopMessage voice-message{{ $orderId['order_id'] }}"
                                                                        id="message-output">
                                                                    <button class="submit sendMessage" data-orderid="{{ $orderId['order_id'] }}" alt="Submit"><i
                                                                            class="fa fa-paper-plane"
                                                                            aria-hidden="true"></i></button>
                                                                    <button class="submit micro start" alt="Micro"
                                                                        data-orderid="{{ $orderId['order_id'] }}"
                                                                        id="start{{ $orderId['order_id'] }}"><i
                                                                            class="fa fa-microphone"
                                                                            aria-hidden="true"></i></button>
                                                                    <button class="submit micro pause d-none" alt="Micro"
                                                                        data-orderid="{{ $orderId['order_id'] }}"
                                                                        id="stop{{ $orderId['order_id'] }}"><i
                                                                            class="fa fa-pause"
                                                                            aria-hidden="true"></i></button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                    @endempty
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection

@section('scripts')
    <script src="{{ asset('assets/customer/js/custom-js/chat/index.js') }}"></script>
    <script src="{{ asset('/assets/js/firebase.js') }}"></script>
    <script>
    // var config = {
    //     apiKey: "{{config('services.firebase.api_key')}}",
    //     authDomain: "{{config('services.firebase.auth_domain')}}",
    //     databaseURL: "{{config('services.firebase.database_url')}}",
    //     projectId: "{{config('services.firebase.project_id')}}",
    //     storageBucket: "{{config('services.firebase.storage_bucket')}}",
    //     messagingSenderId: "{{config('services.firebase.messaging_sender_id')}}"
    // };

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



        var order_id = $(".getChat").attr('data-orderid');

        var customer_id = '{{ auth()->user()->uid }}';

        var restaurantImage = '{{ asset('assets/customer/images/Logo-Round.png') }}';
        var customerImage =
            '{{ route('display.image', [Config::get('constants.IMAGES.USER_IMAGE_PATH'), Auth::user()->profile_image]) }}';
        if (!customerImage) {
            customerImage = '{{ asset('assets/customer/images/user-small.png') }}';
        }
        var db_name = "{{ Config::get('constants.FIREBASE_DB_NAME') }}";
        var resturant_id = {!! json_encode($resturantId) !!};
        var url = '/' + db_name + '/' + resturant_id + '/' + order_id + '/' + customer_id;

        $(".chats").html("<h5>No Conversion Found.</h5>");
        firebase.database().ref(url).on('value', function(snapshot) {
            var chat_element = "";
            var chats = snapshot.val();
            $.each(chats, function(index, value) {
                if (value.sent_from) {
                    if (value.sent_from == 'RESTAURANT') {
                        chat_element += ' <li class="sent">';
                        chat_element +=
                            '<img src=' + restaurantImage + ' class="img-fluid">';
                        chat_element += '       <p>' + value.message;
                        chat_element += '        <span>' + value.message_date + '</span>';
                        chat_element += '</p>';

                        chat_element += '    </li>'
                    } else {
                        chat_element += ' <li class="replies">';
                        chat_element += '       <p>' + value.message;
                        chat_element += '        <span>' + value.message_date + '</span>';
                        chat_element += '  </p>';
                        chat_element +=
                            '      <img src=' + customerImage + ' class="img-fluid">';
                        chat_element += '    </li>'
                    }
                    $(".chats").html(chat_element);
                    $("#message-output").val('');
                    lastIndex = index;
                }
            });
        });

        $(".click-chat").on("click", function() {
            order_id = $(this).data('orderid');
            $(".chats").html('');
            $(".order-no").html(order_id);
            var url = '/' + db_name + '/' + resturant_id + '/' + order_id + '/' + customer_id;
            firebase.database().ref(url).on('value', function(snapshot) {
                var chat_element = "";
                var chats = snapshot.val();

                $(".chats").html("<h5>No Conversion Found.</h5>");
                $.each(chats, function(index, value) {

                    if (value.sent_from) {
                        if (value.sent_from == 'RESTAURANT') {
                            chat_element += ' <li class="sent">';
                            chat_element +=
                                '<img src=' + restaurantImage + ' class="img-fluid">';
                            chat_element += '       <p>' + value.message;
                            chat_element += '        <span>' + value.message_date + '</span>';
                            chat_element += '</p>';

                            chat_element += '    </li>'
                        } else {
                            chat_element += ' <li class="replies">';
                            chat_element += '       <p>' + value.message;
                            chat_element += '        <span>' + value.message_date + '</span>';
                            chat_element += '  </p>';
                            chat_element +=
                                '      <img src=' + customerImage + ' class="img-fluid">';
                            chat_element += '    </li>'
                        }

                        // var update_url = '/' + db_name + '/' + resturant_id + '/' + order_id + '/' + index;
                        var update_url = '/' + db_name + '/' + resturant_id + '/' + order_id + '/' +
                            customer_id + '/' + index;

                        // value.isseen = true;
                        var updates = {};
                        updates[update_url] = value;
                        firebase.database().ref(update_url).update({isseen:true});
                        $(".chats").html(chat_element);
                        $("#message-output").val('');
                        lastIndex = index;
                    }
                });
            });
        });
    </script>
@endsection
