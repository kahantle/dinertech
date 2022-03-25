$(function () {
    "use strict";

    $("#add-more").on('click',function () {
        var html = "";
        html += "<div class='row'>";
            html += "<div class='col-xl-2 col-md-3 col-sm-4 col-5'>";
                html += "<div class='form-group' style='display: inline-block'>";
                    html +=
                        "<input type='time' class='add-time opening_time' id='opening_hours' name='opening_hours[]' placeholder='Selecting Open Hours'>";
                    html += "<span for='opening_hours' class='help-block'></span>";
                html += "</div>";
            html += "</div>";
            html += "<div class='col-xl-2 col-md-3 col-sm-4 col-5'>";
                html += "<div class='form-group' style='display: inline-block'>";
                            html +=
                                "<input type='time' class='add-time closing_time' id='closing_hours' name='closing_hours[]' placeholder='Selecting Closeing Hours'>";
                            html += "<span for='closing_hours' class='error'></span>";
                html += "</div>";
            html += "</div>";
            html += "<div class='col-xl-2 col-md-2 col-sm-3 mt-3'>";
                html += "<button class='btn btn-danger remove-btn' type='button'>Remove</button>";
            html += "</div>";
        html += "</div>";
        $(".add-more-times").append(html);
    });

    $(document).on("click", ".remove-btn", function () {
        $(this).parent().parent().remove();
    });

    $(document).on("click", "#submit_form", function () {
        // console.log($(".opening_time").val());
        $(".opening_time").each(function () {
            console.log($(this).val());
        });
    });
    // $("#submit_form").on('click', function () {
    //     console.log($("#hourForm").vaild());
    // });
});