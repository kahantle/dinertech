<!-- Bootstrap JS & Jquery -->
<script src="{{ asset('assets/customer/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/customer/vendors/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/customer/vendors/owl-carousel/js/owl.carousel.min.js') }}"></script>
<!-- custome Jquery -->
<script src="{{ asset('assets/customer/js/main.js') }}"></script>
<script src="{{ asset('assets/customer/js/sliders.js') }}"></script>
<script src="{{ asset('assets/customer/js/header.js') }}"></script>


<script src="{{ asset('assets/customer/js/feather-icons/4.28.0/dist/feather.min.js') }}"></script>
<script src="{{ asset('assets/customer/js/moment/moment-with-locales.js') }}"></script>
<script src="{{ asset('assets/customer/js/custom-js/common.js') }}"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('assets/customer/js/jquery.lazy.min.js') }}"></script>
<script>
$('#btnSave').click(function(e) {
    $('#yourModal').modal('toggle'); //or  $('#IDModal').modal('hide');
});

//Model All Hide and Show
$(".within-first-modal").on("click", function() {
    $("#second-modal").modal("show");
    $("#yourModal").modal("hide");
});

$(".btn-second-modal-close").on("click", function() {
    $("#second-modal").modal("hide");
    $("#yourModal").modal("show");
});

$(".within-third-modal").on("click", function() {
    $("#third-modal").modal("show");
    $("#yourModal").modal("hide");
});
$('.btn-party-modal-close').on('click', function() {
    $('#third-modal').modal('hide');
    $('#yourModal').modal('show');
});

//Button Hide if login
$( document ).ready(function() {
    @auth
       $('#loginbutton').hide();
    @else
        // Not authorised.
    @endauth
});
</script>

<script>
$(".coupenremove").hide();

function applyCoupenCode() { 
    var coupon_code = $('#coupon_code').val();
    var cart_id = $('#cartid').val();
    var promotion_id = $('#promotion_id').val();
    var itemFormData = {
        'coupon_code': coupon_code,
        'cart_id':cart_id
    };
    if (coupon_code != '') {
        let baseUrl = window.location.origin; // Gets the base URL (e.g., https://dinertech.io)
        let ajaxUrl = baseUrl === "https://dinertech.io" ? "/web/customer/newpromotion" : "/customer/newpromotion";

        $.ajax({
            type: "post",
            url: ajaxUrl,
            data: itemFormData,
            dataType: "json",
            cache: true,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(result) {
                console.log(result);
                var discount=parseFloat(result.discount);
                if(result.status=='success'){
                    //console.log(promotion_id);
                    $('.coupenremove').show();
                    $('#coupon_code_msgs').hide();
                    $('#discount').html('$' + discount.toFixed(2));
                    $('#total_price').html('$' + result.itemPrice.toFixed(2));
                    $('#promotion_id').val(result.promotion_id);
                    $('#promo_description').html(result.promo_description);
                    $('.couponcode').html(result.couponcode);
                    $(".bgcolorchange").css("background-color","#54ba72");
                    $(".apply-content").css("display", "none");
                    $(".Promotion-content").css("display", "block");
                    $("#checkout").load(location.href + " #checkout");
                }else{
                    $('#grand_total').val();
                    $(".apply-content").css("display", "none");
                    $(".Promotion-content").css("display", "block");
                }
                $('#coupon_code_msgs').html(result.msg);
            }
        });
    } else {
        $('#coupen_code_msg').html('Please enter coupen Code')
    }
}

    // Function to apply promotion code to the coupon code input field
    function applyPromotion(promotionCode) {
    // Set the promotion code in the coupon code input field
    $('#coupon_code').val(promotionCode);
}

    // Adding click event listener to the "Apply" buttons in promotions
    $(document).ready(function() {
    $('.aa-browse-btn').click(function() {
        // Extract the promotion code from the clicked promotion
        var promotionCode = $(this).closest('.card-body').find('.promotion_text-cololr').text().trim();

        // Call the applyPromotion function with the extracted promotion code
        applyPromotion(promotionCode);
    });
});

var removecoupen = "{{ url('customer/remove_coupon_code') }}";

function remove_coupon_code() {
    $('#coupon_code_msg').html('');
    var coupon_code = $('#coupon_code').val();
    var promotion_id = $('#promotion_id').val();
    //console.log("Pomo -->"+promotion_id);
    $('#coupon_code').val('');
    var cart_id = $('#cartid').val();
    //console.log("Cart -->"+cart_id);
    var removecoupendata = {
        'promotion_id': promotion_id,
        'coupon_code': coupon_code,
        'cart_id': cart_id,
    };
    if (coupon_code != '') {
        $.ajax({
            type: 'post',
            url: removecoupen,
            data: removecoupendata,
            dataType: "json",
            cache: true,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(result) {
                //console.log(result);
                if (result != '') {
                    $('.coupenremove').hide();
                    $("#checkout").load(location.href + " #checkout");
                    $("#prmotioncode").load(location.href + " #prmotioncode");
                    $(".bgcolorchange").css("background-color", "");
                    $('#promo_description').html('');
                } else {

                }
            }
        });
    }
}


$(document).on("click", ".redeemProduct", function () {
    var menuId = $(this).attr("data-cartMenuId");
    var loyaltyRuleId = $(this).attr("data-cartLoyaltyRuleId");
    redeemToCart({menuId : menuId,loyaltyRuleId : loyaltyRuleId})
});


function redeemToCart(data) {
    $.ajax({
        type: "POST",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        },
        url: "{{ route('customer.addToCart') }}",
        data: data,
        dataType: "html",
        success: function (response) {
            if (response) {
                $(".scroll-inner-blog").load(
                    window.location.href + " .scroll-inner-blog"
                );
                $(".content").load(
                    window.location.href + " .content"
                )
                $("#checkout").load(window.location.href + " #checkout");
                //$(".addProduct").css("display", "none");
                //$(".removeProduct").css("display", "block");
            }
        }
    });
}

</script>
@yield('scripts')
