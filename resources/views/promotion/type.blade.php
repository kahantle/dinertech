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
                            <h2>Select Promotion Type</h2>
                        </div>
                        <!-- <div class="form-group">
                                            <i class="fa fa-search" aria-hidden="true"></i>
                                            <input type="text" name="item-name" class="form-control" placeholder="Search Menu">
                                            <i class="fa fa-times" aria-hidden="true"></i>
                                          </div> -->
                    </div>
                </div>
            </nav>
        </div>
        <div class="dashboard promotions promotions-type promotions-type-t-blog">
            <div class="container-fluid">
                <div class="pro-cards">
                    @foreach ($promotionType as $item)
                        <div class="pro-card detail">
                            <div class="left-s left-t-inner-blog">
                                <div class="checkbox switcher">
                                    <img src="{{ asset('assets/images/pt-cart.png') }}" class="img-fluid">
                                </div>
                                <div class="left-align-blog">
                                    <p>{{ $item->promotion_name }}</p>
                                </div>

                            </div>
                            <div class="right-s">
                                <p>{{ $item->promotion_details }}</p>
                                <div class="pro-btn">
                                    <div class="btn-custom">
                                        <a href="{{ route('promotion.type.form', [$item->promotion_type_id]) }}"
                                            class="btn-blue">
                                            <span>Next</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
    </section>
@endsection
@section('scripts')
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
    <script src="{{ asset('assets/js/common.js') }}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\PromotionRequest', '#promotionForm') !!}
@endsection
