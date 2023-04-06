$(document).ready(function(e) {
  $.ajax({
    headers: {
      "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
    url: route,
    type: "POST",
    dataType: "JSON",
    success: function (res) {
      $("#accordion").html(res.html);
    }
  });

  $('#modifierItemForm').on('submit',function(e){
    e.preventDefault();
    var url = $(this).attr("action");
    $.ajax({
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
      },
      url: url,
      type: "POST",
      data: $('#modifierItemForm').serialize(),
      success: function (res) {
        toastr.success(res.alert);
        $("#accordion").html(res.html);
        $(".openModifierItemFormPopUp").css('visibility', 'hidden');
        $(".openModifierItemFormPopUp").css('opacity', 0);
      }
    });
  });

  $('#modifierForm').on('submit',function(e){
    e.preventDefault();
    var url = $(this).attr("action");
    var modifier_group_id = $('#modifier_group_id').val();
    $.ajax({
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
      },
      url: url,
      type: "POST",
      data: $('#modifierForm').serialize(),
      success: function (res) {
        toastr.success(res.alert);
        $("#accordion").html(res.html);
        $(".modifierGroupPopUp").css('visibility', 'hidden');
        $(".modifierGroupPopUp").css('opacity', 0);
        $('#modifier_id').append("<option value='"+ res.modifier_group_id +"'>" + res.modifier_group_name + "</option>");
      }
    });
  });

  $(document).on('click', '.openModifierForm', function(e) {
    e.stopPropagation();
    $('#modifierForm')[0].reset();
    $(".closeAllModal").css('visibility', 'hidden');
    $(".closeAllModal").css('opacity', 0);
    var url = $(this).data('route');

    if($(this).hasClass("open")){
      $(".groupBtn").html('Add');
      $(".groupHeading").html('Add modifier group');

    }else{
      $(".groupBtn").html('Update');
      $(".groupHeading").html('Edit modifier group');
    }

    if(url){
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
          if(res.data.allow_multiple=='1'){
            $('#allow_multiple').prop('checked', true);
          }
          $("#modifier_group_id").val(res.data.modifier_group_id);
          $("#modifier_group_name").val(res.data.modifier_group_name);
          $(".modifierGroupPopUp").css('visibility', 'visible');
          $(".modifierGroupPopUp").css('opacity', 1);
        }
      });
    }else{
      $(".modifierGroupPopUp").css('visibility', 'visible');
      $(".modifierGroupPopUp").css('opacity', 1);
    }
  });

  $(document).on('click', '.closeModal', function(e) {
    $(".modifierGroupPopUp").css('visibility', 'hidden');
    $(".modifierGroupPopUp").css('opacity', 0);
  });

  $(document).on('click', '.openModifierItemForm', function(e) {
    e.stopPropagation();
    $('#modifierItemForm')[0].reset();
    $(".closeAllModal").css('visibility', 'hidden');
    $(".closeAllModal").css('opacity', 0);
    var url = $(this).data('route');

    if($(this).hasClass("open")){
      $(".itemHeading").html('Add modifier group item');
      $(".itemBtn").html('Add');

    }else{
      $(".error-help-block").remove();
      $(".itemHeading").html('Edit modifier group item');
      $(".itemBtn").html('Update');
    }


    if(url){
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
          $("#modifier_group_item_name").val(res.data.modifier_group_item_name);
          $("#modifier_group_item_price").val(res.data.modifier_group_item_price);
          $("#modifier_item_group_id").val(res.data.modifier_group_id);
          $("#modifier_item_id").val(res.data.modifier_item_id);
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

  $(document).on('click', '.closeModal', function(e) {
    e.stopPropagation()
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
          $("#accordion").html(res.html);
        },
        error: function (xhr, ajaxOptions, thrownError) {
          swal.fire("Error deleting!", "Please try again", "error");
        }
      });
    } else if (result.dismiss === "cancel") {

    }
  });
  });

  $(".menu-price").on("change", function () {
    var price = $(this).val().split("$");
    price = parseFloat(price[1]).toFixed(2);
    $(this).val("$ " + price);
  });

  $(".remove-img").on('click', function () {
    var url = $(this).data("route");
    var menuId = $(this).attr('data-menu-id');
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this photo!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, remove it!",
    }).then(function (result) {
        if (result.value) {
            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                url: url,
                type: "POST",
                data: {
                    menuId: menuId,
                },
                // dataType: "json",
                beforeSend: function () {
                    $("body").preloader();
                },
                complete: function () {
                    $("body").preloader("remove");
                },
                success: function (res) {
                    if (res.error) {
                      toastr.error(res.error);
                    } else {
                      toastr.success(res.alert);
                      window.location.reload();
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    swal.fire("Error deleting!", "Please try again", "error");
                },
            });
        }
    });
  });
});
