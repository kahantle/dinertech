$(function(){

    "use strict";
	var baseUrl = $("#base-url").attr('content');

    $(".type").on('click',function () {
       var type = $(this).data('type');
       var menuId = $("#menuId").val();
       if(type == 'Custom Date')
       {
            $("#customDateMenuId").val(menuId);
            $("#stockType").val(type);
       }
       else
       {
            $.ajax({
                url:baseUrl+"/restaurants/menu/type/change/",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type:"POST",
                dataType:"html",
                data:{
                    menuId:menuId,
                    type:type
                },
                success:function (response) {
                    if(response == true)
                    {
                        toastr.success('Menu item type updated.', 'Success');
                        // setTimeout(function() {
                        //     window.location.reload();        
                        // },5000);
                    }
                    else
                    {
                        toastr.error('Some error in item type update.', 'Error!');
                    }
                }
            });
       }
    });

    $(".refresh").on("click",function () {
        window.location.reload();
    });
});