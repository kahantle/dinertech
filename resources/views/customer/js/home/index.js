$(function(){
  
  "use strict";
	var baseUrl = $("#base-url").attr('content');

	$("#login").validate({
        rules:{
          email:{
            required:true
          },
          password:{
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
            $.ajax({
              type: "POST",
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              url: $(form).attr("action"),
              data: $(form).serialize(),
              // dataType:"json",
              dataType: "html",
              success: function(data) {
                if(data == 'Success')
                {
                    window.location.reload();
                }
                else
                {
                  $("#login-error").html(data);
                }
              }
            });
        }
	});


    $("#customer-signup").validate({
      rules:{
        first_name:{
          required:true
        },
        last_name:{
          required:true
        },
        physical_address:{
          required:true
        },
        city:{
          required:true
        },
        state:{
          required:true
        },
        zipcode:{
          required:true
        },
        mobile_number:{
          required:true,
          number:true,
          mobileUnique:true
        },
        email_id:{
          required:true,
          email:true,
          emailUnique:true
        },
        password:{
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
          $.ajax({
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: $(form).attr("action"),
            data: $(form).serialize(),
            dataType:"json",
            success: function(data) {
              if(data.success)
              {
                swal("Success","Signup succcessfully.", "success")
                  .then((result) => {
                    // Reload the Page
                    location.reload();
                });
                // window.location.replace(baseUrl);
              }
              else 
              {
                var errors = [];
                $.each( data.error, function( key, value) {
                  // $("#register-error").html(value);
                  errors.push(value);
                });
                $("#register-error").html(errors.join(" <br> "));
              }
            }
          });
      }
    });

    jQuery.validator.addMethod("emailUnique", function(value, element){
        var response = false;
        $.ajax({
          url:baseUrl+"/email/unique",
          type:"POST",
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          async: false,
          data:{
            email:value
          },
          success:function (data) {
            response = (data == true) ? true : false;
            
          }
        });
        return response;
    }, "This email is already taken! Try another.");
    
    jQuery.validator.addMethod("mobileUnique", function(value, element){
      var response = false;
      $.ajax({
        url:baseUrl+"/mobile/unique",
        type:"POST",
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        async: false,
        data:{
          mobile:value
        },
        success:function (data) {
          response = (data == true) ? true : false;
        }
      });
      return response;
  }, "This mobile number is already taken! Try another.");

    $("#forget-password").validate({
        rules:{
            email_mobile_number:{
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
            $.ajax({
              type: "POST",
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              url: $(form).attr("action"),
              data: $(form).serialize(),
              dataType: "html",
              success: function(data) {
                if(data == true)
                {
                  document.getElementById("forgotPassword").style.display = "none";
                  $("#verification-btn").modal("show");
                  // swal("Success","OTP sent succcessfully.", "success")
                  // .then((result) => {
                  //   // Reload the Page
                  //   location.reload();
                  // });
                }
                else 
                {
                    swal("Error", "User not found.", "error")
                    .then((result) => {
                      // Reload the Page
                      location.reload();
                    });
                }
              }
            });
        }
    });

    $(document).on("click","#submitOtp",function(e){
        e.preventDefault();
         // var allBlank = true; //assume they're all blank until we discover otherwise
         //  //loop through each of the inputs matched
         //  $('#verifyOtp :input').each(function(index, el)
         //  {
         //    if ($(el).val().length != 0) allBlank = false; //they're not all blank anymore
         //  });
         // if(allBlank == false)
         // {
         //    $(".otp-error").removeClass("hide");
         //    $(".otp-error").addClass("show");
         // }
         // else
         // {
             $.ajax({
              type: "POST",
              headers: {
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              url: $("#verifyOtp").attr("action"),
              data: $("#verifyOtp").serialize(),
              dataType: "html",
              success: function(data) {
                if(data)
                {
                    $("#uid").val(data);
                   document.getElementById("verification").style.display = "none";
                   $("#verification-success").modal("show");
                  // swal("Success","OTP sent succcessfully.", "success")
                  // .then((result) => {
                  //   // Reload the Page
                  //   location.reload();
                  // });
                }
                else 
                {
                     swal("Error", "Please enter valid otp.", "error");
                }
              }
            });
         // }
    });

    $("#reset-password").validate({
        rules:{
            password:{
                required:true,
                min:6
            },
            password_confirmation:{
                required:true,
                min:6,
                equalTo:"#password",
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
            $.ajax({
             type: "POST",
             headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             },
             url: $(form).attr("action"),
             data: $(form).serialize(),
             dataType: "html",
             success: function(data) {
               if(data == true)
               {
                 swal("Success","Password reset successfully.", "success")
                 .then((result) => {
                   // Reload the Page
                   location.reload();
                 });
               }
               else 
               {
                    swal("Error", "User not found.", "error")
                    .then((result) => {
                      // Reload the Page
                      location.reload();
                    });
               }
             }
           });
        }
    });

    $(document).on("click",".category",function(){
        $("#menuIteams").empty();
        var categoryId = $(this).data('category-id');
        var restaurantId = $(this).data('restaurant-id');
        $.ajax({
         type: "POST",
         headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         },
         url: baseUrl+'/menu-items',
         data: {
            categoryId:categoryId,
            restaurantId:restaurantId
         },
         dataType: "html",
         success: function(response) {
            $("#menuIteams").html(response);
            $(".category"+categoryId).addClass('active');
         }
       });
    });

    $(document).on("click",".cart",function(){
        var menuId = $(this).data("menu-id");
        $(".modifierItems-"+menuId).empty();
        $.ajax({
          type: "POST",
          headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          url: baseUrl+'/getMenumodifier',
          data: {
             menuId:menuId,
          },
          dataType: "html",
          success: function(response) {
             $(".modifierItems-"+menuId).html(response);
             $(".modifier-menu-"+menuId).modal('show');
             $(".menuId").val(menuId);
             // $('body').css("padding-right","");
             $(".paddingRemove").removeAttr("style");

          }
        }); 
    });

    $(document).on("click",".add-item",function(){
        var menuId = $(this).data("menu-id");
        $(".cart-quantity-counter-"+menuId).empty();
        // $(".quantity-counter-"+menuName).removeClass("hide");
        // $(".quantity-counter-"+menuName).addClass("show");
        // $(".cart-"+menuName).addClass("hide");
        $(".modalClose").trigger('click');
        // increaseValue(menuId);
        $.ajax({
          type: "POST",
          headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          url: $(".cartform").attr('action'),
          data: $(".cartform").serialize(),
          dataType: "html",
          success: function(response) {
            $(".cart-quantity-counter-"+menuId).html(response);
            $("#lblCartCount").html($(".cartCount").val());
            snakbarTostar("Item added to cart successfully.");
             // $("#lblCartCount").html(response);
            //  window.location.reload();
             // $(".modifier-increase").addClass("increase-with-modifire");
             // $(".modifier-decrease").addClass("decrease-with-modifire");
             // $(".modifier-increase").removeClass("increase");
             // $(".modifier-decrease").removeClass("decrease");
          }
        });
    });

    $(document).on("click",".modalClose",function(){
        var menuId = $(this).data('menu-id');
        $(".paddingRemove").removeAttr("style");
        $(".modifier-menu-"+menuId).modal('hide');
    });

    $(document).on("click",".add-to-cart",function(){
        var menuId = $(this).data("menu-id");
        var menuName = $(this).data("menu-name");
        var categoryId = $(this).data("category-id");
        // $(".quantity-counter-"+menuName).removeClass("hide");
        // $(".quantity-counter-"+menuName).addClass("show");
      console.log(baseUrl);
        $.ajax({
          type: "POST",
          headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          url: baseUrl+'/add-to-cart',
          data: {
             menuId:menuId,
             menuName:menuName,
             categoryId:categoryId,
          },
          dataType: "html",
          success: function(response) {
            $(".cart-quantity-counter-"+menuId).html(response);
            $("#lblCartCount").html($(".cartCount").val());
            snakbarTostar("Item added to cart successfully.");
          }
        });
    });

    

    $(document).on("click",".increase-with-modifire",function(){
        $(".cart-alert-popup").html();
        var menuId = $(this).data('menu-id');
        $.ajax({
          type: "POST",
          headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          url: baseUrl+'/opencart-alert-modal',
          data: {
            menuId:menuId,
          },
          dataType: "html",
          success: function(response) {
            $(".cart-alert-popup").html(response);
            $(".cart-alert").modal('show');
          }
        });
    });

    $(document).on("click",".decrease-with-modifire",function(){
        $("#decrease-modal").modal('show');
    });

    $(document).on("click",".repeat-last",function(){
        var menuId = $(this).data('menu-id');
        var cartKey = $(this).data('cart-key');
        $.ajax({
          type: "POST",
          headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          url: baseUrl+'/add-to-repeatLast',
          data: {
            menuId:menuId,
            cartKey:cartKey,
          },
          dataType: "html",
          success: function(response) {
            if(response)
            {
                increaseValue(menuId);
                // $('.repeat-last-cart').trigger('click');
            }
            // $(".cart-alert-popup").html(response);
            // $(".cart-alert").modal('show');
          }
        });
    });

    $(document).on("click",".cart-increase",function(){
        var menuId =$(this).data('menu-id');
        // increaseValue(menuId);
        $.ajax({
          type: "POST",
          headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          url: baseUrl+'/add-to-repeatLast',
          data: {
            menuId:menuId,
          },
          dataType: "html",
          success: function(response) {
            if(response)
            {
                increaseValue(menuId);
                // $('.repeat-last-cart').trigger('click');
            }
            // $(".cart-alert-popup").html(response);
            // $(".cart-alert").modal('show');
          }
        });
    });

    $(document).on("click",".increase",function(){
        var menuId =$(this).data('menu-id');
        var quantity = $("#quantity-"+menuId).val();
        if(quantity < 10)
        {
          // increaseValue(menuId);
          $.ajax({
            type: "POST",
            headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: baseUrl+'/add-to-repeatLast',
            data: {
              menuId:menuId,
            },
            dataType: "html",
            success: function(response) {
              if(response)
              {
                  increaseValue(menuId);
                  // $('.repeat-last-cart').trigger('click');
              }
              // $(".cart-alert-popup").html(response);
              // $(".cart-alert").modal('show');
            }
          });
        }
        {
          $("#quantity-"+menuId).val(quantity);
        }
    });

    $(document).on("click",".decrease",function(){
      var menuId = $(this).data('menu-id');
      var quantity = $("#quantity-"+menuId).val();
      if(quantity != 1)
      {
        $.ajax({
          type: "POST",
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          url: baseUrl+'/quantity-decrease',
          data: {
            menuId:menuId,
          },
          dataType: "html",
          success: function(response) {
            if(response)
            {
                decreaseValue(menuId);
                // $('.repeat-last-cart').trigger('click');
            }
            // $(".cart-alert-popup").html(response);
            // $(".cart-alert").modal('show');
          }
        });
      }
    });

    $(document).on("click",".cart-decrease",function(){
        var menuId =$(this).data('menu-id');
        var quantity = $("#quantity-"+menuId).val();
        if(quantity != 1)
        {
          $.ajax({
            type: "POST",
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: baseUrl+'/quantity-decrease',
            data: {
              menuId:menuId,
            },
            dataType: "html",
            success: function(response) {
              if(response)
              {
                  decreaseValue(menuId);
                  // $('.repeat-last-cart').trigger('click');
              }
              // $(".cart-alert-popup").html(response);
              // $(".cart-alert").modal('show');
            }
          });
        }
    });

    $(document).on("click",".add-new-item",function(){
        var menuId = $(this).data('menu-id');
        $.ajax({
          type: "POST",
          headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          url: baseUrl+'/getMenumodifier',
          data: {
             menuId:menuId,
          },
          dataType: "html",
          success: function(response) {
             $(".cart-alert").modal('hide');
             $(".modifierItems-"+menuId).html(response);
             $(".modifier-menu-"+menuId).modal('show');
             $(".menuId").val(menuId);
             // $('body').css("padding-right","");
             $(".paddingRemove").removeAttr("style");
          }
        });
    })

    $(document).on("click",".repeat-last-cart",function(){
        $(".cart-alert").modal('hide');
    })

    // $(document).on("click",".increase",function(){
    //     var menuId = $(this).data('menu-id');
    //     increaseValue(menuId)
    // })

    // $(document).on("click",".decrease",function(){
    //     var menuId = $(this).data('menu-id');
    //     increaseValue(menuId)
    // })

    $(document).on("change",".number",function(){
      var idAttr = $(this).attr('id');
      document.getElementById(idAttr).value = 10;
    });

    $("#searchItem").on("keyup keypress",function(){
      var searchItem = $(this).val();
      if(searchItem.length > 1)
      {
        $.ajax({
          type: "POST",
          headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          url: baseUrl+'/search/menuitem/',
          data: {
            searchItem:searchItem
          },
          dataType: "html",
          success: function(response) {
            console.log("if");
            $("#menuIteams").addClass('hide');
            $("#searchIteams").removeClass('hide');
            $("#searchIteams").html(response);
          }
        });
      }
      else
      {
        $("#searchIteams").empty();
        $("#menuIteams").removeClass('hide');
        $("#searchIteams").addClass('hide');
      }
    });

    function increaseValue(menuId) {
      var value = parseInt(document.getElementById('quantity-'+menuId).value, 10);
      value = isNaN(value) ? 1 : value;
      if(value < 10)
      {
        value++;
        document.getElementById('quantity-'+menuId).value = value;
      }
      else
      {
        value = document.getElementById('quantity-'+menuId).value;
      }
    }

    function decreaseValue(menuId) {
      var value = parseInt(document.getElementById('quantity-'+menuId).value, 10);
      value = isNaN(value) ? 1 : value;
      value < 1 ? value = 1 : '';
      if(value == 1)
      {
        value = 1;
      }
      else
      {
        value--;
      }
      document.getElementById('quantity-'+menuId).value = value;
    }

    function snakbarTostar(message) {
			var x = document.getElementById("snackbar");
      x.className = "show";
      $(".show").html(message);
			setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
		}
});

