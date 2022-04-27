@extends('customer-layouts.app')


@section('content')
    <div class="add-address-banner wd-dr-inner-blog">
        <div class="container">
            <div class="wd-dr-chat-left">
                <div class="wd-dr-chat-inner">
                    <h1>
                        Promotions
                    </h1>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>

    <div class="container list-address">
        <div class="jumbotron">
            <div class="row">
                @foreach ($promotionLists as $promotion)
                    <div class="col-md-6 order-detail-heading Promotions">
                        <div class="add-info">
                            <ul>
                                <li>
                                    <h3>{{ $promotion->promotion_code }}</h3>
                                </li>
                            </ul>
                            <h4 class="order-accepted">{{ $promotion->promotion_name }}</h4>
                            <p>
                                {{ $promotion->promotion_details }}
                            </p>
                            <div class="clearfix">

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection
