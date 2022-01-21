$(function(){
    "use strict";
    var baseUrl = $("#base-url").attr('content');

    $(document).on("change",".method-option",function(){
        if($(this).val() == 'card')
        {
            $(".payment-credit-card").css("box-shadow","#2d34f1 0px 2px 8px");
            $(".payment-cash").css("box-shadow","");
        }

        if($(this).val() == 'cash')
        {
            $(".payment-credit-card").css("box-shadow","");
            $(".payment-cash").css("box-shadow","#2d34f1 0px 2px 8px");
        }
    });
});