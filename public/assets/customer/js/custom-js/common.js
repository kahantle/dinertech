$(function() {
    "use strict";
    var baseUrl = $("#base-url").attr('content');

    $(function() {
        $('.lazy').lazy();
    });

    feather.replace();

    $(document.body).delegate(".cart-remove", "click", function() {
        removeItem($(this).data("menu-id"));
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

    function showMenuModifiers(menuId) {
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
            success: function(response) {
                $(".modifiers-" + menuId).html(response.view);
                $(".modifier-modal-" + menuId).modal("show");
            }
        });
    }

    $(document).on("click", ".with-modifier-add", function() {
        var menuId = $(this).attr("data-menu-id");
        $(".modifier-modal-" + menuId).modal("hide");
        $.ajax({
            type: "POST",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            url: $("#addToCart").attr("action"),
            data: $("#addToCart").serialize(),
            dataType: "html",
            success: function(response) {
                if (response) {
                   $(".add-order-" + menuId).addClass("d-none");
                   $(".product-quantity-" + menuId).removeClass("d-none");
                   $(".product-quantity-" + menuId).addClass("d-inline-flex");
                   $(".scroll-inner-blog").load(
                       window.location.href + " .scroll-inner-blog"
                   );
                   $("#checkout").load(window.location.href + " #checkout");
                }
            }
        });
    });

    $(document).on("click", ".add-to-order", function () {
        var menuId = $(this).attr("data-menu-id");
        if ($(this).hasClass("have-modifiers")) {
            showMenuModifiers(menuId);
            return;
        }
        $.ajax({
            type: "POST",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            url: "customer/add-to-cart",
            data: {
                menuId: menuId
            },
            dataType: "html",
            success: function(response) {
                if (response) {
                    $(".add-order-" + menuId).addClass("d-none");
                    $(".product-quantity-" + menuId).removeClass("d-none");
                    $(".product-quantity-" + menuId).addClass("d-inline-flex");
                    $(".scroll-inner-blog").load(window.location.href + " .scroll-inner-blog");
                    $("#checkout").load(window.location.href + " #checkout");
                }
            }
        });
    });

    $(document).on("click", ".with-modifier-plus", function() {
        var menuId = $(this).attr("data-menu-id");
        var cartKey = $(this).attr("data-cart-item");
        $.ajax({
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: baseUrl + '/opencart-alert-modal',
            data: {
                menuId: menuId,
                cartKey: cartKey
            },
            dataType: "json",
            success: function(response) {
                if (response) {
                    $(".repeat-last-add-modal-" + menuId).html(response.view);
                    $(".repeat-last-modal-" + menuId).modal("show");
                }
            }
        });
    });

    $(document).on("click", ".repeat-last-cart", function() {
        var menuId = $(this).data('menu-id');
        var cartKey = $(this).data('cart-key');
        var cartQuantity = $(".quantity-" + menuId).val();
        $.ajax({
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: baseUrl + '/add-to-repeatLast',
            data: {
                menuId: menuId,
                cartKey: cartKey
            },
            dataType: "html",
            success: function(response) {
                if (response) {
                    $(".repeat-last-modal-" + menuId).modal("hide");
                    $(".quantity-" + menuId).val(cartQuantity++);
                    $(".scroll-inner-blog").load(window.location.href + " .scroll-inner-blog");
                }
            }
        });
    });

    $(document).on('click', '.decrease-repeat-last', function() {
        $("#cart-alert-modal").modal('show');
    });

    $(document).on("click", ".add-new-item", function() {
        var menuId = $(this).data('menu-id');
        $(".repeat-last-modal-" + menuId).modal("hide");
        $.ajax({
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: baseUrl + '/getMenumodifier',
            data: {
                menuId: menuId,
            },
            dataType: "json",
            success: function(response) {
                if (response) {
                    $(".modifiers-" + menuId).html(response.view);
                    $(".modifier-modal-" + menuId).modal('show');
                }
            }
        });
    });

    $(document).on("click", ".product-quantity-plus", function() {
        var menuId = $(this).data("menu-id");
        var value = $(".quantity-" + menuId).val();
        $.ajax({
            type: "POST",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            url: baseUrl + "/quantity-change",
            data: {
                menuId: menuId,
                action : 'increament'
            },
            success: function (response) {
                if (response.success) {
                    $(".quantity-" + menuId).val(response.new_qty);
                    $(".scroll-inner-blog").load(
                        window.location.href + " .scroll-inner-blog"
                    );
                    $("#checkout").load(window.location.href + " #checkout");
                }
            }
        });
    });

    $(document).on("click", ".product-quantity-minus", function() {
        var menuId = $(this).data("menu-id");
        var value = $(".quantity-" + menuId).val();
        if (value != 1) {
            $.ajax({
                type: "POST",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                },
                url: baseUrl + "/quantity-change",
                data: {
                    menuId: menuId,
                    action: "decreament"
                },
                success: function(response) {
                    if (response.success) {
                        $(".quantity-" + menuId).val(response.new_qty);
                        $(".scroll-inner-blog").load(
                            window.location.href + " .scroll-inner-blog"
                        );
                        $("#checkout").load(
                            window.location.href + " #checkout"
                        );
                    }
                }
            });
        } else {
            removeItem(menuId);
        }
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

    $(document).on("click", ".without-modifier", function() {
        var menuId = $(this).data('menu-id');
        $.ajax({
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: baseUrl + '/add-to-cart',
            data: {
                menuId: menuId
            },
            dataType: "html",
            success: function (response) {
                console.log(response);
                if (response) {
                    $("#add-order-" + menuId).hide();
                    $(".without-modifier-quantity-" + menuId).removeClass('d-none');
                    $(".without-modifier-quantity-" + menuId).addClass('d-inline-flex');
                    $(".scroll-inner-blog").load(window.location.href + " .scroll-inner-blog");
                    $("#checkout").load(window.location.href + " #checkout");
                }
                // snakbarTostar("Item added to cart successfully.");
            }
        });
    });

    $(document).on("click", ".without-modifier-plus", function() {
        var menuId = $(this).data('menu-id');
        var value = $('.quantity-' + menuId).val();
        var cartItem = $(this).data('cart-item');
        if (value != 10) {
            value++;
        }
        $.ajax({
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: baseUrl + '/quantity-increment',
            data: {
                menuId: menuId,
                menuKey: cartItem
            },
            success: function(response) {
                if (response == true) {
                    $('.quantity-' + menuId).val(value);
                    $(".scroll-inner-blog").load(window.location.href + " .scroll-inner-blog");
                    $("#checkout").load(window.location.href + " #checkout");
                }
            }
        });
    });

    $(document).on("click", ".without-modifier-minus", function() {
        var menuId = $(this).data('menu-id');
        var value = $('.quantity-' + menuId).val();
        var cartItem = $(this).data('cart-item');
        if (value > 1) {
            value--;
        }
        $.ajax({
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: baseUrl + '/quantity-decrement',
            data: {
                menuId: menuId,
                menuKey: cartItem
            },
            success: function(response) {
                if (response == true) {
                    $('.quantity-' + menuId).val(value);
                    $(".scroll-inner-blog").load(window.location.href + " .scroll-inner-blog");
                    $("#checkout").load(window.location.href + " #checkout");
                }
            }
        });
    });

    function removeItem(menu_id) {
        $.ajax({
            type: "POST",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            url: baseUrl + "/cart/item/delete",
            data: {
                menuId: menu_id
            },
            dataType: "json",
            success: function(response) {
                if (response) {
                    $(".add-order-" + menu_id).removeClass("d-none");
                    $(".product-quantity-" + menu_id)
                        .removeClass("d-inline-flex")
                        .addClass("d-none");
                    $("#checkout").load(window.location.href + " #checkout");
                    $(".scroll-inner-blog").load(
                        window.location.href + " .scroll-inner-blog"
                    );
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
