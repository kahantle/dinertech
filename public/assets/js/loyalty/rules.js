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
    var categories = [];
    $(document).on('change', '.table-tag .add input[name="modifier_item"]', function() {
        var categoryId = $(this).attr('data-category-id');
        
        if (items.includes($(this).attr('data-item-id'))) {
            if ($(".item-group-" + categoryId).length == 1) {
                $("#modifier-group-" + categoryId).prop('checked', false);
            }
            items.pop($(this).attr('data-item-id'));
            categories.prop(categoryId);
        } else {
            items.push($(this).attr('data-item-id'));
            categories.push(categoryId);
        }
    });

    $(document).on('change', '.selectall', function() {
        var categoryId = $(this).attr('data-category-id');
        if ($(this).prop('checked') == true) {
            categories.push(categoryId);
            // $(".item-group-" + categoryId).attr('checked', true);
            $(".item-group-" + categoryId).prop('checked', true);
            $(".item-group-" + categoryId).each(function() {
                if (items.includes($(this).attr('data-item-id'))) {
                    items.pop($(this).attr('data-item-id'));
                } else {
                    items.push($(this).attr('data-item-id'));
                }
            });
        } else {
            
            $(".item-group-" + categoryId).prop('checked', false);
            categories.pop(categoryId);
            $(".item-group-" + categoryId).each(function() {
                items.pop($(this).attr('data-item-id'));
            });
        }
    });

    $(document).on('click', ".count-item", function() {
        $('#count-checked-checkboxes').val(items.length);
        $("#items-ids").val(JSON.stringify(items));
        $("#categoryIds").val(JSON.stringify(categories));
        $(".second-part").modal("hide");
        $('#addRule').modal('show');
    });

    $(".edit-rule").on("click", function(e) {
        e.preventDefault();
        $('#addRule').modal("show");
        $("#modal-title").html('Update Loyalty Rules');
        $(".modal-submit").html('Update Loyalty');
        $("#loyalty-rule-add").attr('action', baseUrl + '/loyalty/rules/update');
        $("#count-checked-checkboxes").removeClass('choose-blog');
        $("#count-checked-checkboxes").addClass('edit-choose-blog');
        $(".edit-choose-blog").css({ "width": "100%" });
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
            success: function(res) {
                if (res.success) {
                    $("#ruleId").val(res.data.rules_id);
                    $("#points").val(res.data.point);
                    $("#count-checked-checkboxes").val(res.data.rules_items_count);
                    $("#editMenuItemModal").html(res.view);
                }
            }
        });
    });

    $(document).on("click", ".edit-choose-blog", function() {
        $("#addRule").modal("hide");
        $(".edit-second-part").modal("show");
        $('.edit-category input[type="checkbox"]').each(function() {
            if ($(this).is(":checked")) {
                categories.push($(this).attr('data-category-id'));
            }
        });

        $('.edit-menu input[type="checkbox"]').each(function() {
            if ($(this).is(":checked")) {
                items.push($(this).attr('data-item-id'));
            }
        });

    });

    $(document).on('click', '.edit-modifier-modal', function() {
        $(document).find(".edit-second-part").modal("hide");
        $("#addRule").modal("show");
    });

    // $(document).on('change', '.edit-menu input[type="checkbox"]', function() {
    //     var categoryId = $(this).attr('data-category-id');
    //     if ($(this).prop('checked') == true) {
    //         categories.push(categoryId);
    //         $(".item-group-" + categoryId).attr('checked', true);
    //         $(".item-group-" + categoryId).each(function() {
    //             if (items.includes($(this).attr('data-item-id'))) {
    //                 items.pop($(this).attr('data-item-id'));
    //             } else {
    //                 items.push($(this).attr('data-item-id'));
    //             }
    //         });
    //     } else {
    //         $(".item-group-" + categoryId).attr('checked', false);
    //         categories.pop(categoryId);
    //         $(".item-group-" + categoryId).each(function() {
    //             items.pop($(this).attr('data-item-id'));
    //         });
    //     }
    // });

    $(document).on('click', ".edit-count-item", function() {
        $('#count-checked-checkboxes').val(items.length);
        $("#items-ids").val(JSON.stringify(items));
        $("#categoryIds").val(JSON.stringify(categories));
        $(".edit-second-part").modal("hide");
        $('#addRule').modal('show');
    });

    $(".delete-rule").on("click", function() {
        $("#deleteMessage").html("Are you sure you want to delete <b>" + $(this).attr('data-rule-point') + " Points</b> Loyalty rules from the list ? ");
        $("#deleteModal").modal("show");
        $("#rule_id").val($(this).attr('data-rule-id'));
    });
});