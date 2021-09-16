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
                        <!--<button type="button" class="btn btn-default btn-lg">ADD USERS +</button>-->
                        <div class="clearfix"></div>
                    </div>
                </section>

                <section class="page-content user-page-content">
                    <div class="row zmd-hierarchical-display in paymentinfo-row" data-animation="hierarchical-display">
                        <div class="col-sm-12 zoomIn animated" style="animation-delay: 0.12s;">
                            <h1 class="daily_report" >Daily Sales Report</h1>
                            {{-- <div class="igFrameBar">
                                <div class="igData igData1"></div>
                                <div class="igData igData2"></div>
                                <div class="igData igData3"></div>
                                <div class="igData igData4"></div>
                                <div class="igData igData5"></div>
                                <div class="igData igData6"></div>
                                <div class="igData igData7"></div>
                            </div> --}}
                            <figure class="highcharts-figure">
                                <div id="container"></div>
                            </figure>
                        </div>
                    </div>
                    <div class="row zmd-hierarchical-display in paymentinfo-row" data-animation="hierarchical-display">
                        <div class="col-sm-12 zoomIn animated" style="animation-delay: 0.12s;">
                            <h1 class="daily_report" >Daily Profit Report</h1>
                            <div class="igFrameBar">
                                <div class="igData igData1"></div>
                                <div class="igData igData2"></div>
                                <div class="igData igData3"></div>
                                <div class="igData igData4"></div>
                                <div class="igData igData5"></div>
                                <div class="igData igData6"></div>
                                <div class="igData igData7"></div>
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
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/data.js"></script>
    <script src="https://code.highcharts.com/modules/drilldown.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script>
        // Create the chart
        Highcharts.chart('container', {
          chart: {
            type: 'column'
          },
          title: {
            text: 'Browser market shares. January, 2018'
          },
          subtitle: {
            text: 'Click the columns to view versions. Source: <a href="http://statcounter.com" target="_blank">statcounter.com</a>'
          },
          colors: [
                '#706bc8',
                '#706bc8', 
                '#706bc8',
                '#706bc8',
                '#706bc8', 
                '#706bc8',
                '#706bc8', 
                '#706bc8'
                
            ],
          accessibility: {
            announceNewData: {
              enabled: true
            }
          },
          xAxis: {
            type: 'category'
          },
          yAxis: {
            title: {
              text: 'Total percent market share'
            }

          },
          legend: {
            enabled: false
          },
          plotOptions: {
            series: {
              borderWidth: 0,
              dataLabels: {
                enabled: true,
                format: '{point.y:.1f}%'
              }
            }
          },

          tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
          },

          series: [
            {
              name: "Day1",
              colorByPoint: true,
              data: [
                {
                  name: "Day1",
                  y: '10',
                  drilldown: "Day1"
                },
                {
                  name: "Day2",
                  y: 10.57,
                  drilldown: "Day2"
                },
                {
                  name: "Day3",
                  y: 7.23,
                  drilldown: "Day3"
                },
                {
                  name: "Day4",
                  y: 5.58,
                  drilldown: "Day4"
                },
                {
                  name: "Day5",
                  y: 4.02,
                  drilldown: "Day5"
                },
                {
                  name: "Day6",
                  y: 1.92,
                  drilldown: "Day6"
                },
                {
                  name: "Other",
                  y: 7.62,
                  drilldown: null
                }
              ]
            }
          ],
          drilldown: {
            series: [
              {
                name: "Chrome",
                id: "Chrome",
                data: [
                  [
                    "v65.0",
                    0.1
                  ],
                  [
                    "v64.0",
                    1.3
                  ],
                  [
                    "v63.0",
                    53.02
                  ],
                  [
                    "v62.0",
                    1.4
                  ],
                  [
                    "v61.0",
                    0.88
                  ],
                  [
                    "v60.0",
                    0.56
                  ],
                  [
                    "v59.0",
                    0.45
                  ],
                  [
                    "v58.0",
                    0.49
                  ],
                  [
                    "v57.0",
                    0.32
                  ],
                  [
                    "v56.0",
                    0.29
                  ],
                  [
                    "v55.0",
                    0.79
                  ],
                  [
                    "v54.0",
                    0.18
                  ],
                  [
                    "v51.0",
                    0.13
                  ],
                  [
                    "v49.0",
                    2.16
                  ],
                  [
                    "v48.0",
                    0.13
                  ],
                  [
                    "v47.0",
                    0.11
                  ],
                  [
                    "v43.0",
                    0.17
                  ],
                  [
                    "v29.0",
                    0.26
                  ]
                ]
              },
              {
                name: "Firefox",
                id: "Firefox",
                data: [
                  [
                    "v58.0",
                    1.02
                  ],
                  [
                    "v57.0",
                    7.36
                  ],
                  [
                    "v56.0",
                    0.35
                  ],
                  [
                    "v55.0",
                    0.11
                  ],
                  [
                    "v54.0",
                    0.1
                  ],
                  [
                    "v52.0",
                    0.95
                  ],
                  [
                    "v51.0",
                    0.15
                  ],
                  [
                    "v50.0",
                    0.1
                  ],
                  [
                    "v48.0",
                    0.31
                  ],
                  [
                    "v47.0",
                    0.12
                  ]
                ]
              },
              {
                name: "Internet Explorer",
                id: "Internet Explorer",
                data: [
                  [
                    "v11.0",
                    6.2
                  ],
                  [
                    "v10.0",
                    0.29
                  ],
                  [
                    "v9.0",
                    0.27
                  ],
                  [
                    "v8.0",
                    0.47
                  ]
                ]
              },
              {
                name: "Safari",
                id: "Safari",
                data: [
                  [
                    "v11.0",
                    3.39
                  ],
                  [
                    "v10.1",
                    0.96
                  ],
                  [
                    "v10.0",
                    0.36
                  ],
                  [
                    "v9.1",
                    0.54
                  ],
                  [
                    "v9.0",
                    0.13
                  ],
                  [
                    "v5.1",
                    0.2
                  ]
                ]
              },
              {
                name: "Edge",
                id: "Edge",
                data: [
                  [
                    "v16",
                    2.6
                  ],
                  [
                    "v15",
                    0.92
                  ],
                  [
                    "v14",
                    0.4
                  ],
                  [
                    "v13",
                    0.1
                  ]
                ]
              },
              {
                name: "Opera",
                id: "Opera",
                data: [
                  [
                    "v50.0",
                    0.96
                  ],
                  [
                    "v49.0",
                    0.82
                  ],
                  [
                    "v12.1",
                    0.14
                  ]
                ]
              }
            ]
          }
        });
    </script>
@endsection