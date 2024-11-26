@extends('layouts.app')
@section('content')
  <!-- Header Start -->
  <section class="lrForm off-white">
    <div class="container-fluid pl-0">
      <div class="row align-items-center">
        <div class="col-lg-5 col-md-6">
          <div class="left-pattern">
            <div class="logo">
              <a href="#"><img src="{{ asset('images/logo.png') }}" class="img-fluid"></a>
            </div>
            <div class="btm-img">
              <img src="{{ asset('images/mn-img.png') }}" class="img-fluid">
            </div>
          </div>
        </div>

        <div class="col-lg-7 col-md-6">
          @include('common.flashMessage')

          <div class="form-info">
            <h2>Contact Us</h2>
            {{ Form::open(array('route' => array('add.contact.post'),'id'=>'contactForm','method'=>'POST',
            'class'=>'')) }}             
            <div class="form-group">   
                <i class="fa fa-user" aria-hidden="true"></i>           
                <input type="text" id="name" name="name" class="form-control" placeholder="Your Name">
              </div>
              <div class="form-group">   
                <i class="fa fa-laptop" aria-hidden="true"></i>         
                <input type="text" id="subject" name="subject" class="form-control" placeholder="subject">
              </div>
              <div class="form-group">   
                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>  
                <textarea type="text" id="description" name="description" class="form-control" placeholder="Description"></textarea>
              </div>
              <div class="form-group">
                <div class="btn-custom">
                  <input class="btn-blue" type="submit" value="Submit" />
                </div>
              </div>
            </form>
          </div>  
        </div>

      </div>
    </div>
  </section>
@endsection
@section('scripts')
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
{!! JsValidator::formRequest('App\Http\Requests\ContactRequest','#contactForm'); !!} 
@endsection