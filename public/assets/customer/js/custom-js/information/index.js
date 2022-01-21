$(function() {

    "use strict";
    // var baseUrl = $("#base-url").attr('content');

    feather.replace();

    $('#contactForm').validate({
        rules: {
            name: {
                required: true
            },
            phone_number: {
                required: true,
                number: true
            },
            email: {
                required: true,
                email: true
            },
            message: {
                required: true
            }
        },
        highlight: function(element) {
            $(element).closest('.control-group').removeClass('success').addClass('error');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).parents('.form-control').removeClass('has-error').addClass('has-success');
        },
        errorPlacement: function(error, element) {
            if (element.hasClass('select2') && element.next('.select2-container').length) {
                error.insertAfter(element.next('.select2-container'));
            } else if (element.parent('.form-control').length) {
                error.insertAfter(element.parent());
            } else if (element.prop('type') === 'radio' && element.parent('.radio-inline').length) {
                error.insertAfter(element.parent());
            } else if (element.prop('type') === 'checkbox' || element.prop('type') === 'radio') {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        }
    });

    jQuery.validator.setDefaults({
        debug: true,
        success: "valid"
    });
});