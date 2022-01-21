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
            var check_length = $(".category_item-first:checked").length;
            $("#hidden_eligible_item-first").val(check_length);
        }
        else if($(this).prop("checked") == false){
            $("."+id).prop("checked",false)  
            $("#hidden_eligible_item-first").val('');  
        }
    });

    $(document).on('click', '.categoryList-two', function() {
        var id =$(this).attr('id')
         if($(this).prop("checked") == true){
             $("."+id).prop("checked",true)
             var check_length = $(".category_item-second:checked").length;
             $("#hidden_eligible_item-second").val(check_length);
         }
         else if($(this).prop("checked") == false){
             $("."+id).prop("checked",false)  
             $("#hidden_eligible_item-second").val('');  
         }
     });

    $(document).on('click', '.category_item-first', function() {
        var check_length = $(".category_item-first:checked").length;
        if(check_length){
            $("#hidden_eligible_item").val(check_length);
        }else{
            $("#hidden_eligible_item").val('');
        }
    });

    $(document).on('click', '.category_item-second', function() {
        var check_length = $(".category_item-second:checked").length;
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


    $(document).on('click', '.eligible_popup_close-first', function() {
        var check_length = $(".category_item-first:checked").length;
        if(check_length){
            $("#slct").text(check_length+" Eligible items selected.");
        }else{
            $("#slct").text('Eligible Items');
        }
    });


    $(document).on('click', '.eligible_popup_close-second', function() {
        var check_length = $(".category_item-second:checked").length;
        if(check_length){
            $("#slct-two").text(check_length+" Eligible items selected.");
        }else{
            $("#slct-two").text('Eligible Items');
        }
    });

    $("#select-box").on("change",function(){
        if($(this).val() == 2)
        {
            $("#tab-1").hide();
            $("#tab-2").show();
        }
        else
        {
            $("#tab-1").show();
            $("#tab-2").hide();
        }
    });

    $(document).on('keyup change',".discount_percentage",function(){
        if($(this).val() >= 100)
        {
            $(this).val('100');
        }
    });
    
});