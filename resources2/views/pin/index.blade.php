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
          <h2>Pin</h2>
          </div>
          <div class="clear reset_form">
            <span>Clear</span>
            <i class="fa fa-repeat reset_form" aria-hidden="true"></i>
          </div>
        </div>
      </div>
    </nav>
  </div>
  {{ Form::open(array('route' => array('promotionType.set_pin'),'id'=>'menuForm','method'=>'POST','class'=>'')) }}

  <div class="dashboard enable-pin">
    <div class="container">
       <div class="form-info pt-lg-5 pt-4">
          <div class="text text-center">
            <div class="code form_pin">
                <p>Enter Password Pin</p>
              <ul>
                <li class="codeblock setPin"><input type="text" id="digit-1" name="digit[1]" data-next="digit-2" class="form-control digit-group-input" ></li>
                <li class="codeblock setPin"><input type="text" id="digit-2" name="digit[2]" data-next="digit-3" data-previous="digit-2" class="form-control digit-group-input" ></li>
                <li class="codeblock setPin"><input type="text" id="digit-3" name="digit[3]" data-next="digit-4" data-previous="digit-3" class="form-control digit-group-input" ></li>
                <li class="codeblock setPin"><input type="text" id="digit-4" name="digit[4]"  data-next="digit-5" data-previous="digit-4" class="form-control digit-group-input" ></li>
              </ul>
            </div>

            <div class="code form_confirm_pin" style="display: none">
                <p>Enter Confirm Password Pin</p>

                <ul>
                  <li class="codeblock setPin"><input type="text" id="digit_confirm_1" name="digit[1]" data-next="digit_confirm_2" class="form-control  digit-group-input" ></li>
                  <li class="codeblock setPin"><input type="text" id="digit_confirm_2" name="digit[2]" data-next="digit_confirm_3" data-previous="digit_confirm_2" class="form-control  digit-group-input" ></li>
                  <li class="codeblock setPin"><input type="text" id="digit_confirm_3" name="digit[3]" data-next="digit_confirm_4" data-previous="digit_confirm_3" class="form-control  digit-group-input" ></li>
                  <li class="codeblock setPin"><input type="text" id="digit_confirm_4" name="digit[4]"  data-next="digit_confirm_5" data-previous="digit_confirm_4" class="form-control  digit-group-input" ></li>
                </ul>
              </div>
          </div>
        </div>  
    </div>
  </div>
</form>

</section>
@endsection
@section('scripts')
<script src="{{ asset('assets/js/common.js')}}"></script>
<script src="{{asset('/assets/js/pin.js')}}"></script>  
<script>
    var pin_route = "{{route('promotionType.set_pin')}}";
    var account_route = "{{route('account')}}";
  </script>  
@endsection