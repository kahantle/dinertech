$(document).ready(function() {
    $(document).on('change', '.discountUsdPercentage', function() {
        var currentValue = $(this).val();
        if(currentValue=="USD"){
            $("#discount_amount").attr("placeholder", "Discount (USD)");
            $("#discount_amount").removeClass("discount_percentage");
            // $("#discount_amount").attr("data-discount", "USD");
        }else{
            $("#discount_amount").attr("placeholder", "Discount (%)");
            $("#discount_amount").addClass("discount_percentage");
            // $("#discount_amount").attr("data-discount", "PERCENT");
        }
    });


    $(document).on('change', '.setMinimumOrderAmount', function() {
        if($(this).prop('checked') == true){
            $(".minimumAmountDiv").show();
        }else{
            $(".minimumAmountDiv").hide();
        }
    });

    // $(document).on('change', '.onlyForSelectedPayment', function() {
    //     if($(this).prop('checked') == true){
    //         $(".onlyForSelectedPaymentDiv").show();
    //         $("#cash").prop("checked", true);
    //         $("#cardtodelivery").prop( "checked", true);
    //     }else{
    //         $("#cash").prop( "checked", false );
    //         $("#cardtodelivery").prop( "checked", false );
    //         $(".onlyForSelectedPaymentDiv").hide();
    //     }
    // });


    $(document).on('change', '.onlyForSelectedPayment', function() {
        if($(this).prop('checked') == true){
            // $(this).prop('checked', true);
            $(".onlyForSelectedPaymentDiv").show();
            $("#cash").prop("checked", true);
            $("#cardtodelivery").prop( "checked", true);
        }else{
            // $(this).prop('checked', false);
            $("#cash").prop( "checked", false );
            $("#cardtodelivery").prop( "checked", false );
            $(".onlyForSelectedPaymentDiv").hide();
        }
    });

    $(document).on('keyup change',".discount_percentage",function(){
        if($(this).val() >= 100)
        {
            $(this).val('100');
        }
    });
});