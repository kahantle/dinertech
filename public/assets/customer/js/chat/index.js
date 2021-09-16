$(function(){
    "use strict";
    
    var baseUrl = $("#base-url").attr('content');
    
    try {
        Typekit.load({
            async: true
        });
        
    } catch (e) {}

    $(".messages").animate({
        scrollTop: $(document).height()
    }, "fast");

    $("#profile-img").click(function() {
        $("#status-options").toggleClass("active");
    });

    $(".expand-button").click(function() {
        $("#profile").toggleClass("expanded");
        $("#contacts").toggleClass("expanded");
    });

    $("#status-options ul li").click(function() {
        $("#profile-img").removeClass();
        $("#status-online").removeClass("active");
        $("#status-away").removeClass("active");
        $("#status-busy").removeClass("active");
        $("#status-offline").removeClass("active");
        $(this).addClass("active");

        if ($("#status-online").hasClass("active")) {
            $("#profile-img").addClass("online");
        } else if ($("#status-away").hasClass("active")) {
            $("#profile-img").addClass("away");
        } else if ($("#status-busy").hasClass("active")) {
            $("#profile-img").addClass("busy");
        } else if ($("#status-offline").hasClass("active")) {
            $("#profile-img").addClass("offline");
        } else {
            $("#profile-img").removeClass();
        };

        $("#status-options").removeClass("active");
    });

    function getChats(orderId) {
        $.ajax({
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: baseUrl+'/getChats',
            data: {
                orderId:orderId,
            },
            dataType: "html",
            success: function(response) {
                if(response)
                {
                    $(".messages").html(response);
                    $(".submit").attr('data-order-id',orderId);
                    $(".export").attr('href',baseUrl+"/chat/export/"+orderId);
                }
            }
        });    
    }
    // getChats($(".contact").data('order-id'));
    setInterval(function(){
        getChats($(".active").data('order-id'));// this will run after every 5 seconds
    }, 5000);
    function newMessage() {
        var message = $(".message-input input").val();
        if ($.trim(message) == '') {
            return false;
        }
        // $('<li class="replies"><img src="images/boy.png" alt="" /><p>' + message + '</p></li>').appendTo($('.messages ul'));
        // $('.message-input input').val(null);
        // $('.contact.active .preview').html('<span>You: </span>' + message);
        var orderId = $(".submit").data('order-id');
        $.ajax({
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: baseUrl+'/send/message',
            data: {
                orderId:orderId,
                message:message,
            },
            dataType: "html",
            success: function(response) {
                if(response)
                {
                    $('.message-input input').val(null);
                    getChats(orderId);
                }
            }
        });
        $(".messages").animate({
            scrollTop: $(document).height()
        }, "fast");
    };

    $('.submit').click(function() {
        newMessage();
    });

    $(window).on('keydown', function(e) {
        if (e.which == 13) {
            newMessage();
            return false;
        }
    });
    //# sourceURL=pen.js
    
    
    $(".contact").on("click",function() {
        var orderId = $(this).data('order-id');
        $(".submit").removeAttr('data-order-id');
        $.ajax({
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: baseUrl+'/getChats',
            data: {
                orderId:orderId,
            },
            dataType: "html",
            success: function(response) {
                // console.log(response);
                if(response)
                {
                    $(".contact").removeClass('active');
                    $(".messages").html(response);
                    $(".chat-"+orderId).addClass('active');
                    $(".submit").attr('data-order-id',orderId);
                    $(".export").attr('href',baseUrl+"/chat/export/"+orderId);
                }
            }
        });
    });

//    $(".export").on("click",function(e){
//      e.preventDefault();
//      var orderId = $(this).data('order-id');
//      $.ajax({
//         type: "POST",
//         headers: {
//             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         },
//         url: baseUrl+'/chat/export',
//         data: {
//             orderId:orderId,
//         },
//         // dataType: "html",
//         cache: false,
//         success: function(response) {
//             // if(response)
//             // {
//             //     $(".contact").removeClass('active');
//             //     $(".messages").html(response);
//             //     $(".chat-"+orderId).addClass('active');
//             //     $(".submit").attr('data-order-id',orderId);
//             //     $(".export").attr('data-order-id',orderId);
//             // }
//         }
//     });
//    });
});