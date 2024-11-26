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
              <h2>Messages</h2>
              </div>
            </div>
          </div>
        </nav>
      </div>

  <div class="dashboard category content-wrapper">
    @include('common.flashMessage')
    <div class="container-fluid">
          <div class="row m-0">
            <div class="col-lg-4 p-0">
              <div class="chat-table">
                <div class="chat-search">
                  <i class="fa fa-search searchTextBtn" aria-hidden="true"></i>
                  <input type="search" id="chat-search" class="searchText" value="{{$orderNumber}}" placeholder="Search here">
                </div>
                @foreach($orders as $key=>$item)
                    @if (!empty($last_messages[$key]))
                        <div class="chat-content @if($key==0) active @endif" data-customer_id="{{$item->user->uid}}" data-user_name="{{$item->user->full_name}}" data-order_id="{{$item->order_number}}" data-id="{{$item->order_id}}" >
                        <input type="hidden" name="uid" id="uid" value="{{$item->uid}}">
                            <img src="{{ asset('assets/images/person.png') }}" class="img-fluid">
                            <div class="chat-name">
                                <div class="cn-left">
                                <h6>{{$item->user->full_name}}</h6>
                                <span>{{ empty($last_messages[$key]['value']) ? "" : substr($last_messages[$key]['value'],0,15)."..." }}</span>
                                </div>
                                <div class="cn-right">

                                <h6>{{$item->order_number}}</h6>
                                <i class="{{ $last_messages[$key]['is_seen'] ? 'fa fa-circle text-danger display-1' : '' }}"></i>
                                <span></span>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
              </div>
            </div>
            <div class="col-lg-8 p-0">
              <div class="chat-details ">

                <div class="chat-header ">
                  <div class="ch-left">
                    @if($orders->count())
                    <h5 id="order_user">{{$orders[0]->user->full_name}} </h5>
                    <span id="order_id" >{{$orders[0]->order_number}}</span>
                    @else
                    <h5 id="order_user">-</h5>
                    <span id="order_id" >-</span>
                    @endif
                  </div>
                  <div class="ch-right">
                    <a href="#0"><img src="{{ asset('assets/images/bell.png') }}" class="img-fluid"></a>
                    <a href="#0"><img src="{{ asset('assets/images/exit.png') }}" class="img-fluid"></a>
                  </div>
                </div>

                <div class="chat-area">
                  <ul class="msg-body">
                  </ul>
                </div>

                <div class="chat-footer">
                  <input type="text" id="message" name="message" placeholder="Message">
                  <div class="cf-icon">
                    <input type="hidden" id="customerId">
                    <a href="#0"><img src="{{ asset('assets/images/send.png') }}" class="send-icon sendToken sendMessage"></a>
                    <a href="#0"><img src="{{ asset('assets/images/microphone.png') }}" class="microphone-icon "></a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="chat-links">
            <a href="#0"><img src="{{ asset('assets/images/category-menu-icon.png') }}"></a>
            <a href="#0"><img src="{{ asset('assets/images/chat.png') }}"></a>
            <a href="#0"><img src="{{ asset('assets/images/category-detail.png') }}"></a>
          </div>
        </div>
  </div>
