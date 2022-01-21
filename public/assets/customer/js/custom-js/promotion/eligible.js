$(function() {
    "use strict";
    var baseUrl = $("#base-url").attr('content');

    $(function() {
        $('.lazy').lazy();
    });

    feather.replace();

    $(document).on("click", ".pro-menu-modifier", function() {
        var menuId = $(this).data('menu-id');
        var promotionId = $(this).data('promotion');
        $.ajax({
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: baseUrl + '/promotions/menu/getMenuModifier',
            data: {
                menuId: menuId,
                promotionId: promotionId
            },
            dataType: "json",
            success: function(response) {
                $("#add-order-" + menuId).hide();
                $(".modifiers-" + menuId).html(response.view);
                $(".modifier-modal-" + menuId).modal('show');
            }
        });
    });

    $(document).on("click", ".pro-without-modifier", function() {
        var menuId = $(this).data('menu-id');
        var promotionId = $(this).data('promotion');
        $.ajax({
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: baseUrl + '/promotion/menu/add-to-cart',
            data: {
                menuId: menuId,
                promotionId: promotionId
            },
            dataType: "html",
            success: function(response) {
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

    $(document).on("click", ".pro-without-modifier-plus", function() {
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

    $(document).on("click", ".pro-without-modifier-minus", function() {
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

    $(document).on("click", ".pro-with-modifier-plus", function() {
        var menuId = $(this).attr("data-menu-id");
        $.ajax({
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: baseUrl + '/opencart-alert-modal',
            data: {
                menuId: menuId,
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

    $(".cart-remove").on('click', function(e) {
        // e.preventDefault();
        var cartKey = $(this).data("cart-item");
        var menuId = $(this).data('menu-id');
        $.ajax({
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: baseUrl + "/cart/item/delete",
            data: {
                removeKey: cartKey,
                menuId: menuId
            },
            dataType: "json",
            success: function(response) {
                if (response) {
                    $(".scroll-inner-blog").load(window.location.href + " .scroll-inner-blog");
                    $("#menu-" + menuId).load(window.location.href + " #menu-" + menuId);
                    $("#checkout").load(window.location.href + " #checkout");
                    // snakbarTostar("Item added to cart successfully.");
                }
            }
        });
    });
});