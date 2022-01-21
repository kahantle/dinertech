$(function(){

    "use strict";
	var baseUrl = $("#base-url").attr('content');

	$(document).on("change","#app_notification",function(){
		$.ajax({
		  type: "POST",
		  headers: {
		     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		  },
		  url: baseUrl+'/setting/update',
		  data: {
		     type:"app_setting",
		     value:($(this).is(':checked') == true) ? 1 : 0,
		  },
		  dataType: "html",
		  success: function(response) {
		     if(response)
		     {
		     	window.location.reload();
		     }
		  }
		});
	});

	$(document).on("change","#chat_notification",function(){
		$.ajax({
		  type: "POST",
		  headers: {
		     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		  },
		  url: baseUrl+'/setting/update',
		  data: {
		     type:"chat_setting",
		     value:($(this).is(':checked') == true) ? 1 : 0,
		  },
		  dataType: "html",
		  success: function(response) {
		     if(response)
		     {
		     	window.location.reload();
		     }
		  }
		});
	});

	$(document).on("change","#location_tracking",function(){
		$.ajax({
		  type: "POST",
		  headers: {
		     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		  },
		  url: baseUrl+'/setting/update',
		  data: {
		     type:"location_setting",
		     value:($(this).is(':checked') == true) ? 1 : 0,
		  },
		  dataType: "html",
		  success: function(response) {
		     if(response)
		     {
		     	window.location.reload();
		     }
		  }
		});
	});

})