</section>
@endsection
@section('scripts')
<script src="{{asset('/assets/js/chat.js')}}"></script>
<script src="{{asset('/assets/js/firebase.js')}}"></script>
<script>
    $("#message").keyup(function(){
        var getMessage = $('#message').val();
        var getdata = wordFilter(getMessage);
        $('#message').val(getdata);
    });

    function wordFilter(str) {
      var filterWords = ["4r5e", "5h1t", "5hit", "a55", "anal", "anus", "ar5e", "arrse", "arse", "ass", "ass-fucker", "asses", "assfucker", "assfukka", "asshole", "assholes", "asswhole", "a_s_s", "b!tch", "b00bs", "b17ch", "b1tch", "ballbag", "balls", "ballsack", "bastard", "beastial", "beastiality", "bellend", "bestial", "bestiality", "bi+ch", "biatch", "bitch", "bitcher", "bitchers", "bitches", "bitchin", "bitching", "bloody", "blow job", "blowjob", "blowjobs", "boiolas", "bollock", "bollok", "boner", "boob", "boobs", "booobs", "boooobs", "booooobs", "booooooobs", "breasts", "buceta", "bugger", "bum", "bunny fucker", "butt", "butthole", "buttmuch", "buttplug", "c0ck", "c0cksucker", "carpet muncher", "cawk", "chink", "cipa", "cl1t", "clit", "clitoris", "clits", "cnut", "cock", "cock-sucker", "cockface", "cockhead", "cockmunch", "cockmuncher", "cocks", "cocksuck", "cocksucked", "cocksucker", "cocksucking", "cocksucks", "cocksuka", "cocksukka", "cok", "cokmuncher", "coksucka", "coon", "cox", "crap", "cum", "cummer", "cumming", "cums", "cumshot", "cunilingus", "cunillingus", "cunnilingus", "cunt", "cuntlick", "cuntlicker", "cuntlicking", "cunts", "cyalis", "cyberfuc", "cyberfuck", "cyberfucked", "cyberfucker", "cyberfuckers", "cyberfucking", "d1ck", "damn", "dick", "dickhead", "dildo", "dildos", "dink", "dinks", "dirsa", "dlck", "dog-fucker", "doggin", "dogging", "donkeyribber", "doosh", "duche", "dyke", "ejaculate", "ejaculated", "ejaculates", "ejaculating", "ejaculatings", "ejaculation", "ejakulate", "f u c k", "f u c k e r", "f4nny", "fag", "fagging", "faggitt", "faggot", "faggs", "fagot", "fagots", "fags", "fanny", "fannyflaps", "fannyfucker", "fanyy", "fatass", "fcuk", "fcuker", "fcuking", "feck", "fecker", "felching", "fellate", "fellatio", "fingerfuck", "fingerfucked", "fingerfucker", "fingerfuckers", "fingerfucking", "fingerfucks", "fistfuck", "fistfucked", "fistfucker", "fistfuckers", "fistfucking", "fistfuckings", "fistfucks", "flange", "fook", "fooker", "fuck", "fucka", "fucked", "fucker", "fuckers", "fuckhead", "fuckheads", "fuckin", "fucking", "fuckings", "fuckingshitmotherfucker", "fuckme", "fucks", "fuckwhit", "fuckwit", "fudge packer", "fudgepacker", "fuk", "fuker", "fukker", "fukkin", "fuks", "fukwhit", "fukwit", "fux", "fux0r", "f_u_c_k", "gangbang", "gangbanged", "gangbangs", "gaylord", "gaysex", "goatse", "God", "god-dam", "god-damned", "goddamn", "goddamned", "hardcoresex", "heshe", "hoar", "hoare", "hoer", "homo", "hore", "horniest", "horny", "hotsex", "jack-off", "jackoff", "jap", "jerk-off", "jism", "jiz", "jizm", "jizz", "kawk", "knob", "knobead", "knobed", "knobend", "knobhead", "knobjocky", "knobjokey", "kock", "kondum", "kondums", "kum", "kummer", "kumming", "kums", "kunilingus", "l3i+ch", "l3itch", "labia", "lust", "lusting", "m0f0", "m0fo", "m45terbate", "ma5terb8", "ma5terbate", "masochist", "master-bate", "masterb8", "masterbat*", "masterbat3", "masterbate", "masterbation", "masterbations", "masturbate", "mo-fo", "mof0", "mofo", "mothafuck", "mothafucka", "mothafuckas", "mothafuckaz", "mothafucked", "mothafucker", "mothafuckers", "mothafuckin", "mothafucking", "mothafuckings", "mothafucks", "mother fucker", "motherfuck", "motherfucked", "motherfucker", "motherfuckers", "motherfuckin", "motherfucking", "motherfuckings", "motherfuckka", "motherfucks", "muff", "mutha", "muthafecker", "muthafuckker", "muther", "mutherfucker", "n1gga", "n1gger", "nazi", "nigg3r", "nigg4h", "nigga", "niggah", "niggas", "niggaz", "nigger", "niggers", "nob", "nob jokey", "nobhead", "nobjocky", "nobjokey", "numbnuts", "nutsack", "orgasim", "orgasims", "orgasm", "orgasms", "p0rn", "pawn", "pecker", "penis", "penisfucker", "phonesex", "phuck", "phuk", "phuked", "phuking", "phukked", "phukking", "phuks", "phuq", "pigfucker", "pimpis", "piss", "pissed", "pisser", "pissers", "pisses", "pissflaps", "pissin", "pissing", "pissoff", "poop", "porn", "porno", "pornography", "pornos", "prick", "pricks", "pron", "pube", "pusse", "pussi", "pussies", "pussy", "pussys", "rectum", "retard", "rimjaw", "rimming", "s hit", "s.o.b.", "sadist", "schlong", "screwing", "scroat", "scrote", "scrotum", "semen", "sex", "sh!+", "sh!t", "sh1t", "shag", "shagger", "shaggin", "shagging", "shemale", "shi+", "shit", "shitdick", "shite", "shited", "shitey", "shitfuck", "shitfull", "shithead", "shiting", "shitings", "shits", "shitted", "shitter", "shitters", "shitting", "shittings", "shitty", "skank", "slut", "sluts", "smegma", "smut", "snatch", "son-of-a-bitch", "spac", "spunk", "s_h_i_t", "t1tt1e5", "t1tties", "teets", "teez", "testical", "testicle", "tit", "titfuck", "tits", "titt", "tittie5", "tittiefucker", "titties", "tittyfuck", "tittywank", "titwank", "tosser", "turd", "tw4t", "twat", "twathead", "twatty", "twunt", "twunter", "v14gra", "v1gra", "vagina", "viagra", "vulva", "w00se", "wang", "wank", "wanker", "wanky", "whoar", "whore", "willies", "willy", "xrated", "xxx"];
        var rgx = new RegExp(filterWords.join("|"), "gi");
        return str.replace(rgx, "");
    }
