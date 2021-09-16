@extends('admin.layouts.app')

@section('content')
    <section id="right-content-wrapper" class="ps-container ps-active-y" data-ps-id="c878bcb0-cdfa-ab28-2fce-7147f311d569">
        <div class="right-content-outter">
            <div class="right-content-inner" style="opacity: 1;">
                <section class="page-header alternative-header">
                    <div class="page-header_title user-page-header_title">
                        <h1>
                            <span data-i18n="dashboard1.dashboard">Payment Info</span>
                            <span class="page-header_subtitle" data-i18n="dashboard1.welcomeMsg" data-i18n-options="{&quot;username&quot;: &quot;John Doe&quot;}">Welcome back {{Auth::guard('admin')->user()->full_name}}</span>
                        </h1>
                        <div class="del-ref-btn-grp">
                            <div class="dropdown">
                                <button class="btn btn-default btn-lg title-text dropdown-toggle" type="button" data-toggle="dropdown">1 Month
                                <span class="caret"></span></button>
                                <ul class="dropdown-menu">
                                    <li><a href="#">1 Day</a></li>
                                    <li><a href="#">1 Month</a></li>
                                    <li><a href="#">1 Year</a></li>
                                </ul>
                            </div> 
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </section>

                 <section class="page-content user-page-content">
                    @foreach ($restaurants as $restaurant)
                        <div class="row zmd-hierarchical-display in paymentinfo-row" data-animation="hierarchical-display">
                            <div class="col-sm-4  zoomIn animated right-border" style="animation-delay: 0.12s;">
                                <div class="panel panel-default panel-user panel-res">
                                    <div class="panel-body no-padding">
                                        <a href="{{route('admin.paymentInfo.report',$restaurant->restaurant->restaurant_id)}}">
                                            <img src="{{asset('assets/admin/img/sub res-2.png')}}" class="sub-inner-blog-first">
                                            <div class="media media-first" style="width: 100%;">
                                                <div class="media-body">
                                                    <div class="res-bottom-info">
                                                        <div class="namelogo">
                                                            <img class="media-object user-img" src="{{$restaurant->getProfileImagePathAttribute()}}" alt="">
                                                            <h3 class="media-heading res-heading">{{$restaurant->restaurant->restaurant_name}}</h3>
                                                            <div class="clearfix"></div>
                                                        </div>
                                                        <div class="person">
                                                            <div class="sales">
                                                                <h2>Sales</h2>
                                                                <h3>$ 123.00</h3>
                                                            </div>
                                                            <div class="profit">
                                                                <h2>Profit</h2>
                                                                <h3>$ 123.00</h3>
                                                            </div>
                                                            <div class="clearfix"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4  zoomIn animated right-border" style="animation-delay: 0.12s;">
                                <div class="pbar">
                                    <div class="heading">
                                        <h3>
                                            Online Payment
                                        </h3>
                                        @if ($restaurant->restaurant->orders_count != 0 && $restaurant->restaurant->totalOnlinePayments != 0)
                                            @php
                                                $percentage = number_format($restaurant->restaurant->totalOnlinePayments/$restaurant->restaurant->orders_count * 100,2);
                                            @endphp
                                        @else
                                            @php
                                                $percentage = 0;
                                            @endphp
                                        @endif
                                        
                                        <h2>
                                            {{$percentage}}%
                                        </h2>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" aria-valuenow="{{$percentage}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$percentage}}%;">
                                            <span class="sr-only">60% Complete</span>
                                        </div>
                                    </div>
                                    {{$restaurant->restaurant->totalOnlinePayment}}
                                    <div class="stat-wrapper">
                                        <h4 class="no-margin-top margin-bottom-2">Online Sales <span class="rs">$ {{($restaurant->restaurant->totalOnlineSales) ? number_format($restaurant->restaurant->totalOnlineSales,2) : 0}}</span></h4>
                                        <div class="linear-progress-demo  cc-preloader-primary" data-toggle="linear-progress" data-mode="determinate" data-type="primary" data-value="30" style="width: 100%;" aria-valuenow="30" value="30">
                                            <div class="md-progress-linear" role="progressbar" md-mode="" aria-valuemax="100" aria-valuemin="0" aria-valuenow="88" value="88">
                                                <div class="md-container md-mode-determinate">
                                                    <div class="md-dashed"></div>
                                                    <div class="md-bar md-bar1"></div>
                                                    <div class="md-bar md-bar2" style="transform: translateX(-35%) scale(0.3, 1);"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @php
                                        $onlineProfit = $restaurant->restaurant->totalOnlineCartCharge - $restaurant->restaurant->totalOnlineDiscountCharge;
                                    @endphp
                                    <div class="stat-wrapper">
                                        <h4 class="no-margin-top margin-bottom-2">Online Profit <span class="rs">$ {{($onlineProfit == 0) ? 0 : number_format($onlineProfit,2)}}</span></h4>
                                        <div class="linear-progress-demo  cc-preloader-primary" data-toggle="linear-progress" data-mode="determinate" data-type="primary" data-value="30" style="width: 100%;" aria-valuenow="30" value="30">
                                            <div class="md-progress-linear" role="progressbar" md-mode="" aria-valuemax="100" aria-valuemin="0" aria-valuenow="88" value="88">
                                                <div class="md-container md-mode-determinate">
                                                    <div class="md-dashed"></div>
                                                    <div class="md-bar md-bar1"></div>
                                                    <div class="md-bar md-bar2" style="transform: translateX(-35%) scale(0.3, 1);"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4  zoomIn animated" style="animation-delay: 0.12s;">
                                <div class="chart" id="chartContainer">
                                    <figure class="chart__figure">
                                        <canvas class="chart__canvas" id="chartCanvas" width="160" height="160" aria-label="Example doughnut chart showing data as a percentage" role="img"></canvas>
                                    
                                    </figure>
                                </div>
                                <div class="">
                                    {{-- <div class="micro-chart-1 cc-spc-warning" data-toggle="simple-pie-chart" data-percent="2" data-type="warning" data-size="45" data-line-width="3">
                                        <div class="cc-spc-wrapper" role="pie-chart" aria-valuemin="0" aria-valuemax="100" aria-valuenow="2" data-valuenow="0" data-diameter="45" style="width: 100%; height: 150px">
                                            <div class="cc-spc-chart-percent"><span>2</span>%</div>
                                            <svg class="cc-spc-svg" width="100" height="100">
                                                <circle class="cc-spc-track" cx="38.5" cy="38.5" r="38.5" fill="transparent" stroke="#F2F3F3" stroke-width="10"></circle>
                                                <circle class="cc-spc-bar" cx="38.5" cy="38.5" r="38.5" fill="transparent" stroke="#706bc8" stroke-width="10" stroke-dasharray="122.46000000000001" stroke-dashoffset="122.46000000000001" stroke-linecap="square" style="stroke-dashoffset: 15.9198px; transition-duration: 1000ms;"></circle>
                                            </svg>
                                        </div>
                                    </div> --}}
                                    <div class="bemat-pie-chart" data-toggle="simple-pie-chart" data-percent="37" data-type="primary"></div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    
                    {{-- <div class="row zmd-hierarchical-display in paymentinfo-row" data-animation="hierarchical-display">
                        <div class="col-sm-4 zoomIn animated right-border" style="animation-delay: 0.12s;">
                            <div class="panel panel-default panel-user panel-res">
                                <div class="panel-body no-padding">
                                    <a href="Payment.html">
                                        <img src="img/sub res-2 (1).png" class="sub-inner-blog-first">
                                        <div class="media media-first" style="width: 100%;">
                                            <div class="res-info">
                                                <div class="media-body">
                                                    <div class="res-bottom-info">
                                                        <div class="namelogo">
                                                            <img class="media-object user-img" src="img/1-1.png" alt="">
                                                            <h3 class="media-heading res-heading">Oncical Farm Restaurant</h3>
                                                            <div class="clearfix">
                                                            </div>
                                                        </div>
                                                        <div class="person">
                                                            <div class="sales">
                                                                <h2>Sales</h2>
                                                                <h3>$ 123.00</h3>
                                                            </div>
                                                            <div class="profit">
                                                                <h2>Profit</h2>
                                                                <h3>$ 123.00</h3>
                                                            </div>
                                                            <div class="clearfix"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4 zoomIn animated right-border" style="animation-delay: 0.12s;">
                            <div class="pbar">
                                <div class="heading">
                                    <h3>
                                        Online Payment
                                    </h3>
                                    <h2>
                                        70%
                                    </h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
                                        <span class="sr-only">60% Complete</span>
                                    </div>
                                </div>
                                <div class="stat-wrapper">
                                    <h4 class="no-margin-top margin-bottom-2">Online Sales <span class="rs">$ 120.00</span></h4>
                                    <div class="linear-progress-demo  cc-preloader-primary" data-toggle="linear-progress" data-mode="determinate" data-type="primary" data-value="30" style="width: 100%;" aria-valuenow="30" value="30">
                                        <div class="md-progress-linear" role="progressbar" md-mode="" aria-valuemax="100" aria-valuemin="0" aria-valuenow="88" value="88">
                                            <div class="md-container md-mode-determinate">
                                                <div class="md-dashed"></div>
                                                <div class="md-bar md-bar1"></div>
                                                <div class="md-bar md-bar2" style="transform: translateX(-35%) scale(0.3, 1);"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="stat-wrapper">
                                    <h4 class="no-margin-top margin-bottom-2">Online Profit <span class="rs">$ 100000.00</span></h4>
                                    <div class="linear-progress-demo  cc-preloader-primary" data-toggle="linear-progress" data-mode="determinate" data-type="primary" data-value="30" style="width: 100%;" aria-valuenow="30" value="30">
                                        <div class="md-progress-linear" role="progressbar" md-mode="" aria-valuemax="100" aria-valuemin="0" aria-valuenow="88" value="88">
                                            <div class="md-container md-mode-determinate">
                                                <div class="md-dashed"></div>
                                                <div class="md-bar md-bar1"></div>
                                                <div class="md-bar md-bar2" style="transform: translateX(-35%) scale(0.3, 1);"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4 zoomIn animated" style="animation-delay: 0.12s;">
                            <div class="">
                                <div class="micro-chart-1 cc-spc-warning" data-toggle="simple-pie-chart" data-percent="87" data-type="warning" data-size="45" data-line-width="3">
                                    <div class="cc-spc-wrapper" role="pie-chart" aria-valuemin="0" aria-valuemax="100" aria-valuenow="87" data-valuenow="0" data-diameter="45" style="width: 100%; height: 150px">
                                        <div class="cc-spc-chart-percent"><span>87</span>%</div>
                                        <svg class="cc-spc-svg" width="100" height="100">
                                            <circle class="cc-spc-track" cx="38.5" cy="38.5" r="38.5" fill="transparent" stroke="#F2F3F3" stroke-width="10"></circle>
                                            <circle class="cc-spc-bar" cx="38.5" cy="38.5" r="38.5" fill="transparent" stroke="#706bc8" stroke-width="10" stroke-dasharray="122.46000000000001" stroke-dashoffset="122.46000000000001" stroke-linecap="square" style="stroke-dashoffset: 15.9198px; transition-duration: 1000ms;"></circle>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    
                    {{$restaurants->links('vendor.pagination.custom')}}
                </section> 
                <!-- /#page-content -->
            </div>
        </div>
    </section>
    <!-- /#right-content-wrapper -->
@endsection

@section('script')
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" type="text/javascript"></script>
<script>
    // This demo uses the Chartjs javascript library

    const percent = 84;
    const color = '#706bc8';
    const canvas = 'chartCanvas';
    const container = 'chartContainer';

    const percentValue = percent; // Sets the single percentage value
    const colorGreen = color, // Sets the chart color
    animationTime = '1400'; // Sets speed/duration of the animation

    const chartCanvas = document.getElementById(canvas), // Sets canvas element by ID
    chartContainer1 = document.getElementById(container), // Sets container element ID
    divElement = document.createElement('div'), // Create element to hold and show percentage value in the center on the chart
    domString = '<div class="chart__value"><p>' + percentValue + '%</p></div>'; // String holding markup for above created element

    // Create a new Chart object
    const doughnutChart = new Chart(chartCanvas, {
    type: 'doughnut', // Set the chart to be a doughnut chart type
    data: {
        datasets: [
            {
                data: [percentValue, 100 - percentValue], // Set the value shown in the chart as a percentage (out of 100)
                backgroundColor: [colorGreen], // The background color of the filled chart
                borderWidth: 0 // Width of border around the chart
            }
        ]
    },
    options: {
        cutoutPercentage: 84, // The percentage of the middle cut out of the chart
        responsive: false, // Set the chart to not be responsive
        tooltips: {
            enabled: false // Hide tooltips
        }
    }
    });

    Chart.defaults.global.animation.duration = animationTime; // Set the animation duration

    divElement.innerHTML = domString; // Parse the HTML set in the domString to the innerHTML of the divElement
    chartContainer1.appendChild(divElement.firstChild); // Append the divElement within the chartContainer1 as it's child
</script> --}}
@endsection
