$(document).ready(function() {
    $(document).on('change', '.discountUsdPercentage', function() {
        var currentValue = $(this).val();
        if(currentValue=="usd"){
            $("#discount_amount").attr("placeholder", "Discount (USD)");
        }else{
            $("#discount_amount").attr("placeholder", "Discount (%)");
        }
    });


    $(document).on('change', '.setMinimumOrderAmount', function() {
        if($(this).prop('checked') == true){
            $(".minimumAmountDiv").show();
        }else{
            $(".minimumAmountDiv").hide();
        }
    });

    $(document).on('change', '.onlyForSelectedPayment', function() {
        if($(this).prop('checked') == true){
            $(".onlyForSelectedPaymentDiv").show();
        }else{
            $(".onlyForSelectedPaymentDiv").hide();
        }
    });


    $(document).on('change', '.onlyForSelectedPayment', function() {
        if($(this).prop('checked') == true){
            $(".onlyForSelectedPaymentDiv").show();
        }else{
            $(".onlyForSelectedPaymentDiv").hide();
        }
    });
});


$(document).on('click', '.categoryList', function() {
    var id =$(this).attr('id')
     if($(this).prop("checked") == true){
         $("."+id).prop("checked",true)        }
     else if($(this).prop("checked") == false){
         $("."+id).prop("checked",false)        }
 });


$(document).ready(function() {
    var buttonAdd = $("#add-button");
    var buttonRemove = $("#remove-button");
    var className = ".dynamic-field";
    var count = (is_edit==0)?0:$(className).length;
    var field = "";
    var maxFields = 50;
  
    function totalFields() {
      return $(className).length;
    }
  
    function addNewField() {
      var original_count = totalFields()
      original_count =original_count+1;
      count = totalFields() + 1;
      field = $("#dynamic-field-1").clone();
     
      var popup_field = '<div id="field-'+count+'" class="overlay field-popup popup_intial">';
      popup_field+='<div class="popup text-center">';
      popup_field+='<h2>Eligible Items '+count+'</h2>';
      popup_field+='<a class="close" href="#">&times;</a>';
      popup_field+='<div class="content">';
      popup_field+='<div id="accordion'+count+'" class="accordion">';
            category.forEach(function(value,key) {
                var rand_number_1 = Math.floor(Math.random() * 10000000);; 
                var rand_number_2 = Math.floor(Math.random() * 10000000);;  
                var rand_number_3 = Math.floor(Math.random() * 10000000);;  
                popup_field+='<div class="card mb-0">';
                popup_field+='<div class="form-group cs-checkbox">';
                popup_field+='<input type="checkbox" class="checkbox-custom categoryList" id="category'+rand_number_1+'" value="'+value.category_id+'" name="eligible_item['+original_count+']['+value.category_id+']">';
                popup_field+='<label for="category'+rand_number_1+'">'+value.category_name+'</label>';
                popup_field+='</div>';
                popup_field+='<div class="card-header collapsed" data-toggle="collapse" href="#collapse'+rand_number_2+'">';
                popup_field+='<a class="card-title">';
                popup_field+='<i class="fa fa-plus"></i>'
                popup_field+='</a>'
                popup_field+='</div>'
                popup_field+='<div id="collapse'+rand_number_2+'" class="card-body collapse" data-parent="#accordion'+count+'">';
                        value.category_item.forEach(function(value1,key1,) {
                            popup_field+='<div class="form-group cs-checkbox">';
                            popup_field+='<input type="checkbox" class="checkbox-custom category'+rand_number_1+'" id="item'+key1+rand_number_3+'" value="'+value1.menu_id+'" name="eligible_item['+original_count+']['+value.category_id+']['+value1.menu_id+']">';
                            popup_field+='<label for="item'+key1+rand_number_3+'">'+value1.item_name+'</label>';
                            popup_field+='</div>'
                        });
                         popup_field+='</div>';
                         popup_field+='</div>';
              });
              popup_field+='</div>';
              popup_field+='</div>';
              popup_field+='<div class="form-group form-btn justify-content-center">';   
                popup_field+='<div class="btn-custom">';
                popup_field+='<button disabled class="btn-blue"><span>Close</span></button>';
                popup_field+='</div>';
                popup_field+='</div>';
                popup_field+='</div>';
                popup_field+='</div>';
      $(".popup_intial:last").after($(popup_field));
      field.attr("id", "dynamic-field-" + count);
      field.children("label").text("Field " + count);
      field.find("input").val("");
      $(className + ":last").after($(field));

      $('.display_count').each(function(i, obj) {
          $(this).text("Eligible Items "+ ++i)
      });

    }
  
    function removeLastField() {
      if (totalFields() > 1) {
        $(className + ":last").remove();
        $(".popup_intial:last").remove();
      }
    }
  
    function enableButtonRemove() {
      if (totalFields() > 2) {
        buttonRemove.removeAttr("disabled");
        buttonRemove.addClass("shadow-sm");
      }
    }
  
    function disableButtonRemove() {
      if (totalFields() === 2) {
        buttonRemove.attr("disabled", "disabled");
        buttonRemove.removeClass("shadow-sm");
      }
    }
  
    function disableButtonAdd() {
      if (totalFields() === maxFields) {
        buttonAdd.attr("disabled", "disabled");
        buttonAdd.removeClass("shadow-sm");
      }
    }
  
    function enableButtonAdd() {
      if (totalFields() === (maxFields - 1)) {
        buttonAdd.removeAttr("disabled");
        buttonAdd.addClass("shadow-sm");
      }
    }
  
    buttonAdd.click(function() {
      addNewField();
      $('.first_link').each(function (key,value) {
      if(key>0){
           var i = key+1;
          $(this).attr('href',"#field-" + i);
      }
    });
      enableButtonRemove();
      disableButtonAdd();
    });
  
    buttonRemove.click(function() {
      removeLastField();
      disableButtonRemove();
      enableButtonAdd();
    });

    enableButtonRemove();
  });
  