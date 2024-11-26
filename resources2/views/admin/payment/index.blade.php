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
                                <button class="btn btn-default btn-lg title-text dropdown-toggle" type="button" data-toggle="dropdown">{{$filterType}}
                                <span class="caret"></span></button>
                                <ul class="dropdown-menu">
                                    <li><a href="{{route('admin.paymentInfo.index','today')}}">1 Day</a></li>
                                    <li><a href="{{route('admin.paymentInfo.index','currentMonth')}}">1 Month</a></li>
                                    <li><a href="{{route('admin.paymentInfo.index','currentYear')}}">1 Year</a></li>
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
                                                                <h3>$ {{number_format($restaurant->restaurant->orders->sum('grand_total'),2)}}</h3>
                                                            </div>
                                                            <div class="profit">
                                                                <h2>Profit</h2>
                                                                <h3>$ {{number_format($restaurant->restaurant->orders->sum('cart_charge') - $restaurant->restaurant->orders->sum('discount_charge') - $restaurant->restaurant->orders->sum('tax_charge'),2)}}</h3>
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
                                        
                                        @if ($restaurant->restaurant->online_orders_count != 0 && $restaurant->restaurant->OnlineOrders->sum('grand_total') != 0)
                                            @php
                                                $percentage = number_format($restaurant->restaurant->OnlineOrders->sum('grand_total') * $restaurant->restaurant->online_orders_count / 100,2);
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
                                    <div class="stat-wrapper">
                                        <h4 class="no-margin-top margin-bottom-2">Online Sales <span class="rs">$ {{($restaurant->restaurant->OnlineOrders->sum('grand_total')) ? number_format($restaurant->restaurant->OnlineOrders->sum('grand_total'),2) : 0}}</span></h4>
                                        <div class="progress wd-dr-progress">
                                            <div class="progress-bar" role="progressbar" style="width: {{$percentage}}%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                    @php
                                        $onlineProfit = $restaurant->restaurant->OnlineOrders->sum('cart_charge') - $restaurant->restaurant->OnlineOrders->sum('discount_charge') - $restaurant->restaurant->OnlineOrders->sum('tax_charge');
                                        if($restaurant->restaurant->online_orders_count != 0)
                                        {
                                            $profitPercentage = number_format($restaurant->restaurant->online_orders_count * $onlineProfit / 100,2);
                                        }
                                        else 
                                        {
                                            $profitPercentage = 0;
                                        }
                                    @endphp
                                    <div class="stat-wrapper">
                                        <h4 class="no-margin-top margin-bottom-2">Online Profit <span class="rs">$ {{($onlineProfit == 0) ? 0 : number_format($onlineProfit,2)}}</span></h4>
                                        <div class="progress wd-dr-progress">
                                            <div class="progress-bar" role="progressbar" style="width: {{$profitPercentage}}%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4  zoomIn animated chartPercentage" style="animation-delay: 0.12s;" data-percentage="{{$percentage}}" data-restaurantid="{{$restaurant->restaurant->restaurant_id}}">
                                <div class="chart" id="chartContainer-{{$restaurant->restaurant->restaurant_id}}">
                                    <figure class="chart__figure">
                                        <canvas class="chart__canvas" id="chartCanvas-{{$restaurant->restaurant->restaurant_id}}" width="160" height="160" aria-label="Example doughnut chart showing data as a percentage" role="img"></canvas>
                                    </figure>
                                </div>
                                <div class="">
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" type="text/javascript"></script>
    <script src="{{asset('assets/admin/js/payment/index.js')}}"></script>
@endsection
