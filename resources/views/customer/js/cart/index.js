$(function(){
    "use strict";
    var baseUrl = $("#base-url").attr('content');

    $(document).on("click",".increment",function(){
        var menuId = $(this).data('menu-id');
        var menuKey = $(this).data('menu-key');
        // var newQuantity = increaseValue(menuId);
        // var oldTotal = $(this).data('menu-total');
        // var newTotal = oldTotal * newQuantity;
        // $(".menuTotal-"+menuId).html(newTotal.toFixed(2));
        $.ajax({
          type: "POST",
          headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          url: baseUrl+'/quantity-increment',
          data: {
            menuId:menuId,
            menuKey:menuKey,
          },
          dataType: "html",
          success: function(response) {
            if(response)
            {
                window.location.reload();
                // $('.repeat-last-cart').trigger('click');
            }
            // $(".cart-alert-popup").html(response);
            // $(".cart-alert").modal('show');
          }
        });
    });

    $(document).on("click",".decrement",function(){
        var menuId = $(this).data('menu-id');
        var menuKey = $(this).data('menu-key');
        // decreaseValue(menuId);
        $.ajax({
          type: "POST",
          headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          url: baseUrl+'/quantity-decrement',
          data: {
            menuId:menuId,
            menuKey:menuKey,
          },
          dataType: "html",
          success: function(response) {
            if(response)
            {
                window.location.reload();
                // $('.repeat-last-cart').trigger('click');
            }
            // $(".cart-alert-popup").html(response);
            // $(".cart-alert").modal('show');
          }
        });
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
      return value;
    }

    function decreaseValue(menuId) {
      var value = parseInt(document.getElementById('quantity-'+menuId).value, 10);
      value = isNaN(value) ? 1 : value;
      value < 1 ? value = 1 : '';
      value--;
      document.getElementById('quantity-'+menuId).value = value;
      return value;
    }

    $(document).on("click",".cart-customize",function(){
        $(".customize-menu").html("");
        var menuId = $(this).data('menu-id');
        var cartKey = $(this).data('cart-key');
        $.ajax({
          type: "POST",
          headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          url: baseUrl+'/cart/customize/',
          data: {
             menuId:menuId,
             cartKey:cartKey,
          },
          dataType: "html",
          success: function(response) {
             $(".customize-menu").html(response);
             $(".customize").modal('show');
             $(".menuId").val(menuId);
          }
        });
    });

    // $(".UpdateItem").on("click",function () {
    //   $.ajax({
    //     type: "POST",
    //     headers: {
    //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //     },
    //     url: $("#customizeCartItem").attr("action"),
    //     data: $("#customizeCartItem").serialize(),
    //     // dataType:"json",
    //     dataType: "html",
    //     success: function(data) {
    //       if(data == 'Success')
    //       {
    //         window.location.reload();
    //       }
    //     }
    //   });
    // });

    $(document).on("click",".selectTiming",function(){
        $(".options").addClass('show');
    });

    $(document).on("change",".timingDropDown",function(){
       if($(this).val() == 0)
       {
         $(".oreder-text").html('Current Timing is set in your order.');
         $("#future-order").modal("hide");
         $(".options").addClass('hide');
         $(".options").removeClass('show');
         var currentDate = new Date();
         var h =  currentDate.getHours(), m = currentDate.getMinutes();
         var _time = (h > 12) ? (h-12 + ':' + m +' PM') : (h + ':' + m +' AM');
         $("#orderDate").val(currentDate.getFullYear()+'-'+currentDate.getMonth()+'-'+currentDate.getDate());
         $("#orderTime").val(_time);
       }
       else if($(this).val() == 1)
       {
         $("#future-order").modal("show");

         var defaults = {
             calendarWeeks: true,
             showClear: true,
             showClose: true,
             allowInputToggle: true,
             useCurrent: true,
             ignoreReadonly: true,
             minDate: new Date(),
             toolbarPlacement: 'top',
             locale: 'en',
             icons: {
                 time: 'fa fa-clock-o',
                 date: 'fa fa-calendar',
                 up: 'fa fa-angle-up',
                 down: 'fa fa-angle-down',
                 previous: 'fa fa-angle-left',
                 next: 'fa fa-angle-right',
                 today: 'fa fa-dot-circle-o',
                 clear: 'fa fa-trash',
                 close: 'fa fa-times'
             }
         };
         var optionsDatetime = $.extend({}, defaults, {
             format: 'DD-MM-YYYY HH:mm'
         });

         var optionsDate = $.extend({}, defaults, {
             format: 'DD-MM-YYYY'
         });

         // var optionsTime = $.extend({}, defaults, {
         //     format: 'HH:mm a'
         // });

         $('.datepicker').datetimepicker(optionsDate);
         // $('.timepicker').datetimepicker(optionsTime);
         $('.datetimepicker').datetimepicker(optionsDatetime);
         $(".options").addClass('hide');
         $(".options").removeClass('show');

        Date.prototype.addHours= function(h){
            this.setHours(this.getHours()+h);
            return this;
        }
        var today = new Date().addHours(1.50);
        var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
         $('.timepicker').datetimepicker({
             defaultDate:moment(time, "HH:mm a"),
             format: 'HH:mm a'
         });
       } 
    });

    $(document).on("click",".set-order-time",function(){
        // var date = moment($(".select-date").val());
        var date = $(".select-date").val();
        var time = $(".select-time").val(); 
        
        $("#orderDate").val(date);
        $("#orderTime").val(time);
        $(".oreder-text").html('your order will be ready at '+date+' and time '+time);
        $("#future-order").modal("hide");
        $(".options").removeClass('show');
        $(".options").addClass('hide');
    });

});