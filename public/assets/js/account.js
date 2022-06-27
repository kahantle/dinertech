$(document).ready(function() {
  $(document).on('click', '.makeCallNotificationUpdate', function(event) {
    event.preventDefault();
    event.stopPropagation();
    var currentValue = $(this).prop("checked");
    var value = $(this).attr('value');
    var currentId = $(this).attr('id');
    var type = $(this).data('type');
    if(type=="Pin" && currentValue){
      window.location.href = pin_route
      return false
    }
    Swal.fire({
        title: "Are you sure?",
        text: "You want to change "+type+" setting?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, change it!"
    }).then(function(result) {
       if (result.value) {
        $.ajax({
          headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          url: url,
          type: "POST",
          dataType: "json",
          data:{
            type:type,
            notification_value:value
          },
          beforeSend: function() {
            $("body").preloader();
          },
          complete: function(){
            $("body").preloader('remove');
          }, 
          success: function (res) {
            if(res.success){
              $("#"+currentId).prop('checked',currentValue);
              toastr.success(res.message,'',toastrSetting);
            }else{
              toastr.error(res.message,'',toastrSetting);
            }
          },
          error: function (xhr, ajaxOptions, thrownError) {
              swal.fire("Error change setting!", "Please try again", "error");
          }
      });
      } else if (result.dismiss === "cancel") {
     
      }
   });
  });


  $(document).on('blur', '.setPin', function(event) {
    var is_valid_form_1 = false;
    var form_type = $("#form_type").val();
    var input_1 = $("#digit-1").val();
    var input_2 = $("#digit-2").val();
    var input_3 = $("#digit-3").val();
    var input_4 = $("#digit-4").val();
    var pin = input_1+input_2+input_3+input_4;
    if(input_1 && input_2 && input_3 && input_4){
        var pin = input_1+input_2+input_3+input_4;
        $.ajax({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          url: verify_pin_route,
          type: "POST",
          dataType: "json",
          data:{
            pin:pin
          },
          beforeSend: function() {
            $("body").preloader();
          },
          complete: function(){
            $("body").preloader('remove');
          }, 
          success: function (res) {
            if(res.success){
              toastr.success(res.message,'',toastrSetting);
              window.location.href = account_route
            }else{
              toastr.error(res.message,'',toastrSetting);
              $('#verify_pin')[0].reset();
            }
          },
          error: function (xhr, ajaxOptions, thrownError) {
          }
        });
    }
  });


  $(document).on('click', '.reset_form', function(event) {
    $('#verify_pin')[0].reset();
  });

  $(document).on("click", "#save-tax", function () {
    var type = $(this).data("type");
    var salesTax = $("#tax-value").val();
      $.ajax({
          headers: {
              "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
          },
          url: url,
          type: "POST",
          dataType: "json",
          data: {
              type: type,
              notification_value: salesTax,
          },
          beforeSend: function () {
              $("body").preloader();
          },
          complete: function () {
              $("body").preloader("remove");
          },
          success: function (res) {
              if (res.success) {
                  toastr.success(res.message, "", toastrSetting);
              } else {
                  toastr.error(res.message, "", toastrSetting);
              }
          },
          error: function (xhr, ajaxOptions, thrownError) {
              swal.fire("Error change setting!", "Please try again", "error");
          },
      });
  });
});
