$(document).ready(function() {
    $(document).on('click', '.discountUsdPercentage', function() {
        var currentValue = $(this).val();
        if(currentValue=="usd"){
            $("#discount_amount").attr("placeholder", "Discount (USD)");
        }else{
            $("#discount_amount").attr("placeholder", "Discount (%)");
        }
    });

    $(document).on('click', '.categoryList', function() {
       var id =$(this).attr('id')
        if($(this).prop("checked") == true){
            $("."+id).prop("checked",true)
            var check_length = $(".category_item:checked").length;
            $("#hidden_eligible_item").val(check_length);
        }
        else if($(this).prop("checked") == false){
            $("."+id).prop("checked",false)  
            $("#hidden_eligible_item").val('');  
        }
    });

    $(document).on('click', '.category_item', function() {
        var check_length = $(".category_item:checked").length;
        if(check_length){
            $("#hidden_eligible_item").val(check_length);
        }else{
            $("#hidden_eligible_item").val('');
        }
     });

     $(document).on('change', '.onlyForSelectedPayment', function() {
        if($(this).prop('checked') == true){
            $(".onlyForSelectedPaymentDiv").show();
            $("#cash").prop("checked", true);
            $("#cardtodelivery").prop( "checked", true);
        }else{
            $("#cash").prop( "checked", false );
            $("#cardtodelivery").prop( "checked", false );
            $(".onlyForSelectedPaymentDiv").hide();
        }
    });
    
    $(document).on('click', '.eligible_popup_close', function() {
        var check_length = $(".category_item:checked").length;
        if(check_length){
            $("#slct").text(check_length+" Eligible items selected.");
        }else{
            $("#slct").text('Eligible Items');
        }
    })
    
    $(document).on('keyup change',".discount_percentage",function(){
        if($(this).val() >= 100)
        {
            $(this).val('100');
        }
    });
});