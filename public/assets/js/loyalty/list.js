$(function () {
    "use strict";

    var baseUrl = $("[name='base-url']").attr("content");

    $(".select2").select2({
        placeholder: "Select Category",
    });

    $(".change-status").on("click", function () {
        var loyaltyId = $(this).attr("data-loyalty-id");
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: baseUrl + "/loyalty/change/status",
            type: "POST",
            data: {
                loyaltyId: loyaltyId,
            },
            dataType: "JSON",
            beforeSend: function () {
                $("body").preloader();
            },
            complete: function () {
                location.reload();
                $("body").preloader("remove");
            },
            success: function (res) {},
        });
    });

    $(".edit-loyalty").on("click", function () {
        var loyaltyId = $(this).attr("data-loyalty-id");
        var loyaltyType = $(this).attr("data-loyalty-type");
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: baseUrl + "/loyalty/edit",
            type: "POST",
            dataType: "JSON",
            data: {
                loyaltyId: loyaltyId,
                loyaltyType: loyaltyType,
            },
            beforeSend: function () {
                $("body").preloader();
            },
            complete: function () {
                $("body").preloader("remove");
            },
            success: function (response) {
                if (response.success) {
                    $(".loyalty-id").val(response.loyalty.loyalty_id);
                    $(".loyalty-edit").html("Update Loyalty");
                    if (response.loyalty.no_of_orders != null) {
                        $("#noOfOrders").val(response.loyalty.no_of_orders);
                        $("#points").val(response.loyalty.point);
                        $("#orderLoyalty").modal("show");
                    }
                    else if (response.loyalty.amount != null) {
                        $("#amount").val(response.loyalty.amount);
                        $("#amount-points").val(response.loyalty.point);
                        $("#amount_spent").modal("show");
                    }
                    else if (response.loyalty.categories.length != 0) {
                        $("#categories option").prop('selected',false);
                        $("#category-points").val(response.loyalty.point);
                        response.loyalty.categories.forEach(element => {
                            $("#categories option[value="+element.category_id+"]").attr("selected","selected");
                        });
                        $("#category_based").modal("show");
                        $(".select2").select2();
                    }

                }
            },
        });
    });

    $(".delete-loyalty").on("click", function () {
        var loyaltyId = $(this).attr("data-loyalty-id");
        var loyaltyType = $(this).attr("data-loyalty-type");
        $("#deleteModal").modal("show");
        $("#delete-message").html(
            "Are you sure you want to delete " +
                loyaltyType +
                " Loyalty program from the list?"
        );
        $("#loyaltyId").val(loyaltyId);
    });
});
