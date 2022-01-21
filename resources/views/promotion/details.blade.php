@extends('layouts.app')
@section('content')
 <section id="wrapper">
    @include('layouts.sidebar')
    <div id="navbar-wrapper">
      <nav class="navbar navbar-inverse">
        <div class="container-fluid">
          <div class="navbar-header">
            <div class="profile-title-new">
            <a href="javaScript:void(0);" class="navbar-brand" id="sidebar-toggle"><i class="fa fa-bars"></i></a>
            <h2>Promotion / Add</h2>
            </div>
            <div class="plus">
            <a href="{{route('promotion.add')}}" ><i class="fa fa-plus" aria-hidden="true"></i></a>
            </div>
          </div>
        </div>
      </nav>
    </div>
    <div class="dashboard category content-wrapper">
      <div class="dashboard orders content-wrapper">
        <div class="container-fluid">
          <div class="general-container">
          <h2>{{$promotion->promotion_code}}</h2>
            <div class="text">
              <p>{{$promotion->promotion_name}}</p>
              <ul class="ammount">
                <li>Minimum Discont Ammount : $ {{$promotion->discount_type}}</li>
                <li>Minimum Billing Ammount   : $ {{$promotion->discount_type}}</li>
                <li>Discont Percentage : {{$promotion->discount}}%</li>
                <li>Discount Ammount  :  - </li>
              </ul>
              <h2>Description</h2>
              <p>{{$promotion->promotion_details}}</p> 
              <div class="btn-custom inline">
              <a class="btn-blue"  href="{{route('promotion.edit',[$promotion->promotion_id])}}"><span>Edit</span></a>
                <a class="btn-blue delete" href="javascript:void(0);" data-route="{{route('promotion.delete',[$promotion->promotion_id])}}"><span>Delete</span></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
     </section>
@endsection
@section('scripts')
<script src="{{asset('/assets/js/promotion.js')}}"></script>    
@endsection