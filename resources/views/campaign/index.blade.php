@extends('layouts.app')
@section('content')
    <section id="wrapper">
        <div class="d-lg-block d-sm-none d-md-none header-sidebar-menu">
            @include('layouts.sidebar')
            <div id="navbar-wrapper">
                <nav class="navbar navbar-inverse">
                    <div class="container-fluid">
                        <div class="navbar-header">
                            <div class="profile-title-new">
                                <a href="#" class="navbar-brand sidebar-nav-blog" id="sidebar-toggle"><i
                                        class="fa fa-bars"></i></a>
                                <h2>Campaigns</h2>
                            </div>
                            <div class="add-campaign-blog">
                                <a href="{{ route('campaign.create') }}" class="add-campaign-blog" target="_blank">
                                    <button class="add-campaign">
                                        <i class="fa fa-plus"></i>
                                        Add Campaign
                                    </button>
                                </a>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>

            <div class="dashboard category content-wrapper pt-1">
                @include('common.flashMessage')
                <div class="dashboard promotions">
                    @php
                        $totalSubscribers = explode('-', $currentPlan->subscribers);
                    @endphp
                    @if ($restaurant_subscribers > $totalSubscribers)
                        <div class="container mt-2">
                            <div class="alert alert-danger" role="alert">
                                You have more subscribers to the current plan limit. Please upgrade the plan.
                            </div>
                        </div>
                    @endif
                    <div class="wd-dr-current-plan">
                        <div class="card">
                            <div class="card-body">
                                <p>Current plan:<span>&nbsp;$ {{ $currentPlan->price }}/
                                        {{ Config::get('constants.SUBSCRIPTION_TYPE.MONTH') }}</span></p>

                                <p>Subscribers:<span>&nbsp;{{ $restaurant_subscribers }}/{{ $totalSubscribers[1] }}</span>
                                </p>
                                <p>Billing
                                    Cycle:<span>&nbsp;{{ \Carbon\Carbon::parse($stripeSubscription->current_period_start)->format('M d Y') }}
                                        to
                                        {{ \Carbon\Carbon::parse($stripeSubscription->current_period_end)->format('M d Y') }}
                                    </span></p>
                            </div>
                            <div class="card-footer">
                                <a class="upgrade-plan-bog mr-4"
                                    href="{{ route('subscription.cancel', $stripeSubscription->id) }}">Cancel Plan</a>
                                <a class="upgrade-plan-bog" href="{{ route('subscription.upgrade') }}">Upgrade Plan</a>
                            </div>
                        </div>
                    </div>
                    <div class="dash-second">
                        <div class="container-fluid">
                            <div class="number-table number-blog-table">
                                <table class="table table-responsive">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="dr-title-t-inner-blog d-campaign-name-inner">Campaign
                                                Name</th>
                                            <th scope="col" class="dr-title-t-inner-blog d-status-name">Status</th>
                                            <th scope="col" class="dr-title-t-inner-blog d-creates-name"> Created </th>
                                        </tr>
                                    </thead>
                                </table>

                                @if (count($draftCampaigns) != 0 || count($sentCampaigns) != 0)
                                    @foreach ($draftCampaigns as $campaign)
                                        <table class="table table-responsive">
                                            <tbody>
                                                <tr class="header-url table-header-url">
                                                    <td class="inner-second-blog-inner d-inner-camp"><span
                                                            class="order-numerber-blog"></span>
                                                        <p class="m-0 pl-5">
                                                            {{ $campaign->Name }} </p>
                                                    </td>
                                                    <td class="inner-blog-u inner-first-blog-u">DRAFT </td>
                                                    <td class="reports-blog campaign-date-{{ $campaign->CampaignID }}">
                                                        {{ date('d M Y,h:i A', strtotime($campaign->DateCreated)) }}
                                                    </td>

                                                    <td class="btn-blog-group table-desktop">
                                                        <button class="btn-delete campaign-delete"
                                                            data-campaignId="{{ $campaign->CampaignID }}">Delete</button>
                                                    </td>
                                                </tr>
                                                <tr class="header-url table-mobile">
                                                    <td class="btn-blog-group">
                                                        <button class="btn-delete campaign-delete"
                                                            data-campaignId="{{ $campaign->CampaignID }}">Delete</button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    @endforeach
                                    @foreach ($sentCampaigns as $campaign)
                                        <input type="hidden" id="{{ $campaign->CampaignID }}"
                                            value="{{ $campaign->Subject }}">
                                        <table class="table table-responsive">
                                            <tbody>
                                                <tr class="header-url table-header-url">
                                                    <td class="inner-second-blog-inner d-inner-camp"><span
                                                            class="order-numerber-blog"></span>
                                                        <p class="m-0 pl-5"
                                                            id="campaign-nm-{{ $campaign->CampaignID }}">
                                                            {{ $campaign->Name }} </p>
                                                    </td>
                                                    <td class="inner-blog-u inner-blog-sent">SENT </td>
                                                    <td class="reports-blog"
                                                        id="campaign-date-{{ $campaign->CampaignID }}">
                                                        {{ date('d M Y,h:i A', strtotime($campaign->SentDate)) }}
                                                    </td>

                                                    <td class="btn-blog-group table-desktop">
                                                        <button class="btn-edit btn-inner get-report"
                                                            data-campaignId="{{ $campaign->CampaignID }}">Report</button>
                                                        <button class="btn-delete campaign-delete"
                                                            data-campaignId="{{ $campaign->CampaignID }}">Delete</button>
                                                    </td>
                                                </tr>
                                                <tr class="header-url table-mobile">
                                                    <td class="btn-blog-group">
                                                        <button class="btn-edit btn-inner get-report"
                                                            data-campaignId="{{ $campaign->CampaignID }}">Report</button>
                                                        <button class="btn-delete campaign-delete"
                                                            data-campaignId="{{ $campaign->CampaignID }}">Delete</button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    @endforeach
                                @else
                                    <div class="campaign-appear-blog">
                                        <p>you do not have any campaigns.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="report"></div>
@endsection

@section('scripts')
    <script src="{{ asset('/assets/js/campaign/index.js') }}"></script>
@endsection
