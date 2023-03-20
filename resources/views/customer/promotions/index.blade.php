@extends('customer-layouts.app')

@section('content')
    <link rel="stylesheet" type="text/css" href="{{asset('assets/customer/css/promotion_page.css')}}">

    <section class="dash-body-ar wd-dr-dash-inner">
        <div class="wrp-ar-nav-body">
            @include('customer-layouts.navbar')
            <div id="chatdesk" class="chart-board ">
                <div class="row flex-row flex-nowrap">
                    <div class="col-xl-8 col-lg-12 col-md-12 dashbord-home dashbord-home-cart active">
                        <div class="content">
                            @foreach ($promotions as $promotion)
                                <div class="order-content my-2">
                                <div class="card-body">
                                    <div class="promotion_text-cololr d-flex justify-content-between">
                                        <span class="promotion_code-{{$promotion->promotion_id}}">{{$promotion->promotion_code}}</span><i class="data_feather_copy"
                                            data-feather="copy" data-promotion-code-id="{{$promotion->promotion_id}}"></i>
                                    </div>
                                    <span>{{$promotion->promotion_name}}</span>
                                </div>
                                <div class="card-footer bg-white promotion_b-redi">
                                    <span>{{$promotion->promotion_details ?? "No datails"}}</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="overlay"></div>
                    @include('customer-layouts.right-sidebar')
                </div>
            </div>
        </div>
    </section>
@endsection 

@section('scripts')

<script>
    $(function(){
        $('.data_feather_copy').click(function(){
            var copyText = $('.promotion_code-'+$(this).data('promotion-code-id'));
            copyText.select();
            navigator.clipboard.writeText(copyText.value);

            alert("Copied the text: " + copyText.value);
        });
    });
</script>

@endsection
