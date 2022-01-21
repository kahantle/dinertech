$(function(){

    "use strict";
	var baseUrl = $("#base-url").attr('content');

	function initialize() {
	  var input = document.getElementById('searchTextField');
	  var autocomplete = new google.maps.places.Autocomplete(input);
	    google.maps.event.addListener(autocomplete, 'place_changed', function () {
	        var place = autocomplete.getPlace();
	        console.log(place);
	        document.getElementById('addressTextBox').value = place.formatted_address;
	        document.getElementById('cityName').value = place.address_components[2].long_name;
	        document.getElementById('stateName').value = place.address_components[4].long_name;
	        document.getElementById('latitude').value = place.geometry.location.lat();
	        document.getElementById('longitude').value = place.geometry.location.lng();
	    });
	}
	google.maps.event.addDomListener(window, 'load', initialize);

	$("#createAddress").validate({
		rules:{
		    address:{
		        required:true,
		    },
		    address_type:{
		        required:true
		    },
		    zipcode:{
		        required:true,
		    },
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