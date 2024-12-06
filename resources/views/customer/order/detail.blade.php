@extends('customer-layouts.app')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('assets/customer/css/promotion_page.css')}}">
@endsection

@section('content')
    <section class="dash-body-ar wd-dr-dash-inner">
        <div class="wrp-ar-nav-body">
            @include('customer-layouts.navbar')
            <div id="chatdesk" class="chart-board ">
                @include('customer.messages') 
                <div class="row">
                    <div class="col-xl-8 col-lg-12 col-md-12">
                        <div class="content ">
                            <div class="order-content">
                                <div class="order-jumbotron">
                                    @if ($order->order_progress_status == Config::get('constants.ORDER_STATUS.PREPARED') || $order->order_progress_status == Config::get('constants.ORDER_STATUS.COMPLETED') || $order->order_progress_status == Config::get('constants.ORDER_STATUS.CANCEL'))
                                        <div class="row order-heading">
                                            <div class="col-md-4 order-detail-heading">
                                                <ul class="m-0">
                                                    <li>
                                                        <h3>{{ $order->order_number }}</h3>
                                                    </li>
                                                </ul>
                                                <label class="order-accepted">Order
                                                    {{ $order->order_progress_status }}</label>
                                            </div>
                                            <div class="col-md-4 order-detail-date text-right">
                                                <label class="order-lable">Order Date/Time</label>
                                                <h3 class="order-min">
                                                    {{ \Carbon\Carbon::parse($order->order_date)->format('M d') }}</h3>
                                            </div>
                                        </div>
                                    @else
                                        <div class="row order-heading">
                                            <div class="col-md-4 order-detail-heading">
                                                {{-- <ul class="m-0"> --}}
                                                    {{-- <li> --}}
                                                        <label>{{ $order->order_number }}</label>
                                                    {{-- </li> --}}
                                                {{-- </ul> --}}
                                                <h3 class="order-accepted">ORDER
                                                    {{ $order->order_progress_status }}</h3>
                                            </div>
                                            <div class="col-md-4 order-detail-pickup">
                                                <label class="order-lable">Pickup Time</label>
                                                @if ($order->isPickUp == 1)
                                                    <h3 class="order-min">{{ $order->pickup_time }}</h3>
                                                @else
                                                    <h3 class="order-min">00:00</h3>
                                                @endif
                                            </div>
                                            <div class="col-md-4 order-detail-date text-right">
                                                <label class="order-lable">Order Date/Time</label>
                                                <h3 class="order-min">
                                                    {{ \Carbon\Carbon::parse($order->order_date)->format('M d') }},{{ $order->order_time }}
                                                </h3>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="row order-detail">
                                        <div class="col-lg-9 order-border-t" id="style-1">
                                            @foreach ($order->orderItems as $item)
                                                <div class="media order-detail-item">
                                                    <div class="media-left">
                                                        <a href="#" alt="Food">
                                                            @foreach ($item->menuItems as $menu)
                                                                <img src="{{ $menu->getMenuImgAttribute() }}"
                                                                    class="img-fluid media-object">
                                                            @endforeach
                                                        </a>
                                                    </div>
                                                    <div class="media-t-blog-inner">
                                                        <div class="media-body">
                                                            <h3 class="media-heading">{{ $item->menu_name }}</h3>
                                                            <ul>
                                                                @foreach ($orderMenuGroups as $modifierGroup)
                                                                    @if ($modifierGroup->menu_id == $item->menu_id)
                                                                        @php
                                                                            $groupItem = implode(',', $groupIteamArray[$item->menu_id][$modifierGroup->order_modifier_group_id]);
                                                                        @endphp
                                                                        <li>
                                                                            {{ $modifierGroup->modifier_group_name }} :
                                                                            {{ $groupItem }}
                                                                        </li>
                                                                    @endif
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                        <div class="media-footer">
                                                            <div class="price_count">
                                                                <h3>${{ $item->menu_price }}<span
                                                                        class="item-count">&nbsp; X
                                                                        &nbsp;{{ $item->menu_qty }}</span>
                                                                </h3>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                        <div class="col-lg-3 col-md-inner-first">
                                            <div class="order-border-left order-detail-left">
                                                <div class="d-flex align-items-center justify-content-between w-100 mb-2">
                                                    <span class="cart-charges">
                                                        Cart Charges
                                                    </span>
                                                    <span class="charges-price">
                                                        ${{ $order->cart_charge }}
                                                    </span>

                                                </div>
                                                <div class="d-flex align-items-center justify-content-between w-100 mb-2">
                                                    <span class="cart-charges">
                                                        Delivery Charges
                                                    </span>
                                                    <span class="charges-price">
                                                        ${{ $order->delivery_charge }}
                                                    </span>
                                                </div>
                                                <div class="d-flex align-items-center justify-content-between w-100 mb-2">
                                                    <span class="cart-charges">
                                                     Sales Tax
                                                    </span>
                                                    <span class="charges-price">
                                                        +${{ $order->sales_tax }}
                                                    </span>
                                                </div>
                                                <div class="d-flex align-items-center justify-content-between w-100 mb-2">
                                                    <span class="cart-charges total_disc">
                                                        Total Discount
                                                    </span>
                                                    <span class="charges-price total_disc">
                                                        {{$order->discount_charge}}
                                                    </span>
                                                </div>
                                                <div class="d-flex align-items-center justify-content-between w-100 mb-2">
                                                    <span class="cart-charges">
                                                        Grand Total
                                                    </span>
                                                    <span class="charges-price">
                                                        ${{ $order->grand_total }}
                                                    </span>
                                                </div>
                                                <button type="button" class="btn btn-total-amount"
                                                    alt="Total Amount Payable">
                                                    <h4>${{ $order->grand_total }}</h4>
                                                    Total Amount Payable
                                                </button>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Button trigger modal -->
                            </div>
                        </div>
                    </div>
                    @include('customer-layouts.right-sidebar')
                </div>
            </div>
        </div>
    </section>
@endsection
