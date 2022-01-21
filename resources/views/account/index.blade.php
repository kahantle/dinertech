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
          <h2>Account</h2>
          </div>
        </div>
      </div>
    </nav>
  </div>

  <div class="acoount content-wrapper">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-6">
          <div class="panel-group" id="accordionMenu" role="tablist" aria-multiselectable="true">
            <div class="panel panel-default">
              <div class="panel-heading" role="tab" id="headingOne">
                <h4 class="panel-title">
                  <a  aria-expanded="false" href="{{route('report')}}" >
                    Reports
                  </a>
                </h4>
              </div>
           
            </div>
            <div class="panel panel-default">
              <div class="panel-heading" role="tab" id="headingTwo">
                <h4 class="panel-title">
                  <a role="button" aria-expanded="false" href="{{route('hours')}}" >
                    Hours of operations 
                  </a>
                </h4>
              </div>

            </div>
            <div class="panel panel-default">
              <div class="panel-heading" role="tab" id="headingThree">
                <h4 class="panel-title">
                  <a role="button"   href="{{route('contact')}}" aria-expanded="false" aria-controls="collapseThree">
                    Contact Us
                  </a>
                </h4>
              </div>
        
            </div> 
          </div>
        </div>
        <div class="col-md-6">
          <div class="switches">
            <div class="checkbox switcher">
              <label for="is_app_notification">
                <div class="title">
                  <p>Enable Pin Protected</p>
                </div>
                <div class="switch-btn">
                  <input type="checkbox" class="makeCallNotificationUpdate" id="is_app_notification" 
                  data-type="Pin" value="{{$restaurant->is_pinprotected}}"
                  @if($restaurant->is_pinprotected)? checked @endif>
                  <span><small></small></span>
                </div>
              </label>
            </div>
            <div class="checkbox switcher">
              <label for="is_chat_notification">
                <div class="title">
                  <p>App Notification</p>
                </div>
                <div class="switch-btn">
                  <input type="checkbox" class="makeCallNotificationUpdate" id="is_chat_notification" 
                  data-type="chat" value="{{$user->chat_notifications}}"  
                  @if($user->chat_notifications)? checked @endif>
                  <span><small></small></span>
                </div>
              </label>
            </div>
            <div class="checkbox switcher">
              <label for="is_location_tracking">
                <div class="title">
                  <p>Accepting Online Orders</p>
                </div>
                <div class="switch-btn">
                  <input type="checkbox" class="makeCallNotificationUpdate" id="is_location_tracking" 
                  data-type="location" value="{{$user->location_tracking}}" 
                  @if($user->location_tracking)? checked @endif>
                  <span><small></small></span>
                </div>
              </label>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
@section('scripts')
<script>
  var url = "{{route('update-account-settings')}}";
  var pin_route = "{{route('pin.index')}}";
</script>  
<script src="{{asset('/assets/js/account.js')}}"></script>  
@endsection