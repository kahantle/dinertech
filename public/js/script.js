$(function () {
	const $button  = document.querySelector('#sidebar-toggle');
	const $wrapper = document.querySelector('#wrapper');
	$button.addEventListener('click', (e) => {
	  e.preventDefault();
	  $wrapper.classList.toggle('toggled');
	});
	$(".toggle-password").click(function() {
	  $(this).toggleClass("fa-eye fa-eye-slash");
	  var input = $($(this).attr("toggle"));
	  if (input.attr("type") == "password") {
	    input.attr("type", "text");
	  } else {
	    input.attr("type", "password");
	  }
	});
});