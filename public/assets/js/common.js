$(document).ready(function () {
    function readURL(input) {
        if (input.files && input.files[0]) {
            var fileType = input.files[0];
            fileType = fileType['type'];
            var validImageTypes = ["image/gif", "image/jpeg", "image/png"];
            if (validImageTypes.includes(fileType)) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    var img = $('<img width="170" height="170" class="itemImage" id="dynamic">');
                    img.attr('src', e.target.result);
                    img.appendTo('.slt-img');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    }
    $("#image").change(function () {
        $(".slt-img").html('');
        readURL(this);
    });
    $('.slt-img').click(function () {
        $('#image').trigger('click');
    });

    $('.add-category[href*=\\#]:not([href=\\#])').on('click', function () {
        var target = $(this.hash);
        target = target.length ? target : $('[name=' + this.hash.substr(1) + ']');
    });

    $(document).on('change', '.discountUsdPercentage', function () {
        var currentValue = $(this).val();
        if (currentValue == "usd") {
            $("#discount_amount").attr("placeholder", "Discount (USD)");
        } else {
            $("#discount_amount").attr("placeholder", "Discount (%)");
        }
    });


    $(document).on('change', '.setMinimumOrderAmount', function () {
        $(".minimumAmountDiv").toggle();
    });

    $(document).on('change', '.onlyForSelectedPayment', function () {
        $(".onlyForSelectedPaymentDiv").toggle();
    });

    $("#promotion_code").on("keyup", function (e) {
        var max = 15;
        var inputLength = $(this).val().length;
        if (inputLength > max) {
            $(this).val($(this).val().substring(0, max));
        }
    });

    $(".add-category a").each(function () {
        if ($(this).hasClass("disabled")) {
            $(this).removeAttr("href");
        }
    });
});
