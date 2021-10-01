@extends('admin.layouts.app')

@section('css')
    <style>

    </style>
@endsection

@section('content')
    
        <section id="right-content-wrapper" class="ps-container ps-active-y" data-ps-id="c878bcb0-cdfa-ab28-2fce-7147f311d569">
            <div class="right-content-outter">
                <div class="right-content-inner" style="opacity: 1;">
                    <section class="page-header alternative-header">
                        <div class="wd-dr-page-dropdown">
                            <div class="page-header_title wd-dr-page-title">
                                <h1>
                                    <span data-i18n="dashboard1.dashboard">DASHBOARD</span>
                                    <span class="page-header_subtitle" data-i18n="dashboard1.welcomeMsg" data-i18n-options="{&quot;username&quot;: &quot;John Doe&quot;}">Welcome back {{Auth::guard('admin')->user()->full_name}}</span>
                                </h1>
                                <div class="drop-down w-dirst-drop">
                                    <div class="selected">
                                        <a href="#" class="wd-dr-sec"><span>Month</span><div class="caret"></div></a>
                                    </div>
                                    <div class="options">
                                        <ul style="display: none;">
                                            <li class="filter" data-filter="Month"><a href="#">Month<span class="value"></span></a></li>
                                            <li class="filter" data-filter="Week"><a href="#">Week<span class="value"></span></a></li>
                                            <li class="filter" data-filter="Today"><a href="#">Today<span class="value"></span></a></li>
                                            <li class="filter" data-filter="Year"><a href="#">Year<span class="value"></span></a></li>
                                            <li class="filter" data-filter="Custom"><a href="#"  class="title-link"> Custom<span class="value"></span></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="wd-dr-dropdown">
                                <!-- <input type="text" name="datefilter" value="" class="input-time">          -->
                                
                                <!--Grid row-->
                                {{-- <div class="wf-dr-drop-inner wp-drop-menu"> --}}
                                {{-- <div class="wg-inner-blog hide">
                                    <div class="row">
                                        <div class="col-sm-6 d-dta-p-blog">
                                            <label>From</label>
                                            <div class="input-group date">
                                                <input type="date" class="form-control date" id="from-date">
                                            </div>
                                        </div>
                                        <div class="col-sm-6 d-dta-p-blog">
                                            <label>To</label>
                                            <div class="input-group date">
                                                <input type="date" class="form-control date" id="to-date">
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                                {{-- </div> --}}
                                <div class="wg-inner-blog hide">
                                    <div class="row">
                                        <!-- <div class="wf-dr-drop-inner wp-drop-menu"> -->
                                        <div class="col-sm-6 d-dta-p-blog">
                                            <label>From</label>
                                            <div class="input-group date">
                                                <input type="date" class="form-control date" data-date="" data-date-format="DD MMMM YYYY" id="from-date"></span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 d-dta-p-blog">
                                                <label>To</label>
                                                <div class="input-group date">
                                                    <input type="date" class="form-control date" data-date="" data-date-format="DD MMMM YYYY" id="to-date"></span>
                                                </div>
                                        </div>
                                        <!-- </div> -->
                                    </div>
                                </div>
                                <div class="drop-down">
                                    <div class="selected">
                                        <a href="#" class="wd-dr-sec"><span>Month</span><div class="caret"></div></a>
                                    </div>
                                    <div class="options">
                                        <ul style="display: none;">
                                            <li class="filter" data-filter="Month"><a href="#">Month<span class="value"></span></a></li>
                                            <li class="filter" data-filter="Year"><a href="#">Year<span class="value"></span></a></li>
                                            <li class="filter" data-filter="Week"><a href="#">Week<span class="value"></span></a></li>
                                            <li class="filter" data-filter="Today"><a href="#">Today<span class="value"></span></a></li>
                                            <li class="filter" data-filter="Custom"><a href="#"  class="title-link"> Custom<span class="value"></span></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section class="page-content">
                        <div class="row zmd-hierarchical-display in" data-animation="hierarchical-display">
                            <div class="col-lg-3 col-sm-6 zoomIn animated" style="animation-delay: 0.12s;">
                                <div class="panel panel-default">
                                    <div class="panel-body no-padding">
                                        <div class="mini-card mini-card-primary">
                                            <div class="mini-card-left">
                                                <span>Users</span>
                                                <h2 id="user_count">{{$users}}</h2>
                                                <span class="filter-type">{{$filter}}</span>
                                            </div>
                                            <div class="mini-card-right">
                                                <div class="bemat-mini-chart bemat-mini-chart-primary">
                                                    <svg class="peity" height="28" width="64"><rect fill="#4D89F9" x="0.64" y="15.555555555555557" width="5.12" height="12.444444444444443"></rect><rect fill="#4D89F9" x="7.040000000000001" y="18.666666666666668" width="5.119999999999999" height="9.333333333333332"></rect><rect fill="#4D89F9" x="13.440000000000001" y="12.444444444444443" width="5.119999999999997" height="15.555555555555557"></rect><rect fill="#4D89F9" x="19.84" y="21.77777777777778" width="5.120000000000001" height="6.222222222222221"></rect><rect fill="#4D89F9" x="26.24" y="12.444444444444443" width="5.1200000000000045" height="15.555555555555557"></rect><rect fill="#4D89F9" x="32.64" y="18.666666666666668" width="5.1200000000000045" height="9.333333333333332"></rect><rect fill="#4D89F9" x="39.04" y="3.1111111111111143" width="5.1200000000000045" height="24.888888888888886"></rect><rect fill="#4D89F9" x="45.44" y="18.666666666666668" width="5.1200000000000045" height="9.333333333333332"></rect><rect fill="#4D89F9" x="51.839999999999996" y="15.555555555555557" width="5.1200000000000045" height="12.444444444444443"></rect><rect fill="#4D89F9" x="58.239999999999995" y="0" width="5.1200000000000045" height="28"></rect></svg>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-3 col-sm-6 zoomIn animated" style="animation-delay: 0.25s;">
                                <div class="panel panel-default">
                                    <div class="panel-body no-padding">
                                        <div class="mini-card mini-card-success">
                                            <div class="mini-card-left">
                                                <span>Restaurants</span>
                                                <h2 id="restaurant_count">{{$restaurants}}</h2>
                                                <span class="filter-type">{{$filter}}</span>
                                            </div>
                                            <div class="mini-card-right">
                                                <div class="bemat-mini-chart bemat-mini-chart-success">
                                                    <span class="peity-bar" style="display: none;">4,3,5,2,5,3,8,3,4,9</span><svg class="peity" height="28" width="64"><rect fill="#4D89F9" x="0.64" y="15.555555555555557" width="5.12" height="12.444444444444443"></rect><rect fill="#4D89F9" x="7.040000000000001" y="18.666666666666668" width="5.119999999999999" height="9.333333333333332"></rect><rect fill="#4D89F9" x="13.440000000000001" y="12.444444444444443" width="5.119999999999997" height="15.555555555555557"></rect><rect fill="#4D89F9" x="19.84" y="21.77777777777778" width="5.120000000000001" height="6.222222222222221"></rect><rect fill="#4D89F9" x="26.24" y="12.444444444444443" width="5.1200000000000045" height="15.555555555555557"></rect><rect fill="#4D89F9" x="32.64" y="18.666666666666668" width="5.1200000000000045" height="9.333333333333332"></rect><rect fill="#4D89F9" x="39.04" y="3.1111111111111143" width="5.1200000000000045" height="24.888888888888886"></rect><rect fill="#4D89F9" x="45.44" y="18.666666666666668" width="5.1200000000000045" height="9.333333333333332"></rect><rect fill="#4D89F9" x="51.839999999999996" y="15.555555555555557" width="5.1200000000000045" height="12.444444444444443"></rect><rect fill="#4D89F9" x="58.239999999999995" y="0" width="5.1200000000000045" height="28"></rect></svg>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-3 col-sm-6 zoomIn animated" style="animation-delay: 0.39s;">
                                <div class="panel panel-default">
                                    <div class="panel-body no-padding">
                                        <div class="mini-card mini-card-info">
                                            <div class="mini-card-left">
                                                <span>Total Orders</span>
                                                <h2 id="orders_count">{{$orders}}</h2>
                                                <span class="filter-type">{{$filter}}</span>
                                            </div>
                                            <div class="mini-card-right">
                                                <div class="bemat-mini-chart bemat-mini-chart-info">
                                                    <svg class="peity" height="28" width="64"><rect fill="#4D89F9" x="0.64" y="15.555555555555557" width="5.12" height="12.444444444444443"></rect><rect fill="#4D89F9" x="7.040000000000001" y="18.666666666666668" width="5.119999999999999" height="9.333333333333332"></rect><rect fill="#4D89F9" x="13.440000000000001" y="12.444444444444443" width="5.119999999999997" height="15.555555555555557"></rect><rect fill="#4D89F9" x="19.84" y="21.77777777777778" width="5.120000000000001" height="6.222222222222221"></rect><rect fill="#4D89F9" x="26.24" y="12.444444444444443" width="5.1200000000000045" height="15.555555555555557"></rect><rect fill="#4D89F9" x="32.64" y="18.666666666666668" width="5.1200000000000045" height="9.333333333333332"></rect><rect fill="#4D89F9" x="39.04" y="3.1111111111111143" width="5.1200000000000045" height="24.888888888888886"></rect><rect fill="#4D89F9" x="45.44" y="18.666666666666668" width="5.1200000000000045" height="9.333333333333332"></rect><rect fill="#4D89F9" x="51.839999999999996" y="15.555555555555557" width="5.1200000000000045" height="12.444444444444443"></rect><rect fill="#4D89F9" x="58.239999999999995" y="0" width="5.1200000000000045" height="28"></rect></svg>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-3 col-sm-6 zoomIn animated" style="animation-delay: 0.53s;">
                                <div class="panel panel-default">
                                    <div class="panel-body no-padding">
                                        <div class="mini-card mini-card-danger">
                                            <div class="mini-card-left">
                                                <span>Total Delivery</span>
                                                <h2>0</h2>
                                                <span>{{$filter}}</span>
                                            </div>
                                            <div class="mini-card-right">
                                                <div class="bemat-mini-chart bemat-mini-chart-danger">
                                                    <span class="peity-bar" style="display: none;">4,3,5,6,5,4,6,3,2,6</span><svg class="peity" height="28" width="64"><rect fill="#4D89F9" x="0.64" y="9.333333333333336" width="5.12" height="18.666666666666664"></rect><rect fill="#4D89F9" x="7.040000000000001" y="14" width="5.119999999999999" height="14"></rect><rect fill="#4D89F9" x="13.440000000000001" y="4.666666666666664" width="5.119999999999997" height="23.333333333333336"></rect><rect fill="#4D89F9" x="19.84" y="0" width="5.120000000000001" height="28"></rect><rect fill="#4D89F9" x="26.24" y="4.666666666666664" width="5.1200000000000045" height="23.333333333333336"></rect><rect fill="#4D89F9" x="32.64" y="9.333333333333336" width="5.1200000000000045" height="18.666666666666664"></rect><rect fill="#4D89F9" x="39.04" y="0" width="5.1200000000000045" height="28"></rect><rect fill="#4D89F9" x="45.44" y="14" width="5.1200000000000045" height="14"></rect><rect fill="#4D89F9" x="51.839999999999996" y="18.666666666666668" width="5.1200000000000045" height="9.333333333333332"></rect><rect fill="#4D89F9" x="58.239999999999995" y="0" width="5.1200000000000045" height="28"></rect></svg>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="panel panel-default" data-animation="animate" data-animation-in="zoomIn">
                                    <div class="panel-heading">
                                        <header>
                                            Live Statistics
                                            <!--<span class="label label-primary pull-right">1024 users online</span>-->
                                        </header>

                                        {{-- <div class="panel-heading-tools">
                                            <div class="btn-group">
                                                <a class="btn btn-icon-toggle panel-tools-menu dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                <ul class="dropdown-menu dropdown-menu-right">
                                                    <li><a href="#">Refresh</a></li>
                                                </ul>
                                            </div>
                                        </div> --}}
                                    </div>
                                    <div class="panel-body">
                                        <div class="statistics">
                                            <div class="row wd-stics-blog">
                                                <div class="col-lg-4">
                                                    <div class="wd-sal-first">
                                                        <h5 class="totalSales">$ {{$totalSales}}</h5>
                                                        <span class="wd-dr-sales">Total Sales</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-8">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div id="chart">
                                                                <!--<svg class="height-5 nv-chart-60603"><g class="nvd3 nv-wrap nv-cumulativeLine" transform="translate(60,30)"><g><g class="nv-interactive"><g class=" nv-wrap nv-interactiveLineLayer"><g class="nv-interactiveGuideLine"></g></g></g><g class="nv-x nv-axis" style="pointer-events: none;" transform="translate(0,200)"><g class="nvd3 nv-wrap nv-axis"><g><path class="domain" d="M0,0V0H546V0"></path><text class="nv-axislabel" text-anchor="middle" y="36" x="273"></text></g><g class="nv-axisMaxMin" transform="translate(0,0)"><text dy=".71em" y="7" transform="rotate(0 0,0)" style="text-anchor: middle;">12/16/2015</text></g><g class="nv-axisMaxMin" transform="translate(546,0)"><text dy=".71em" y="7" transform="rotate(0 0,0)" style="text-anchor: middle;">12/17/2015</text></g></g></g><g class="nv-y nv-axis"><g class="nvd3 nv-wrap nv-axis"><g><g class="tick major" style="opacity: 1;" transform="translate(0,200)"><line x2="546" y2="0"></line><text x="-3" dy=".32em" style="text-anchor: end;" opacity="0" y="0">0.0%</text></g><g class="tick major" style="opacity: 1;" transform="translate(0,154.02298850574712)"><line x2="546" y2="0"></line><text x="-3" dy=".32em" style="text-anchor: end;" opacity="1" y="0">100.0%</text></g><g class="tick major" style="opacity: 1;" transform="translate(0,108.04597701149426)"><line x2="546" y2="0"></line><text x="-3" dy=".32em" style="text-anchor: end;" opacity="1" y="0">200.0%</text></g><g class="tick major" style="opacity: 1;" transform="translate(0,62.068965517241395)"><line x2="546" y2="0"></line><text x="-3" dy=".32em" style="text-anchor: end;" opacity="1" y="0">300.0%</text></g><g class="tick major" style="opacity: 1;" transform="translate(0,16.091954022988517)"><line x2="546" y2="0"></line><text x="-3" dy=".32em" style="text-anchor: end;" opacity="1" y="0">400.0%</text></g><path class="domain" d="M0,0H0V200H0"></path><text class="nv-axislabel" style="text-anchor: middle;" transform="rotate(-90)" y="-63" x="-100"></text></g><g class="nv-axisMaxMin" transform="translate(0,200)"><text style="opacity: 1;" dy=".32em" y="0" x="-3" text-anchor="end">0.0%</text></g><g class="nv-axisMaxMin" transform="translate(0,0)"><text style="opacity: 1;" dy=".32em" y="0" x="-3" text-anchor="end">435.0%</text></g></g></g><g class="nv-background"><rect width="546" height="200"></rect></g><g class="nv-linesWrap" style="pointer-events: none;"><g class="nvd3 nv-wrap nv-line" transform="translate(0,0)"><defs><clipPath id="nv-edge-clip-60603"><rect width="546" height="200"></rect></clipPath></defs><g clip-path=""><g class="nv-groups"><g style="stroke-opacity: 1; fill-opacity: 0.5; fill: rgb(31, 119, 180); stroke: rgb(31, 119, 180);" class="nv-group nv-series-0"><path class="nv-line" d="M0,200L24.81818181818182,184.367816091954L49.63636363636364,160.15325670498083L74.45454545454545,168.58237547892722L99.27272727272728,163.2183908045977L124.0909090909091,161.30268199233717L148.9090909090909,153.25670498084293L173.72727272727272,146.360153256705L198.54545454545456,100.38314176245213L248.1818181818182,169.34865900383141L273,122.98850574712644L297.8181818181818,143.29501915708812L322.6363636363636,156.32183908045977L347.45454545454544,137.16475095785444L347.45454545454544,161.455938697318L372.2727272727273,156.32183908045977L397.0909090909091,157.85440613026822L421.9090909090909,178.544061302682L446.72727272727275,123.37164750957855L471.54545454545456,157.54789272030652L496.3636363636364,157.85440613026822L521.1818181818182,143.29501915708812L546,137.93103448275863"></path></g><g style="stroke-opacity: 1; fill-opacity: 0.5; fill: rgb(255, 127, 14); stroke: rgb(255, 127, 14);" class="nv-group nv-series-1"><path class="nv-line" d="M0,200L24.81818181818182,168.73563218390805L49.63636363636364,104.98084291187742L74.45454545454545,121.83908045977013L99.27272727272728,94.25287356321839L124.0909090909091,61.30268199233717L148.9090909090909,91.18773946360155L173.72727272727272,74.32950191570885L198.54545454545456,34.48275862068968L248.1818181818182,0.766283524904253L273,0L297.8181818181818,40.61302681992339L322.6363636363636,66.66666666666669L347.45454545454544,28.35249042145597L347.45454545454544,76.93486590038316L372.2727272727273,66.66666666666669L397.0909090909091,69.73180076628353L421.9090909090909,95.78544061302681L446.72727272727275,76.3218390804598L471.54545454545456,53.7931034482759L496.3636363636364,91.95402298850577L521.1818181818182,55.938697318007684L546,48.27586206896552"></path></g></g><g class="nv-scatterWrap" clip-path=""><g class="nvd3 nv-wrap nv-scatter nv-chart-60603" transform="translate(0,0)"><defs><clipPath id="nv-edge-clip-60603"><rect width="546" height="200"></rect></clipPath></defs><g clip-path=""><g class="nv-groups"><g style="stroke-opacity: 1; fill-opacity: 0.5; stroke: rgb(31, 119, 180); fill: rgb(31, 119, 180);" class="nv-group nv-series-0"><circle cx="0" cy="200" r="2.256758334191025" class="nv-point nv-point-0"></circle><circle cx="24.81818181818182" cy="184.367816091954" r="2.256758334191025" class="nv-point nv-point-1"></circle><circle cx="49.63636363636364" cy="160.15325670498083" r="2.256758334191025" class="nv-point nv-point-2"></circle><circle cx="74.45454545454545" cy="168.58237547892722" r="2.256758334191025" class="nv-point nv-point-3"></circle><circle cx="99.27272727272728" cy="163.2183908045977" r="2.256758334191025" class="nv-point nv-point-4"></circle><circle cx="124.0909090909091" cy="161.30268199233717" r="2.256758334191025" class="nv-point nv-point-5"></circle><circle cx="148.9090909090909" cy="153.25670498084293" r="2.256758334191025" class="nv-point nv-point-6"></circle><circle cx="173.72727272727272" cy="146.360153256705" r="2.256758334191025" class="nv-point nv-point-7"></circle><circle cx="198.54545454545456" cy="100.38314176245213" r="2.256758334191025" class="nv-point nv-point-8"></circle><circle cx="248.1818181818182" cy="169.34865900383141" r="2.256758334191025" class="nv-point nv-point-9"></circle><circle cx="273" cy="122.98850574712644" r="2.256758334191025" class="nv-point nv-point-10"></circle><circle cx="297.8181818181818" cy="143.29501915708812" r="2.256758334191025" class="nv-point nv-point-11"></circle><circle cx="322.6363636363636" cy="156.32183908045977" r="2.256758334191025" class="nv-point nv-point-12"></circle><circle cx="347.45454545454544" cy="137.16475095785444" r="2.256758334191025" class="nv-point nv-point-13"></circle><circle cx="347.45454545454544" cy="161.455938697318" r="2.256758334191025" class="nv-point nv-point-14"></circle><circle cx="372.2727272727273" cy="156.32183908045977" r="2.256758334191025" class="nv-point nv-point-15"></circle><circle cx="397.0909090909091" cy="157.85440613026822" r="2.256758334191025" class="nv-point nv-point-16"></circle><circle cx="421.9090909090909" cy="178.544061302682" r="2.256758334191025" class="nv-point nv-point-17"></circle><circle cx="446.72727272727275" cy="123.37164750957855" r="2.256758334191025" class="nv-point nv-point-18"></circle><circle cx="471.54545454545456" cy="157.54789272030652" r="2.256758334191025" class="nv-point nv-point-19"></circle><circle cx="496.3636363636364" cy="157.85440613026822" r="2.256758334191025" class="nv-point nv-point-20"></circle><circle cx="521.1818181818182" cy="143.29501915708812" r="2.256758334191025" class="nv-point nv-point-21"></circle><circle cx="546" cy="137.93103448275863" r="2.256758334191025" class="nv-point nv-point-22"></circle></g><g style="stroke-opacity: 1; fill-opacity: 0.5; stroke: rgb(255, 127, 14); fill: rgb(255, 127, 14);" class="nv-group nv-series-1"><circle cx="0" cy="200" r="2.256758334191025" class="nv-point nv-point-0"></circle><circle cx="24.81818181818182" cy="168.73563218390805" r="2.256758334191025" class="nv-point nv-point-1"></circle><circle cx="49.63636363636364" cy="104.98084291187742" r="2.256758334191025" class="nv-point nv-point-2"></circle><circle cx="74.45454545454545" cy="121.83908045977013" r="2.256758334191025" class="nv-point nv-point-3"></circle><circle cx="99.27272727272728" cy="94.25287356321839" r="2.256758334191025" class="nv-point nv-point-4"></circle><circle cx="124.0909090909091" cy="61.30268199233717" r="2.256758334191025" class="nv-point nv-point-5"></circle><circle cx="148.9090909090909" cy="91.18773946360155" r="2.256758334191025" class="nv-point nv-point-6"></circle><circle cx="173.72727272727272" cy="74.32950191570885" r="2.256758334191025" class="nv-point nv-point-7"></circle><circle cx="198.54545454545456" cy="34.48275862068968" r="2.256758334191025" class="nv-point nv-point-8"></circle><circle cx="248.1818181818182" cy="0.766283524904253" r="2.256758334191025" class="nv-point nv-point-9"></circle><circle cx="273" cy="0" r="2.256758334191025" class="nv-point nv-point-10"></circle><circle cx="297.8181818181818" cy="40.61302681992339" r="2.256758334191025" class="nv-point nv-point-11"></circle><circle cx="322.6363636363636" cy="66.66666666666669" r="2.256758334191025" class="nv-point nv-point-12"></circle><circle cx="347.45454545454544" cy="28.35249042145597" r="2.256758334191025" class="nv-point nv-point-13"></circle><circle cx="347.45454545454544" cy="76.93486590038316" r="2.256758334191025" class="nv-point nv-point-14"></circle><circle cx="372.2727272727273" cy="66.66666666666669" r="2.256758334191025" class="nv-point nv-point-15"></circle><circle cx="397.0909090909091" cy="69.73180076628353" r="2.256758334191025" class="nv-point nv-point-16"></circle><circle cx="421.9090909090909" cy="95.78544061302681" r="2.256758334191025" class="nv-point nv-point-17"></circle><circle cx="446.72727272727275" cy="76.3218390804598" r="2.256758334191025" class="nv-point nv-point-18"></circle><circle cx="471.54545454545456" cy="53.7931034482759" r="2.256758334191025" class="nv-point nv-point-19"></circle><circle cx="496.3636363636364" cy="91.95402298850577" r="2.256758334191025" class="nv-point nv-point-20"></circle><circle cx="521.1818181818182" cy="55.938697318007684" r="2.256758334191025" class="nv-point nv-point-21"></circle><circle cx="546" cy="48.27586206896552" r="2.256758334191025" class="nv-point nv-point-22"></circle></g></g><g class="nv-point-paths"></g></g></g></g></g></g><rect class="nv-indexLine" width="3" x="-2" fill="red" fill-opacity="0.5" style="pointer-events: all;" transform="translate(0,0)" height="200"></rect></g><g class="nv-avgLinesWrap" style="pointer-events: none;"></g><g class="nv-legendWrap" transform="translate(0,-30)"><g class="nvd3 nv-legend" transform="translate(0,5)"><g transform="translate(403.5999984741211,5)"><g class="nv-series" transform="translate(0,5)"><circle style="stroke-width: 2px; fill: rgb(31, 119, 180); stroke: rgb(31, 119, 180);" class="nv-legend-symbol" r="5"></circle><text text-anchor="start" class="nv-legend-text" dy=".32em" dx="8">Today</text></g><g class="nv-series" transform="translate(60.5,5)"><circle style="stroke-width: 2px; fill: rgb(255, 127, 14); stroke: rgb(255, 127, 14);" class="nv-legend-symbol" r="5"></circle><text text-anchor="start" class="nv-legend-text" dy=".32em" dx="8">Yesterday</text></g></g></g></g><g class="nv-controlsWrap" transform="translate(0,-30)"><g class="nvd3 nv-legend" transform="translate(0,5)"><g transform="translate(26.5,5)"><g class="nv-series" transform="translate(0,5)"><circle style="stroke-width: 2px; fill: rgb(68, 68, 68); stroke: rgb(68, 68, 68);" class="nv-legend-symbol" r="5"></circle><text text-anchor="start" class="nv-legend-text" dy=".32em" dx="8">Re-scale y-axis</text></g></g></g></g></g></g></svg>-->
                                                                {{-- <svg class="chart-style"></svg> --}}
                                                                <canvas id="mychart" width="1099" height="300"></canvas>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4 col-sm-6">
                                <div class="panel panel-default" data-animation="animate" data-animation-in="zoomIn">
                                    <div class="panel-heading">
                                        <header>Live Sales
                                            <span class="panel-date filter-type">{{$filter}}</span>
                                        </header>
                                        <div class="sales-amount"> 
                                            @if ($previousSales < $liveSales)
                                                <img src="{{asset('assets/admin/img/up-arrow.png')}}" class="down-arrow up-arrow">
                                                <span class="price livesales-price profit">
                                                    $ {{number_format($liveSales,2)}}
                                                </span>
                                            @else
                                                <img src="{{asset('assets/admin/img/down-arrow.png')}}" class="down-arrow">
                                                <span class="price livesales-price loss">
                                                    $ {{number_format($liveSales,2)}}
                                                </span>    
                                            @endif
                                        </div>
                                    </div>                                        
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6">
                                <div class="panel panel-default" data-animation="animate" data-animation-in="zoomIn">
                                    <div class="panel-heading">
                                        <header>Active Orders
                                            <span class="panel-date filter-type">{{$filter}}</span>
                                        </header>

                                        <span class="active_order">
                                            {{$activeOrders}}
                                        </span>

                                    </div>
                                    
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-6">
                                <div class="panel panel-default" data-animation="animate" data-animation-in="zoomIn">
                                    <div class="panel-heading">
                                        <header>Declined Orders
                                            <span class="panel-date filter-type">{{$filter}}</span>
                                        </header>
                                        <span class="dec_order">
                                            {{$declinedOrders}}
                                        </span>
                                    </div>
                                </div>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
    <script src="{{asset('assets/admin/js/dashboard/dashboard.js')}}"></script>
    <script>
        var data = {
            type: "line",
            data: {
                labels: @json($chart['days']),
                datasets: [{
                    label: 'Total Sales',
                    data: @json($chart['sales']),
                    fill: false,
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1
                }]
            },
        };

        var myChart = document.getElementById('mychart').getContext('2d');
        window.bar = new Chart(myChart, data);
    </script>
    <script>
        // // Wrapping in nv.addGraph allows for '0 timeout render', stores rendered charts in nv.graphs,
        // // and may do more in the future... it's NOT required
        // nv.addGraph(function() {
        //     var chart = nv.models.cumulativeLineChart()
        //         .useInteractiveGuideline(true)
        //         .x(function(d) {
        //             return d[0]
        //         })
        //         .y(function(d) {
        //             return d[1]
        //         })
        //         .color(d3.scale.category10().range())
        //         .average(function(d) {
        //             return d.mean / 100;
        //         })
        //         .duration(300)
        //         .clipVoronoi(false);
        //         chart.dispatch.on('renderEnd', function() {
        //             console.log('render complete: cumulative line with guide line');
        //         });

        //         chart.xAxis.tickFormat(function(d) {
        //             return d3.time.format('%m/%d/%y')(new Date(d))
        //         });

        //         chart.yAxis.tickFormat(d3.format(',.1%'));
        //         //chart.yDomain([0, 15]);

        //         d3.select('#chart svg')
        //             .datum(cumulativeTestData())
        //             .call(chart);

        //         //TODO: Figure out a good way to do this automatically
        //         nv.utils.windowResize(chart.update);

        //         chart.dispatch.on('stateChange', function(e) {
        //             nv.log('New State:', JSON.stringify(e));
        //         });
        //         chart.state.dispatch.on('change', function(state) {
        //             nv.log('state', JSON.stringify(state));
        //         });

        //         return chart;
        // });

        // function flatTestData() {
        //     return [{
        //         key: "Snakes",
        //         values: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9].map(function(d) {
        //             var currentDate = new Date();
        //             currentDate.setDate(currentDate.getDate() + d);
        //             return [currentDate, 0]
        //         })
        //     }];
        // }

        // function cumulativeTestData() {
        //     return [{
        //         key: "Long",
        //         values: [
        //             [1083297600000, -2.974623048543],
        //             [1085976000000, -1.7740300785979],
        //             [1088568000000, 4.4681318138177],
        //             [1091246400000, 7.0242541001353],
        //             [1093924800000, 7.5709603667586],
        //             [1096516800000, 20.612245065736],
        //             [1099195200000, 21.698065237316],
        //             [1101790800000, 40.501189458018],
        //             [1104469200000, 50.464679413194],
        //             [1107147600000, 48.917421973355],
        //             [1109566800000, 63.750936549160],
        //             [1112245200000, 59.072499126460],
        //             [1114833600000, 43.373158880492],
        //             [1117512000000, 54.490918947556],
        //             [1120104000000, 56.661178852079],
        //             [1122782400000, 73.450103545496],
        //             [1125460800000, 71.714526354907],
        //             [1128052800000, 85.221664349607],
        //             [1130734800000, 77.769261392481],
        //             [1133326800000, 95.966528716500],
        //             [1136005200000, 107.59132116397],
        //             [1138683600000, 127.25740096723],
        //             [1141102800000, 122.13917498830],
        //             [1143781200000, 126.53657279774],
        //             [1146369600000, 132.39300992970],
        //             [1149048000000, 120.11238242904],
        //             [1151640000000, 118.41408917750],
        //             [1154318400000, 107.92918924621],
        //             [1156996800000, 110.28057249569],
        //             [1159588800000, 117.20485334692],
        //             [1162270800000, 141.33556756948],
        //             [1164862800000, 159.59452727893],
        //             [1167541200000, 167.09801853304],
        //             [1170219600000, 185.46849659215],
        //             [1172638800000, 184.82474099990],
        //             [1175313600000, 195.63155213887],
        //             [1177905600000, 207.40597044171],
        //             [1180584000000, 230.55966698196],
        //             [1183176000000, 239.55649035292],
        //             [1185854400000, 241.35915085208],
        //             [1188532800000, 239.89428956243],
        //             [1191124800000, 260.47781917715],
        //             [1193803200000, 276.39457482225],
        //             [1196398800000, 258.66530682672],
        //             [1199077200000, 250.98846121893],
        //             [1201755600000, 226.89902618127],
        //             [1204261200000, 227.29009273807],
        //             [1206936000000, 218.66476654350],
        //             [1209528000000, 232.46605902918],
        //             [1212206400000, 253.25667081117],
        //             [1214798400000, 235.82505363925],
        //             [1217476800000, 229.70112774254],
        //             [1220155200000, 225.18472705952],
        //             [1222747200000, 189.13661746552],
        //             [1225425600000, 149.46533007301],
        //             [1228021200000, 131.00340772114],
        //             [1230699600000, 135.18341728866],
        //             [1233378000000, 109.15296887173],
        //             [1235797200000, 84.614772549760],
        //             [1238472000000, 100.60810015326],
        //             [1241064000000, 141.50134895610],
        //             [1243742400000, 142.50405083675],
        //             [1246334400000, 139.81192372672],
        //             [1249012800000, 177.78205544583],
        //             [1251691200000, 194.73691933074],
        //             [1254283200000, 209.00838460225],
        //             [1256961600000, 198.19855877420],
        //             [1259557200000, 222.37102417812],
        //             [1262235600000, 234.24581081250],
        //             [1264914000000, 228.26087689346],
        //             [1267333200000, 248.81895126250],
        //             [1270008000000, 270.57301075186],
        //             [1272600000000, 292.64604322550],
        //             [1275278400000, 265.94088520518],
        //             [1277870400000, 237.82887467569],
        //             [1280548800000, 265.55973314204],
        //             [1283227200000, 248.30877330928],
        //             [1285819200000, 278.14870066912],
        //             [1288497600000, 292.69260960288],
        //             [1291093200000, 300.84263809599],
        //             [1293771600000, 326.17253914628],
        //             [1296450000000, 337.69335966505],
        //             [1298869200000, 339.73260965121],
        //             [1301544000000, 346.87865120765],
        //             [1304136000000, 347.92991526628],
        //             [1306814400000, 342.04627502669],
        //             [1309406400000, 333.45386231233],
        //             [1312084800000, 323.15034181243],
        //             [1314763200000, 295.66126882331],
        //             [1317355200000, 251.48014579253],
        //             [1320033600000, 295.15424257905],
        //             [1322629200000, 294.54766764397],
        //             [1325307600000, 295.72906119051],
        //             [1327986000000, 325.73351347613],
        //             [1330491600000, 340.16106061186],
        //             [1333166400000, 345.15514071490],
        //             [1335758400000, 337.10259395679],
        //             [1338436800000, 318.68216333837],
        //             [1341028800000, 317.03683945246],
        //             [1343707200000, 318.53549659997],
        //             [1346385600000, 332.85381464104],
        //             [1348977600000, 337.36534373477],
        //             [1351656000000, 350.27872156161],
        //             [1354251600000, 349.45128876100]
        //         ],
        //         mean: 250
        //     }, {
        //         key: "Short",
        //         values: [
        //             [1083297600000, -0.77078283705125],
        //             [1085976000000, -1.8356366650335],
        //             [1088568000000, -5.3121322073127],
        //             [1091246400000, -4.9320975829662],
        //             [1093924800000, -3.9835408823225],
        //             [1096516800000, -6.8694685316805],
        //             [1099195200000, -8.4854877428545],
        //             [1101790800000, -15.933627197384],
        //             [1104469200000, -15.920980069544],
        //             [1107147600000, -12.478685045651],
        //             [1109566800000, -17.297761889305],
        //             [1112245200000, -15.247129891020],
        //             [1114833600000, -11.336459046839],
        //             [1117512000000, -13.298990907415],
        //             [1120104000000, -16.360027000056],
        //             [1122782400000, -18.527929522030],
        //             [1125460800000, -22.176516738685],
        //             [1128052800000, -23.309665368330],
        //             [1130734800000, -21.629973409748],
        //             [1133326800000, -24.186429093486],
        //             [1136005200000, -29.116707312531],
        //             [1138683600000, -37.188037874864],
        //             [1141102800000, -34.689264821198],
        //             [1143781200000, -39.505932105359],
        //             [1146369600000, -45.339572492759],
        //             [1149048000000, -43.849353192764],
        //             [1151640000000, -45.418353922571],
        //             [1154318400000, -44.579281059919],
        //             [1156996800000, -44.027098363370],
        //             [1159588800000, -41.261306759439],
        //             [1162270800000, -47.446018534027],
        //             [1164862800000, -53.413782948909],
        //             [1167541200000, -50.700723647419],
        //             [1170219600000, -56.374090913296],
        //             [1172638800000, -61.754245220322],
        //             [1175313600000, -66.246241587629],
        //             [1177905600000, -75.351650899999],
        //             [1180584000000, -81.699058262032],
        //             [1183176000000, -82.487023368081],
        //             [1185854400000, -86.230055113277],
        //             [1188532800000, -84.746914818507],
        //             [1191124800000, -100.77134971977],
        //             [1193803200000, -109.95435565947],
        //             [1196398800000, -99.605672965057],
        //             [1199077200000, -99.607249394382],
        //             [1201755600000, -94.874614950188],
        //             [1204261200000, -105.35899063105],
        //             [1206936000000, -106.01931193802],
        //             [1209528000000, -110.28883571771],
        //             [1212206400000, -119.60256203030],
        //             [1214798400000, -115.62201315802],
        //             [1217476800000, -106.63824185202],
        //             [1220155200000, -99.848746318951],
        //             [1222747200000, -85.631219602987],
        //             [1225425600000, -63.547909262067],
        //             [1228021200000, -59.753275364457],
        //             [1230699600000, -63.874977883542],
        //             [1233378000000, -56.865697387488],
        //             [1235797200000, -54.285579501988],
        //             [1238472000000, -56.474659581885],
        //             [1241064000000, -63.847137745644],
        //             [1243742400000, -68.754247867325],
        //             [1246334400000, -69.474257009155],
        //             [1249012800000, -75.084828197067],
        //             [1251691200000, -77.101028237237],
        //             [1254283200000, -80.454866854387],
        //             [1256961600000, -78.984349952220],
        //             [1259557200000, -83.041230807854],
        //             [1262235600000, -84.529748348935],
        //             [1264914000000, -83.837470195508],
        //             [1267333200000, -87.174487671969],
        //             [1270008000000, -90.342293007487],
        //             [1272600000000, -93.550928464991],
        //             [1275278400000, -85.833102140765],
        //             [1277870400000, -79.326501831592],
        //             [1280548800000, -87.986196903537],
        //             [1283227200000, -85.397862121771],
        //             [1285819200000, -94.738167050020],
        //             [1288497600000, -98.661952897151],
        //             [1291093200000, -99.609665952708],
        //             [1293771600000, -103.57099836183],
        //             [1296450000000, -104.04353411322],
        //             [1298869200000, -108.21382792587],
        //             [1301544000000, -108.74006900920],
        //             [1304136000000, -112.07766650960],
        //             [1306814400000, -109.63328199118],
        //             [1309406400000, -106.53578966772],
        //             [1312084800000, -103.16480871469],
        //             [1314763200000, -95.945078001828],
        //             [1317355200000, -81.226687340874],
        //             [1320033600000, -90.782206596168],
        //             [1322629200000, -89.484445370113],
        //             [1325307600000, -88.514723135326],
        //             [1327986000000, -93.381292724320],
        //             [1330491600000, -97.529705609172],
        //             [1333166400000, -99.520481439189],
        //             [1335758400000, -99.430184898669],
        //             [1338436800000, -93.349934521973],
        //             [1341028800000, -95.858475286491],
        //             [1343707200000, -95.522755836605],
        //             [1346385600000, -98.503848862036],
        //             [1348977600000, -101.49415251896],
        //             [1351656000000, -101.50099325672],
        //             [1354251600000, -99.487094927489]
        //         ],
        //         mean: -60
        //     }, {
        //         key: "Gross",
        //         mean: 125,
        //         values: [
        //             [1083297600000, -3.7454058855943],
        //             [1085976000000, -3.6096667436314],
        //             [1088568000000, -0.8440003934950],
        //             [1091246400000, 2.0921565171691],
        //             [1093924800000, 3.5874194844361],
        //             [1096516800000, 13.742776534056],
        //             [1099195200000, 13.212577494462],
        //             [1101790800000, 24.567562260634],
        //             [1104469200000, 34.543699343650],
        //             [1107147600000, 36.438736927704],
        //             [1109566800000, 46.453174659855],
        //             [1112245200000, 43.825369235440],
        //             [1114833600000, 32.036699833653],
        //             [1117512000000, 41.191928040141],
        //             [1120104000000, 40.301151852023],
        //             [1122782400000, 54.922174023466],
        //             [1125460800000, 49.538009616222],
        //             [1128052800000, 61.911998981277],
        //             [1130734800000, 56.139287982733],
        //             [1133326800000, 71.780099623014],
        //             [1136005200000, 78.474613851439],
        //             [1138683600000, 90.069363092366],
        //             [1141102800000, 87.449910167102],
        //             [1143781200000, 87.030640692381],
        //             [1146369600000, 87.053437436941],
        //             [1149048000000, 76.263029236276],
        //             [1151640000000, 72.995735254929],
        //             [1154318400000, 63.349908186291],
        //             [1156996800000, 66.253474132320],
        //             [1159588800000, 75.943546587481],
        //             [1162270800000, 93.889549035453],
        //             [1164862800000, 106.18074433002],
        //             [1167541200000, 116.39729488562],
        //             [1170219600000, 129.09440567885],
        //             [1172638800000, 123.07049577958],
        //             [1175313600000, 129.38531055124],
        //             [1177905600000, 132.05431954171],
        //             [1180584000000, 148.86060871993],
        //             [1183176000000, 157.06946698484],
        //             [1185854400000, 155.12909573880],
        //             [1188532800000, 155.14737474392],
        //             [1191124800000, 159.70646945738],
        //             [1193803200000, 166.44021916278],
        //             [1196398800000, 159.05963386166],
        //             [1199077200000, 151.38121182455],
        //             [1201755600000, 132.02441123108],
        //             [1204261200000, 121.93110210702],
        //             [1206936000000, 112.64545460548],
        //             [1209528000000, 122.17722331147],
        //             [1212206400000, 133.65410878087],
        //             [1214798400000, 120.20304048123],
        //             [1217476800000, 123.06288589052],
        //             [1220155200000, 125.33598074057],
        //             [1222747200000, 103.50539786253],
        //             [1225425600000, 85.917420810943],
        //             [1228021200000, 71.250132356683],
        //             [1230699600000, 71.308439405118],
        //             [1233378000000, 52.287271484242],
        //             [1235797200000, 30.329193047772],
        //             [1238472000000, 44.133440571375],
        //             [1241064000000, 77.654211210456],
        //             [1243742400000, 73.749802969425],
        //             [1246334400000, 70.337666717565],
        //             [1249012800000, 102.69722724876],
        //             [1251691200000, 117.63589109350],
        //             [1254283200000, 128.55351774786],
        //             [1256961600000, 119.21420882198],
        //             [1259557200000, 139.32979337027],
        //             [1262235600000, 149.71606246357],
        //             [1264914000000, 144.42340669795],
        //             [1267333200000, 161.64446359053],
        //             [1270008000000, 180.23071774437],
        //             [1272600000000, 199.09511476051],
        //             [1275278400000, 180.10778306442],
        //             [1277870400000, 158.50237284410],
        //             [1280548800000, 177.57353623850],
        //             [1283227200000, 162.91091118751],
        //             [1285819200000, 183.41053361910],
        //             [1288497600000, 194.03065670573],
        //             [1291093200000, 201.23297214328],
        //             [1293771600000, 222.60154078445],
        //             [1296450000000, 233.35556801977],
        //             [1298869200000, 231.22452435045],
        //             [1301544000000, 237.84432503045],
        //             [1304136000000, 235.55799131184],
        //             [1306814400000, 232.11873570751],
        //             [1309406400000, 226.62381538123],
        //             [1312084800000, 219.34811113539],
        //             [1314763200000, 198.69242285581],
        //             [1317355200000, 168.90235629066],
        //             [1320033600000, 202.64725756733],
        //             [1322629200000, 203.05389378105],
        //             [1325307600000, 204.85986680865],
        //             [1327986000000, 229.77085616585],
        //             [1330491600000, 239.65202435959],
        //             [1333166400000, 242.33012622734],
        //             [1335758400000, 234.11773262149],
        //             [1338436800000, 221.47846307887],
        //             [1341028800000, 216.98308827912],
        //             [1343707200000, 218.37781386755],
        //             [1346385600000, 229.39368622736],
        //             [1348977600000, 230.54656412916],
        //             [1351656000000, 243.06087025523],
        //             [1354251600000, 244.24733578385]
        //         ]
        //     }, {
        //         key: "S&P 1500",
        //         values: [
        //             [1083297600000, -1.7798428181819],
        //             [1085976000000, -0.36883324836999],
        //             [1088568000000, 1.7312581046040],
        //             [1091246400000, -1.8356125950460],
        //             [1093924800000, -1.5396564170877],
        //             [1096516800000, -0.16867791409247],
        //             [1099195200000, 1.3754263993413],
        //             [1101790800000, 5.8171640898041],
        //             [1104469200000, 9.4350145241608],
        //             [1107147600000, 6.7649081510160],
        //             [1109566800000, 9.1568499314776],
        //             [1112245200000, 7.2485090994419],
        //             [1114833600000, 4.8762222306595],
        //             [1117512000000, 8.5992339354652],
        //             [1120104000000, 9.0896517982086],
        //             [1122782400000, 13.394644048577],
        //             [1125460800000, 12.311842010760],
        //             [1128052800000, 13.221003650717],
        //             [1130734800000, 11.218481009206],
        //             [1133326800000, 15.565352598445],
        //             [1136005200000, 15.623703865926],
        //             [1138683600000, 19.275255326383],
        //             [1141102800000, 19.432433717836],
        //             [1143781200000, 21.232881244655],
        //             [1146369600000, 22.798299192958],
        //             [1149048000000, 19.006125095476],
        //             [1151640000000, 19.151889158536],
        //             [1154318400000, 19.340022855452],
        //             [1156996800000, 22.027934841859],
        //             [1159588800000, 24.903300681329],
        //             [1162270800000, 29.146492833877],
        //             [1164862800000, 31.781626082589],
        //             [1167541200000, 33.358770738428],
        //             [1170219600000, 35.622684613497],
        //             [1172638800000, 33.332821711366],
        //             [1175313600000, 34.878748635832],
        //             [1177905600000, 40.582332613844],
        //             [1180584000000, 45.719535502920],
        //             [1183176000000, 43.239344722386],
        //             [1185854400000, 38.550955100342],
        //             [1188532800000, 40.585368816283],
        //             [1191124800000, 45.601374057981],
        //             [1193803200000, 48.051404337892],
        //             [1196398800000, 41.582581696032],
        //             [1199077200000, 40.650580792748],
        //             [1201755600000, 32.252222066493],
        //             [1204261200000, 28.106390258553],
        //             [1206936000000, 27.532698196687],
        //             [1209528000000, 33.986390463852],
        //             [1212206400000, 36.302660526438],
        //             [1214798400000, 25.015574480172],
        //             [1217476800000, 23.989494069029],
        //             [1220155200000, 25.934351445531],
        //             [1222747200000, 14.627592011699],
        //             [1225425600000, -5.2249403809749],
        //             [1228021200000, -12.330933408050],
        //             [1230699600000, -11.000291508188],
        //             [1233378000000, -18.563864948088],
        //             [1235797200000, -27.213097001687],
        //             [1238472000000, -20.834133840523],
        //             [1241064000000, -12.717886701719],
        //             [1243742400000, -8.1644613083526],
        //             [1246334400000, -7.9108408918201],
        //             [1249012800000, -0.77002391591209],
        //             [1251691200000, 2.8243816569672],
        //             [1254283200000, 6.8761411421070],
        //             [1256961600000, 4.5060912230294],
        //             [1259557200000, 10.487179794349],
        //             [1262235600000, 13.251375597594],
        //             [1264914000000, 9.2207594803415],
        //             [1267333200000, 12.836276936538],
        //             [1270008000000, 19.816793904978],
        //             [1272600000000, 22.156787167211],
        //             [1275278400000, 12.518039090576],
        //             [1277870400000, 6.4253587440854],
        //             [1280548800000, 13.847372028409],
        //             [1283227200000, 8.5454736090364],
        //             [1285819200000, 18.542801953304],
        //             [1288497600000, 23.037064683183],
        //             [1291093200000, 23.517422401888],
        //             [1293771600000, 31.804723416068],
        //             [1296450000000, 34.778247386072],
        //             [1298869200000, 39.584883855230],
        //             [1301544000000, 40.080647664875],
        //             [1304136000000, 44.180050667889],
        //             [1306814400000, 42.533535927221],
        //             [1309406400000, 40.105374449011],
        //             [1312084800000, 37.014659267156],
        //             [1314763200000, 29.263745084262],
        //             [1317355200000, 19.637463417584],
        //             [1320033600000, 33.157645345770],
        //             [1322629200000, 32.895053150988],
        //             [1325307600000, 34.111544824647],
        //             [1327986000000, 40.453985817473],
        //             [1330491600000, 46.435700783313],
        //             [1333166400000, 51.062385488671],
        //             [1335758400000, 50.130448220658],
        //             [1338436800000, 41.035476682018],
        //             [1341028800000, 46.591932296457],
        //             [1343707200000, 48.349391180634],
        //             [1346385600000, 51.913011286919],
        //             [1348977600000, 55.747238313752],
        //             [1351656000000, 52.991824077209],
        //             [1354251600000, 49.556311883284]
        //         ]
        //     }];
        // }
    </script>
@endsection