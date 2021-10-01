$(function(){
    
    "use strict";
    var baseUrl = $("#base-url").attr('content');
    
     //TOGGLING NESTED ul
     $(".drop-down .selected a").click(function() {
        $(".drop-down .options ul").toggle();
    });
    
    //SELECT OPTIONS AND HIDE OPTION AFTER SELECTION
    $(".drop-down .options ul li a").click(function() {
        var text = $(this).html();
        $(".drop-down .selected a span").html(text);
        $(".drop-down .options ul").hide();
    }); 


    //HIDE OPTIONS IF CLICKED ANYWHERE ELSE ON PAGE
    $(document).bind('click', function(e) {
        var $clicked = $(e.target);
        if (! $clicked.parents().hasClass("drop-down"))
            $(".drop-down .options ul").hide();
    });

    // filterData('All');
    function filterData(filterType,fromDate,toDate)
    {
        $.ajax({
            url:baseUrl+"/dashboard/filter/",
            type:"POST",
            dataType:"JSON",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data:{
                filterType:filterType,
                fromDate:fromDate,
                toDate:toDate
            },
            success:function (response){
                // console.log(response);
                $(".filter-type").html(response.filter);
                $("#user_count").html(response.users);
                $("#restaurant_count").html(response.restaurants);
                $("#orders_count").html(response.orders);
                $(".totalSales").html("$ "+response.totalSales);
                var html = '';
                if(response.previousSales < response.liveSales)
                {
                    html += '<img src="'+baseUrl.replace('/admin','/')+'assets/admin/img/up-arrow.png" class="down-arrow up-arrow">';
                    html += '<span class="price livesales-price profit">'+response.liveSales+'</span>';
                }
                else
                {
                    html += '<img src="'+baseUrl.replace('/admin','/')+'assets/admin/img/down-arrow.png" class="down-arrow">';
                    html += '<span class="price livesales-price loss">'+response.liveSales+'</span>';
                }
                $(".sales-amount").html(html);
                $(".livesales-price").html(response.liveSales);
                $(".active_order").html(response.activeOrders);
                $(".dec_order").html(response.declinedOrders);
                chartDetail(response.chart);
            }
        });
    }

    $('.filter').on("click",function(){
        var value = $(this).data('filter');
        var fromdate = '';
        var todate = '';
        if(value == 'Custom')
        {
            $(".wg-inner-blog").addClass('show');
            $(".wg-inner-blog").removeClass('hide');
            // $("#to-date").trigger('change');
        }
        else
        {
            $(".wg-inner-blog").addClass('hide');
            $(".wg-inner-blog").removeClass('show');
            filterData(value,fromdate,todate);   
        }
        // console.log(value);
        
    });

    $(document).on("change","#from-date",function(){
        if(document.getElementById("to-date").value != '')
        {
            $("#to-date").trigger('change');
        }
    });

    $(document).on("change","#to-date",function(){
        var fromdate = document.getElementById("from-date").value;
        var todate = document.getElementById("to-date").value;
        if(fromdate >= todate)
        {
            alert('From date should be less than To date');
            document.getElementById("to-date").value = '';
            return false;
        }
        filterData('Custom',fromdate,todate);
    });

    function chartDetail(chartData)
    {
        // window.bar.destroy();
        const labels = chartData.days;
        var data = {
            type: "line",
            data: {
                labels: labels,
                datasets: [{
                    label: 'Total Sales',
                    data: chartData.sales,
                    fill: false,
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1
                }]
            },
        };

        var myChart = document.getElementById('mychart').getContext('2d');
        window.bar = new Chart(myChart, data);
    }


  
    
});