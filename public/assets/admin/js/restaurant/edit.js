$(function(){

      "use strict";
	    
      $(".refresh").on('click',function(){
        location.reload();
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

      // $("#restaurantForm").validate({
      //   rules:{
      //     email:{
      //       required:true,
      //       emailUnique:true
      //     }
      //   },
      //   onkeyup: false,
      //   onfocusout: false,
      //   onsubmit: true,
      //   highlight: function (element, errorClass, validClass) 
      //   {
      //     $(element).parents('.form-control').removeClass('has-success').addClass('has-error');
      //   },
      //   unhighlight: function (element, errorClass, validClass) 
      //   {
      //     $(element).parents('.form-control').removeClass('has-error').addClass('has-success');
      //   },
      //   errorPlacement: function (error, element) 
      //   {
      //     if(element.hasClass('select2') && element.next('.select2-container').length) 
      //     {
      //       error.insertAfter(element.next('.select2-container'));
      //     } 
      //     else if (element.parent('.input-group').length) 
      //     {
      //         error.insertAfter(element.parent());
      //     }
      //     else if (element.prop('type') === 'radio' && element.parent('.radio-inline').length) 
      //     {
      //         error.insertAfter(element.parent().parent());
      //     }
      //     else if (element.prop('type') === 'checkbox' || element.prop('type') === 'radio') 
      //     {
      //         error.appendTo(element.parent().parent());
      //     }
      //     else 
      //     {
      //         error.insertAfter(element);
      //     }
      //   },
      // });
  
      // jQuery.validator.addMethod("emailUnique", function(value, element){
      //     var response = false;
      //     $.ajax({
      //       url:baseUrl+"/restaurant/email/unique",
      //       type:"POST",
      //       headers: {
      //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      //       },
      //       async: false,
      //       data:{
      //         email:value,
      //         restaurantUid:$("#restaurantUid").val()
      //       },
      //       success:function (data) {
      //         response = (data == true) ? true : false;
              
      //       }
      //     });
      //     return response;
      // }, "This email is already taken! Try another.");
});