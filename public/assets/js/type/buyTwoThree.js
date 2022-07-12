$(document).ready(function () {

    var baseUrl = $("meta[name='base-url']").attr("content");

    $("#select-box").on("change", function () {
        if ($(this).val() == "Manually set discount") {
            $("#tab-1").hide();
            $("#tab-2").show();
        } else {
            $("#tab-1").show();
            if ($(document).find(".discount-remove").length != 0) {
                $(document).find("#addDiscountItem").html("");
            }
            $("#tab-2").hide();
        }
    });

    $(document).on('keyup change', ".discount_percentage", function () {
        if ($(this).val() >= 100) {
            $(this).val('100');
        }
    });

    $(document).on('click', '.categoryList', function () {
        var id = $(this).attr('id');
        var category = $(this).data('category');
        if ($(this).prop("checked") == true) {
            $("." + id).prop("checked", true)
            var check_length = $(".category_item_" + category + ":checked").length;
            $(document).find("#hidden_eligible_item_" + category).val(check_length);
        }
        else if ($(this).prop("checked") == false) {
            $("." + id).prop("checked", false)
            $(document).find("#hidden_eligible_item_" + category).val('');
        }
    });

    $(document).on('click', '.checkbox-custom', function () {
        var categoryType = $(this).data("category");
        var check_length = $(".category_item_" + categoryType + ":checked").length;
        if (check_length) {
            $("#hidden_eligible_item_" + categoryType).val(check_length);
        } else {
            $("#hidden_eligible_item_" + categoryType).val('');
        }
    });

    $(document).on('change', '.onlyForSelectedPayment', function () {
        if ($(this).prop('checked') == true) {
            $(".onlyForSelectedPaymentDiv").show();
            $("#cash").prop("checked", true);
            $("#cardtodelivery").prop("checked", true);
        } else {
            $("#cash").prop("checked", false);
            $("#cardtodelivery").prop("checked", false);
            $(".onlyForSelectedPaymentDiv").hide();
        }
    });

    $(document).on('click', '.eligible_popup_remove', function () {
        var popupId = $(this).data('popup');
        var check_length = $(".category_item_" + popupId + ":checked").length;
        if (check_length) {
            $("#slct-" + popupId).text(check_length + " Eligible items selected.");
        } else {
            $("#slct-" + popupId).text('Eligible Items');
        }
    });

    var count = $(".eligible-item").length + 1;
    var uid = $("input[name='restaurant_user_id']").val();
    $(document).on('click', "#addEligibleItems", function () {
        count = $(".eligible-item").length + 1;

        $(document).find(".btn-remove-one").show();
        if ($(".discount-remove").length != 0) {
            $("#select-discount-type").show();
            $("#select-box option[value=2]").attr('selected', 'selected');
            // $("#select-discount-type").removeClass("discount-remove");
        }

        var words_number = toWords(count);

        var html = '<div  id="eligible-item-' + words_number + '" class="form-group eligible-item">';
        html += '<a href="#field-' + words_number + '" class="fill-inner w-100 fill-sec">';
        html += '<img src="' + baseUrl + '/assets/images/order-cart.png" class="items-inner-st-sec wd-dr-wrapper">';
        html += '<p name="slct" id="slct-' + words_number + '" class="form-control inner-p-wrapper-blog-sys">Eligible Items Group ' + count + '</p>';
        html += '</a>';
        html += '<button type="button" class="btn btn-remove btn-remove-' + words_number + '" data-remove=' + words_number + '>✕</button>';
        html += '<div>';
        html += '<input type="text" style="clip-path: circle(0);height: 0;padding: 0; width: 0; position: absolute; opacity: 0;" id="hidden_eligible_item_' + words_number + '" name="hidden_eligible_item_' + words_number + '" />';
        html += '</div>';
        html += '</div>';

        $("#eligibleItems").append(html);

        $.ajax({
            url: baseUrl + '/promotion-add/getCategory',
            type: "POST",
            dataType: "json",
            data: {
                "uid": (uid) ? uid : 0,
                "_token": $("meta[name='csrf-token']").attr('content'),
            },
            success: function (response) {
                var categoryData = response;
                if (categoryData) {
                    var popUp = '<div id="field-' + words_number + '" class="overlay field-popup">';
                    popUp += '<div class="popup text-center">';
                    popUp += '<h2>Eligible Items</h2>';
                    popUp += '<a class="close eligible_popup_close" href="#">&times;</a>';
                    popUp += '<div class="content">';
                    popUp += '<div id="accordion" class="accordion">';
                    for (var i in categoryData) {
                        if (categoryData[i].category_item.length != 0){
                            popUp += '<div class="card mb-0">';
                            popUp += '<div class="form-group cs-checkbox">';
                            popUp += '<input type="checkbox" class="checkbox-custom categoryList" id="category_' + words_number + i + '" value=' + categoryData[i].category_id + ' name="category[' + count + '][' + categoryData[i].category_id + ']" data-category="' + words_number + '">';
                            popUp += '<label for="category_' + words_number + i + '">' + categoryData[i].category_name + '</label>';
                            popUp += '</div>';
                            popUp += '<div class="card-header collapsed" data-toggle="collapse" href="#collapse_' + words_number + i + '">';
                            popUp += '<a class="card-title">';
                            popUp += '<i class="fa fa-plus"></i>';
                            popUp += '</a>';
                            popUp += '</div>';
                            popUp += '<div id="collapse_' + words_number + i + '" class="card-body collapse" data-parent="#accordion" >';
                            for (var item in categoryData[i].category_item) {
                                popUp += '<div class="form-group cs-checkbox">';
                                popUp += '<input type="checkbox" class="checkbox-custom category_item_' + words_number + ' category_' + words_number + i + '" id="item' + categoryData[i].category_id + item + count +'" value=' + categoryData[i].category_item[item].menu_id + ' name="category[' + count + '][' + categoryData[i].category_id + '][' + categoryData[i].category_item[item].menu_id + ']" data-category="' + words_number + '">';
                                popUp += '<label for="item' + categoryData[i].category_id + item + count+'">' + categoryData[i].category_item[item].item_name + '</label>';
                                popUp += '</div>';
                            }
                            popUp += '</div>';
                            popUp += '</div>';
                        }
                    }
                    popUp += '</div>';
                    popUp += '</div>';
                    popUp += '<div class="form-group form-btn justify-content-center">';
                    popUp += '<a class="close eligible_popup_remove eligible_popup-inner" href="#" data-popup="' + words_number + '">Submit</a>';
                    popUp += '</div>';
                    popUp += '</div>';
                    popUp += '</div>';
                    $("#addEligiblePopup").append(popUp);
                }
            }
        });

        var manually_discount = '<div class="input-group mb-3 manually-discount manually-discount-' + words_number + '">';
        manually_discount += '<div class="input-group-prepend">';
        manually_discount += '<span class="input-group-text inner-text-blog"> Items Group ' + count + ' :';
        manually_discount += '</span>';
        manually_discount += '</div>';
        manually_discount += '<input type="text" class="form-control discount_percentage" value="0"  name="item_group_discount[' + count + ']" oninput="this.value = this.value.replace(/[^0-9.]/g, "").replace(/(\..*?)\..*/g, "$1");">';
        manually_discount += '<div class="input-group-prepend">';
        manually_discount += '<span class="input-group-text input-group-text-first">%</span>';
        manually_discount += '</div>';
        manually_discount += '</div>';

        $("#addItemGroup").append(manually_discount);

        var automatically_discount = '<div class="input-group mb-3 automatically-discount automatically-discount-' + words_number + '">';
        automatically_discount += '<div class="input-group-prepend">';
        automatically_discount += '<span class="input-group-text inner-text-blog pr-5"></span>';
        automatically_discount += '</div>';
        automatically_discount += '<input type="text" class="form-control discount_percentage" value="0"  name="item_discount[' + (count - 1) + ']" oninput="this.value = this.value.replace(/[^0-9.]/g, "").replace(/(\..*?)\..*/g, "$1");" readonly>';
        automatically_discount += '<div class="input-group-prepend">';
        automatically_discount += '<span class="input-group-text input-group-text-first">%</span>';
        automatically_discount += '</div>';
        automatically_discount += '</div>';
        $("#addDiscountItem").append(automatically_discount);
        count++;
    });

    $(document).on("click", ".btn-remove", function () {
        $(document).find(".eligible-item").last().remove();
        $(document).find(".field-popup").last().remove();
        $(document).find(".manually-discount").last().remove();
        $(document).find(".automatically-discount").last().remove();
        if ($(".eligible-item").length == 1) {
            $(document).find(".btn-remove-one").hide();
            $("#addDiscountItem").html();
            $("#select-discount-type").hide();
            $("#select-discount-type").addClass("discount-remove");
            $("#tab-2").show();
            $("#tab-1").hide();
        }
    });

    var th = ['', 'thousand', 'million', 'billion', 'trillion'];

    var dg = ['zero', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine'];
    var tn = ['ten', 'eleven', 'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'];
    var tw = ['twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety'];
    function toWords(s) {
        s = s.toString();
        s = s.replace(/[\, ]/g, '');
        if (s != parseFloat(s)) return 'not a number';
        var x = s.indexOf('.');
        if (x == -1) x = s.length;
        if (x > 15) return 'too big';
        var n = s.split('');
        var str = '';
        var sk = 0;
        for (var i = 0; i < x; i++) {
            if ((x - i) % 3 == 2) {
                if (n[i] == '1') {
                    str += tn[Number(n[i + 1])] + ' ';
                    i++;
                    sk = 1;
                } else if (n[i] != 0) {
                    str += tw[n[i] - 2] + ' ';
                    sk = 1;
                }
            } else if (n[i] != 0) {
                str += dg[n[i]] + ' ';
                if ((x - i) % 3 == 0) str += 'hundred ';
                sk = 1;
            }
            if ((x - i) % 3 == 1) {
                if (sk) str += th[(x - i - 1) / 3] + ' ';
                sk = 0;
            }
        }
        if (x != s.length) {
            var y = s.length;
            str += 'point ';
            for (var i = x + 1; i < y; i++) str += dg[n[i]] + ' ';
        }
        return str.replace(/^\s+|\s+$/gm, '');
    }

    var total_eligible_item = $(".eligible-item").length;

    for (var item = 1; item <= total_eligible_item; item++) {
        var item_count = $(".total_item_count_" + toWords(item)).val();
        if (item_count) {
            $("#slct-" + toWords(item)).text(item_count + " Eligible items selected.");
            $("#hidden_eligible_item-" + toWords(item)).val(item_count);
        }
    }
});