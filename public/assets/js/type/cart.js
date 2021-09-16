$(document).ready(function() {
    $(document).on('change', '.discountUsdPercentage', function() {
        var currentValue = $(this).val();
        if(currentValue=="usd"){
            $("#discount_amount").attr("placeholder", "Discount (USD)");
        }else{
            $("#discount_amount").attr("placeholder", "Discount (%)");
        }
    });


    $(document).on('change', '.setMinimumOrderAmount', function() {
        if($(this).prop('checked') == true){
            $(".minimumAmountDiv").show();
        }else{
            $(".minimumAmountDiv").hide();
        }
    });

    $(document).on('change', '.onlyForSelectedPayment', function() {
        if($(this).prop('checked') == true){
            $(".onlyForSelectedPaymentDiv").show();
        }else{
            $(".onlyForSelectedPaymentDiv").hide();
        }
    });
});