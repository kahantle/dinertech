@extends('layouts.app')
@section('content')
<section id="wrapper">
  @include('layouts.sidebar')
  <div id="navbar-wrapper">
    <nav class="navbar navbar-inverse">
      <div class="container-fluid">
        <div class="navbar-header">
          <div class="profile-title-new">
          <a href="#" class="navbar-brand" id="sidebar-toggle"><i class="fa fa-bars"></i></a>
     
          <h2>Reports</h2>
          </div>
          <div class="report-days">
            <select class="duration_change form-control">
              <option value="1" @if($result['time_duration']==="1") selected @endif>Today</option>
              <option value="7"  @if($result['time_duration']==="7") selected @endif>Last 7 Day’s </option>
              <option value="30" @if($result['time_duration']==="30") selected @endif>Last Months </option>
            </select>
          </div>
        </div>
      </div>
    </nav>
  </div>
  <div class="dashboard report">
    <div class="container-fluid">
       <div class="row orders-report">
         <div class="col-lg-4">
           <div class="repot-box">
             <h5>Orders</h5>
             <span>Last {{$result['time_duration']}} Days</span>
             <div class="report-numbers">
               <div class="left-numbers">
                 <p class="first">{{ $result['get_order']}}</p>
                 @if(abs($result['order_pr_status']))
                 <p class="up secound"><i class="fa fa-caret-up" aria-hidden="true"></i>  {{number_format($result['order_pr_status'],2)}} %</p>
                 @else
                 <p class="down secound"><i class="fa fa-caret-down" aria-hidden="true"></i>  {{number_format($result['order_pr_status'],2)}} %</p>
                 @endif
               </div>
               <div class="right-numbers">
                 <span>All Time</span>
                 <p class="report-time">{{$result['all_order']}}</p>
               </div>
             </div>
           </div>
         </div>
         <div class="col-lg-4">
           <div class="repot-box">
             <h5>Pending Orders</h5>
             <span>Last {{$result['time_duration']}}  Days</span>
             <div class="report-numbers">
              <div class="left-numbers">
                <p class="first">{{ $result['get_pendingorder']}}</p>
                @if(abs($result['pending_order_pr_status']))
                <p class="up secound"><i class="fa fa-caret-up" aria-hidden="true"></i>  {{number_format($result['pending_order_pr_status'],2)}} %</p>
                @else
                <p class="down secound"><i class="fa fa-caret-down" aria-hidden="true"></i>  {{number_format($result['pending_order_pr_status'],2)}} %</p>
                @endif
              </div>
              <div class="right-numbers">
                <span>All Time</span>
                <p class="report-time">{{$result['all_pendingorder']}}</p>
              </div>
            </div>
           </div>
         </div>
         <div class="col-lg-4">
           <div class="repot-box">
             <h5>Total Delivery</h5>
             <span>Last {{$result['time_duration']}}  Days</span>
             <div class="report-numbers">
               <div class="left-numbers">
                 <p class="first">{{ $result['get_delivery']}}</p>
               </div>
               <div class="right-numbers">
                 <span>All Time</span>
                 <p class="report-time">{{ $result['all_delivery']}}</p>
               </div>
             </div>
           </div>
         </div>
       </div>
       <div class="row orders-report-graph">
         <div class="col-lg-7">
           <div class="repot-box">
             <h5>Sales (USD)</h5>
             <span>Last {{$result['time_duration']}}  Days</span>
             <div class="report-numbers">
               <div class="left-numbers">
                 <p class="first">{{ $result['sales_total']}}</p>
                 @if(abs($result['sales_per']))
                <p class="up secound"><i class="fa fa-caret-up" aria-hidden="true"></i>  {{number_format($result['sales_per'],2)}} %</p>
                @else
                <p class="down secound"><i class="fa fa-caret-down" aria-hidden="true"></i>  {{number_format($result['sales_per'],2)}} %</p>
                @endif
               </div>
               <div class="right-numbers">
                  <div class="avg-value">
                    <span>Avg.Value</span>
                    <p class="report-time">{{ $result['avg_values']}}</p>
                  </div>
                  <div class="alltime-value">
                    <span>All Time</span>
                    <p class="report-time">{{ $result['all_sales'] }}</p>
                  </div>
               </div>
             </div>
             <div class="basic_graph" id="basic_graph">
               
             </div>
           </div>
         </div>
         <div class="col-lg-5">
           <div class="repot-box">
             <h5>Clients</h5>
             <span class="w-100"><span class="green-rbox"></span>New</span>
             <span class="w-100"><span class="yellow-rbox"></span>Returning</span>
             <div class="pie_chart" id="pie_chart"> 
             </div>
           </div>
         </div>
       </div>
    </div>
  </div>
</section>
@endsection
@section('scripts')
<script src="https://code.highcharts.com/highcharts.src.js"></script> 
<script>
    $(document).on('change', '.duration_change', function() {
    var days = $(this).val();
    if(days){
      window.location.href = "http://" + window.location.host + window.location.pathname + '?duration=' + days;
    }else{
      window.location.href = "http://" + window.location.host + window.location.pathname ;
    }
  });
Highcharts.chart('pie_chart', {
    chart: {
        type: 'pie',
    },
    credits:false,
    colors:['#B7E985','#FBDA1E'],
    title: {
        text: ''
    },
    subtitle: {
        text: ''
    },
    plotOptions: {
        pie: {
            innerSize: 250,
        }
    },
    series: [{
        name: 'Delivered amount',
        data:  {!! $result['clients'] !!},
        
    }]
});
         
Highcharts.chart('basic_graph', {
    chart: {
        type: 'area'
    },
    colors:['#514DC8'],
    credits:false,
    title: false,
    xAxis: {
        allowDecimals: false,
        labels:false,
        labels: {
            enabled: false    
        }
    },
    yAxis: {
        title: false,
    },
  
    plotOptions: {
        area: {
            marker: {
                enabled: false,
                symbol: 'circle',
                radius: 2,
                states: {
                    hover: {
                        enabled: false
                    }
                }
            }
        }
    },
    series: [{
        name: 'Sales',
        data:  {!! $result['sales_array'] !!}
    }]
});
</script>
@endsection