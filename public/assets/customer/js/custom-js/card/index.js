$(function() {

    "use strict";

    var baseUrl = $("#base-url").attr('content');

    feather.replace();

    $(".delete-card").on("click", function() {
        var cardId = $(this).data('card-id');
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: baseUrl + '/cards/delete',
                    data: {
                        cardId: cardId
                    },
                    dataType: "html",
                    success: function(data) {
                        if (data == true) {
                            Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            );
                            setTimeout(function() {
                                window.location.reload();
                            }, 1000);
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Something went wrong!',
                                // footer: '<a href="">Why do I have this issue?</a>'
                            })
                        }
                    }
                });
            }
        })
    });
});