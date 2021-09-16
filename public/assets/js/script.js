$(function () {

	const $button  = document.querySelector('#sidebar-toggle');
	const $wrapper = document.querySelector('#wrapper');
	
	if($button !== null) {
	  $button.addEventListener('click', (e) => {
	    e.preventDefault();
	    $wrapper.classList.toggle('toggled');
	  });
	}
	
	$(".toggle-password").click(function(e) {
	  e.preventDefault();
	  $(this).find('i.fa').toggleClass("fa-eye fa-eye-slash");
	  var input = $($(this).attr("toggle"));
	  if (input.attr("type") == "password") {
	    input.attr("type", "text");
	  } else {
	    input.attr("type", "password");
	  }
	});


});

$(document).ready(function(){
	$('.digit-group-input').each(function() {
		$(this).attr('maxlength', 1);
		$(this).on('keyup', function(e) {
			var parent = $(this).parent();
			if(e.keyCode === 8 || e.keyCode === 37) {
				var prev =$(this).data('previous');
				if(prev.length) {
					$('[data-next='+prev+']').select();
				}
			} else if((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 65 && e.keyCode <= 90) || (e.keyCode >= 96 && e.keyCode <= 105) || e.keyCode === 39) {
				var next = $(this).data('next');
				if(next) {
					$('[data-previous='+next+']').select();
				}
			}
		});
	});});


	$(document).ready(function(){
		$('.digit-card-input').each(function() {
			$(this).attr('maxlength', 4);
			$(this).on('keyup', function(e) {
				if($(this).val().length>3){
				var parent = $(this).parent();
				if(e.keyCode === 8 || e.keyCode === 37) {
					var prev =$(this).data('previous');
					if(prev.length) {
						$('[data-next='+prev+']').select();
					}
				} else if((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 65 && e.keyCode <= 90) || (e.keyCode >= 96 && e.keyCode <= 105) || e.keyCode === 39) {
					var next = $(this).data('next');
					if(next) {
						$('[data-previous='+next+']').select();
					}
				}
			}
			});
		});});