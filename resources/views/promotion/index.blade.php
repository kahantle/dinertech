@extends('layouts.app')
@section('content')
 <section id="wrapper">
    @include('layouts.sidebar')
    <div id="navbar-wrapper">
        <nav class="navbar navbar-inverse">
          <div class="container-fluid">
            <div class="navbar-header">
              <div class="profile-title-new">
              <a href="#" class="navbar-brand" id="sidebar-toggle"><i class="fa fa-bars"></i></a>
              <h2>Promotions</h2>
              </div>
              <div class="plus">
                <a href="{{route('promotion.type.list')}}" class="fa fa-plus" aria-hidden="true"></a>
              </div>
            </div>
          </div>
        </nav>
      </div>
    <div class="dashboard category content-wrapper">
      <div class="dashboard promotions">
        <div class="container">
          <div class="pro-cards">
              <div class="pro-card title">
                <div class="left-s">
                  <p>status</p>
                  <p>name</p>
                </div>
                <div class="right-s">
                  <p>Coupon</p>
                  <p>Used</p>
                  <p>Created</p>
                  <p>Edit</p>
                </div>
              </div>
              @foreach ($promotion as $key=>$item)
              <div class="pro-card detail ">
                <div class="left-s">
                  <div class="checkbox switcher">
                    <label for="{{$key}}">
                      <div class="switch-btn">
                        <input type="checkbox" class="changeStatus" data-id="{{$item->promotion_id}}" id="{{$key}}" value="" {{$item->status=='ACTIVE' ? 'checked' : ''}}>
                        <span><small></small></span>
                      </div>
                    </label>
                  </div>
                  <p>{{$item->promotion_type->promotion_name ?? ''}}</p>
                </div>
                <div class="right-s">
                  <p>{{($item->promotion_code?$item->promotion_code:"-")}}</p>

                  <p>{{($item->promotion_used)?$item->promotion_used:"-"}}</p>
                  <p>{{$item->created_at}}</p>
                  <div class="category">
                    <div class="order-detail">
                      <div class="order-icons cat">
                        @if($item->promotion_type_id==1)
                        <a href="{{route('promotion.edit.cart.post',[$item->promotion_id,$item->promotion_type_id])}}"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                        @elseif($item->promotion_type_id==2)
                        <a href="{{route('promotion.edit.select.item',[$item->promotion_id,$item->promotion_type_id])}}"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                        @elseif($item->promotion_type_id==3)
                        <a href="{{route('promotion.edit.free.post',[$item->promotion_id,$item->promotion_type_id])}}"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                        @elseif($item->promotion_type_id==4)
                        <a href="{{route('promotion.edit.paymentmethod.post',[$item->promotion_id,$item->promotion_type_id])}}"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                        @elseif($item->promotion_type_id==5)
                        <a href="{{route('promotion.edit.free.item',[$item->promotion_id,$item->promotion_type_id])}}"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                        @elseif($item->promotion_type_id==6)
                        <a href="{{route('promotion.edit.getonefree.item',[$item->promotion_id,$item->promotion_type_id])}}"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                        @elseif($item->promotion_type_id==7)
                        <a href="{{route('promotion.edit.mealbundle.item',[$item->promotion_id,$item->promotion_type_id])}}"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                        @elseif($item->promotion_type_id==8)
                        <a href="{{route('promotion.edit.buytwothree.item',[$item->promotion_id,$item->promotion_type_id])}}"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                        @elseif($item->promotion_type_id==9)
                        <a href="{{route('promotion.edit.fixeddiscount.item',[$item->promotion_id,$item->promotion_type_id])}}"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                        @elseif($item->promotion_type_id==10)
                        <a href="{{route('promotion.edit.discountcombo.item',[$item->promotion_id,$item->promotion_type_id])}}"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                      @endif
                        <a href="javascript:void(0);" data-id="{{$item->promotion_id}}" class="delete"><i class="fa fa-trash"   aria-hidden="true"></i></a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              @endforeach
              <div class="float-right"> {{ $promotion->links('vendor.pagination.bootstrap-4') }}</div>
            </div>
          </div>
        </div>
    </section>
@endsection
@section('scripts')
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
<script src="{{asset('/assets/js/promotion.js')}}"></script>
@endsection
