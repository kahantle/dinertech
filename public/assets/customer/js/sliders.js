$(function() {
    "use strict";
    var baseUrl = $("#base-url").attr('content');

    $(' #first-slider').owlCarousel({
        loop: false,
        margin: 2,
        responsiveClass: true,
        autoplayHoverPause: true,
        autoplay: true,
        nav: true,
        dots: false,
        slideSpeed: 400,
        paginationSpeed: 400,
        autoplayTimeout: 3000,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 1
            },
            1000: {
                items: 1
            },
            1366: {
                items: 1
            },
            1920: {
                items: 1
            }
        }
    })

    var card_owl = $('.owl_1').owlCarousel({
        loop: false,
        margin: 2,
        responsiveClass: true,
        autoplayHoverPause: true,
        autoplay: true,
        nav: true,
        dots: false,
        slideSpeed: 400,
        paginationSpeed: 400,
        autoplayTimeout: 3000,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 1
            },
            1000: {
                items: 1
            },
            1366: {
                items: 1
            },
            1920: {
                items: 1
            }
        }
    })

    card_owl.on('changed.owl.carousel', function(event) {
        var current = event.item.index;
        var cardId = $(event.target).find(".owl-item").eq(current).find(".item").attr('data-card-id');
        $("#card_id").val(cardId);
    });


    $('.owl-first-blog').owlCarousel({
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
    })


    // $(document) .ready(function(){
    // var li =  $(".owl-item li ");
    // $(".li").click(function(){
    // li.removeClass('active');
    // });
    // });
})