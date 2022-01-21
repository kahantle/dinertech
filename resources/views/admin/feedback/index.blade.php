@extends('admin.layouts.app')

@section('content')
    <section id="right-content-wrapper" class="ps-container ps-active-y" data-ps-id="c878bcb0-cdfa-ab28-2fce-7147f311d569">
        <div class="right-content-outter">
            <div class="right-content-inner" style="opacity: 1;">
                <section class="page-header alternative-header">
                    <div class="page-header_title user-page-header_title">
                        <h1>
                            <span data-i18n="dashboard1.dashboard">Feedback</span>
                            <span class="page-header_subtitle" data-i18n="dashboard1.welcomeMsg" data-i18n-options="{&quot;username&quot;: &quot;John Doe&quot;}">Welcome back {{Auth::guard('admin')->user()->full_name}}</span>
                        </h1>
                        
                        <!--<button type="button" class="btn btn-default btn-lg">ADD USERS +</button>-->
                        <div class="clearfix"></div>
                    </div>
                </section>

                <section class="page-content user-page-content">
                    
                    <div class="row zmd-hierarchical-display in paymentinfo-row" data-animation="hierarchical-display">
                        <div class="col-sm-1 zoomIn animated" style="animation-delay: 0.12s;">
                            <h2 class="" >Sr. No</h2>
                        </div>
                        <div class="col-sm-3 zoomIn animated" style="animation-delay: 0.12s;">
                            <h2 class="" >Name</h2>
                        </div>
                        <div class="col-sm-2 zoomIn animated" style="animation-delay: 0.12s;">
                            <h2 class="" >Feedback Type</h2>
                        </div>
                        <div class="col-sm-3 zoomIn animated" style="animation-delay: 0.12s;">
                            <h2 class="" >Date & Time</h2>
                        </div>
                        <div class="col-sm-3 zoomIn animated" style="animation-delay: 0.12s;">
                            <h2 class="" >Mobile Number</h2>
                        </div>
                    </div>

                    <div class="row zmd-hierarchical-display in paymentinfo-row" data-animation="hierarchical-display">
                        <div class="bs-example">
                            <div class="accordion" id="accordionExample">
                                @php $i = ($feedbacks->currentpage()-1)* $feedbacks->perpage() + 1;@endphp
                                @forelse ($feedbacks as $key => $feedback)
                                    <div class="card panel panel-default panel-user">
                                        <div class="card-header" id="headingOne">
                                            <h2 class="mb-0">
                                                <button type="button" class="btn btn-link collapse-btn" data-toggle="collapse" data-target="#collapse{{$feedback->id}}">
                                                    <div class="col-sm-1 zoomIn animated" style="animation-delay: 0.12s;">
                                                        <h2 class="" >{{$key + $i}}</h2>
                                                    </div>
                                                    <div class="col-sm-3 zoomIn animated" style="animation-delay: 0.12s;">
                                                        <h2 class="" >{{$feedback->name}}</h2>
                                                    </div>
                                                    <div class="col-sm-2 zoomIn animated" style="animation-delay: 0.12s;">
                                                        <h2 class="" >{{$feedback->feedback_type}}</h2>
                                                    </div>
                                                    <div class="col-sm-3 zoomIn animated" style="animation-delay: 0.12s;">
                                                        <h2 class="" >{{$feedback->created_at->format('d,F Y h:s')}}</h2>
                                                    </div>
                                                    <div class="col-sm-3 zoomIn animated" style="animation-delay: 0.12s;">
                                                        <h2 class="" >{{$feedback->phone}}</h2>
                                                    </div>
                                                </button>									
                                            </h2>
                                        </div>
                                        <div id="collapse{{$feedback->id}}" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                                            <div class="card-body">
                                                <div class="col-sm-6">
                                                    <p>{!! $feedback->suggestion !!}</p>
                                                </div>
                                                <div class="col-sm-4 col-sm-offset-2">
                                                    <ul>
                                                        <li>{{$feedback->created_at->format('d,F Y h:s')}}</li>
                                                        <li>{{$feedback->email}}</li>
                                                        <li>{{$feedback->phone}}</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>        
                                @empty
                                    
                                @endforelse
                            </div>
                            {{$feedbacks->links('vendor.pagination.custom')}}
                        </div>
                    </div>
                </section>
                <!-- /#page-content -->                                    
            </div>
        </div>
        
    </section>
    <!-- /#right-content-wrapper -->
@endsection