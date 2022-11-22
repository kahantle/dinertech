$(function() {

    "use strict";
    var baseUrl = $("#base-url").attr('content');

    $(function() {
        $('.lazy').lazy();
    });


    if ($("#first-modal").length != 0) {
        $("#first-modal").modal("show");
        $(".sidebar-ar").addClass('blur-background');
        $(".dash-body-ar").addClass('blur-background');
        $(".wd-dr-right-toogle").addClass('blur-background');
        $(".sidebar").addClass('blur-background');
    }

    // $(window).on('load', function() {

    // });

    $(".within-first-modal").on("click", function() {
        $("#second-modal").modal("show");
        $("#first-modal").modal("hide");
    });

    $(".btn-second-modal-close").on("click", function() {
        $("#second-modal").modal("hide");
        $("#first-modal").modal("show");
    });

    $(".within-third-modal").on("click", function() {
        $("#third-modal").modal("show");
        $("#first-modal").modal("hide");
    });

    $('.btn-party-modal-close').on('click', function() {
        $('#third-modal').modal('hide');
        $('#first-modal').modal('show');
    });

    loadMenu($(".owl-carousel,.active").find('.category').attr('data-category-id'));

    function loadMenu(categoryId) {
        $.ajax({
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: baseUrl + '/menu-items',
            data: {
                categoryId: categoryId
            },
            dataType: "json",
            success: function (response) {
                $("#style-4").html(response.view);

                // Configure/customize these variables.
                var showChar = 176; // How many characters are shown by default
                var ellipsestext = "";
                var moretext = "Read More";
                var lesstext = "Read Less";

                $(document).find('.more').each(function() {
                    var content = $(this).html();

                    if (content.length > showChar) {

                        var c = content.substr(0, showChar);
                        var h = content.substr(showChar, content.length - showChar);

                        var html = c + '<span class="moreellipses">' + ellipsestext + '</span><span class="morecontent"><span>' + h + '</span><a href="" class="morelink">' + moretext + '</a></span>';

                        $(this).html(html);
                    }

                });

                $(document).on('click', ".morelink", function() {
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

                $(".rateYo").each(function() {
                    var rating = $(this).attr("data-rating");
                    $(this).rateYo({
                        rating: rating,
                        starWidth: "20px",
                        readOnly: true
                    });
                });
            }
        })
    }

    var owl = $('.owl-theme');
    owl.owlCarousel({
        loop: false,
        margin: 10,
        autoplay: false,
        nav: true,
        dots: false,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 2
            },
            1000: {
                items: 3
            },
            1366: {
                items: 3
            },
            1920: {
                items: 4
            }
        }
    });

    $(".category").on('click', function() {
        var categoryId = $(this).attr('data-category-id');
        if (categoryId) {
            loadMenu(categoryId);
        }
    });

    $("#login-error").hide();
    $("#loginForm").validate({
        rules: {
            username: {
                required: true
            },
            password: {
                required: true
            }
        },
        onkeyup: false,
        onfocusout: false,
        onsubmit: true,
        highlight: function(element, errorClass, validClass) {
            $(element).parents('.form-control').removeClass('has-success').addClass('has-error');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).parents('.form-control').removeClass('has-error').addClass('has-success');
        },
        errorPlacement: function(error, element) {
            if (element.hasClass('select2') && element.next('.select2-container').length) {
                error.insertAfter(element.next('.select2-container'));
            } else if (element.parent('.input-group').length) {
                error.insertAfter(element.parent());
            } else if (element.prop('type') === 'radio' && element.parent('.radio-inline').length) {
                error.insertAfter(element.parent().parent());
            } else if (element.prop('type') === 'checkbox' || element.prop('type') === 'radio') {
                error.appendTo(element.parent().parent());
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function(form) {
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: $(form).attr("action"),
                data: $(form).serialize(),
                dataType: "html",
                success: function(data) {
                    if (data == 'Success') {
                        $(".sidebar-ar").removeClass('blur-background');
                        $(".dash-body-ar").removeClass('blur-background');
                        $(".wd-dr-right-toogle").removeClass('blur-background');
                        $(".sidebar").removeClass('blur-background');

                        window.location.reload();
                    } else {
                        $("#login-error").show();
                        $("#login-error").html(data);
                    }
                }
            });
        }
    });

    $("#register-error").hide();
    $("#customer-signup").validate({
        rules: {
            first_name: {
                required: true
            },
            last_name: {
                required: true
            },
            physical_address: {
                required: true
            },
            city: {
                required: true
            },
            state: {
                required: true
            },
            zipcode: {
                required: true
            },
            mobile_number: {
                required: true,
                number: true,
                mobileUnique: true
            },
            email_id: {
                required: true,
                email: true,
                emailUnique: true
            },
            password: {
                required: true
            }
        },
        onkeyup: false,
        onfocusout: false,
        onsubmit: true,
        highlight: function(element, errorClass, validClass) {
            $(element).parents('.form-control').removeClass('has-success').addClass('has-error');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).parents('.form-control').removeClass('has-error').addClass('has-success');
        },
        errorPlacement: function(error, element) {
            if (element.hasClass('select2') && element.next('.select2-container').length) {
                error.insertAfter(element.next('.select2-container'));
            } else if (element.parent('.input-group').length) {
                error.insertAfter(element.parent());
            } else if (element.prop('type') === 'radio' && element.parent('.radio-inline').length) {
                error.insertAfter(element.parent().parent());
            } else if (element.prop('type') === 'checkbox' || element.prop('type') === 'radio') {
                error.appendTo(element.parent().parent());
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function(form) {
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: $(form).attr("action"),
                data: $(form).serialize(),
                dataType: "json",
                success: function(data) {
                    if (data.success) {
                        $("#second-modal").modal("hide");
                        Swal.fire(
                            'Success',
                            'Signup succcessfully.',
                            'success'
                        )
                        $("#first-modal").modal("show");

                    } else {
                        var errors = [];
                        $.each(data.error, function(key, value) {
                            errors.push(value);
                        });
                        $("#register-error").show();
                        $("#register-error").html(errors.join(" <br> "));
                    }
                }
            });
        }
    });

    jQuery.validator.addMethod("emailUnique", function(value, element) {
        var response = false;
        $.ajax({
            url: baseUrl + "/email/unique",
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            async: false,
            data: {
                email: value
            },
            success: function(data) {
                response = (data == true) ? true : false;

            }
        });
        return response;
    }, "This email is already taken! Try another.");

    jQuery.validator.addMethod("mobileUnique", function(value, element) {
        var response = false;
        $.ajax({
            url: baseUrl + "/mobile/unique",
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            async: false,
            data: {
                mobile: value
            },
            success: function(data) {
                response = (data == true) ? true : false;
            }
        });
        return response;
    }, "This mobile number is already taken! Try another.");

    $(".openPromotion").on("click", function() {
        var promotionType = $(this).data('promotion-type');
        var promotionId = $(this).data('promotion-id');
        if (promotionType == 1 || promotionType == 3 || promotionType == 4 || promotionType == 5) {
            $(".background-" + promotionId).addClass('card-v-inner-sys-five');
        } else if (promotionType == 2) {
            $(".background-" + promotionId).addClass('card-v-inner-sys-first');
        } else if (promotionType == 6) {
            $(".background-" + promotionId).addClass('card-v-inner-sys-seven');
        } else if (promotionType == 7) {
            $(".background-" + promotionId).addClass('card-v-inner-sys-six');
        } else if (promotionType == 8) {
            $(".background-" + promotionId).addClass('card-v-inner-sys-four');
        } else if (promotionType == 9) {
            $(".background-" + promotionId).addClass('card-v-inner-sys-third');
        } else if (promotionType == 10) {
            $(".background-" + promotionId).addClass("card-v-inner-sys-second");
        }
        $("#exampleModal-" + promotionId).modal("show");
    });

    $('.btn-inner-first').on('click', function() {
        var promotionId = $(this).data('promotion-id');
        $('.remove-select-' + promotionId).removeClass('selected-blog');
        $('.cancel-modal-' + promotionId).addClass('selected-blog');
        $("#exampleModal-" + promotionId).modal("hide");
    });

    $("#forgot-error").hide();
    $("#forget-password").validate({
        rules: {
            email_mobile_number: {
                required: true
            }
        },
        onkeyup: false,
        onfocusout: false,
        onsubmit: true,
        highlight: function(element, errorClass, validClass) {
            $(element).parents('.form-control').removeClass('has-success').addClass('has-error');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).parents('.form-control').removeClass('has-error').addClass('has-success');
        },
        errorPlacement: function(error, element) {
            if (element.hasClass('select2') && element.next('.select2-container').length) {
                error.insertAfter(element.next('.select2-container'));
            } else if (element.parent('.input-group').length) {
                error.insertAfter(element.parent());
            } else if (element.prop('type') === 'radio' && element.parent('.radio-inline').length) {
                error.insertAfter(element.parent().parent());
            } else if (element.prop('type') === 'checkbox' || element.prop('type') === 'radio') {
                error.appendTo(element.parent().parent());
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function(form) {
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: $(form).attr("action"),
                data: $(form).serialize(),
                dataType: "json",
                success: function(data) {
                    if (data.success == true) {
                        $("#third-modal").modal("hide");
                        $("#four-modal").modal('show');
                        localStorage.setItem("email_id", data.email_id);
                    } else {
                        $("#forgot-error").html(data.message);
                        $("#forgot-error").show();
                    }
                }
            });
        }
    });

    $('.btn-five-msg').on('click', function() {
        if ($(this).hasClass('with-five')) {
            $('#four-modal').modal('hide');
        }
        $("#email_id").val(localStorage.getItem('email_id'));
        $('#five-modal').modal('show');
    });

    $(".otpInput").on("keyup", function() {
        if (this.value.length == this.maxLength) {
            $(this).next('.otpInput').focus();
        }
    });

    $("#otp-error").hide();
    $('.btn-six-msg').on('click', function() {
        if ($(this).hasClass('with-six')) {
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: $("#OtpVerify").attr("action"),
                data: $("#OtpVerify").serialize(),
                dataType: "json",
                success: function(data) {
                    if (data.success == true) {
                        $('#five-modal').modal('hide');
                        $('#six-modal').modal('show');
                    } else {
                        $("#otp-error").html(data.message);
                        $("#otp-error").show();
                    }
                }
            });
        }
    });

    $('.btn-seven-msg').on('click', function() {
        if ($(this).hasClass('with-seven')) {
            $('#six-modal').modal('hide');
        }
        $("#customer_email_id").val(localStorage.getItem('email_id'));
        $('#seven-modal').modal('show');
    });

    $('.btn-partyware-modal-close').on('click', function() {
        $('#seven-modal').modal('hide');
        $('#first-modal').modal('show');
    });

    $("#reset-password-error").hide();
    $("#chage-password").validate({
        rules: {
            password: {
                required: true
            },
            retype_password: {
                required: true,
                equalTo: "#new-password"

            }
        },
        onkeyup: false,
        onfocusout: false,
        onsubmit: true,
        highlight: function(element, errorClass, validClass) {
            $(element).parents('.form-control').removeClass('has-success').addClass('has-error');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).parents('.form-control').removeClass('has-error').addClass('has-success');
        },
        errorPlacement: function(error, element) {
            if (element.hasClass('select2') && element.next('.select2-container').length) {
                error.insertAfter(element.next('.select2-container'));
            } else if (element.parent('.input-group').length) {
                error.insertAfter(element.parent());
            } else if (element.prop('type') === 'radio' && element.parent('.radio-inline').length) {
                error.insertAfter(element.parent().parent());
            } else if (element.prop('type') === 'checkbox' || element.prop('type') === 'radio') {
                error.appendTo(element.parent().parent());
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function(form) {
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: $(form).attr("action"),
                data: $(form).serialize(),
                dataType: "json",
                success: function(data) {
                    if (data.success == true) {
                        Swal.fire("Success", data.message, "success")
                            .then((result) => {
                                $("#seven-modal").modal("hide");
                                $("#first-modal").modal('show');
                                localStorage.removeItem("email_id");
                            });

                    } else {
                        $("#reset-password-error").html(data.message);
                        $("#reset-password-error").show();
                    }
                }
            });
        }
    });

    $("#searchMenu").on("keyup keypress", function() {
        var searchItem = $(this).val();
        if (searchItem.length > 1) {
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: baseUrl + '/search/menuitem',
                data: {
                    searchItem: searchItem
                },
                dataType: "json",
                success: function (response) {
                    if (response) {
                        $("#menuItems").addClass('d-none');
                        // $("#searchItems").addClass('d-block');
                        $("#searchItems").html(response.view);
                    }
                }
            });
        } else {
            $("#searchItems").empty();
            $("#menuItems").removeClass('d-none');
            // $("#searchItems").addClass('d-none');
        }
    });

});
