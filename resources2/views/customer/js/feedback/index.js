$(function(){

	$("#feedbackForm").validate({
		rules:{
		    name:{
		        required:true,
		    },
		    phone_number:{
		        required:true
		    },
		    email:{
		        required:true,
		    },
		    feedback_type:{
		    	required:true,
		    },
		    message:{
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
		}
	});
});