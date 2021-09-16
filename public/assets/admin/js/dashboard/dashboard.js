$(function(){
    
    "use strict";
     //TOGGLING NESTED ul
     $(".drop-down .selected a").click(function() {
        $(".drop-down .options ul").toggle();
    });
    
    //SELECT OPTIONS AND HIDE OPTION AFTER SELECTION
    $(".drop-down .options ul li a").click(function() {
        var text = $(this).html();
        $(".drop-down .selected a span").html(text);
        $(".drop-down .options ul").hide();
    }); 


    //HIDE OPTIONS IF CLICKED ANYWHERE ELSE ON PAGE
    $(document).bind('click', function(e) {
        var $clicked = $(e.target);
        if (! $clicked.parents().hasClass("drop-down"))
            $(".drop-down .options ul").hide();
    });

    $('.filter').on("click",function(){
        var value = $(this).data('filter');
        if(value == 'Custom')
        {
            $(".wg-inner-blog").addClass('show');
            $(".wg-inner-blog").removeClass('hide');
        }
        else
        {
          $(".wg-inner-blog").addClass('hide');
          $(".wg-inner-blog").removeClass('show');   
        }
    });

    $.ajax({
        url:"",
        type:"POST",
        dataType:"JSON",
        data:{

        },
        success:function (response){
            
        }
    });
});