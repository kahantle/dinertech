@extends('layouts.app')
@section('content')
    <style type="text/css">
        .disabled {
            opacity: 0.2;
        }

    </style>
    <section id="wrapper">
        @include('layouts.sidebar')
        <div id="navbar-wrapper">
            <nav class="navbar navbar-inverse">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <div class="profile-title-new">
                            <a href="#" class="navbar-brand" id="sidebar-toggle"><i class="fa fa-bars"></i></a>
                            <h2>Recent Orders</h2>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
        <div class="dashboard content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        @if ($orders)
                            <div class="orders order-blogs-inner">
                                @foreach ($orders as $key => $order)
                                    <div class="order {{ $order->order_status == 1 ? 'yellow' : '' }} ">
                                        <div class="order-name">
                                            <h4>{{ $order->user->full_name }}</h4>
                                            <span>Order Number :#{{ $order->order_number }}</span>
                                        </div>
                                        <div class="order-detail order-t-inner-blog">
                                            <div class="time">
                                                @if ($order->pickup_time)
                                                    <span class="btn">{{ $order->pickup_time }}</span>
                                                @endif
                                                <span title="Pick-up order" class="grey-border">Pick-up</span>
                                                @if ($order->order_progress_status === 'ACCEPTED')
                                                    <a href="javaScript:void(0);" class="grey-border action"
                                                        data-toggle="tooltip" title="Prepare order!"
                                                        data-route="{{ route('action.order', [$order->order_id, 'action' => 'PREPARED']) }}"
                                                        data-value="prepared">Prepare order</a>
                                                @else
                                                    <a href="javaScript:void(0);" class="grey-border disabled"
                                                        title="Prepare order!">Prepare order</a>
                                                @endif
                                            </div>
                                            <div class="order-icons">
                                                @if ($order->order_status == '')
                                                    <a href="{{ route('chat', ['order_id' => $order->order_number]) }}"
                                                        class="disabled"><img
                                                            src="{{ asset('images/message.png') }}"
                                                            class="img-fluid icon"></a>
                                                @else
                                                    <a href="{{ route('chat', ['order_id' => $order->order_number]) }}"><img
                                                            src="{{ asset('images/message.png') }}"
                                                            class="img-fluid icon"></a>
                                                @endif
                                                @if ($order->order_status == '')
                                                    <a href="javaScript:void(0);" data-toggle="tooltip"
                                                        title="Accept Order!"
                                                        data-route="{{ route('action.order', [$order->order_id, 'action' => 'ACCEPTED']) }}"
                                                        class="action" data-value="Accept">
                                                        <img src="{{ asset('images/check.png') }}"
                                                            class="img-fluid icon">
                                                    </a>
                                                @else
                                                    <a href="javaScript:void(0);" data-toggle="tooltip"
                                                        title="Accept Order!" class="disabled"><img
                                                            src="{{ asset('images/check.png') }}"
                                                            class="img-fluid icon"></a>
                                                @endif
                                                @if ($order->order_status == '')
                                                    <a href="javaScript:void(0);" data-toggle="tooltip"
                                                        title="Decline Order!"
                                                        data-route="{{ route('action.order', [$order->order_id, 'action' => 'CANCEL']) }}"
                                                        class="action" data-value="Cancel"><img
                                                            src="{{ asset('images/close.png') }}"
                                                            class="img-fluid icon"></a>
                                                @else
                                                    <a href="javaScript:void(0);" data-toggle="tooltip"
                                                        title="Decline Order!" class="disabled"><img
                                                            src="{{ asset('images/close.png') }}"
                                                            class="img-fluid icon"></a>
                                                @endif
                                                @if ($order->order_progress_status === 'ACCEPTED')
                                                    <a href="javaScript:void(0);"
                                                        onclick="printJS('{{ route('order.pdf', $order->order_id) }}')"
                                                        data-toggle="tooltip" title="Print Order Receipt!"
                                                        class=""><img src="{{ asset('images/type.png') }}"
                                                            class="img-fluid icon"></a>
                                                @else
                                                    <a href="javaScript:void(0);" data-toggle="tooltip"
                                                        title="Print Order Receipt!" class="disabled"><img
                                                            src="{{ asset('images/type.png') }}"
                                                            class="img-fluid icon"></a>
                                                @endif
                                            </div>
                                            <div class="detail">
                                                <a href="{{ route('details', $order->order_id) }}" data-toggle="tooltip"
                                                    title="Order details!" class="grey-border">details</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                <div class="w-100 pagination-links"> {{ $orders->links() }}</div>
                            @else
                                <p>No records found.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
    <div id="openTimePicker" class="openTimePickerPopUp closeAllModal overlay w-100">
        <div class="popup text-center">
            {{ Form::open(['id' => 'orderTimePickup', 'method' => 'POST', 'class' => '']) }}
            <a class="close closeModal" href="javaScript:void(0);">&times;</a>
            <div class="content">
                <h5 class="groupHeading">Pickup Time</h5>
                <div class="row m-0">
                    <div class="form-group  col-lg-6">
                        <select class="form-control sltDuration " id="sltDuration" name="sltDuration">
                            <option value="">Duration</option>
                            @for ($i = 1; $i <= 60; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="form-group  col-lg-6">
                        <select class="form-control sltMinutes " id="sltMinutes" name="sltMinutes">
                            <option value="">Type</option>
                            <option value="minutes">Mintues</option>
                            <option value="hours">Hours</option>
                        </select>
                        <input type="hidden" id="actionUrl" name="actionUrl" class="actionUrl" />
                    </div>
                </div>
            </div>
            <div class="btn-custom">
                <button class="groupBtn acceptOrder btn-blue"><span>Order Accept</span></button>
            </div>
            </form>
        </div>
    </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
    <script src="{{ asset('/assets/js/order.js') }}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\VerifyRequest', '#verifyForm') !!}
    {!! JsValidator::formRequest('App\Http\Requests\PickTimeRequest', '#orderTimePickup') !!}

@endsection
