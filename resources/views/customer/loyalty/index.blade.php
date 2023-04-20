@extends('customer-layouts.app')

@section('content')
    <link rel="stylesheet" type="text/css" href="{{asset('assets/customer/css/promotion_page.css')}}">
    <section class="dash-body-ar wd-dr-dash-inner">
        <div class="wrp-ar-nav-body">
            @include('customer-layouts.navbar')
            <div id="chatdesk" class="chart-board">
                <div class="row flex-row flex-nowrap">
                    <div class="col-xl-8 col-lg-12 col-md-12 dashbord-home dashbord-home-cart active">
                        <div class="content">
                            <div class="wd-hours-method wd-dr-member-program">
                                <div class="text-center wd-dr-member-dinner mt-3">
                                    <i data-feather="gift" class="mb-2"></i>
                                    <p class="mb-1">Dinertech Platinum Member</p>
                                    <h1>{{ $user->total_points }}</h1>
                                    <h5>Avilable Points</h5>
                                </div>
                                @php
                                    $available_points = $user->total_points;
                                @endphp
                                @foreach ($loyalties as $loyaltyRule)
                                    <h6 class="mt-5 mb-3">{{ $loyaltyRule->point }} Points</h6>
                                    <div class="row">

                                        @foreach ($loyaltyRule->rulesItems as $item)
                                            @php
                                                $menuItem = $item->menuItems->first();
                                                $loyaltyPoints = $loyaltyRule->point;
                                                $notEligable = $available_points < $loyaltyPoints;
                                            @endphp


                                            <div class="col-md-4">
                                                <a class="card {{ $notEligable ? 'card-points-blog-inner' : '' }}">
                                                    <div class="card-body p-0">
                                                        <img class="card-img-top" src="{{$menuItem->menu_img}}"
                                                            alt="Card image cap">
                                                        @if ($notEligable)
                                                            <p>Not Eligible</p>
                                                        @endif
                                                    </div>
                                                    <div
                                                        class="card-footer d-flex justify-content-between align-items-center">
                                                        <div class="card-inner-t-inner-blog">
                                                            <h5 class="card-title mb-1">{{$menuItem->item_name}}</h5>
                                                            <p class="card-text">{{ $loyaltyPoints }} Points</p>
                                                        </div>
                                                        <div class="modal-points-left">
                                                            @if (!$notEligable)
                                                                <button type="button" class="modal-add-button toggle addProduct" data-loyaltyRuleId = "{{$loyaltyRule->rules_id}}" data-menuId="{{$menuItem->menu_id}}">Add</button>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
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
        $(function () {

            $(document).on("click", ".addProduct", function () {
                var menuId = $(this).attr("data-menuId");
                var loyaltyRuleId = $(this).attr("data-loyaltyRuleId");
                addToCart({menuId : menuId,loyaltyRuleId : loyaltyRuleId})
            });

            function addToCart(data) {
                $.ajax({
                    type: "POST",
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                    },
                    url: "{{ route('customer.addToCart') }}",
                    data: data,
                    dataType: "html",
                    success: function (response) {
                        if (response) {
                            $(".scroll-inner-blog").load(
                                window.location.href + " .scroll-inner-blog"
                            );
                            $(".content").load(
                                window.location.href + " .content"
                            )
                            $("#checkout").load(window.location.href + " #checkout");
                        }
                    }
                });
            }
        })

    </script>
@endsection
