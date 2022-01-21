$(document).ready(function () {

    (function ($) {
        "use strict";


        // validate contactForm form
        $(function () {
            $('#get_in_touch').validate({
                rules: {
                    your_name: {
                        required: true
                    },
                    your_email: {
                        required: true,
                        email: true
                    },
                    your_phone: {
                        required: true,
                        digits: true,
                        minlength: 10

                    }
                },
                messages: {
                    your_name: {
                        required: "Please enter your name"
                    },
                    your_phone: {
                        required: "Please enter the phone number",
                        digits: "Only digits are allowed",
                        minlength: "Minimum 10 digits required"

                    },
                    your_email: {
                        required: "Please enter the email address",
                        email: "Invalid email address"
                    }
                },
                submitHandler: function (form) {
                    var name = $('#your_name').val();
                    var email = $('#your_email').val();
                    var phone = $('#your_phone').val();
                    var message = $('#your_message').val();
                    var site_url = location.hostname;
                    $.ajax({
                        url: "contact",
                        data: $(form).serialize(),
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: "POST",
                        success: function (data) {
                            if (data == "success") {
                                $("#form_messages").html("<span class='success'>Form submitted successfully.</span>");
                            } else {
                                $("#form_messages").html("<span class='fail'>There is some problem to submit form.</span>");
                            }
                        },
                        error: function (response) {
                            $("#form_messages").html("<span class='fail'>There is some problem to submit form.</span>");
                        }
                    });

                }
            })
        })

    })(jQuery)
})