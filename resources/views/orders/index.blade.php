@extends('layouts.app')
@section('content')
<section id="wrapper">
  @include('layouts.sidebar')
  <div id="navbar-wrapper">
    <nav class="navbar navbar-inverse">
      <div class="container-fluid">
        <div class="navbar-header">
          <a href="#" class="navbar-brand" id="sidebar-toggle"><i class="fa fa-bars"></i></a>
          <h2>Orders</h2>
        </div>
      </div>
    </nav>
  </div>
  <div class="dashboard orders content-wrapper">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <div class="orderss">
            <ul class="nav nav-tabs" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#complete" role="tab">
                  <span>completed orders</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#cancel" role="tab">
                  <span>declined by restaurant</span>
                </a>
              </li>
            </ul>
            <div class="tab-content">
                        <div class="tab-pane active" id="complete" role="tabpanel">
                          <div class="t-c">
                            <div class="orders">
                            @foreach($completedOrders as $key => $order)
                              <div class="order">
                                <div class="order-name">
                                  <h4>{{$order->user->name}}</h4>
                                  <span>Order Number :#{{$order->order_number}}</span>
                                </div>
                                <div class="order-detail">
                                  <div class="time">
                                    <p>{{$order->order_date}}</p>
                                  </div>
                                  <div class="order-icons">
                                    <a href="{{route('order.pdf',$order->order_id)}}"><img src="{{ asset('assets/images/type.png') }}" class="img-fluid icon"></a>
                                  </div>
                                  <div class="detail">
                                    <a href="{{route('details',$order->order_id)}}" class="grey-border">details</a>
                                  </div>
                                </div>
                              </div>
                              @endforeach
                            </div>
                          </div>
                        </div>
                        <div class="tab-pane" id="cancel" role="tabpanel">
                          <div class="t-c">
                            <div class="orders">
                            @foreach($canceldOrders as $key => $order)

                              <div class="order red">
                                <div class="order-name">
                                  <h4>{{$order->user->name}}</h4>
                                  <span>Order Number :#{{$order->order_number}}</span>
                                </div>
                                <div class="order-detail">
                                  <div class="time">
                                    <p>{{$order->order_date}}</p>
                                  </div>
                                  <div class="order-icons">
                                    <a href="{{route('details',$order->order_id)}}"><img src="{{ asset('assets/images/type.png') }}" class="img-fluid icon"></a>
                                  </div>
                                  <div class="detail">
                                    <a href="{{route('details',$order->order_id)}}" class="grey-border">details</a>
                                  </div>
                                </div>
                              </div>
                              @endforeach

                            </div>
                          </div>
                        </div>
         
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
