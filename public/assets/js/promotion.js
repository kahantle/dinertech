$(document).ready(function(e) {
  $(document).on('click', '.delete', function() {
    var id = $(this).data('id')
    var url = "promotion/delete/"+id;

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

  $(document).on('click', '.changeStatus', function() {
            var isChecked = $(this).prop('checked');
            var id = $(this).data('id')
            var url = "promotion/status/"+id+"/"+isChecked;
            $.ajax({
              headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              url: url,
              type: "POST",
              dataType: "json",
              beforeSend: function() {
                $("body").preloader();
                    },
                    complete: function(){
                $("body").preloader('remove');
                    }, 
              success: function (res) {
                toastr.success(res.alert);
              },
              error: function (xhr, ajaxOptions, thrownError) {
                  
              }
          });
  });


  $(document).on('click', '.promotionType', function() {
    if($(this).parent().find('input:checkbox:first').prop('checked') == false){
      $(this).parent().find('input:checkbox:first').attr('checked', 'checked');
      $(".promotionPopup").css('visibility', 'visible');
      $(".promotionPopup").css('opacity', 1);
    }else{
      $(this).parent().find('input:checkbox:first').attr('checked',false);
      $(".closeAllModal").css('visibility', 'hidden');
      $(".closeAllModal").css('opacity', 0);
    }
  });


  $( ".closeModal" ).bind( "click", function(e) {
    $(".closeAllModal").css('visibility', 'hidden');
    $(".closeAllModal").css('opacity', 0);
  });
});