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
                                    <span>{{$promotion->promotion_details ?? "No details"}}</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="overlay"></div>
                    
                    @if (!isMobile())
                        @include('customer-layouts.right-sidebar')
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')

<script>

    $(function(){
        $('.data_feather_copy').click(function(){

            var dynamicId = $(this).data('promotion-code-id');
            var copyText = $('.promotion_code-'+dynamicId).html();
            // var copyText = $('.promotion_code-'+$(this).data('promotion-code-id'));

            var temp = $("<input>");
            $("body").append(temp);
            temp.val(copyText).select();
            document.execCommand("copy");
            temp.remove();

            // copyText.value = copyText.html();
            // copyText.focus();
            // copyText.select();

            // try {
            //     document.execCommand('copy');
            // } catch (err) {
            //     console.error('Unable to copy to clipboard', err);
            // }

            alert("Copied the text: " + copyText);
        });
    });
</script>

@endsection
