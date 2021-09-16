$(document).ready(function(e) {
    $( ".closeModal" ).bind( "click", function(e) {
      $(".modifierGroupPopUp").css('visibility', 'hidden');
      $(".modifierGroupPopUp").css('opacity', 0);
  });

  $( ".openItemForm" ).bind( "click", function(e) {
    e.preventDefault();
    $('#menuForm')[0].reset();
    $(".closeAllModal").css('visibility', 'hidden');
    $(".closeAllModal").css('opacity', 0);
      var url = $(this).data('route');
      if(url){
        $(".itemHeading").html('Edit Menu item');
        $(".itemBtn").html('Update');
        $.ajax({
          headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
          },
          url: url,
          type: "GET",
          dataType: "JSON",
          beforeSend: function() {
            $("body").preloader();
                },
                complete: function(){
            $("body").preloader('remove');
                },
          success: function (res) {
            $("#item_name").val(res.data.item_name);
            $("#item_details").val(res.data.item_details);
            $("#item_price").val(res.data.item_price);
            $("#menu_id").val(res.data.menu_id);
            $("#category_id").val(res.data.category_id);
            $("#modifier_group_id").val(res.data.modifier_group_id);
            var img = $('<img width="200" height="197" id="dynamic">');
            $(".slt-img").html('');
            if(res.data.item_img){
              var image_path = image_url.replace(':change_param', res.data.item_img);
              img.attr('src', image_path);
              img.appendTo('.slt-img');
            }
            $(".openModifierItemFormPopUp").css('visibility', 'visible');
            $(".openModifierItemFormPopUp").css('opacity', 1);
          }
        });
      }else{
        $("#modifier_item_group_id").val($(this).data('id'));
        $(".openModifierItemFormPopUp").css('visibility', 'visible');
        $(".openModifierItemFormPopUp").css('opacity', 1);
      }
  });

  $( ".closeModal" ).bind( "click", function(e) {
    $(".closeAllModal").css('visibility', 'hidden');
    $(".closeAllModal").css('opacity', 0);
});



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

  $(document).on('click', '.searchTextBtn', function() {
    var text = $("#searchText").val();
    window.location.href = "http://" + window.location.host + window.location.pathname + '?searchText=' + text;
  });

  $(document).on('change', '.searchText', function() {
    var text = $("#searchText").val();
    if(text){
      window.location.href = "http://" + window.location.host + window.location.pathname + '?searchText=' + text;
    }else{
      window.location.href = "http://" + window.location.host + window.location.pathname ;
    }
  });

  
});