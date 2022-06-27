$(function() {
    "use strict";
    var baseUrl = $("[name='base-url']").attr('content');

    $(".choose-blog").on('click', function() {
        $('#addRule').modal('hide');
        $('.second-part').modal('show');
    });

    $(".modifier-modal").on('click', function() {
        $(".second-part").modal('hide');
        $('#addRule').modal('show');
    });

    $(".add-rule").on('click', function() {
        $('#addRule').modal('hide');
        $("#points").val();
        $("#menuItems").val();
    });


    var items = [];
    $(document).on('change', 'input[name="modifier_item"]', function() {
        var categoryId = $(this).attr('data-category-id');
        if ($(this).prop("checked") == true) {
            var item = {
                category_id: categoryId,
                menu: $(this).attr("data-item-id"),
            };
            items.push(item);
        }

        if ($(this).prop("checked") == false) {
            
            for (var i = 0; i < items.length; i++)
                if (items[i].menu && items[i].menu === $(this).attr("data-item-id")) {
                    items.splice(i, 1);
                    break;
                }
        }
    });

    $(document).on('change', '.selectall', function() {
        var categoryId = $(this).attr('data-category-id');
        if ($(this).prop("checked") == true) {
            $(".item-group-" + categoryId).attr('checked', true);
            $(".item-group-" + categoryId).prop("checked", true);

            $(".item-group-" + categoryId).each(function () {
                if ($(this).is(":checked")) {
                    items.push({
                        category_id: $(this).attr("data-category-id"),
                        menu: $(this).attr("data-item-id"),
                    });
                }
            }); 
        }

        $(".item-group-" + categoryId).each(function () {
            if ($(this).prop("checked") == false) {
                for (var i = 0; i < items.length; i++)
                if (items[i].menu &&items[i].menu === $(this).attr("data-item-id")) {
                    items.splice(i, 1);
                    break;
                }
            }
        });
    });

    $(document).on('click', ".count-item", function() {
        $('#count-checked-checkboxes').val(items.length);
        $("#items-ids").val(JSON.stringify(items));
        $(".second-part").modal("hide");
        $('#addRule').modal('show');
    });

    $(".edit-rule").on("click", function(e) {
        e.preventDefault();
        var ruleId = $(this).attr('data-rule-id');
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: baseUrl + '/loyalty/rule/data/' + ruleId,
            type: "GET",
            dataType: "JSON",
            beforeSend: function() {
                $("body").preloader();
            },
            complete: function() {
                $("body").preloader('remove');
            },
            success: function (res) {
                if (res.success == true)
                {
                    $("#addRule").modal("show");
                    $("#modal-title").html("Update Loyalty Rules");
                    $(".modal-submit").html("Update Loyalty");
                    $("#loyalty-rule-add").attr(
                        "action",
                        baseUrl + "/loyalty/rules/update"
                    );
                    $("#count-checked-checkboxes").removeClass("choose-blog");
                    $("#count-checked-checkboxes").addClass(
                        "edit-choose-blog"
                    );
                    $(".edit-choose-blog").css({ width: "100%" });
                    $(document).find("#ruleId").val(res.data.rules_id);
                    $(document).find(".set-point").val(res.data.point);
                    $(document).find("#count-checked-checkboxes").val(res.data.rules_items_count);
                    $("#editMenuItemModal").html(res.view);
                }
                else
                {
                    alert("Some error in open edit popup.");    
                }
            }
        });
    });

    $(document).on("click", ".edit-choose-blog", function() {
        $("#addRule").modal("hide");
        $(".edit-second-part").modal("show");
        
        $('.edit-menu input[type="checkbox"]').each(function() {
            if ($(this).is(":checked")) {
                items.push({
                    category_id: $(this).attr("data-category-id"),
                    menu: $(this).attr("data-item-id"),
                });
                // items.push($(this).attr('data-item-id'));
            }
        });
    });

    $(document).on('click', '.edit-modifier-modal', function() {
        $(document).find(".edit-second-part").modal("hide");
        $("#addRule").modal("show");
    });

    $(document).on('click', ".edit-count-item", function() {
        $('#count-checked-checkboxes').val(items.length);
        $("#items-ids").val(JSON.stringify(items));
        $(".edit-second-part").modal("hide");
        $('#addRule').modal('show');
    });

    $(".delete-rule").on("click", function () {
        $("#delete-message").html(
            "Are you sure you want to delete <b>" +
                $(this).attr("data-rule-point") +
                " Points</b> Loyalty rules from the list ? "
        );
        $("#deleteModal").modal("show");
        $("#rule_id").val($(this).attr('data-rule-id'));
    });

    var showChar = 500; // How many characters are shown by default
    var ellipsestext = "...";
    var moretext = "Read more";
    var lesstext = "Read less";

    $(".more").each(function () {
        var content = $(this).html();

        if (content.length > showChar) {
            var c = content.substr(0, showChar);
            var h = content.substr(showChar, content.length - showChar);

            var html =
                c +
                '<span class="moreellipses">' +
                ellipsestext +
                '</span><span class="morecontent"><span>' +
                h +
                '</span><a href="" class="morelink">' +
                moretext +
                "</a></span>";

            $(this).html(html);
        }
    });

    $(".morelink").on('click',function () {
        if ($(this).hasClass("less")) {
            $(this).removeClass("less");
            $(this).html(moretext);
        } else {
            $(this).addClass("less");
            $(this).html(lesstext);
        }
        $(this).parent().prev().toggle();
        $(this).prev().toggle();
        return false;
    });
});