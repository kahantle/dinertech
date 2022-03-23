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
          <h2>Hours</h2>
          </div>
          <div class="plus">
          <a href="{{route('add.hours')}}" ><i class="fa fa-plus" aria-hidden="true"></i></a>
        </div>
        </div>
      </div>
    </nav>
  </div>
  <div class="dashboard orders content-wrapper">
    @include('common.flashMessage')
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="orderss">
            <div class="orders">
            @foreach($hoursdata as $data)
              <div class="order red">
                <div class="order-name">
                  <h4>{{$data->groupDays}}</h4>
                </div>
                <div class="order-detail">
                  <div class="time">
                    <p>{{date("h:i:a",strtotime($data->opening_time))}} - {{date("h:i:a",strtotime($data->closing_time))}}</p>
                  </div>
                  <div class="order-icons">
                    <a class="action-edit" href="{{route('edit.hour',$data->hours_group_id)}}">
                      <i class="fa fa-pencil" aria-hidden="true"></i>
                    </a>
                    <a class="action-delete delete" href="javaScript:void(0);"  data-route="{{route('delete.hour.post',$data->hours_group_id)}}">
                      <i class="fa fa-trash" aria-hidden="true"></i>
                    </a>
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
</section>
@endsection
@section('scripts') 
<script src="{{asset('/assets/js/hours.js')}}"></script> 
@endsection