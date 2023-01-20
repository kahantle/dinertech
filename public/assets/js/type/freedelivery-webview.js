$(function () {
    "use strict";

    $('#promotionForm').validate({
        rules: {
            promotion_name: {
                required: true
            },
            dicount_usd_percentage_amount: {
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
            only_selected_payment_method: {
                required: true
            },
            mark_promo_as: {
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
            only_selected_payment_method: {
                required: "Please select payment method."
            },
            mark_promo_as: {
                required: "Please select mark promo as."
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
    // just for the demos, avoids form submit
    jQuery.validator.setDefaults({
        debug: true,
        success: "valid"
    });

    var form = $("#promotionForm");
    form.validate();
    $(".formsubmit").on('click', function () {
        var promotionId = $("#promotion_id").length;
        if (promotionId == 0) {
            if (form.valid() == true) {
                Android.showToast("Promotion add successfully.");
                // alert("Hello");
            }
            else {
                Android.showToast("error");
            }
        } else {
            if (form.valid() == true) {
                Android.showToast("Promotion update successfully.");
            }
            else {
                Android.showToast("error");
            }
        }
    });

    $(".cancel").on('click', function () {
        Android.showToast("back");
    });
});
