$(function(){
    "use strict";
    var baseUrl = $("#base-url").attr('content');

    $(".boxShadow").on('click', function() {
        $(".place-order").addClass('show');
         $(".set-card-number").html($(this).data('card-number'));
         $("#cardNumber").val($(this).data('card-number'));
         $(".set-card-holderName").html($(this).data('card-holder-name'));
         $("#cardHolderName").val($(this).data('card-holder-name'));
         $(".set-card-exp_date").html($(this).data('exp-date'));
         $("#cardExpDate").val($(this).data('exp-date'));
          $(".boxShadow").each(function() {
            $(this).css({
              "box-shadow": "none"
            });
          })
       $(this).css({
         "box-shadow": "-5px 4px 11px 2px #5e5ed6"
       });
     });
});