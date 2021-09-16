$(document).ready(function() {
  $(document).on('click', '.action', function() {
    var url = $(this).data('route');
    var value = $(this).data('value');
    Swal.fire({
      title: "Are you sure?",
      text: "You want to "+value+" order !",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Yes, "+value+" order !"
    }).then(function(result) {
      if (result.isConfirmed) {
       if (value==='Accept') {
          $(".openTimePickerPopUp").css('visibility', 'visible');
          $(".openTimePickerPopUp").css('opacity', 1);
          $("#actionUrl").val(url);
        }else{
          $.ajax({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: url,
            type: "post",
            dataType: "json",
            beforeSend: function() {
              $("body").preloader();
            },
            complete: function(){
              $("body").preloader('remove');
            }, 
            success: function (res) {
              toastr.success(res.alert);
              window.location.href = res.route;
            }
          });
        }
      }else{
       
      }
    });
  });

  $(".closeModal" ).bind( "click", function(e) {
    $(".closeAllModal").css('visibility', 'hidden');
    $(".closeAllModal").css('opacity', 0);
  });

$(".makeActionRequest").bind( "click", function(e) {
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: $(".actionUrl").val(),
        data:{
          type : $(".sltMinutes").val(),
          minutes: $(".sltDuration").val()
        },
        type: "post",
        dataType: "json",
        beforeSend: function() {
          $("body").preloader();
        },
        complete: function(){
          $("body").preloader('remove');
        }, 
        success: function (res) {
          toastr.success(res.alert);
          window.location.href = res.route;
        }
      });
  });
});