</script>
<script>
var sendMessage = '{{ route("chat.send") }}';
var chatMessageCountUpdate = '{{ route("chat.message.count") }}';
var getMessages = '{{ route("chat.get") }}';
var db_name = "{{ Config::get('constants.FIREBASE_DB_NAME') }}";
var resturant_id = {!! json_encode($resturant_id) !!};
</script>
<script>
$('document').ready(function() {
    $(document).on('click', '.searchTextBtn', function() {
        var text = $(".searchText").val();
        window.location.href = "http://" + window.location.host + window.location.pathname + '?order_id=' + text;
    });

    $(document).on('change', '.searchText', function() {
        var text = $(".searchText").val();
        if(text){
        window.location.href = "http://" + window.location.host + window.location.pathname + '?order_id=' + text;
        }else{
        window.location.href = "http://" + window.location.host + window.location.pathname ;
        }
    });

    $(document).on("click",".sendMessage",function(){
        var uid = $("#uid").val();
        if(!$("#message").val()) return
            $.ajax({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: sendMessage,
                type: "POST",
                dataType: "json",
                data:{
                    uid :$("#uid").val(),
                    message:$("#message").val(),
                    // order_id:$(".active").data('order_id'),
                    order_id : $("#order_id").text(),
                    // customer_id:$(".active").data('customer_id')
                    customer_id : $("#customerId").val()
                },
                beforeSend: function() {
                $("body").preloader();
                },
                complete: function(){
                $("body").preloader('remove');
                },
                success: function (res) {
                toastr.success(res.message);
                $("#message").val('');
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    swal.fire("Error deleting!", "Please try again", "error");
                }
            });
    });

    $("#message").keyup(function(event) {
        if (event.keyCode === 13) {
          $(".sendMessage").click();
        }
    });

    // Initialize Firebase

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
    const messaging = firebase.messaging();
    //Push Notification

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
                  url: '{{ route("store.token") }}',
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

    var order_id=$(".active").data('order_id');
    var customer_id = $(".active").data('customer_id');
    var url = '/'+db_name+'/'+resturant_id+'/'+order_id+'/'+customer_id+'/';
    $(".msg-body").html("<h5>No Conversion Found.</h5>");
    firebase.database().ref(url).on('value', function(snapshot) {
        var chat_element = "";
        var value = snapshot.val();
        let last_msg = "";
        $.each(value, function(index, value){
          if(value.sent_from=='RESTAURANT'){
            chat_element += ' <li class="company-msg">';
            chat_element += '      <img src="{{ asset("assets/images/person.png") }}" class="img-fluid">';
            chat_element += '     <div class="cht-msg">'
            chat_element += '       <p>'+value.message+'</p>';
            chat_element += '        <span>'+value.message_date+'</span>';
            chat_element += '      </div>'
            chat_element += '    </li>'
            }else{
            chat_element += ' <li class="client-msg">';
            chat_element += '      <img src="{{ asset("assets/images/person.png") }}" class="img-fluid">';
            chat_element += '     <div class="cht-msg">'
            chat_element += '       <p>'+value.message+'</p>';
            chat_element += '        <span>'+value.message_date+'</span>';
            chat_element += '      </div>'
            chat_element += '    </li>'
            }
          $(".msg-body").html(chat_element);
          $("#message").val('');
          lastIndex = index;
          last_msg = value.message;
        });
    });

    $(document).on("click",".chat-content",function(){
        $('.chat-content').removeClass('active');
        $(this).addClass('active');
        order_id=$(this).data('order_id');
        var user = $(this).data('user_name');
        var customer_id = $(this).data('customer_id');
        $("#customerId").val(customer_id);
        $("#order_id").text(order_id);
        $("#order_user").text(user);
        $(".msg-body").html('');
        var url = '/'+db_name+'/'+resturant_id+'/'+order_id+'/'+customer_id+'/';
        firebase.database().ref(url).on('value', function(snapshot) {
        var chat_element = "";
        var value = snapshot.val();
        $(".msg-body").html("<h5>No Conversion Found.</h5>");
        $.each(value, function(index, value){
          if(value.sent_from=='RESTAURANT'){
            chat_element += ' <li class="company-msg">';
            chat_element += '      <img src="{{ asset("assets/images/person.png") }}" class="img-fluid">';
            chat_element += '     <div class="cht-msg">'
            chat_element += '       <p>'+value.message+'</p>';
            chat_element += '        <span>'+value.message_date+'</span>';
            chat_element += '      </div>'
            chat_element += '    </li>'
          }else{
            chat_element += ' <li class="client-msg">';
            chat_element += '      <img src="{{ asset("assets/images/person.png") }}" class="img-fluid">';
            chat_element += '     <div class="cht-msg">'
            chat_element += '       <p>'+value.message+'</p>';
            chat_element += '        <span>'+value.message_date+'</span>';
            chat_element += '      </div>'
            chat_element += '    </li>'
          }

          var update_url = '/' + db_name + '/' + resturant_id + '/' + order_id + '/' +
                            customer_id + '/' + index;
          // // value.is_read = 1;
          // value.isseen = true;
          // var updates = {};
          // updates[update_url] = value;
          // firebase.database().ref().update(updates);
          var updates = {};
            updates[update_url] = value;
            firebase.database().ref(update_url).update({isseen:true});
          $(".msg-body").html(chat_element);
            $("#message").val('');
            lastIndex = index;
          });
        });

        $.ajax({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: chatMessageCountUpdate,
            type: "POST",
            dataType: "json",
            data:{
                order_number : $("#order_id").text(),
            },
            success: function (res) {
              console.log("message counter update.");
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log("message counter not update.");
            }
        });
    });

});
</script>
@endsection
