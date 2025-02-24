@extends('customer-layouts.app')

@section('content')
    <section class="dash-body-ar wd-dr-dash-inner">
        <div class="wrp-ar-nav-body">
            @include('customer-layouts.navbar')
            <div id="chatdesk" class="chart-board ">
                @include('customer.messages')
                <div class="row">
                    <div class="col-xl-8 col-lg-12 col-md-12 mb-4">
                        <div class="card add-card-detail">
                            <div class="card-body wd-dr-dashboart-inner">
                                <h2 class="card-title">Add Card Details</h2>
                                <div class="row">
                                    <div class="col-md-6 col-lg-6 mb-4">
                                        <input type="hidden" value="{{ asset('assets/customer/images/') }}"
                                            id="card-image-path">
                                        <div class="wd-dr-background add-payment add-pay-inner-d">
                                            <h4>
                                                <img src="{{ asset('assets/customer/images/logo-payment.png') }}"
                                                    class="show-card-image hide">
                                            </h4>
                                            <label class="card-font card-number">XXXX XXXX XXXX XXXX</label>
                                            <div>
                                                <div class="expdate">
                                                    <label class="datetext">Exp Date</label>
                                                    <label class="card-font card-exp-date">MM / YY</label>
                                                </div>
                                                <div class="cvv">
                                                    <label class="datetext">CVV</label>
                                                    <label class=" card-font card-cvv">***</label>
                                                </div>
                                            </div>
                                            <div class="clearfix ">

                                            </div>
                                            <label>
                                                Card Holder Name
                                            </label>
                                            <h4 class="card-holder-name">
                                                XXXX XXXX XXXX.
                                            </h4>
                                            <div class="clearfix ">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6 card-detail">
                                        <h3 class="card-title"> Card Details </h3>
                                        <form action="{{ route('customer.cards.store') }}" method="post" id="addCardForm">
                                            @csrf
                                            <input type="hidden" name="card_type" id="cardType">
                                            <div class="form-group">
                                                <input id="card-number" type="tel" name="card_number"
                                                    class="form-control address" inputmode="numeric"
                                                    pattern="[0-9\s]{13,19}" autocomplete="cc-number" maxlength="19"
                                                    placeholder="Card Number">
                                                @error('card_number')
                                                    {{ $message }}
                                                @enderror
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control address" name="card_expire_date"
                                                        id="card-exp-date" placeholder="Exp Date" maxlength="5">
                                                    @error('card_expire_date')
                                                        {{ $message }}
                                                    @enderror
                                                </div>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control address" name="card_cvv"
                                                        id="card-cvv" placeholder="CVV" maxlength="3">
                                                    @error('card_cvv')
                                                        {{ $message }}
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control address" name="card_holder_name"
                                                    id="card-holder-name" placeholder="Card Holder Name">
                                                @error('card_holder_name')
                                                    {{ $message }}
                                                @enderror
                                            </div>
                                            <div class="row form-group">
                                                <div class="col-md-6 col-md-offset-3">
                                                    <button type="submit" class="btn btn-primary btn-add-to-cart
"
                                                        alt="Add Card">
                                                        <h4>Add Card</h4>

                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    {{-- <div class="row mx-auto mt-4">
                                        <div class="col-md-3">
                                            <img src="{{ asset('assets/customer/images/visa.png') }}"
                                                class="rounded card-image">
                                        </div>
                                        <div class="col-md-3">
                                            <img src="{{ asset('assets/customer/images/master_card.png') }}"
                                                class="rounded card-image">
                                        </div>
                                        <div class="col-md-3">
                                            <img src="{{ asset('assets/customer/images/american-express_1.png') }}"
                                                class="rounded card-image">
                                        </div>
                                        <div class="col-md-3">
                                            <img src="{{ asset('assets/customer/images/discover.png') }}"
                                                class="rounded card-image">
                                        </div>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                    @include('customer-layouts.right-sidebar')
                </div>
            </div>
        </div>
        </div>
    </section>

@endsection

@section('scripts')
    <script src="{{ asset('assets/customer/js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/customer/js/additional-methods.min.js') }}"></script>
    <script src="{{ asset('assets/customer/js/custom-js/card/create.js') }}"></script>
@endsection
