$(function(){

    "use strict";
	var baseUrl = $("#base-url").attr('content');

    var categoryId = $(".category").data('category-id');
    loadMenu(categoryId);

    $(".category").on("click",function () {
        // $(this).closest('li').removeClass('active');
        $(this).parent().siblings().removeClass('active');
        var categoryId = $(this).data('category-id');
        loadMenu(categoryId);
        var href = $(this).attr('href').replace("#",'');
        $(".category-"+href).addClass('active');
    });

    function loadMenu(categoryId)
    {
        $.ajax({
            url:baseUrl+"/restaurants/menuitem/get",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:"POST",
            dataType:"html",
            data:{
                categoryId:categoryId
            },
            success:function (response) {
                $("#loadmenu").html(response);
            }
        });
    }

});