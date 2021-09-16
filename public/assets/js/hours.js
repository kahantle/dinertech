$(document).ready(function() {
  $(document).on('click', '.delete', function() {
    var url = $(this).data('route');
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!"
    }).then(function(result) {
       if (result.value) {
        $.ajax({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: url,
            type: "GET",
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
            },
            error: function (xhr, ajaxOptions, thrownError) {
                swal.fire("Error deleting!", "Please try again", "error");
            }
        });
      } else if (result.dismiss === "cancel") {
     
      }
   });
  });
});