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
          <h2>Select Promotion Type</h2>
          </div>
        </div>
        <div class="plus">
          <a href="{{route('feedback.add')}}" ><i class="fa fa-plus" aria-hidden="true"></i></a>
        </div>
      </div>
    </nav>
  </div>

  <div class="dashboard promotions promotions-type">
        <div class="container">
          <div class="pro-cards">

            @foreach($promotiontype as $item)

            <a href="javascipt:void(0);" class="makeCallNotificationUpdate" data-route="{{route('promotionType.add')}}" data-value="{{$item->promotion_type_id}}" id="{{$item->promotion_type_id}}">
              <div class="pro-card detail">
                <div class="left-s">
                  <div class="checkbox switcher">
                    <img src="{{ asset('assets/images/pt-cart.png') }}" class="img-fluid">
                  </div>
                  <p>{{$item->promotion_name}}</p>
                </div>
                <div class="right-s">
                  <p>{{$item->promotion_details}}</p>
                  @if(in_array($item->promotion_type_id,$promotionTypeData))
                  <p id="fa-check"><i class="fa fa-check" aria-hidden="true"></i></p>
                  @else
                  <p id="fa-check"></i></p>
                  @endif
                </div>
              </div>
              </a>

              @endforeach
            </div>
          </div>
        </div>
</section>
@endsection
@section('scripts') 
<script src="{{asset('/assets/js/promotionType.js')}}"></script> 
@endsection