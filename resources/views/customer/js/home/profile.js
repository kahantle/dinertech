$(function(){

	$(document).on('click','.update-profile',function(){
		// disableTxt();
		$(".inputname").prop('disabled',false);
		$(".inputsurname").prop('disabled',false);
		$(".inputemail").prop('disabled',false);
		$(".inputmob").prop('disabled',false);
		$(".inputaddress").prop('disabled',false);
        $(".profile_pic_upload").prop('disabled',false);
        $(".submitProfile").prop('disabled',false);
	});

	 $("#profile-update").validate({
   		rules:{
   			first_name:{
   				required:true
   			},
   			last_name:{
   				required:true
   			},
   			physical_address:{
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
            else if (element.parent('.input-group').length) 
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
        },
    });
});