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
          <h2>Edit Feedback</h2>
          </div>
        </div>
      </div>
    </nav>
  </div>

  <div class="add-category Promotion dashboard content-wrapper category">
    <div class="container-fluid p-0">
      <div class="feedback-form">
        {{ Form::open(array('route' => array('edit.feedback.post'),'id'=>'feedbackForm','method'=>'POST','files'=>'true',
        'class'=>'')) }}
        <div class="content text-center pb-4">
          <h3>Send Us Your Feedback</h3>
          <p>Do You have a Feature Request or App Error,General Feedback ?,let us know in the field bellow.</p>
        </div>
        <input type="hidden" name="hidden_id" value="{{$feedbackRecords->id}}">

        <div class="form-group">            
          <input type="text" id="name" name="name" value="{{$feedbackRecords->name}}" class="form-control"
          placeholder="Enter feedback name" />
        </div>
        <div class="form-group">            
          <input type="text" id="email" name="email" value={{$feedbackRecords->email}} class="form-control"
          placeholder="Enter feedback email" />
        </div>
        <div class="form-group">            
          <input type="text" id="phone" name="phone" value="{{$feedbackRecords->phone}}" class="form-control"
          placeholder="Enter feedback phone" />
        </div>
        <div class="form-group select-input">             
          <select type="text" class="form-control" name="feedback_type" placeholder="General Feedback">
            <option value="" disabled selected>Select feedback type</option>
            <option value="General Feedback" @if($feedbackRecords->feedback_type==='General Feedback') selected @endif>General Feedback</option>
            <option value="Feature Request" @if($feedbackRecords->feedback_type==='Feature Request') selected @endif>Ideas</option>
            <option value="App Error" @if($feedbackRecords->feedback_type==='App Error') selected @endif>App Error</option>
          </select>
        </div>


     
        {{-- <div class="form-group select-input">             
          <select type="text" class="form-control" name="feedback_report" placeholder="feedback report">
            <option value="{{$feedbackRecords->feedback_report}}" selected="">{{$feedbackRecords->feedback_report}}</option>
            <option value="Excellent">Excellent</option>
            <option value="Good">Good</option>
            <option value="Bad">Bad</option>
          </select>
        </div> --}}
        <div class="form-group">            
          <textarea type="text" id="suggestion" name="suggestion" class="form-control"
          placeholder="Enter feedback suggestion">{{$feedbackRecords->suggestion}}</textarea>
        </div>

    </div>
    <div class="form-group m-4">
      <div class="btn-custom">
        <button class="btn-blue"><span>Update Feedback</span></button>
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