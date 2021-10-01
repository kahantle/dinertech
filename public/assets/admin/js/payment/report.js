$(function(){

    "use strict";
	var baseUrl = $("#base-url").attr('content');
    var restaurantId = $("#restaurantId").val();

    // getChart("Month");
    $.ajax({
        url:baseUrl+'/payment/chart/',
        type:"POST",
        dataType:"JSON",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data:{
            restaurantId:restaurantId,
        },
        success:function(response){
           console.log(response);
        //    getChart(response.days,response.amount,response.colors);
            getChart(response.salesData);
            getProfitChart(response.profit);
        }
    });
    $(".filter").on("click",function(e){
        e.preventDefault();
        $(".title-text").html("1 "+$(this).data('filter')+"<span class='caret'></span>");
        
        $.ajax({
            url:baseUrl+'/payment/chart/',
            type:"POST",
            dataType:"JSON",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data:{
                restaurantId:restaurantId,
                filterValue:$(this).data('filter')
            },
            success:function(response){
                // getChart(response.days,response.amount,response.colors);
                if(window.bar != undefined) 
                    window.bar.destroy(); 
                getChart(response.salesData);
                getProfitChart(response.profit);
            }
        });
    });

    function getChart(chartData)
    {
        var xValues = chartData.days;
        var yValues = chartData.amount;
        var barColors = chartData.colors;
        var data = {
                type: "bar",
                data: {
                    labels: xValues,
                    datasets: [{
                        backgroundColor: barColors,
                        data: yValues
                    }]
                },
                options: {
                    legend: {display: false},
                    title: {
                        display: true,
                    }
                }
            };
         var myChart = document.getElementById('mychart').getContext('2d');
         window.bar = new Chart(myChart, data);
    }

    function getProfitChart(profitData)
    {
        var xProfitValues = profitData.days;
        var yprofitValues = profitData.profits;
        var barProfitColors = profitData.colors;

        var dataProfit = {
            type: "bar",
            data: {
                labels: xProfitValues,
                datasets: [{
                    backgroundColor: barProfitColors,
                    data: yprofitValues
                }]
            },
            options: {
                legend: {display: false},
                title: {
                    display: true,
                }
            }
        };
        var profitChart = document.getElementById('profitChart').getContext('2d');
        // if(window.bar != undefined) 
        //     window.bar.destroy();
        window.bar = new Chart(profitChart, dataProfit);
    }
});