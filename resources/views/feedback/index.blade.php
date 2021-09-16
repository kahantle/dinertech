@extends('layouts.app')
@section('content')
<section id="wrapper">
  @include('layouts.sidebar')

  <div id="navbar-wrapper">
    <nav class="navbar navbar-inverse">
      <div class="container-fluid">
        <div class="navbar-header">
          <a href="#" class="navbar-brand" id="sidebar-toggle"><i class="fa fa-bars"></i></a>
          <h2>Feedbacks</h2>
        </div>
        <div class="plus">
          <a href="{{route('feedback.add')}}" ><i class="fa fa-plus" aria-hidden="true"></i></a>
        </div>
      </div>
    </nav>
  </div>
  <div class="dashboard orders content-wrapper">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="orderss">
            <div class="orders">
              @foreach($feedbackRecords as $feedbackRecord)
              <div class="order">
                <div class="">
                  <p>{{$feedbackRecord->name}}</p>
                </div>
                <div class="order-detail">
                  <div class="time">
                    <p>{{$feedbackRecord->feedback_type}}</p>
                  </div>
                  <div class="order-icons ">
                    <a class="action-edit" href="{{route('feedback.edit',$feedbackRecord->id)}}"><i class="fa fa-pencil" aria-hidden="true"></i> </a>
                    <a href="javaScript:Void(0);" class="delete action-delete" data-route="{{route('feedback.delete',$feedbackRecord->id)}}"><i class="fa fa-trash" aria-hidden="true"></i></a>
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
<script src="{{asset('/assets/js/feedback.js')}}"></script> 
@endsection