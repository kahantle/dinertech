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

  {{-- <div class="acoount content-wrapper">
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
                  <a role="button" href="{{route('contact')}}" aria-expanded="false" aria-controls="collapseThree">
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
  </div> --}}
  <div class="acoount content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="panel-group" id="accordionMenu" role="tablist" aria-multiselectable="true">
                    <div class="panel panel-default">
                        <div class="panel-heading panle-heading-inner active" role="tab" id="headingOne">
                            <h4 class="panel-title">
                                <a aria-expanded="false" href="#" class="active">
                                    General Settings
                                    <i class="arrow-right-heavy-orange">Right</i>
                                </a>
                            </h4>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading panle-heading-inner" role="tab" id="headingTwo">
                            <h4 class="panel-title">
                                <a role="button" aria-expanded="false" href="{{route('report')}}">
                                    Reports
                                    <i class="arrow-right-heavy-orange">Right</i>
                                </a>
                            </h4>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading panle-heading-inner" role="tab" id="headingThree">
                            <h4 class="panel-title">
                                <a role="button" href="{{route('hours')}}" aria-expanded="false" aria-controls="collapseThree">
                                  Hours of operations
                                  <i class="arrow-right-heavy-orange">Right</i>
                                </a>
                            </h4>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading panle-heading-inner" role="tab" id="headingFour">
                            <h4 class="panel-title">
                                <a role="button" href="{{route('contact')}}" aria-expanded="false" aria-controls="collapseThree">
                                  Contact Us
                                  <i class="arrow-right-heavy-orange">Right</i>
                                </a>
                            </h4>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading panle-heading-inner" role="tab" id="headingFour">
                            <h4 class="panel-title">
                                <a role="button" href="{{route('account.active.subscription')}}" aria-expanded="false" aria-controls="collapseThree">
                                    Subscriptions
                                    <i class="arrow-right-heavy-orange">Right</i>
                                </a>
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 swiches-inner-blog">
                <div class="switches">
                    <h1>General Settings</h1>
                    <h5>System</h5>
                    <div class="checkbox switcher">
                        <label for="is_location_tracking">
                            <div class="title">
                                <p>Online Orderning System (off/on)</p>
                            </div>
                            <div class="switch-btn">
                                    <input type="checkbox" class="makeCallNotificationUpdate" id="is_location_tracking"
                                    data-type="location" value="{{$user->location_tracking}}"
                                    @if($user->location_tracking)? checked @endif>
                                <span><small></small></span>
                            </div>
                        </label>
                        <label for="is_chat_notification">
                            <div class="title">
                                <p>App Notifications (off/on)</p>
                            </div>
                            <div class="switch-btn">
                                <input type="checkbox" class="makeCallNotificationUpdate" id="is_chat_notification"
                                data-type="chat" value="{{$user->chat_notifications}}" @if($user->chat_notifications)? checked @endif>
                                <span><small></small></span>
                            </div>
                        </label>
                        <label for="auto_print_receipts">
                            <div class="title">
                                <p>Automatically Print Receipts When Order Is Accepted (off/on)</p>
                            </div>
                            <div class="switch-btn">
                                <input type="checkbox" class="makeCallNotificationUpdate" id="auto_print_receipts"
                                data-type="receipts" value="{{$restaurant->auto_print_receipts}}" @if($restaurant->auto_print_receipts) ? checked @endif>
                                <span><small></small></span>
                            </div>
                        </label>
                    </div>
                    <h5>Security</h5>
                    <div class="checkbox switcher">
                        <label for="is_app_notification">
                            <div class="title">
                                <p>Enable Account Pin</p>
                            </div>
                            <div class="switch-btn">
                                <input type="checkbox" class="makeCallNotificationUpdate" id="is_app_notification"
                                  data-type="Pin" value="{{$restaurant->is_pinprotected}}"
                                  @if($restaurant->is_pinprotected)? checked @endif>
                                <span><small></small></span>
                            </div>
                        </label>
                    </div>
                    <h5>Tax</h5>
                    <div class="checkbox switcher check-box-trains">
                        <label>
                            <div class="title">
                                <p>Sales Tax Rate</p>
                            </div>
                            <div class="switch-btn d-flex align-items-center justify-content-end">
                                <span class="input-group-text">%</span>
                                <input type="number" max="100" min="0" style="padding: 8px 28px 8px 15px; width: 100%;" value="{{($restaurant->sales_tax) ? $restaurant->sales_tax : ''}}" id="tax-value">
                                <button type="button" id="save-tax" data-type="sales-tax">Save</button>
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
