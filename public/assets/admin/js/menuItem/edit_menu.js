$(function(){

    "use strict";
	var baseUrl = $("#base-url").attr('content');

    $("#multiple").select2({
        placeholder: "SELECT MODIFER",
        allowClear: true
    });

    $(".imgRemove").on('click',function(){
        myImgRemove(1);
    });

    $("#file-ip-1").on("change",function(){
        showPreview(event, 1);
    });

    
    function showPreview(event, number){
    if(event.target.files.length > 0){
        let src = URL.createObjectURL(event.target.files[0]);
        let preview = document.getElementById("file-ip-"+number+"-preview");
        preview.src = src;
        preview.style.display = "block";
    } 
    }
    function myImgRemove(number) {
        document.getElementById("file-ip-"+number+"-preview").src = "https://i.ibb.co/ZVFsg37/default.png";
        document.getElementById("file-ip-"+number).value = null;
    }

    $(".menuType").on("click",function () {
        var type = $(this).data('type');
        if(type == 'Custom Date')
        {
            $(".selectdate").removeClass('hide');
            $(".selectdate").addClass('show');
            $(".removeSelect-Custom").removeClass('not-active');
            $(".removeSelect-Custom").addClass('res-add-btn');
            $(".removeSelect-Rest").removeClass('res-add-btn');
            $(".removeSelect-Rest").addClass('not-active');
            $(".removeSelect-Available").removeClass('res-add-btn');
            $(".removeSelect-Available").addClass('not-active');
            $(".removeSelect-Indefinitely").removeClass('res-add-btn');
            $(".removeSelect-Indefinitely").addClass('not-active');
            $("#stockType").val(type);
            $(document).find("#dateValue").val('');
        }
        else if(type == 'Available')
        {
            $(".selectdate").addClass('hide');
            $(".selectdate").removeClass('show');
            $(".removeSelect-Available").removeClass('not-active');
            $(".removeSelect-Available").addClass('res-add-btn');
            $(".removeSelect-Rest").removeClass('res-add-btn');
            $(".removeSelect-Rest").addClass('not-active');
            $(".removeSelect-Custom").removeClass('res-add-btn');
            $(".removeSelect-Custom").addClass('not-active');
            $(".removeSelect-Indefinitely").removeClass('res-add-btn');
            $(".removeSelect-Indefinitely").addClass('not-active');
            $("#stockType").val(type);
            $(document).find("#dateValue").val('');
        }
        else if(type == 'Rest of Day')
        {
            $(".selectdate").addClass('hide');
            $(".selectdate").removeClass('show');
            $(".removeSelect-Rest").removeClass('not-active');
            $(".removeSelect-Rest").addClass('res-add-btn');
            $(".removeSelect-Available").removeClass('res-add-btn');
            $(".removeSelect-Available").addClass('not-active');
            $(".removeSelect-Custom").removeClass('res-add-btn');
            $(".removeSelect-Custom").addClass('not-active');
            $(".removeSelect-Indefinitely").removeClass('res-add-btn');
            $(".removeSelect-Indefinitely").addClass('not-active');
            $("#stockType").val(type);
            $(document).find("#dateValue").val('');
        }
        else if(type == 'Indefinitely')
        {
            $(".selectdate").addClass('hide');
            $(".selectdate").removeClass('show');
            $(".removeSelect-Indefinitely").removeClass('not-active');
            $(".removeSelect-Indefinitely").addClass('res-add-btn');
            $(".removeSelect-Available").removeClass('res-add-btn');
            $(".removeSelect-Available").addClass('not-active');
            $(".removeSelect-Custom").removeClass('res-add-btn');
            $(".removeSelect-Custom").addClass('not-active');
            $(".removeSelect-Rest").removeClass('res-add-btn');
            $(".removeSelect-Rest").addClass('not-active');
            $("#stockType").val(type);
            $(document).find("#dateValue").val('');
        }
    });

    $(document).on("click",".appendDate",function () {
        var date = $(".formdate").val()+" To "+$(".todate").val();
        $("#dateValue").val(date);
        $("#custom-date").modal("hide");
    });
   
    $("#editMenuForm").validate({
        rules:{
            item_name:{
                required:true
            },
            item_price:{
                required:true
            },
            item_details:{
                required:true
            },
            category:{
                required:true
            },
            stockType:{
                required:true
            }
        },
        onkeyup: false,
        onfocusout: false,
        onsubmit: true,
        highlight: function (element, errorClass, validClass) 
        {
            $(element).parents('.form-control').removeClass('has-success').addClass('has-error');
        },
        unhighlight: function (element, errorClass, validClass) 
        {
            $(element).parents('.form-control').removeClass('has-error').addClass('has-success');
        },
        errorPlacement: function (error, element) 
        {
            if(element.hasClass('select2') && element.next('.select2-container').length) 
            {
            error.insertAfter(element.next('.select2-container'));
            } 
            else if (element.parent('.form-group').length) 
            {
                error.insertAfter(element.parent());
            }
            else if (element.prop('type') === 'radio' && element.parent('.radio-inline').length) 
            {
                error.insertAfter(element.parent().parent());
            }
            else if (element.prop('type') === 'checkbox' || element.prop('type') === 'radio') 
            {
                error.appendTo(element.parent().parent());
            }
            else 
            {
                error.insertAfter(element);
            }
        },
        submitHandler: function(form) {
            form.submit();
        }
    });
});