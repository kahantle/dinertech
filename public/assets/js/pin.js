$(document).ready(function() {
  $(document).on('blur', '.setPin', function(event) {
    var is_valid_form_1 = false;
    var form_type = $("#form_type").val();
    var input_1 = $("#digit-1").val();
    var input_2 = $("#digit-2").val();
    var input_3 = $("#digit-3").val();
    var input_4 = $("#digit-4").val();
    var pin = input_1+input_2+input_3+input_4;
    if((input_1 && input_2 && input_3 && input_4) && is_valid_form_1==false){
      $(".form_pin").hide();
      $(".form_confirm_pin").show();
      is_valid_form_1 = true;
    }

    if(is_valid_form_1){
        var input_confirm_1 = $("#digit_confirm_1").val();
        var input_confirm_2 = $("#digit_confirm_2").val();
        var input_confirm_3 = $("#digit_confirm_3").val();
        var input_confirm_4 = $("#digit_confirm_4").val();
        if(input_confirm_1 && input_confirm_2 && input_confirm_3 && input_confirm_4){
          var confirm_pin = input_confirm_1+input_confirm_2+input_confirm_3+input_confirm_4;
          if(pin===confirm_pin){
                $.ajax({
                  headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  },
                  url: pin_route,
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
                    }
                  },
                  error: function (xhr, ajaxOptions, thrownError) {
                      swal.fire("Error change setting!", "Please try again", "error");
                  }
              });

          }else{
            is_valid_form_1 = false;
            toastr.error("Pin and Confirm pin should match.",'',toastrSetting);
            $(".form_pin").show();
            $(".form_confirm_pin").hide();
            $('#menuForm')[0].reset();
          }
        }
      }
  });

  $(document).on('click', '.reset_form', function(event) {
    $('#menuForm')[0].reset();
  });

});
