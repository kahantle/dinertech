$(document).ready(function() {
  $(document).on('click', '.makeCallNotificationUpdate', function(event) {
    event.preventDefault();
    event.stopPropagation();
    var value = $(this).data('value');
    var url = $(this).data('route');
    $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: url,
        type: "POST",
        dataType: "json",
        data:{
          promotionTypeId:value
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
              window.location.href = res.route;
            }else{
              toastr.error(res.message,'',toastrSetting);
              window.location.href = res.route;
            }
          },
          error: function (xhr, ajaxOptions, thrownError) {
            swal.fire("Error change setting!", "Please try again", "error");
          }
        });
  });
});
