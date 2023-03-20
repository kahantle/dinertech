$(document).ready(function () { 
    var baseUrl = $("[name='base-url']").attr("content");
    $(document).on("click", ".action", function() {
        var url = $(this).data("route");
        var value = $(this).data("value");
        if (value === "Accept") {
            $(".openTimePickerPopUp").css("visibility", "visible");
            $(".openTimePickerPopUp").css("opacity", 1);
            $("#actionUrl").val(url);
        } else {
            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    )
                },
                url: url,
                type: "post",
                dataType: "json",
                beforeSend: function() {
                    $("body").preloader();
                },
                complete: function() {
                    $("body").preloader("remove");
                },
                success: function(res) {
                    toastr.success(res.alert);
                    // timerMinutes(res.order_pickup_time);
                    window.location.href = res.route;
                }
            });
        }
    });

    $(".closeModal").bind("click", function(e) {
        $(".closeAllModal").css("visibility", "hidden");
        $(".closeAllModal").css("opacity", 0);
    });

    $("#sltDuration").on("change", function () {
        var acceptTime = new Date();
        acceptTime.setMinutes(acceptTime.getMinutes() + parseInt($(this).val(), 10));
        var pickUpTime = acceptTime.getFullYear() + '-' + acceptTime.getMonth() + '-' + acceptTime.getDate() + ' ' + acceptTime.toLocaleTimeString();
        $("#pickUpTime").val(pickUpTime);
    });

    $("#orderTimePickup").on("submit", function(event) {
        event.preventDefault();
        var $form = $(this);
        if (!$form.valid()) return false;
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            url: $(".actionUrl").val(),
            data: {
                type: "minutes",
                minutes: $(".sltDuration").val(),
                pick_up_time: $("#pickUpTime").val()
            },
            type: "post",
            dataType: "json",
            beforeSend: function() {
                $("body").preloader();
            },
            complete: function() {
                $("body").preloader("remove");
            },
            success: function (res) {
                toastr.success(res.alert);
                window.location.href = res.route;
            }
        });
    });

    $(".order-timer").each(function () {
        var orderId = $(this).attr("data-orderId");
        var endTime = $(this).attr("data-pickup").split(" ");
        var now = new Date();
        var totalPickupMinutes = $(this).attr("data-pickup-minutes");
        timerMinutes(now, endTime, totalPickupMinutes, orderId);
    });

    function timerMinutes(now, endTime, totalPickupMinutes, orderId) {
        endTime =
            now.toLocaleString("default", { month: "short" }) +
            " " +
            now.getDate() +
            ", " +
            now.getFullYear() +
            " " +
            endTime[1];

        var countDownDate = new Date(endTime).getTime();
        // Update the count down every 1 second
        var x = setInterval(function() {
            // Get todays date and time
            var now = new Date().getTime();

            // Find the distance between now an the count down date
            var distance = countDownDate - now ;
            // Time calculations for days, hours, minutes and seconds
            var hours = Math.floor(
                (distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
            );
            var minutes = Math.floor(
                (distance % (1000 * 60 * 60)) / (1000 * 60)
            );
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Output the result in an element with id="demo"
            // document.getElementById("demo").innerHTML =
            // hours + "h " + minutes + "m " + seconds + "s ";
            if (minutes != 1) {
                if (minutes * 60 > (totalPickupMinutes * 60) / 2) {
                    $(".order-time-" + orderId).html(
                        "<button class='btn-success btn-sucess-inter'> " +
                            totalPickupMinutes +
                            " MINUTES <br> <p class='m-0'> " +
                            minutes +
                            " min " +
                            seconds +
                            " sec</p> </button>"
                    );
                    $("#change-color-" + orderId).removeClass(
                        "order-new-green"
                    );
                    $("#change-color-" + orderId).addClass(
                        "order-recent-green"
                    );
                }

                if (
                    minutes * 60 < (totalPickupMinutes * 60) / 2 &&
                    minutes * 60 > (totalPickupMinutes * 60) / 4
                ) {
                    $(".order-time-" + orderId).html(
                        "<button class='btn-warning btn-due-blog-yellow'> " +
                            totalPickupMinutes +
                            " MINUTES <br> <p class='m-0'> " +
                            minutes +
                            " min " +
                            seconds +
                            " sec</p> </button>"
                    );
                    $("#change-color-" + orderId).removeClass(
                        "order-recent-green"
                    );
                    $("#change-color-" + orderId).addClass(
                        "order-recent-yellow"
                    );
                }

                if (minutes * 60 < (totalPickupMinutes * 60) / 4) {
                    $(".order-time-" + orderId).html(
                        "<button class='btn-danger btn-due-blog'> " +
                            totalPickupMinutes +
                            " MINUTES <br> <p class='m-0'> " +
                            minutes +
                            " min " +
                            seconds +
                            " sec</p> </button>"
                    );
                    $("#change-color-" + orderId).removeClass(
                        "order-recent-yellow"
                    );
                    $("#change-color-" + orderId).addClass("order-recent-red");
                }
            }

            if (distance < 0) {
                clearInterval(x);
                changeStatus(orderId);
                // document.getElementById("demo").innerHTML = "EXPIRED";
            }

        }, 1000);
    }

    function changeStatus(orderId) {
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            url: baseUrl + "/order/status/due",
            type: "post",
            // dataType: "json",
            data: {
                orderId: orderId
            },
            success: function(res) {
                if (res.success == true) {
                    $(".order-time-" + orderId).html(
                        "<button class='btn-danger btn-due-blog'>ORDER DUE</button>"
                    );
                    sessionStorage.removeItem(orderId);
                }
            }
        });
    }

});
