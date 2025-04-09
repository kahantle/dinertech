@extends('admin.layouts.app')

@section('css')
    <style>
       .chart-container {
            position: relative;
            height: 500px;
            width: 900px;
            /* margin: 0 auto; Centers the container */
        }

        /* For screens smaller than 1272px */
        @media (max-width: 1272px) {
            .chart-container {
                width: 700px;
                height: 500px;
                /* min-height: 400px; */
                /* padding-bottom: 56.25%; 16:9 aspect ratio */
            }
        }
        @media (max-width: 1150px) {
            .chart-container {
                width: 600px;
                height: 400px;
            }
        }

        /* For tablets */
        @media (max-width: 992px) {
            .chart-container {
                width: 800px;
                height: 600px;
            }
        }
        @media (max-width: 880px) {
            .chart-container {
                width: 700px;
                height: 500px;
            }
        }
        @media (max-width: 800px) {
            .chart-container {
                width: 600px;
                height: 400px;
            }
        }

        /* For mobile devices */
        @media (max-width: 768px) {
            .chart-container {
                max-width: 400px;
                max-height: 300px;
            }
        }

        /* For very small screens */
        @media (max-width: 480px) {
            .chart-container {
                max-width: 350px;
                max-height: 250px;
            }
        }
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
                                <span class="page-header_subtitle" data-i18n="dashboard1.welcomeMsg"
                                    data-i18n-options="{&quot;username&quot;: &quot;John Doe&quot;}">Welcome back
                                    {{Auth::guard('admin')->user()->full_name}}</span>
                            </h1>
                            <div class="drop-down w-dirst-drop">
                                <div class="selected">
                                    <a href="#" class="wd-dr-sec"><span>Month</span>
                                        <div class="caret"></div>
                                    </a>
                                </div>
                                <div class="options">
                                    <ul style="display: none;">
                                        <li class="filter" data-filter="Month"><a href="#">Month<span
                                                    class="value"></span></a></li>
                                        <li class="filter" data-filter="Week"><a href="#">Week<span
                                                    class="value"></span></a></li>
                                        <li class="filter" data-filter="Today"><a href="#">Today<span
                                                    class="value"></span></a></li>
                                        <li class="filter" data-filter="Year"><a href="#">Year<span
                                                    class="value"></span></a></li>
                                        <li class="filter" data-filter="Custom"><a href="#" class="title-link"> Custom<span
                                                    class="value"></span></a></li>
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
                                            <input type="date" class="form-control date" data-date=""
                                                data-date-format="DD MMMM YYYY" id="from-date"></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 d-dta-p-blog">
                                        <label>To</label>
                                        <div class="input-group date">
                                            <input type="date" class="form-control date" data-date=""
                                                data-date-format="DD MMMM YYYY" id="to-date"></span>
                                        </div>
                                    </div>
                                    <!-- </div> -->
                                </div>
                            </div>
                            <div class="drop-down">
                                <div class="selected">
                                    <a href="#" class="wd-dr-sec"><span>Month</span>
                                        <div class="caret"></div>
                                    </a>
                                </div>
                                <div class="options">
                                    <ul style="display: none;">
                                        <li class="filter" data-filter="Month"><a href="#">Month<span
                                                    class="value"></span></a></li>
                                        <li class="filter" data-filter="Year"><a href="#">Year<span
                                                    class="value"></span></a></li>
                                        <li class="filter" data-filter="Week"><a href="#">Week<span
                                                    class="value"></span></a></li>
                                        <li class="filter" data-filter="Today"><a href="#">Today<span
                                                    class="value"></span></a></li>
                                        <li class="filter" data-filter="Custom"><a href="#" class="title-link"> Custom<span
                                                    class="value"></span></a></li>
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
                                                <svg class="peity" height="28" width="64">
                                                    <rect fill="#4D89F9" x="0.64" y="15.555555555555557" width="5.12"
                                                        height="12.444444444444443"></rect>
                                                    <rect fill="#4D89F9" x="7.040000000000001" y="18.666666666666668"
                                                        width="5.119999999999999" height="9.333333333333332"></rect>
                                                    <rect fill="#4D89F9" x="13.440000000000001" y="12.444444444444443"
                                                        width="5.119999999999997" height="15.555555555555557"></rect>
                                                    <rect fill="#4D89F9" x="19.84" y="21.77777777777778"
                                                        width="5.120000000000001" height="6.222222222222221"></rect>
                                                    <rect fill="#4D89F9" x="26.24" y="12.444444444444443"
                                                        width="5.1200000000000045" height="15.555555555555557"></rect>
                                                    <rect fill="#4D89F9" x="32.64" y="18.666666666666668"
                                                        width="5.1200000000000045" height="9.333333333333332"></rect>
                                                    <rect fill="#4D89F9" x="39.04" y="3.1111111111111143"
                                                        width="5.1200000000000045" height="24.888888888888886"></rect>
                                                    <rect fill="#4D89F9" x="45.44" y="18.666666666666668"
                                                        width="5.1200000000000045" height="9.333333333333332"></rect>
                                                    <rect fill="#4D89F9" x="51.839999999999996" y="15.555555555555557"
                                                        width="5.1200000000000045" height="12.444444444444443"></rect>
                                                    <rect fill="#4D89F9" x="58.239999999999995" y="0"
                                                        width="5.1200000000000045" height="28"></rect>
                                                </svg>
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
                                                <span class="peity-bar"
                                                    style="display: none;">4,3,5,2,5,3,8,3,4,9</span><svg class="peity"
                                                    height="28" width="64">
                                                    <rect fill="#4D89F9" x="0.64" y="15.555555555555557" width="5.12"
                                                        height="12.444444444444443"></rect>
                                                    <rect fill="#4D89F9" x="7.040000000000001" y="18.666666666666668"
                                                        width="5.119999999999999" height="9.333333333333332"></rect>
                                                    <rect fill="#4D89F9" x="13.440000000000001" y="12.444444444444443"
                                                        width="5.119999999999997" height="15.555555555555557"></rect>
                                                    <rect fill="#4D89F9" x="19.84" y="21.77777777777778"
                                                        width="5.120000000000001" height="6.222222222222221"></rect>
                                                    <rect fill="#4D89F9" x="26.24" y="12.444444444444443"
                                                        width="5.1200000000000045" height="15.555555555555557"></rect>
                                                    <rect fill="#4D89F9" x="32.64" y="18.666666666666668"
                                                        width="5.1200000000000045" height="9.333333333333332"></rect>
                                                    <rect fill="#4D89F9" x="39.04" y="3.1111111111111143"
                                                        width="5.1200000000000045" height="24.888888888888886"></rect>
                                                    <rect fill="#4D89F9" x="45.44" y="18.666666666666668"
                                                        width="5.1200000000000045" height="9.333333333333332"></rect>
                                                    <rect fill="#4D89F9" x="51.839999999999996" y="15.555555555555557"
                                                        width="5.1200000000000045" height="12.444444444444443"></rect>
                                                    <rect fill="#4D89F9" x="58.239999999999995" y="0"
                                                        width="5.1200000000000045" height="28"></rect>
                                                </svg>
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
                                                <svg class="peity" height="28" width="64">
                                                    <rect fill="#4D89F9" x="0.64" y="15.555555555555557" width="5.12"
                                                        height="12.444444444444443"></rect>
                                                    <rect fill="#4D89F9" x="7.040000000000001" y="18.666666666666668"
                                                        width="5.119999999999999" height="9.333333333333332"></rect>
                                                    <rect fill="#4D89F9" x="13.440000000000001" y="12.444444444444443"
                                                        width="5.119999999999997" height="15.555555555555557"></rect>
                                                    <rect fill="#4D89F9" x="19.84" y="21.77777777777778"
                                                        width="5.120000000000001" height="6.222222222222221"></rect>
                                                    <rect fill="#4D89F9" x="26.24" y="12.444444444444443"
                                                        width="5.1200000000000045" height="15.555555555555557"></rect>
                                                    <rect fill="#4D89F9" x="32.64" y="18.666666666666668"
                                                        width="5.1200000000000045" height="9.333333333333332"></rect>
                                                    <rect fill="#4D89F9" x="39.04" y="3.1111111111111143"
                                                        width="5.1200000000000045" height="24.888888888888886"></rect>
                                                    <rect fill="#4D89F9" x="45.44" y="18.666666666666668"
                                                        width="5.1200000000000045" height="9.333333333333332"></rect>
                                                    <rect fill="#4D89F9" x="51.839999999999996" y="15.555555555555557"
                                                        width="5.1200000000000045" height="12.444444444444443"></rect>
                                                    <rect fill="#4D89F9" x="58.239999999999995" y="0"
                                                        width="5.1200000000000045" height="28"></rect>
                                                </svg>
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
                                                <span class="peity-bar"
                                                    style="display: none;">4,3,5,6,5,4,6,3,2,6</span><svg class="peity"
                                                    height="28" width="64">
                                                    <rect fill="#4D89F9" x="0.64" y="9.333333333333336" width="5.12"
                                                        height="18.666666666666664"></rect>
                                                    <rect fill="#4D89F9" x="7.040000000000001" y="14"
                                                        width="5.119999999999999" height="14"></rect>
                                                    <rect fill="#4D89F9" x="13.440000000000001" y="4.666666666666664"
                                                        width="5.119999999999997" height="23.333333333333336"></rect>
                                                    <rect fill="#4D89F9" x="19.84" y="0" width="5.120000000000001"
                                                        height="28"></rect>
                                                    <rect fill="#4D89F9" x="26.24" y="4.666666666666664"
                                                        width="5.1200000000000045" height="23.333333333333336"></rect>
                                                    <rect fill="#4D89F9" x="32.64" y="9.333333333333336"
                                                        width="5.1200000000000045" height="18.666666666666664"></rect>
                                                    <rect fill="#4D89F9" x="39.04" y="0" width="5.1200000000000045"
                                                        height="28"></rect>
                                                    <rect fill="#4D89F9" x="45.44" y="14" width="5.1200000000000045"
                                                        height="14"></rect>
                                                    <rect fill="#4D89F9" x="51.839999999999996" y="18.666666666666668"
                                                        width="5.1200000000000045" height="9.333333333333332"></rect>
                                                    <rect fill="#4D89F9" x="58.239999999999995" y="0"
                                                        width="5.1200000000000045" height="28"></rect>
                                                </svg>
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
                                            <a class="btn btn-icon-toggle panel-tools-menu dropdown-toggle"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
                                                    class="material-icons">more_vert</i></a>
                                            <ul class="dropdown-menu dropdown-menu-right">
                                                <li><a href="#">Refresh</a></li>
                                            </ul>
                                        </div>
                                    </div> --}}
                                </div>
                                <div class="panel-body">
                                    <div class="statistics">
                                        <div class="row wd-stics-blog">
                                            <div class="col-lg-2">
                                                <div class="wd-sal-first">
                                                    <h5 class="totalSales">$ {{$totalSales}}</h5>
                                                    <span class="wd-dr-sales">Total Sales</span>
                                                </div>
                                            </div>
                                            <div class="col-lg-10">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div id="chart">
                                                            <!--<svg class="height-5 nv-chart-60603"><g class="nvd3 nv-wrap nv-cumulativeLine" transform="translate(60,30)"><g><g class="nv-interactive"><g class=" nv-wrap nv-interactiveLineLayer"><g class="nv-interactiveGuideLine"></g></g></g><g class="nv-x nv-axis" style="pointer-events: none;" transform="translate(0,200)"><g class="nvd3 nv-wrap nv-axis"><g><path class="domain" d="M0,0V0H546V0"></path><text class="nv-axislabel" text-anchor="middle" y="36" x="273"></text></g><g class="nv-axisMaxMin" transform="translate(0,0)"><text dy=".71em" y="7" transform="rotate(0 0,0)" style="text-anchor: middle;">12/16/2015</text></g><g class="nv-axisMaxMin" transform="translate(546,0)"><text dy=".71em" y="7" transform="rotate(0 0,0)" style="text-anchor: middle;">12/17/2015</text></g></g></g><g class="nv-y nv-axis"><g class="nvd3 nv-wrap nv-axis"><g><g class="tick major" style="opacity: 1;" transform="translate(0,200)"><line x2="546" y2="0"></line><text x="-3" dy=".32em" style="text-anchor: end;" opacity="0" y="0">0.0%</text></g><g class="tick major" style="opacity: 1;" transform="translate(0,154.02298850574712)"><line x2="546" y2="0"></line><text x="-3" dy=".32em" style="text-anchor: end;" opacity="1" y="0">100.0%</text></g><g class="tick major" style="opacity: 1;" transform="translate(0,108.04597701149426)"><line x2="546" y2="0"></line><text x="-3" dy=".32em" style="text-anchor: end;" opacity="1" y="0">200.0%</text></g><g class="tick major" style="opacity: 1;" transform="translate(0,62.068965517241395)"><line x2="546" y2="0"></line><text x="-3" dy=".32em" style="text-anchor: end;" opacity="1" y="0">300.0%</text></g><g class="tick major" style="opacity: 1;" transform="translate(0,16.091954022988517)"><line x2="546" y2="0"></line><text x="-3" dy=".32em" style="text-anchor: end;" opacity="1" y="0">400.0%</text></g><path class="domain" d="M0,0H0V200H0"></path><text class="nv-axislabel" style="text-anchor: middle;" transform="rotate(-90)" y="-63" x="-100"></text></g><g class="nv-axisMaxMin" transform="translate(0,200)"><text style="opacity: 1;" dy=".32em" y="0" x="-3" text-anchor="end">0.0%</text></g><g class="nv-axisMaxMin" transform="translate(0,0)"><text style="opacity: 1;" dy=".32em" y="0" x="-3" text-anchor="end">435.0%</text></g></g></g><g class="nv-background"><rect width="546" height="200"></rect></g><g class="nv-linesWrap" style="pointer-events: none;"><g class="nvd3 nv-wrap nv-line" transform="translate(0,0)"><defs><clipPath id="nv-edge-clip-60603"><rect width="546" height="200"></rect></clipPath></defs><g clip-path=""><g class="nv-groups"><g style="stroke-opacity: 1; fill-opacity: 0.5; fill: rgb(31, 119, 180); stroke: rgb(31, 119, 180);" class="nv-group nv-series-0"><path class="nv-line" d="M0,200L24.81818181818182,184.367816091954L49.63636363636364,160.15325670498083L74.45454545454545,168.58237547892722L99.27272727272728,163.2183908045977L124.0909090909091,161.30268199233717L148.9090909090909,153.25670498084293L173.72727272727272,146.360153256705L198.54545454545456,100.38314176245213L248.1818181818182,169.34865900383141L273,122.98850574712644L297.8181818181818,143.29501915708812L322.6363636363636,156.32183908045977L347.45454545454544,137.16475095785444L347.45454545454544,161.455938697318L372.2727272727273,156.32183908045977L397.0909090909091,157.85440613026822L421.9090909090909,178.544061302682L446.72727272727275,123.37164750957855L471.54545454545456,157.54789272030652L496.3636363636364,157.85440613026822L521.1818181818182,143.29501915708812L546,137.93103448275863"></path></g><g style="stroke-opacity: 1; fill-opacity: 0.5; fill: rgb(255, 127, 14); stroke: rgb(255, 127, 14);" class="nv-group nv-series-1"><path class="nv-line" d="M0,200L24.81818181818182,168.73563218390805L49.63636363636364,104.98084291187742L74.45454545454545,121.83908045977013L99.27272727272728,94.25287356321839L124.0909090909091,61.30268199233717L148.9090909090909,91.18773946360155L173.72727272727272,74.32950191570885L198.54545454545456,34.48275862068968L248.1818181818182,0.766283524904253L273,0L297.8181818181818,40.61302681992339L322.6363636363636,66.66666666666669L347.45454545454544,28.35249042145597L347.45454545454544,76.93486590038316L372.2727272727273,66.66666666666669L397.0909090909091,69.73180076628353L421.9090909090909,95.78544061302681L446.72727272727275,76.3218390804598L471.54545454545456,53.7931034482759L496.3636363636364,91.95402298850577L521.1818181818182,55.938697318007684L546,48.27586206896552"></path></g></g><g class="nv-scatterWrap" clip-path=""><g class="nvd3 nv-wrap nv-scatter nv-chart-60603" transform="translate(0,0)"><defs><clipPath id="nv-edge-clip-60603"><rect width="546" height="200"></rect></clipPath></defs><g clip-path=""><g class="nv-groups"><g style="stroke-opacity: 1; fill-opacity: 0.5; stroke: rgb(31, 119, 180); fill: rgb(31, 119, 180);" class="nv-group nv-series-0"><circle cx="0" cy="200" r="2.256758334191025" class="nv-point nv-point-0"></circle><circle cx="24.81818181818182" cy="184.367816091954" r="2.256758334191025" class="nv-point nv-point-1"></circle><circle cx="49.63636363636364" cy="160.15325670498083" r="2.256758334191025" class="nv-point nv-point-2"></circle><circle cx="74.45454545454545" cy="168.58237547892722" r="2.256758334191025" class="nv-point nv-point-3"></circle><circle cx="99.27272727272728" cy="163.2183908045977" r="2.256758334191025" class="nv-point nv-point-4"></circle><circle cx="124.0909090909091" cy="161.30268199233717" r="2.256758334191025" class="nv-point nv-point-5"></circle><circle cx="148.9090909090909" cy="153.25670498084293" r="2.256758334191025" class="nv-point nv-point-6"></circle><circle cx="173.72727272727272" cy="146.360153256705" r="2.256758334191025" class="nv-point nv-point-7"></circle><circle cx="198.54545454545456" cy="100.38314176245213" r="2.256758334191025" class="nv-point nv-point-8"></circle><circle cx="248.1818181818182" cy="169.34865900383141" r="2.256758334191025" class="nv-point nv-point-9"></circle><circle cx="273" cy="122.98850574712644" r="2.256758334191025" class="nv-point nv-point-10"></circle><circle cx="297.8181818181818" cy="143.29501915708812" r="2.256758334191025" class="nv-point nv-point-11"></circle><circle cx="322.6363636363636" cy="156.32183908045977" r="2.256758334191025" class="nv-point nv-point-12"></circle><circle cx="347.45454545454544" cy="137.16475095785444" r="2.256758334191025" class="nv-point nv-point-13"></circle><circle cx="347.45454545454544" cy="161.455938697318" r="2.256758334191025" class="nv-point nv-point-14"></circle><circle cx="372.2727272727273" cy="156.32183908045977" r="2.256758334191025" class="nv-point nv-point-15"></circle><circle cx="397.0909090909091" cy="157.85440613026822" r="2.256758334191025" class="nv-point nv-point-16"></circle><circle cx="421.9090909090909" cy="178.544061302682" r="2.256758334191025" class="nv-point nv-point-17"></circle><circle cx="446.72727272727275" cy="123.37164750957855" r="2.256758334191025" class="nv-point nv-point-18"></circle><circle cx="471.54545454545456" cy="157.54789272030652" r="2.256758334191025" class="nv-point nv-point-19"></circle><circle cx="496.3636363636364" cy="157.85440613026822" r="2.256758334191025" class="nv-point nv-point-20"></circle><circle cx="521.1818181818182" cy="143.29501915708812" r="2.256758334191025" class="nv-point nv-point-21"></circle><circle cx="546" cy="137.93103448275863" r="2.256758334191025" class="nv-point nv-point-22"></circle></g><g style="stroke-opacity: 1; fill-opacity: 0.5; stroke: rgb(255, 127, 14); fill: rgb(255, 127, 14);" class="nv-group nv-series-1"><circle cx="0" cy="200" r="2.256758334191025" class="nv-point nv-point-0"></circle><circle cx="24.81818181818182" cy="168.73563218390805" r="2.256758334191025" class="nv-point nv-point-1"></circle><circle cx="49.63636363636364" cy="104.98084291187742" r="2.256758334191025" class="nv-point nv-point-2"></circle><circle cx="74.45454545454545" cy="121.83908045977013" r="2.256758334191025" class="nv-point nv-point-3"></circle><circle cx="99.27272727272728" cy="94.25287356321839" r="2.256758334191025" class="nv-point nv-point-4"></circle><circle cx="124.0909090909091" cy="61.30268199233717" r="2.256758334191025" class="nv-point nv-point-5"></circle><circle cx="148.9090909090909" cy="91.18773946360155" r="2.256758334191025" class="nv-point nv-point-6"></circle><circle cx="173.72727272727272" cy="74.32950191570885" r="2.256758334191025" class="nv-point nv-point-7"></circle><circle cx="198.54545454545456" cy="34.48275862068968" r="2.256758334191025" class="nv-point nv-point-8"></circle><circle cx="248.1818181818182" cy="0.766283524904253" r="2.256758334191025" class="nv-point nv-point-9"></circle><circle cx="273" cy="0" r="2.256758334191025" class="nv-point nv-point-10"></circle><circle cx="297.8181818181818" cy="40.61302681992339" r="2.256758334191025" class="nv-point nv-point-11"></circle><circle cx="322.6363636363636" cy="66.66666666666669" r="2.256758334191025" class="nv-point nv-point-12"></circle><circle cx="347.45454545454544" cy="28.35249042145597" r="2.256758334191025" class="nv-point nv-point-13"></circle><circle cx="347.45454545454544" cy="76.93486590038316" r="2.256758334191025" class="nv-point nv-point-14"></circle><circle cx="372.2727272727273" cy="66.66666666666669" r="2.256758334191025" class="nv-point nv-point-15"></circle><circle cx="397.0909090909091" cy="69.73180076628353" r="2.256758334191025" class="nv-point nv-point-16"></circle><circle cx="421.9090909090909" cy="95.78544061302681" r="2.256758334191025" class="nv-point nv-point-17"></circle><circle cx="446.72727272727275" cy="76.3218390804598" r="2.256758334191025" class="nv-point nv-point-18"></circle><circle cx="471.54545454545456" cy="53.7931034482759" r="2.256758334191025" class="nv-point nv-point-19"></circle><circle cx="496.3636363636364" cy="91.95402298850577" r="2.256758334191025" class="nv-point nv-point-20"></circle><circle cx="521.1818181818182" cy="55.938697318007684" r="2.256758334191025" class="nv-point nv-point-21"></circle><circle cx="546" cy="48.27586206896552" r="2.256758334191025" class="nv-point nv-point-22"></circle></g></g><g class="nv-point-paths"></g></g></g></g></g></g><rect class="nv-indexLine" width="3" x="-2" fill="red" fill-opacity="0.5" style="pointer-events: all;" transform="translate(0,0)" height="200"></rect></g><g class="nv-avgLinesWrap" style="pointer-events: none;"></g><g class="nv-legendWrap" transform="translate(0,-30)"><g class="nvd3 nv-legend" transform="translate(0,5)"><g transform="translate(403.5999984741211,5)"><g class="nv-series" transform="translate(0,5)"><circle style="stroke-width: 2px; fill: rgb(31, 119, 180); stroke: rgb(31, 119, 180);" class="nv-legend-symbol" r="5"></circle><text text-anchor="start" class="nv-legend-text" dy=".32em" dx="8">Today</text></g><g class="nv-series" transform="translate(60.5,5)"><circle style="stroke-width: 2px; fill: rgb(255, 127, 14); stroke: rgb(255, 127, 14);" class="nv-legend-symbol" r="5"></circle><text text-anchor="start" class="nv-legend-text" dy=".32em" dx="8">Yesterday</text></g></g></g></g><g class="nv-controlsWrap" transform="translate(0,-30)"><g class="nvd3 nv-legend" transform="translate(0,5)"><g transform="translate(26.5,5)"><g class="nv-series" transform="translate(0,5)"><circle style="stroke-width: 2px; fill: rgb(68, 68, 68); stroke: rgb(68, 68, 68);" class="nv-legend-symbol" r="5"></circle><text text-anchor="start" class="nv-legend-text" dy=".32em" dx="8">Re-scale y-axis</text></g></g></g></g></g></g></svg>-->
                                                            {{-- <svg class="chart-style"></svg> --}}
                                                            {{-- <canvas id="mychart" width="1099" height="300"></canvas>
                                                            --}}
                                                            <div class="chart-container">
                                                                <canvas id="mychart"></canvas>
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
                                                $ {{number_format($liveSales, 2)}}
                                            </span>
                                        @else
                                            <img src="{{asset('assets/admin/img/down-arrow.png')}}" class="down-arrow">
                                            <span class="price livesales-price loss">
                                                $ {{number_format($liveSales, 2)}}
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
    <script src="{{asset('assets/admin/js/chart/2.5.0/Chart.min.js')}}"></script>
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
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        };

        var myChart = document.getElementById('mychart').getContext('2d');
        window.bar = new Chart(myChart, data);
        // Handle window resizing
        // window.addEventListener('resize', function() {
        //     window.bar.resize();
        // });
    </script>
@endsection
