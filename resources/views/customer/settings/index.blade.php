@extends('customer-layouts.app')

@section('content')
    <link rel="stylesheet" type="text/css" href="{{asset('assets/customer/css/promotion_page.css')}}">

    <section class="dash-body-ar wd-dr-dash-inner">
        <div class="wrp-ar-nav-body">
            @include('customer-layouts.navbar')
            <div id="chatdesk" class="chart-board">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12">
                        <div class="content checkmarrk_setting ">
                            <h3>Notification</h3>
                            <div class="wd-hours-method h-auto my-2 d-flex justify-content-between">
                                <div class="d-flex setting_text-cololr">
                                    <i data-feather="bell"></i>
                                    <span class="mx-2">Order Notification</span>
                                </div>
                                <input type="checkbox" id="switch_Order" onchange="updateSetting('app_setting')" {{ $user->app_notifications == 1 ? 'checked' : "" }} /><label
                                    for="switch_Order">Toggle</label>
                            </div>
                            <div class="wd-hours-method h-auto my-2 d-flex justify-content-between">
                                <div class="d-flex setting_text-cololr">
                                    <i data-feather="message-square"></i>
                                    <span class="mx-2">Chat Notification</span>
                                </div>
                                <input type="checkbox" id="switch_Chat" onchange="updateSetting('chat_setting')" {{ $user->chat_notifications == 1 ? 'checked' : "" }} /><label
                                    for="switch_Chat">Toggle</label>
                            </div>
                            <h3>Location Services</h3>
                            <div class="wd-hours-method h-auto my-2 d-flex justify-content-between">
                                <div class="d-flex setting_text-cololr">
                                    <i data-feather="map-pin"></i>
                                    <span class="mx-2">Location</span>
                                </div>
                                <input type="checkbox" id="switch_Location" onchange="updateSetting('location_setting')" {{ $user->location_tracking == 1 ? 'checked' : "" }} /><label
                                    for="switch_Location">Toggle</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-100" align="center">
                <div class="aco-button-g my-2">
                    <button class="btn d-inline-flex my-2 trigger delete-account">
                        <i class="mx-2" data-feather="trash"></i>
                        Delete Account
                    </button>
                </div>
            </div>
        </div>
    </section>
    <div class="modal-delete">
        <div class="modal-content">
            <div class="woring-icon">
                <div class="woring-icon-content">!</div>
            </div>
            <div class="text-center woring-titel">
                <h2>Are you sure?</h2>
                <p>You won't be able to revert this!</p>
            </div>
            <div class="d-flex justify-content-center mt-3">
                <button class="btn btn-primary trigger-ok close-button-success mx-2">Yes, delete it!</button>
                <button class="btn close-button btn-danger mx-2">Cancel</button>
            </div>
        </div>
    </div>
    <div class="modal-delete-ok">
        <div class="modal-content">
            <div class="woring-icon-ok">
                <div class="woring-icon-content-ok">
                    <i data-feather="check"></i>
                </div>
            </div>
            <div class="text-center woring-titel">
                <h2>Deleted!</h2>
                <p>Your file has been deleted.</p>
            </div>
            <div class="d-flex justify-content-center mt-3">
                <button class="btn btn-primary close-button-ok mx-2">ok</button>
            </div>
        </div>
    </div>
@endsection
