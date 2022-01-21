$(function () {
    "use strict";

    $('#promotionForm').validate({
        rules: {
            promotion_name: {
                required: true
            },
            discount_usd_percentage: {
                required: true
            },
            discount_usd_percentage_amount: {
                required: true
            },
            set_minimum_order: {
                required: true
            },
            set_minimum_order_amount: {
                required: true
            },
            client_type: {
                required: true
            },
            order_type: {
                required: true
            },
            only_selected_payment_method: {
                required: true
            },
            promotion_function: {
                required: true
            }
        },
        messages: {
            promotion_name: {
                required: "Please Enter promotion name."
            },
            dicount_usd_percentage: {
                required: "Please select discount type."
            },
            dicount_usd_percentage_amount: {
                required: "Please Enter amount."
            },
            set_minimum_order: {
                required: "Please select minimum order value."
            },
            set_minimum_order_amount: {
                required: "Please enter minimum amount."
            },
            client_type: {
                required: "Please select client type."
            },
            order_type: {
                required: "Please select order type."
            },
            only_selected_payment_method: {
                required: "Please select payment method."
            },
            promotion_function: {
                required: "Please select promotion function."
            }
        },
        highlight: function (element) {
            $(element).closest('.control-group').removeClass('success').addClass('error');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parents('.form-control').removeClass('has-error').addClass('has-success');
        },
        errorPlacement: function (error, element) {
            if (element.hasClass('select2') && element.next('.select2-container').length) {
                error.insertAfter(element.next('.select2-container'));
            }
            else if (element.parent('.input-group').length) {
                error.insertAfter(element.parent());
            }
            else if (element.prop('type') === 'radio' && element.parent('.radio-inline').length) {
                error.insertAfter(element.parent());
            }
            else if (element.prop('type') === 'checkbox' || element.prop('type') === 'radio') {
                error.insertAfter(element.parent());
            }
            else {
                error.insertAfter(element);
            }
        }
    });

    jQuery.validator.setDefaults({
        debug: true,
        success: "valid"
    });

    function getPlatform() {
        var platform = ["Android", "iOS"];

        for (var i = 0; i < platform.length; i++) {

            if (navigator.platform.indexOf(platform[i]) > - 1) {

                return platform[i];
            }
        }
    }

    var form = $("#promotionForm");
    form.validate();
    $(".formsubmit").on('click', function () {
        var promotionId = $("#promotion_id").length;
        if (promotionId == 0) {
            if (form.valid() == true) {
                if (getPlatform() == 'Android') {
                    Android.showToast("Promotion add successfully.");
                } else if (getPlatform() == 'iOS') {
                    window.webkit.messageHandlers.jsMessageHandler.postMessage("Promotion add successfully.");
                }
            }
            else {
                if (getPlatform() == 'Android') {
                    Android.showToast("error");
                } else if (getPlatform() == 'iOS') {
                    window.webkit.messageHandlers.jsMessageHandler.postMessage("error");
                }
            }
        } else {
            if (form.valid() == true) {
                if (getPlatform() == 'Android') {
                    Android.showToast("Promotion update successfully.");
                } else if (getPlatform() == 'iOS') {
                    window.webkit.messageHandlers.jsMessageHandler.postMessage("Promotion update successfully.");
                }
            }
            else {
                if (getPlatform() == 'Android') {
                    Android.showToast("error");
                } else if (getPlatform() == 'iOS') {
                    window.webkit.messageHandlers.jsMessageHandler.postMessage("error");
                }
            }
        }
    });

    $(".cancel").on('click', function () {
        if (getPlatform() == 'Android') {
            Android.showToast("back");
        } else if (getPlatform() == 'iOS') {
            window.webkit.messageHandlers.jsMessageHandler.postMessage("back");
        }
    });
});