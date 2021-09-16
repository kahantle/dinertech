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
            $("."+id).prop("checked",true)        }
        else if($(this).prop("checked") == false){
            $("."+id).prop("checked",false)        }
    });

});