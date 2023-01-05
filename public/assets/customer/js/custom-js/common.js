$(function() {
    "use strict";
    var baseUrl = $("#base-url").attr('content');

    $(function() {
        $('.lazy').lazy();
    });

    feather.replace();

    $(document.body).delegate(".cart-remove", "click", function() {
        removeItem($(this).data("cart-menu-item-id"));
    });

    const timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
    $.ajax({
        type: "GET",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: baseUrl + "/set-system-time",
        data: {
            sys_timezone: timezone,
        },
        success: function(data) {}
    });

    $(".rateYo").each(function() {
        var rating = $(this).attr("data-rating");
        $(this).rateYo({
            rating: rating,
            starWidth: "20px",
            readOnly: true
        });
    });

    $('[name=paymentType]').on('change', function() {
        if ($(this).val() == 'card') {
            $(".cards").show();
        } else {
            $(".cards").hide();
        }
    });

    $(document).on("click", ".with-modifier-add", function() {
        var menuId = $(this).data("menu-id");
        $(".modifier-modal-" + menuId).modal("hide");
        addToCart($("#addToCart").serialize(),menuId);
    });

    $(document).on("click", ".add-to-order", function () {
        var menuId = $(this).attr("data-menu-id");
        $(this).hasClass("have-modifiers") ? showMenuModifiers(menuId) : addToCart({menuId : menuId});
    });

    $(document).on("change", ".radioModifierItem", function() {
        if ($(this).prop('checked', true)) {
            $(".radiobuttonItem").html($(this).attr('data-modifier-item') + ',');
        }
    });

    var selectedModifier = [];
    $(document).on("change", ".modifierItem", function() {
        if ($(this).is(':checked')) {
            if (jQuery.inArray($(this).attr('data-modifier-item'), selectedModifier) == -1) {
                selectedModifier.push($(this).attr('data-modifier-item'));
                // selectedModifier.splice($.inArray($(this).attr('value'),selectedModifier),1);
            }
        } else {
            selectedModifier.splice($.inArray($(this).attr('data-modifier-item'), selectedModifier), 1);
        }
        $(".primarycardnow").html(selectedModifier.join(','));
    });

    $(document).on("click", ".add-to-cart-again", function() {
        var menuId = $(this).data("menu-id");
        var cartMenuItemId = $(this).data("cart-menu-item-id");
        $(".repeat-last-modal-" + cartMenuItemId).modal("hide");
        showMenuModifiers(menuId);
    });

    $(document).on("click", ".product-quantity-minus", function() {
        var cartMenuItemId = $(this).data("cart-menu-item-id");
        $(".quantity-" + cartMenuItemId).val() != 1 ? quantityChange(cartMenuItemId, "decreament") : removeItem(cartMenuItemId);
    });

    $(document).on("click", ".product-quantity-plus", function () {
        var menuId = $(this).data("menu-id");
        var cartMenuItemId = $(this).data("cart-menu-item-id");
        console.log(cartMenuItemId);
        $(this).hasClass("have-modifiers") ? modalForPlusWithModifiers(cartMenuItemId) : quantityChange(cartMenuItemId, "increament");
    });

    $(document).on("click", ".repeat-last-cart", function () {
        var cartMenuItemId = $(this).data("cart-menu-item-id");
        quantityChange(cartMenuItemId, "increament");
        $(".repeat-last-modal-" + cartMenuItemId).modal("hide");
    });

    const addToCart = (data, menu_id = null) => {
        $.ajax({
            type: "POST",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            url: "customer/add-to-cart",
            data: data,
            dataType: "html",
            success: function (response) {
                let menuId = menu_id ? menu_id : data.menuId;
                if (response) {
                    $(".add-order-" + menuId).addClass("d-none");
                    $(".product-quantity-" + menuId).removeClass("d-none");
                    $(".product-quantity-" + menuId).addClass(
                        "d-inline-flex"
                    );
                    $(".scroll-inner-blog").load(
                        window.location.href + " .scroll-inner-blog"
                    );
                    $("#checkout").load(window.location.href + " #checkout");
                }
            }
        });
    }

    const removeItem = cart_menu_item_id => {
        $.ajax({
            type: "POST",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            url: baseUrl + "/cart/item/delete",
            data: {
                cartMenuItemId: cart_menu_item_id
            },
            dataType: "json",
            success: response => {
                if (response) {
                    $(".add-order-" + response.menu_id).removeClass("d-none");
                    $(".product-quantity-" + response.menu_id).removeClass("d-inline-flex").addClass("d-none");
                    $("#checkout").load(window.location.href + " #checkout");
                    $(".scroll-inner-blog").load(
                        window.location.href + " .scroll-inner-blog"
                    );
                    $(".content").load(
                        window.location.href + " .content"
                    )
                }
            }
        });
    }

    const showMenuModifiers = menuId => {
        $.ajax({
            type: "POST",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            url: baseUrl + "/getMenumodifier",
            data: {
                menuId: menuId
            },
            dataType: "json",
            success: response => {
                $(".modifiers-" + menuId).html(response.view);
                $(".modifier-modal-" + menuId).modal("show");
            }
        });
    }

    const quantityChange = (cartMenuItemId, action) => {
        $.ajax({
            type: "POST",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            url: baseUrl + "/quantity-change",
            data: {
                cartMenuItemId: cartMenuItemId,
                action: action
            },
            success: response => {
                if (response) {
                    $(".quantity-" + cartMenuItemId).val(response.new_qty);
                    $("#checkout").load(window.location.href + " #checkout");
                    $(".scroll-inner-blog").load(
                        window.location.href + " .scroll-inner-blog"
                    );
                }
            }
        });
    }

    function modalForPlusWithModifiers(cartMenuItemId) {
        $.ajax({
            type: "POST",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            url: baseUrl + "/modal-for-plus-with-modifiers",
            data: {
                cartMenuItemId: cartMenuItemId
            },
            dataType: "json",
            success: function(response) {
                if (response) {
                    $(".repeat-last-add-modal-" + cartMenuItemId).html(response.view);
                    $(".repeat-last-modal-" + cartMenuItemId).modal("show");
                }
            }
        });
    }

    $(".owl_1, .owl-item").on("change", function() {
        console.log($(this).children(".active, .item"));
    });

    $(".set-now").on('click', function() {
        $('.set-later').removeClass('selected');
        $(this).addClass('selected');
    });

    $(".set-later").on('click', function() {
        $('.set-now').removeClass('selected');
        $(this).addClass('selected');
        var getTime = moment().add(45, 'minutes').format('LT');
        $("#orderTime").val(convertTime(getTime));
    });

    $(".btokey").on("click", function() {
        var date = new Date($("#orderDate").val());
        var dateFormat = date.getDate() + "/" + (date.getMonth() + 1) + "/" + date.getFullYear();
        var getTime = moment(moment($("#orderTime").val(), ["h:mm A"])).format("hh:mm A");
        $(".set-order-msg").html("Your order will be ready at: " + dateFormat + " and time " + getTime);
        $("#setDate").val(dateFormat);
        $("#setTime").val(getTime);
        $(".selectTime").modal('hide');
    });

    function convertTime(timeStr) {
        var colon = timeStr.indexOf(':');
        var hours = timeStr.substr(0, colon),
            minutes = timeStr.substr(colon + 1, 2),
            meridian = timeStr.substr(colon + 4, 2).toUpperCase();

        var hoursInt = parseInt(hours, 10),
            offset = meridian == 'PM' ? 12 : 0;

        if (hoursInt === 12) {
            hoursInt = offset;
        } else {
            hoursInt += offset;
        }
        return hoursInt + ":" + minutes;
    }
});
