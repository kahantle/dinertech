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
                                    <li class="filter" data-filter="Day"><a href="#Day">Day</a></li>
                                    <li class="filter" data-filter="Month"><a href="#Month">1 Month</a></li>
                                    <li class="filter" data-filter="Year"><a href="#Year">1 Year</a></li>
                                </ul>
                            </div> 
                        </div>
                        <!--<button type="button" class="btn btn-default btn-lg">ADD USERS +</button>-->
                        <div class="clearfix"></div>
                    </div>
                </section>
                
                <section class="page-content user-page-content">
                    <input type="hidden" value="{{$restaurantId}}" id="restaurantId">
                    <div class="row zmd-hierarchical-display in paymentinfo-row" data-animation="hierarchical-display">
                        <div class="col-sm-12 zoomIn animated" style="animation-delay: 0.12s;">
                            <h1 class="daily_report" >Daily Sales Report</h1>
                            <canvas id="mychart" width="1099" height="300"></canvas>
                        </div>
                    </div>
                    <div class="row zmd-hierarchical-display in paymentinfo-row" data-animation="hierarchical-display">
                        <div class="col-sm-12 zoomIn animated" style="animation-delay: 0.12s;">
                            <h1 class="daily_report" >Daily Profit Report</h1>
                            <canvas id="profitChart" width="1099" height="300"></canvas>
                        </div>
                    </div>      
                </section>
                <!-- /#page-content -->
            </div>
        </div>
    </section>
    <!-- /#right-content-wrapper -->
@endsection

@section('script')
    <script src="{{asset('assets/admin/js/chart/2.5.0/Chart.min.js')}}"></script>
    <script src="{{asset('assets/admin/js/payment/report.js')}}"></script>
@endsection