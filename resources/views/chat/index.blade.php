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
                  <div class="chat-content @if($key==0) active @endif" data-customer_id="{{$item->user->uid}}" data-user_name="{{$item->user->full_name}}" data-order_id="{{$item->order_number}}" data-id="{{$item->order_id}}" >
                  <img src="{{ asset('assets/images/person.png') }}" class="img-fluid">
                  <div class="chat-name">
                    <div class="cn-left">
                      <h6>{{$item->user->full_name}}</h6>
                      <span>{{ empty($last_messages[$key]) ? "" : substr($last_messages[$key],0,15)."..." }}</span>
                    </div>
                    <div class="cn-right">
                      <h6>{{$item->order_number}}</h6>
                      <span></span>
                    </div>
                  </div>
                  </div>
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
                    <a href="#0"><img src="{{ asset('assets/images/send.png') }}" class="send-icon sendMessage"></a>
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
      if(!$("#message").val()) return
        $.ajax({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: sendMessage,
            type: "POST",
            dataType: "json",
            data:{
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
    var config = {
        apiKey: "{{config('services.firebase.api_key')}}",
        authDomain: "{{config('services.firebase.auth_domain')}}",
        databaseURL: "{{config('services.firebase.database_url')}}",
        projectId: "{{config('services.firebase.project_id')}}",
        storageBucket: "{{config('services.firebase.storage_bucket')}}",
        messagingSenderId: "{{config('services.firebase.messaging_sender_id')}}"
    };
    firebase.initializeApp(config);
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
        console.log(last_msg);
    });

    $(document).on("click",".chat-content",function(){
        $('.chat-content').removeClass('active');
        $(this).addClass('active');
        order_id=$(this).data('order_id');
        var user = $(this).data('user_name');
        var customer_id = $(this).data('customer_id');
        console.log(customer_id);
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

          var update_url = '/'+db_name+'/'+resturant_id+'/'+order_id+'/'+index+'/';
          // value.is_read = 1;
          value.isseen = true;
          var updates = {};
          updates[update_url] = value;
          firebase.database().ref().update(updates);
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
