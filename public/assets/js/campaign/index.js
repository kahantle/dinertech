$(function() {
    "use strict";

    var baseUrl = $("meta[name='base-url']").attr("content");

    $(".get-report").on("click", function() {
        var campaignId = $(this).attr('data-campaignId');
        $(".report").html('');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: baseUrl + '/campaigns/report',
            type: "POST",
            data: {
                campaignId: campaignId
            },
            dataType: "json",
            beforeSend: function() {
                $("body").preloader();
            },
            complete: function() {
                $("body").preloader('remove');
            },
            success: function(res) {
                $(".report").html(res.view);
                $("#report-modal").modal('show');
                $(".subject-blog").html($("#" + campaignId).val());
                $(".campaign-name").html($("#campaign-nm-" + campaignId).html());
                $(".campaign-date").html($("#campaign-date-" + campaignId).html());
            },
            error: function(xhr, ajaxOptions, thrownError) {
                swal.fire("Error!", "Some error in report detail.", "error");
            }
        });
    });

    $(document).on('click', '.campaign-delete', function() {
        var campaignId = $(this).attr("data-campaignId");
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete it!"
        }).then(function(result) {
            if (result.value) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: baseUrl + '/campaigns/delete',
                    type: "POST",
                    data: {
                        campaignId: campaignId
                    },
                    dataType: "json",
                    beforeSend: function() {
                        $("body").preloader();
                    },
                    complete: function() {
                        $("body").preloader('remove');
                    },
                    success: function(res) {
                        toastr.success(res.alert);
                        window.location.reload();
                        // window.location.href = res.route;
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        swal.fire("Error deleting!", "Please try again", "error");
                    }
                });
            } else if (result.dismiss === "cancel") {

            }
        });
    });
});