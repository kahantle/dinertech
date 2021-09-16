@extends('layouts.app')
@section('content')
<section id="wrapper">
@include('layouts.sidebar')
<div id="navbar-wrapper">
        <nav class="navbar navbar-inverse">
          <div class="container-fluid">
            <div class="navbar-header">
              <a href="#" class="navbar-brand" id="sidebar-toggle"><i class="fa fa-bars"></i></a>
              <h2>Order Details</h2>
              <div class="right-side-nav">
                @if($order->pickup_time)
                <p>Pickup Time</p>
                <div class="time">
                  <a href="#popup-menu">{{$order->pickup_time}} minutes</a>
                </div>
                @endif
                <div class="messenger">
                <a href="{{route('chat',['order_id'=>$order->order_id])}}"><img src="{{ asset('assets/images/messenger.png') }}" class="img-fluid"></a>
              </div>
              <div class="type">
                <a href="javaScript:void(0);" onclick="printJS('{{route('order.pdf',$order->order_id)}}')"><img src="{{ asset('assets/images/type-v.png') }}" class="img-fluid"></a>
              </div>
              </div>
            </div>
          </div>
        </nav>
      </div>
      <div class="menu content-wrapper">
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-4 p-0">
              <div class="order-content">
                @if($order->order_status == 1)
                <div class="o-name  {{($order->order_status==1) ? 'yellow' : ''}}  {{($order->order_status==0) ? 'red' : ''}} ">
                  <h4>{{$userdata->full_name}}</h4>
                  <p>Date & Time : {{date("m/d/Y",strtotime($order->created_at))}} {{date("H:i a",strtotime($order->created_at))}}</p>
                  <p>Order Number : {{$order->order_number}}</p>

                </div>
                @elseif($order->order_status === 0)
                  <div class="o-name">
                  <h4>{{$userdata->full_name}}</h4>
                  <p>Date & Time : {{date("m/d/Y",strtotime($order->created_at))}} {{date("H:i a",strtotime($order->created_at))}}</p>
                  <p>Order Number : {{$order->order_number}}</p>
                </div>
                @else
                <div class="o-name">
                  <h4>{{$userdata->full_name}}</h4>
                  <p>Date & Time : {{date("m/d/Y",strtotime($order->created_at))}} {{date("H:i a",strtotime($order->created_at))}}</p>
                  <p>Order Number : {{$order->order_number}}</p>
                </div>
                @endif
                <div class="o-address">
                  <h5>Address</h5>
                  <p>{{$orderAddress->address}}</p>
                  <h5>Mobile Number</h5>
                  <p><a href="tel:{{$userdata->mobile_number}}">{{$userdata->mobile_number}}</a></p>
                  <h5>Email</h5>
                  <p><a href="mailto:{{$userdata->email_id}}">{{$userdata->email_id}}</a></p>
                </div>
                <div class="charges">
                  <h5>Charges</h5>
                  <div class="charges-text">
                    <ul>
                      <li>
                        <p>Subtotal</p>  
                        <p>${{$order->cart_charge}}</p>
                      </li>
                      <li>
                        <p>Delivery Charges</p>  
                        <p>${{$order->delivery_charge}}</p>
                      </li>
                      <li class="green">
                        <p>Total Discount</p>  
                        <p>${{$order->discount_charge}}</p>
                      </li>
                      <li >
                        <p>Tax</p>  
                        <p>$0</p>
                      </li>
                      <li class="total">
                        <p><b>Grand Total</b></p>
                        <p><b>${{$order->grand_total}}</b></p>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-8">
              <div class="order-detail-card">
                @foreach($order->orderItems as $items)
                <div class="odc">
                  <div class="image">
                    <img src="{{ asset('assets/images/mi-3.png') }}" class="img-fluid">
                  </div>
                  <div class="text">
                    <h6>{{$items->menu_name}}</h6>
                    <p><span>${{$items->menu_total}} </span> X {{$items->menu_qty}}</p>
                     @foreach($items->orderModifierItems as $modifier)
                    <ul>
                      <li>
                        <p>{{$modifier->modifier_group_item_name}}</p>

                        <p>${{ number_format((float)$items->modifier_total, 2, '.', '') }}</p>
                      </li>
                    </ul>
                    @endforeach
                  </div>
                </div>
                @endforeach
                @if($order->order_progress_status == 'INITIAL')
                <div class="three-btn">
                  <div class="btn-custom row col-sm-4">
                    <a class="btn-green action"  href="javaScript:Void(0);" 
                    data-route="{{route('action.order',[$order->order_id,'action'=>'ACCEPTED'])}}" data-value="Accept"><span>accept order</span></a>
                  </div>
                  <div class="btn-custom row col-sm-4">
                    <a class="btn-red action"  href="javaScript:Void(0);" 
                    data-route="{{route('action.order',[$order->order_id,'action'=>'CANCEL'])}}" data-value="Decline"><span>decline order</span></a>
                  </div>
                </div>
                @elseif($order->order_progress_status == 'ACCEPTED')
                <div class="three-btn">
                  <div class="btn-custom row  col-sm-4">
                    <a class="btn-orange action"  href="javaScript:Void(0);" 
                    data-route="{{route('action.order',[$order->order_id,'action'=>'PREPARED'])}}" data-value="Prepare"><span>prepared order</span></a>
                  </div>
                </div>
              </div>
                 @elseif($order->order_progress_status == 'PREPARED')
                <div class="three-btn">
                  <div class="btn-custom row col-sm-4">
                    <a class="btn-orange action"   data-toggle="tooltip" title="Pick-up order"  
                    data-route="{{route('action.order',[$order->order_id,'action'=>'COMPLETED'])}}" 
                    class="grey-border action" 
                    data-value="pickup"><span>Pick up</span></a>
                  </div>
                </div>
                @endif
              </div>
            </div>
          </div>
          </div>
      </div>
</section>
<div id="openTimePicker" class="openTimePickerPopUp closeAllModal overlay w-100">
  <div class="popup text-center">
    <a class="close closeModal" href="javaScript:Void(0);">&times;</a>
    <div class="content">
      <h5 class="groupHeading">Pickup Time</h5>
      {{ Form::open(array('id'=>'orderTimePickup','method'=>'POST','class'=>'')) }}
        <div class="form-group row">                
          <select class="form-control sltDuration col-lg-6" id="sltDuration" name="sltDuration" >
            <option>Duration</option>
            @for ($i=1; $i<=60; $i++)
            <option value="{{$i}}">{{$i}}</option>
             @endfor
          </select>
          <select class="form-control sltMinutes col-lg-6" id="sltMinutes" class="sltMinutes">
            <option value="minutes">Mintues</option>
            <option value="hours">Hours</option>
          </select>
          <input type="hidden" id="actionUrl" name="actionUrl" class="actionUrl" />
        </div>
      <div class="btn-custom">
        <a class="groupBtn acceptOrder btn-blue makeActionRequest"><span>Order Accept</span></a>
      </div>
    </form>
    </div>
  </div>
</div>
@endsection
@section('scripts')
<script src="{{asset('/assets/js/order.js')}}"></script>   
@endsection