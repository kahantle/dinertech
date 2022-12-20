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
                    <button class="btn d-inline-flex my-2 trigger">
                        <i class="mx-2" data-feather="trash"></i>
                        Delete Account
                    </button>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')

<script>

function updateSetting(type, value) {
    $.ajax({
        type: "POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: "{{ route('customer.settings.update') }}",
        data: {
            type: type
        },
        success: function(data) {
        }
    });
}

</script>

@endsection
