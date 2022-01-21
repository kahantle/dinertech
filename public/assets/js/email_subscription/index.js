$(function() {
    "use strict";

    var baseUrl = $("[name='base-url']").attr('content');

    $(".subscription").on('click', function() {

        var activeSubscriptionId = $(".card-blue").attr('data-subscriptionid');
        var subscriptionId = $(this).attr('data-subscriptionid');
        $("#subscription-" + activeSubscriptionId).removeClass('card-blue');
        $("#subscription-" + activeSubscriptionId).addClass('card-black-inner');
        $("#subscription-" + subscriptionId).removeClass('card-black-inner');
        $("#subscription-" + subscriptionId).addClass("card-blue");
        $.ajax({
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: baseUrl + '/subscriptions/payment/modal',
            data: {
                subscriptionId: subscriptionId,
                upgrade: ($("#upgrade").length != 0) ? 'true' : 'false',
            },
            dataType: "json",
            success: function(response) {
                if (response) {
                    $("#payment-modal").html(response.view);
                    $("#exampleModalCenter4").modal("show");
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                Swal.fire("Error!", xhr.responseJSON.message, "error");
            }
        });

    });

    $(document).on("keyup", "#card-cvv", function() {
        if ($(this).val().length > 1) {
            $(".card-cvv").html($(this).val());
        } else {
            $(".card-cvv").html("***");
        }
    });

    $(document).on("keyup", "#inputExpDate", function() {
        if ($(this).val().length > 1) {
            $(".card-exp-date").html(cc_expires_format($(this).val()));
            $(this).val(cc_expires_format($(this).val()));
        } else {
            $(".card-exp-date").html('MM/YY');
        }
    });


    $(document).on('keypress keyup change', '#card-number', function() {
        var imagePath = $(this).attr('data-image-path');
        $(this).val(function(index, value) {
            var cardNumber = value.replace(/\W/gi, '').replace(/(.{4})/g, '$1 ');
            cardNumber = cardNumber.trim();
            $(".card-number").html(cardNumber);
            var cardType = GetCardType(cardNumber);
            $("#cardType").val(cardType);
            if (cardType === 'Visa') {
                $(".show-card-image").addClass("show");
                $(".show-card-image").removeClass("hide");
                $(".show-card-image").attr("src", imagePath + '/visa.png');
            } else if (cardType === 'Mastercard') {
                $(".show-card-image").addClass("show");
                $(".show-card-image").removeClass("hide");
                $(".show-card-image").attr("src", imagePath + '/master_card.png');
            } else if (cardType === 'Discover') {
                $(".show-card-image").addClass("show");
                $(".show-card-image").removeClass("hide");
                $(".show-card-image").attr("src", imagePath + '/discover.png');
            } else if (cardType === 'AMEX') {
                $(".show-card-image").addClass("show");
                $(".show-card-image").removeClass("hide");
                $(".show-card-image").attr("src", imagePath + '/american-express.png');
            } else {
                $(".show-card-image").addClass("show");
                $(".show-card-image").removeClass("hide");
                $(".show-card-image").attr("src", imagePath + '/logo-payment.png');
            }
            return cardNumber;
        });

    });

    $(document).on("click", ".select-method", function() {
        $(document).find("#payment-method").val($(this).attr('data-payment-id'))
    });

    function GetCardType(number) {
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

    $('.moreless-button').click(function() {
        $('.moretext').toggle();
        if ($('.moreless-button').text() == "Show More") {
            $(this).text("Show Less")
        } else {
            $(this).text("Show More")
        }
    });
});