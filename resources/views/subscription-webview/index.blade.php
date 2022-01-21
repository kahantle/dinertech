@extends('layouts.app')
@section('content')
    <section>
        <div class="dashboard category content-wrapper pt-1">
            <div class="dashboard promotions">
                <div class="dash-first">
                    <div class="container-fluid">
                        <div class="profile-inner-blog">
                            <h2 class="mb-1">Benifits Of Email Marketing </h2>
                            <p>Integrate with the DinerTech Campaign Monitor Agency Account Campaign Monitor API Access
                                API.<br>
                                Transfer & Share Data with DinerTech Client Dashboard Be VERY EASY for clients to use
                            </p>
                        </div>
                        <div class="profile-inner-blog">
                            <h2 class="mt-4 mb-3">Subscription Plan </h2>
                        </div>
                        <div class="container">
                            <input type="hidden" value="{{ $uid }}" id="uid">
                            @if ($upgrade_subscription)
                                <input type="hidden" value="upgrade_subscription" id="upgrade">
                            @endif
                            @php $count = 1; @endphp
                            @foreach ($subscriptions as $key => $subscription)
                                @if ($key == 4)
                                    <div class="moretext">
                                @endif
                                @if ($count == 1)
                                    <div class="row row-blog-inner">
                                @endif
                                <div class="col-lg-3 col-md-6">
                                    <div class="card @if ($key == 0) card-blue @else card-black-inner @endif"
                                        id="subscription-{{ $subscription->subscription_id }}"
                                        data-subscriptionid="{{ $subscription->subscription_id }}">
                                        <div class="card-body">
                                            <div class="card-first-inner-blog">
                                                <h5 class="card-title">$ {{ $subscription->price }}</h5>
                                                @if (Config::get('constants.SUBSCRIPTION_TYPE.MONTH') == $subscription->subscription_type)
                                                    <p class="card-text">/
                                                        {{ Str::lower(Config::get('constants.SUBSCRIPTION_TYPE.MONTH')) }}
                                                    </p>
                                                @elseif (Config::get('constants.SUBSCRIPTION_TYPE.YEAR') ==
                                                    $subscription->subscription_type)
                                                    <p class="card-text">/
                                                        {{ Str::lower(Config::get('constants.SUBSCRIPTION_TYPE.YEAR')) }}
                                                    </p>
                                                @endif
                                            </div>
                                            <div class="card-subscriber">
                                                <p>Subscribers</p>
                                                <h6>{{ $subscription->subscribers }}</h6>
                                                <button type="button" class="btn-subscriber subscription"
                                                    data-subscriptionid="{{ $subscription->subscription_id }}">Subscribe</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if ($count == 4)
                        </div>
                        @php $count = 1; @endphp
                    @else
                        @php $count++; @endphp
                        @endif
                        @endforeach
                    </div>
                </div>
                <div class="show-more-inner">
                    <button class="add-campaign moreless-button">Show More</button>
                </div>
            </div>
        </div>
        </div>
        </div>
        <div id="payment-modal"></div>
    </section>
@endsection

@section('scripts')
    <script src="{{ asset('/assets/js/email_subscription/index-webview.js') }}"></script>
@endsection
