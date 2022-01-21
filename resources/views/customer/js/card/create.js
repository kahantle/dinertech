$(function(){
    "use strict";
    var baseUrl = $("#base-url").attr('content');

    $(document).on("keyup","#card-holder-name",function(){
        if($(this).val().length > 1)
        {
            $(".card-holder-name").html($(this).val());
        }
        else
        {
            $(".card-holder-name").html("XXXX XXXX XXXX.");
        }
    });

    $(document).on("keyup","#card-cvv",function(){
        if($(this).val().length > 1)
        {
            $(".card-cvv").html($(this).val());
        }
        else
        {
            $(".card-cvv").html("***");
        }
    });

    $(document).on("keyup","#card-exp-date",function(){
        if($(this).val().length > 1)
        {
            $(".card-exp-date").html(cc_expires_format($(this).val()));
            $(this).val(cc_expires_format($(this).val()));
        }
        else
        {
            $(".card-exp-date").html('MM/YY');
        }
    });

    function cc_expires_format(string) {
        return string.replace(
            /[^0-9]/g, '' // To allow only numbers
        ).replace(
            /^([2-9])$/g, '0$1' // To handle 3 > 03
        ).replace(
            /^(1{1})([3-9]{1})$/g, '0$1/$2' // 13 > 01/3
        ).replace(
            /^0{1,}/g, '0' // To handle 00 > 0
        ).replace(
            /^([0-1]{1}[0-9]{1})([0-9]{1,2}).*/g, '$1/$2' // To handle 113 > 11/3
        );
    }

    $('#card-number').on('keypress keyup change', function () {
      if($(this).val().length > 1)
      {
        $(this).val(function (index, value) {
            var cardNumber =  value.replace(/\W/gi, '').replace(/(.{4})/g, '$1 ');
            $(".card-number").html(cardNumber);
            var cardType = GetCardType(cardNumber);
            var imagePath = $("#card-image-path").val();
            $("#cardType").val(cardType);
            if(cardType === 'Visa')
            {
              $(".show-card-image").addClass("show");
              $(".show-card-image").removeClass("hide");
              $(".show-card-image").attr("src",imagePath+'/visa.png');
            }
            else if(cardType === 'Mastercard')
            {
              $(".show-card-image").addClass("show");
              $(".show-card-image").removeClass("hide");
              $(".show-card-image").attr("src",imagePath+'/master_card.png');
            }
            else if(cardType === 'Discover')
            {
              $(".show-card-image").addClass("show");
              $(".show-card-image").removeClass("hide");
              $(".show-card-image").attr("src",imagePath+'/discover.png');
            }
            else if(cardType === 'AMEX')
            {
              $(".show-card-image").addClass("show");
              $(".show-card-image").removeClass("hide");
              $(".show-card-image").attr("src",imagePath+'/american-express.png');
            }
            else
            {
              $(".show-card-image").addClass("show");
              $(".show-card-image").removeClass("hide");
              $(".show-card-image").attr("src",imagePath+'/logo-payment.png'); 
            }
            return cardNumber;
        });
      }
      else
      {
        $(".card-number").html("XXXX XXXX XXXX XXXX");
        $(".show-card-image").addClass("hide");
        $(".show-card-image").removeClass("show");
      }
    });

    function GetCardType(number)
    {
        // visa
        var re = new RegExp("^4");
        if (number.match(re) != null)
            return "Visa";

        // Mastercard
        re = new RegExp("^5[1-5]");
        if (number.match(re) != null)
            return "Mastercard";

        // AMEX
        re = new RegExp("^3[47]");
        if (number.match(re) != null)
            return "AMEX";

        // Discover
        re = new RegExp("^(6011|622(12[6-9]|1[3-9][0-9]|[2-8][0-9]{2}|9[0-1][0-9]|92[0-5]|64[4-9])|65)");
        if (number.match(re) != null)
            return "Discover";

        // Diners
        re = new RegExp("^36");
        if (number.match(re) != null)
            return "Diners";

        // Diners - Carte Blanche
        re = new RegExp("^30[0-5]");
        if (number.match(re) != null)
            return "Diners - Carte Blanche";

        // JCB
        re = new RegExp("^35(2[89]|[3-8][0-9])");
        if (number.match(re) != null)
            return "JCB";

        // Visa Electron
        re = new RegExp("^(4026|417500|4508|4844|491(3|7))");
        if (number.match(re) != null)
            return "Visa Electron";

        return "";
    }

        $("#addCardForm").validate({
            rules:{
                card_number:{
                    required:true,
                },
                card_expire_date:{
                    required:true
                },
                card_cvv:{
                    required:true,
                    number:true
                },
                card_holder_name:{
                    required:true
                }
            },
            onkeyup: false,
            onfocusout: false,
            onsubmit: true,
            highlight: function (element, errorClass, validClass) 
            {
                $(element).parents('.form-control').removeClass('has-success').addClass('has-error');
            },
            unhighlight: function (element, errorClass, validClass) 
            {
                $(element).parents('.form-control').removeClass('has-error').addClass('has-success');
            },
            errorPlacement: function (error, element) 
            {
                if(element.hasClass('select2') && element.next('.select2-container').length) 
                {
                 error.insertAfter(element.next('.select2-container'));
                } 
                else if (element.parent('.input-group').length) 
                {
                   error.insertAfter(element.parent());
                }
                else if (element.prop('type') === 'radio' && element.parent('.radio-inline').length) 
                {
                   error.insertAfter(element.parent().parent());
                }
                else if (element.prop('type') === 'checkbox' || element.prop('type') === 'radio') 
                {
                   error.appendTo(element.parent().parent());
                }
                else 
                {
                   error.insertAfter(element);
                }
            },
        });

});