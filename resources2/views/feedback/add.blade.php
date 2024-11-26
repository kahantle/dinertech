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
          <h2>Feedback</h2>
          </div>
        </div>
      </div>
    </nav>
  </div>

  <div class="add-category Promotion dashboard content-wrapper category">
    <div class="container-fluid p-0">
      @include('common.flashMessage')

      <div class="feedback-form">
        {{ Form::open(array('route' => array('add.feedback.post'),'id'=>'feedbackForm','method'=>'POST','files'=>'true',
        'class'=>'')) }}
        <div class="content text-center pb-4">
          <h3>Send Us Your Feedback</h3>
          <p>Do You have a Feature Request, App Error or General Feedback? Let us know!</p>
        </div>
        <div class="form-group">            
          <input type="text" id="name" name="name" value="{{$user->first_name}} {{$user->last_name}}" class="form-control"
          placeholder="Enter feedback name" />
        </div>
        <div class="form-group">            
          <input type="text" id="email" name="email" value="{{$user->email_id}}" class="form-control"
          placeholder="Enter feedback email" />
        </div>
        <div class="form-group">            
          <input type="text" id="phone" name="phone" value="{{$user->mobile_number}}" class="form-control"
          placeholder="Enter feedback phone" />
        </div>
        <div class="form-group select-input">             
          <select type="text" class="form-control" name="feedback_type" placeholder="General Feedback">
            <option value="" disabled selected>Select feedback type</option>
            <option value="General Feedback">General Feedback</option>
            <option value="Feature Request">Ideas</option>
            <option value="App Error">App Error</option>
          </select>
        </div>
        {{-- <div class="form-group select-input">             
          <select type="text" class="form-control" name="feedback_report" placeholder="feedback report">
            <option value="" disabled selected="">Select feedback report</option>
            <option value="Excellent">Excellent</option>
            <option value="Good">Good</option>
            <option value="Bad">Bad</option>
          </select>
        </div> --}}
        <div class="form-group">            
          <textarea type="text" id="suggestion" name="suggestion" class="form-control"
          placeholder="Enter feedback suggestion"></textarea>
        </div>

    </div>
    <div class="form-group m-4">
      <div class="btn-custom">
        <button class="btn-blue"><span>Send Feedback</span></button>
      </div>
    </div>
    </form>
  </div>
</div>

</section>
@endsection
@section('scripts')
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
{!! JsValidator::formRequest('App\Http\Requests\FeedbackRequest','#feedbackForm'); !!} 
@endsection