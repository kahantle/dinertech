@extends('layouts.app')
@section('content')
<style>
    .first{
        font-size:30px !important;
    }
</style>
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
              <option value="today" @if($result['time_duration']==="today") selected @endif>Today</option>
              <option value="yesterday"  @if($result['time_duration']==="yesterday") selected @endif>Yesterday</option>
              <option value="this_week"  @if($result['time_duration']==="this_week") selected @endif>This Week</option>
              <option value="last_week"  @if($result['time_duration']==="last_week") selected @endif>Last Week</option>
              <option value="this_month"  @if($result['time_duration']==="this_month") selected @endif>This Month</option>
              <option value="last_month" @if($result['time_duration']==="last_month") selected @endif>Last Month </option>
              <option value="year_to_date" @if($result['time_duration']==="year_to_date") selected @endif>Year To Date </option>
              <option value="last_year"  @if($result['time_duration']==="last_year") selected @endif>Last Year</option>
              <option value="custom"  @if($result['time_duration']==="custom") selected @endif>Custom</option>
            </select>
          </div>
        </div>
      </div>
    </nav>
  </div>
    <div class="modal fade" id="customDateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Select Date</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {{ Form::open(['method' => 'get', 'id' => 'customdatePickerForm', 'class' => '']) }}
                    <div class="modal-body">
                        <div class="form-group row">
                            <label for="from-date" class="col-sm-2 col-form-label">From:</label>
                            <div class="col-sm-10">
                                <input type="date" name="from_date" class="form-control" id="from-date">
                            </div>
                        </div>
                        <input type="hidden" name="duration" value="custom">
                        <div class="form-group row">
                            <label for="from-date" class="col-sm-2 col-form-label">To:</label>
                            <div class="col-sm-10">
                                <input type="date" name="to_date" class="form-control" id="to-date">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Get Report</button>
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
  <div class="dashboard report">
    <div class="container-fluid">
       <div class="row orders-report">
         <div class="col-lg-3">
           <div class="repot-box">
             <h5>Orders</h5>
             <span> {{ ucwords(str_replace('_', ' ', $result['time_duration'])) }} </span>
             <div class="report-numbers">
               <div class="left-numbers">
                 <p class="first">{{ $result['get_orders']}}</p>
                 @if($result['order_percentage_status'])
                 <p class="up secound"><i class="fa fa-caret-up" aria-hidden="true"></i>  {{$result['order_percentage']}} %</p>
                 @else
                 <p class="down secound"><i class="fa fa-caret-down" aria-hidden="true"></i>  {{$result['order_percentage']}} %</p>
                 @endif
               </div>
               <div class="right-numbers">
                 <span>All Time</span>
                 <p class="report-time">{{$result['all_orders']}}</p>
               </div>
             </div>
           </div>
         </div>
         <div class="col-lg-3">
           <div class="repot-box">
             <h5>Pending Orders</h5>
             {{ ucwords(str_replace('_', ' ', $result['time_duration'])) }}  </span>
             <div class="report-numbers">
              <div class="left-numbers">
                <p class="first">{{ $result['get_pending_orders']}}</p>
                @if($result['pending_order_percentage_status'])
                <p class="up secound"><i class="fa fa-caret-up" aria-hidden="true"></i>  {{$result['pending_order_percentage']}} %</p>
                @else
                <p class="down secound"><i class="fa fa-caret-down" aria-hidden="true"></i>  {{$result['pending_order_percentage']}} %</p>
                @endif
              </div>
              <div class="right-numbers">
                <span>All Time</span>
                <p class="report-time">{{$result['all_pending_orders']}}</p>
              </div>
            </div>
           </div>
         </div>
         <div class="col-lg-3">
           <div class="repot-box">
             <h5>Total Delivery</h5>
             {{ ucwords(str_replace('_', ' ', $result['time_duration'])) }}  </span>
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
         <div class="col-lg-3">
           <div class="repot-box">
            <div class="d-flex justify-content-between">
                <h5>Total Tip</h5>
                @if ($result['time_duration'] == 'today' || $result['time_duration'] == 'yesterday')
                    <a class="btn btn-default btn-lg" data-toggle="modal" data-target="#exampleModal">
                        <i class="fa fa-clock-o" aria-hidden="true"></i>
                    </a>
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        {{ Form::open(['method' => 'POST', 'id' => 'customTimePicker', 'route' => 'report']) }}
                        <div class="modal-dialog modal-sm" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Select Time</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group row">
                                        <label for="from-time" class="col-sm-2 col-form-label">From:</label>
                                        <div class="col-sm-10">
                                            <input type="time" name="from_time" class="form-control" id="from-time">
                                        </div>
                                    </div>
                                    <input type="hidden" name="duration" value="{{$result['time_duration']}}">
                                    <div class="form-group row">
                                        <label for="from-time" class="col-sm-2 col-form-label">To:</label>
                                        <div class="col-sm-10">
                                            <input type="time" name="to_time" class="form-control" id="to-time">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Get Tip Amount</button>
                                </div>
                            </div>
                            {{ Form::close() }}
                        </div>
                    </div>
                @endif
            </div>
            {{ ucwords(str_replace('_', ' ', $result['time_duration'])) }}  </span>
            <div class="report-numbers">
            <div class="left-numbers">
                 <p class="first total_tip">{{ $result['total_tip']}}</p>
            </div>
            <div class="right-numbers">
                <span>All Time</span>
                <p class="report-time"> {{ $result['all_tip']}}</p>
            </div>
            </div>
           </div>
         </div>
       </div>
       <div class="row orders-report-graph">
         <div class="col-lg-7">
           <div class="repot-box">
             <h5>Sales (USD)</h5>
             {{ ucwords(str_replace('_', ' ', $result['time_duration'])) }}  </span>
             <div class="report-numbers">
               <div class="left-numbers">
                 <p class="first">{{ $result['sales_total']}}</p>
                 @if($result['sales_percentage_status'])
                <p class="up secound"><i class="fa fa-caret-up" aria-hidden="true"></i>  {{$result['sales_percentage']}} %</p>
                @else
                <p class="down secound"><i class="fa fa-caret-down" aria-hidden="true"></i>  {{$result['sales_percentage']}} %</p>
                @endif
               </div>
               <div class="right-numbers">
                  <div class="avg-value">
                    <span>Avg.Value</span>
                    <p class="report-time">{{ $result['average_values']}}</p>
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

    $('#from-time').on('change',function () {
        var from_time = this.value;
        $('#to-time').attr('min',from_time);
        $('#to-time').attr('value',from_time);
    });

    $("#customTimePicker").submit(function(e) {

        e.preventDefault(); // avoid to execute the actual submit of the form.

        var form = $(this);

        $.ajax({
            type: "POST",
            url: "{{ route('report.custom_tips') }}",
            data: form.serialize(), // serializes the form's elements.
            success: function(data)
            {
                $('.total_tip').html(data.total_tip);
                // form[0].reset();
                $('#exampleModal').modal('hide');
            }
        });

    });


    $(document).on('change', '.duration_change', function() {

        var days = $(this).val();

        if (days == 'custom') {
            $('#customDateModal').modal('toggle');
        } else if(days){
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


