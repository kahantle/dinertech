$(function () {
    "use strict";
    var i = parseInt($("#last_number").val());
    $("#add-more").on('click',function () {
        var html = "";
        html += "<div class='row'>";
            html += "<div class='col-xl-2 col-md-3 col-sm-4 col-5'>";
                html += "<div class='form-group' style='display: inline-block'>";
                    html +=
                        "<input type='time' class='add-time opening_time' id='opening_hours' name='opening_hours[]' data-number='"+i+"' placeholder='Selecting Open Hours'>";
                    html += "<span for='opening_hours' class='help-block'></span>";
                html += "</div>";
            html += "</div>";
            html += "<div class='col-xl-2 col-md-3 col-sm-4 col-5'>";
                html += "<div class='form-group' style='display: inline-block'>";
                            html +=
                                "<input type='time' class='add-time closing_time' id='closing_hours' name='closing_hours[]' data-number='"+i+"' placeholder='Selecting Closeing Hours'>";
                            html += "<span for='closing_hours' class='error'></span>";
                html += "</div>";
            html += "</div>";
            html += "<div class='col-xl-2 col-md-2 col-sm-3 mt-3'>";
                html += "<button class='btn btn-danger remove-btn' type='button'>Remove</button>";
            html += "</div>";
        html += "</div>";
        $(".add-more-times").append(html);
        i++;
    });

    const opening_hours = {};
    $(document).on("change", ".opening_time", function () {
        var count_length = $(this).data('number');
        opening_hours[count_length] = $(this).val();
    });
    $( ".opening_time" ).each(function() {
        $( this ).trigger("change");
    });
    
    const closing_hours = {};
    console.log((Date.parse("1-1-2000 " + "12:00") < Date.parse("1-1-2000 " + "14:06") < Date.parse("1-1-2000 " +"17:06")));
    $(document).on("change", ".closing_time", function () {
        var count_length = $(this).data('number');
        closing_hours[count_length] = $(this).val();
            $.each(opening_hours, function (key, value) {
                if(Date.parse("1-1-2000 " + opening_hours[key]) > Date.parse("1-1-2000 " + closing_hours[key]))
                {
                    alert("Please Select End Max time");
                    $('.closing_time[data-number="'+key+'"]').val('');
                }
                else{
                    if(key!=0){
                        $.each(opening_hours, function(key1, value1) {
                            
                            if((key1 != key && key1 < key)  && Date.parse("1-1-2000 " + opening_hours[key]) <= Date.parse("1-1-2000 " + closing_hours[key1]) && Date.parse("1-1-2000 " + closing_hours[key]) >= Date.parse("1-1-2000 " + opening_hours[key1])) {
                                //else if(key!=0 && (Date.parse("1-1-2000 " + opening_hours[key-1]) < Date.parse("1-1-2000 " + opening_hours[key]) < Date.parse("1-1-2000 " + closing_hours[key-1])))
                                delete opening_hours[key];
                                delete closing_hours[key];
                
                                alert("Please do not Select In Between Time");
                                $('.opening_time[data-number="'+key+'"]').val('');
                                $('.closing_time[data-number="'+key+'"]').val('');
                            }
                        });
                    }
                }
                /*else if(key!=0 && (Date.parse("1-1-2000 " + opening_hours[key]) > Date.parse("1-1-2000 " + opening_hours[key-1]) && Date.parse("1-1-2000 " + opening_hours[key]) < Date.parse("1-1-2000 " + closing_hours[key-1]))) {
                //else if(key!=0 && (Date.parse("1-1-2000 " + opening_hours[key-1]) < Date.parse("1-1-2000 " + opening_hours[key]) < Date.parse("1-1-2000 " + closing_hours[key-1])))
                
                    alert("Please do not Select In Between Time");
                    $('.opening_time[data-number="'+key+'"]').val('');
                    $('.closing_time[data-number="'+key+'"]').val('');
                }*/
                
                /*if (
                    value >= $(".opening_time").last().val() &&
                    closing_hours[key] >= $(".closing_time").last().val() 
                )
                {
                    $("#submit_form").attr('disable',true);
                    alert("Please Enter Valid time");
                    $('.opening_time').last().val('');
                    $('.closing_time').last().val('');
                } else {
                     $("#submit_form").prop("disable", false);
                }*/
                //console.log(value);
                //console.log(closing_hours[count_elements]);
            });
    });
    $( ".closing_time" ).each(function() {
        $( this ).trigger("change");
    });
    //$('.closing_time').trigger("change");
    $(document).on("click", ".remove-btn", function () {
        $(this).parent().parent().remove();
    });

    $("#submit_form").on('click', function () {
        // console.log($("#hourForm").vaild());
    });
});