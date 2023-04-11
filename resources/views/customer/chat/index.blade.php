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
                                                                    <button class="submit sendToken sendMessage" alt="Submit"
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
                                                                    <button class="submit sendToken sendMessage" data-orderid="{{ $orderId['order_id'] }}" alt="Submit"><i
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
    $("#message-output").keyup(function(){
        var getMessage = $('#message-output').val();
        var getdata = wordFilter(getMessage);
        $('#message-output').val(getdata);
    });

    function wordFilter(str) {
       var filterWords = ["4r5e", "5h1t", "5hit", "a55", "anal", "anus", "ar5e", "arrse", "arse", "ass", "ass-fucker", "asses", "assfucker", "assfukka", "asshole", "assholes", "asswhole", "a_s_s", "b!tch", "b00bs", "b17ch", "b1tch", "ballbag", "balls", "ballsack", "bastard", "beastial", "beastiality", "bellend", "bestial", "bestiality", "bi+ch", "biatch", "bitch", "bitcher", "bitchers", "bitches", "bitchin", "bitching", "bloody", "blow job", "blowjob", "blowjobs", "boiolas", "bollock", "bollok", "boner", "boob", "boobs", "booobs", "boooobs", "booooobs", "booooooobs", "breasts", "buceta", "bugger", "bum", "bunny fucker", "butt", "butthole", "buttmuch", "buttplug", "c0ck", "c0cksucker", "carpet muncher", "cawk", "chink", "cipa", "cl1t", "clit", "clitoris", "clits", "cnut", "cock", "cock-sucker", "cockface", "cockhead", "cockmunch", "cockmuncher", "cocks", "cocksuck", "cocksucked", "cocksucker", "cocksucking", "cocksucks", "cocksuka", "cocksukka", "cok", "cokmuncher", "coksucka", "coon", "cox", "crap", "cum", "cummer", "cumming", "cums", "cumshot", "cunilingus", "cunillingus", "cunnilingus", "cunt", "cuntlick", "cuntlicker", "cuntlicking", "cunts", "cyalis", "cyberfuc", "cyberfuck", "cyberfucked", "cyberfucker", "cyberfuckers", "cyberfucking", "d1ck", "damn", "dick", "dickhead", "dildo", "dildos", "dink", "dinks", "dirsa", "dlck", "dog-fucker", "doggin", "dogging", "donkeyribber", "doosh", "duche", "dyke", "ejaculate", "ejaculated", "ejaculates", "ejaculating", "ejaculatings", "ejaculation", "ejakulate", "f u c k", "f u c k e r", "f4nny", "fag", "fagging", "faggitt", "faggot", "faggs", "fagot", "fagots", "fags", "fanny", "fannyflaps", "fannyfucker", "fanyy", "fatass", "fcuk", "fcuker", "fcuking", "feck", "fecker", "felching", "fellate", "fellatio", "fingerfuck", "fingerfucked", "fingerfucker", "fingerfuckers", "fingerfucking", "fingerfucks", "fistfuck", "fistfucked", "fistfucker", "fistfuckers", "fistfucking", "fistfuckings", "fistfucks", "flange", "fook", "fooker", "fuck", "fucka", "fucked", "fucker", "fuckers", "fuckhead", "fuckheads", "fuckin", "fucking", "fuckings", "fuckingshitmotherfucker", "fuckme", "fucks", "fuckwhit", "fuckwit", "fudge packer", "fudgepacker", "fuk", "fuker", "fukker", "fukkin", "fuks", "fukwhit", "fukwit", "fux", "fux0r", "f_u_c_k", "gangbang", "gangbanged", "gangbangs", "gaylord", "gaysex", "goatse", "God", "god-dam", "god-damned", "goddamn", "goddamned", "hardcoresex", "heshe", "hoar", "hoare", "hoer", "homo", "hore", "horniest", "horny", "hotsex", "jack-off", "jackoff", "jap", "jerk-off", "jism", "jiz", "jizm", "jizz", "kawk", "knob", "knobead", "knobed", "knobend", "knobhead", "knobjocky", "knobjokey", "kock", "kondum", "kondums", "kum", "kummer", "kumming", "kums", "kunilingus", "l3i+ch", "l3itch", "labia", "lust", "lusting", "m0f0", "m0fo", "m45terbate", "ma5terb8", "ma5terbate", "masochist", "master-bate", "masterb8", "masterbat*", "masterbat3", "masterbate", "masterbation", "masterbations", "masturbate", "mo-fo", "mof0", "mofo", "mothafuck", "mothafucka", "mothafuckas", "mothafuckaz", "mothafucked", "mothafucker", "mothafuckers", "mothafuckin", "mothafucking", "mothafuckings", "mothafucks", "mother fucker", "motherfuck", "motherfucked", "motherfucker", "motherfuckers", "motherfuckin", "motherfucking", "motherfuckings", "motherfuckka", "motherfucks", "muff", "mutha", "muthafecker", "muthafuckker", "muther", "mutherfucker", "n1gga", "n1gger", "nazi", "nigg3r", "nigg4h", "nigga", "niggah", "niggas", "niggaz", "nigger", "niggers", "nob", "nob jokey", "nobhead", "nobjocky", "nobjokey", "numbnuts", "nutsack", "orgasim", "orgasims", "orgasm", "orgasms", "p0rn", "pawn", "pecker", "penis", "penisfucker", "phonesex", "phuck", "phuk", "phuked", "phuking", "phukked", "phukking", "phuks", "phuq", "pigfucker", "pimpis", "piss", "pissed", "pisser", "pissers", "pisses", "pissflaps", "pissin", "pissing", "pissoff", "poop", "porn", "porno", "pornography", "pornos", "prick", "pricks", "pron", "pube", "pusse", "pussi", "pussies", "pussy", "pussys", "rectum", "retard", "rimjaw", "rimming", "s hit", "s.o.b.", "sadist", "schlong", "screwing", "scroat", "scrote", "scrotum", "semen", "sex", "sh!+", "sh!t", "sh1t", "shag", "shagger", "shaggin", "shagging", "shemale", "shi+", "shit", "shitdick", "shite", "shited", "shitey", "shitfuck", "shitfull", "shithead", "shiting", "shitings", "shits", "shitted", "shitter", "shitters", "shitting", "shittings", "shitty", "skank", "slut", "sluts", "smegma", "smut", "snatch", "son-of-a-bitch", "spac", "spunk", "s_h_i_t", "t1tt1e5", "t1tties", "teets", "teez", "testical", "testicle", "tit", "titfuck", "tits", "titt", "tittie5", "tittiefucker", "titties", "tittyfuck", "tittywank", "titwank", "tosser", "turd", "tw4t", "twat", "twathead", "twatty", "twunt", "twunter", "v14gra", "v1gra", "vagina", "viagra", "vulva", "w00se", "wang", "wank", "wanker", "wanky", "whoar", "whore", "willies", "willy", "xrated", "xxx"];
        var rgx = new RegExp(filterWords.join("|"), "gi");
        return str.replace(rgx, "");
    }
    </script>
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

        //Push Notification
        const messaging = firebase.messaging();

        $(document).on("click",".sendToken",function(){
            messaging
                .requestPermission()
                .then(function() {
                    return messaging.getToken()
                })
                .then(function(response) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: '{{ route("customer.store.token") }}',
                        type: 'POST',
                        data: {
                            token: response
                        },
                        dataType: 'JSON',
                        success: function(response) {
                            console.log('Token stored.');
                        },
                        error: function(error) {
                            console.log(error);
                        },
                    });
                }).catch(function(error) {
                    alert(error);
                });
        });
        messaging.onMessage(function(payload) {
            const noteTitle = payload.notification.title;
            const noteOptions = {
                body: payload.notification.body,
                icon: payload.notification.icon,
            };
            new Notification(noteTitle, noteOptions);
        });


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
