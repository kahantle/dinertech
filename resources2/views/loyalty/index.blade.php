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
                                <h2>Loyalty</h2>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
        <div class="dashboard category content-wrapper pt-1">
            @include('common.flashMessage')
            <div class="dashboard promotions">
                <div class="dash-first">
                    <div class="container-fluid">
                        <div class="profile-inner-blog">
                            <h2>DinerTech Loyalty</h2>
                            <p>Elevate your customer engagement with a loyalty program. The DinerTech Loyalty Platform
                                offers numerous ways to keep customers engaged and coming back for more. You can mix and
                                match different benefits to fit your business needs with our Loyalty subscription. Enroll
                                today for just $29 to add this expanded functionality to your operation.</p>
                        </div>

                        <div class="row profile-two-inner">
                            <div class="col-lg-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h6>Number of Orders</h6>
                                        <p>Customers earn points for each order they place.</p>
                                        <div class="add-order-button">
                                            <a href="javascript:;" class="add-loyalty-blog" data-toggle="modal"
                                                data-target="#loyaltyPayment">Add Loyalty</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h6>Amount Spent</h6>
                                        <p>Customers earn points for each dollar they spend.</p>
                                        <div class="add-order-button">
                                            <a href="javascript:;" class="add-loyalty-blog" data-toggle="modal"
                                                data-target="#loyaltyPayment">Add Loyalty</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h6>Category Based </h6>
                                        <p>Customers earn points for items purchased from select categories.</p>
                                        <div class="add-order-button">
                                            <a href="javascript:;" class="add-loyalty-blog" data-toggle="modal"
                                                data-target="#loyaltyPayment">Add Loyalty</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="dash-second dash-p-instblog">
                    <div class="container">
                        <div class="Benefits-loyalty">
                            <h5 class="my-2">Benefits Of Loyalty </h5>
                           <div class="subscribe-btn-blog">
                                <button type="button" data-toggle="modal" data-target="#loyaltyPayment">Subscribe
                                    Now</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" id="loyaltyPayment" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body modal-inner-blog-based">
                    <div class="subscribe-blog-modal">
                        <h6>Subscription</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <h5>$ 29.00 / Month</h5>
                    <p class="border-0">Subscribe today for just ${{$totalAmount}} with a recurring subscription of $29.00
                        occurring on your
                        account bill date of the {{$startDate}}<sup>th</sup>.</p>

                    <h4>Enter Your Credit / Debit Card Details</h4>
                    <form action="{{ route('loyalty.payment') }}" method="post" id="loyalty-payment">
                        @csrf
                        <input type="hidden" name="payment_method" id="payment-method">
                        <div class="form-group vist-t-blog">
                            <input class="credit-card-number form-control vist-t-blog" type="text" name="card_number"
                                inputmode="numeric" placeholder="XXXX XXXX XXXX XXXX"
                                data-image-path="{{ asset('assets/images/') }}" id="card-number" pattern="[0-9\s]{13,19}"
                                maxlength="19">
                            <img src="{{ asset('assets/images/logo-blue.png') }}"
                                class="img-fluid visa-pit show-card-image">
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" id="inputExpDate" placeholder="MM / YY" maxlength='7'
                                        class="form-control from-first-vblog" name="exp_card">
                                </div>
                                <div class="col-md-6 security-code-blog">
                                    <input class="security-code from-first-vblog form-control" inputmode="numeric"
                                        type="text" placeholder="CVV" name="cvv" id="card-cvv" maxlength="3">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                                placeholder="Card Holder Name" name="card_holder_name">
                        </div>
                        @if (count($paymentMethods['data']) != 0)
                            <div class="form-group">
                                <h3 class="or-line"><span>OR</span></h3>
                            </div>
                            <div class="form-group subscription-inner-blog" id="style-10">
                                @foreach ($paymentMethods['data'] as $payment)
                                    <div class="d-flex align-items-center mb-3 visa-border-blog">
                                        <input type="radio" id="test1" class="check-radio-inner select-method"
                                            name="radio-group" data-payment-id="{{ $payment['id'] }}">
                                        <div class="radio-left-inner-blog">
                                            @if ($payment['card']['brand'] == 'visa')
                                                <img src="{{ asset('assets/images/visa.png') }}" class="img-fluid">
                                            @elseif ($payment['card']['brand'] == 'discover')
                                                <img src="{{ asset('assets/images/discover.png') }}"
                                                    class="img-fluid">
                                            @elseif ($payment['card']['brand'] == 'amex')
                                                <img src="{{ asset('assets/images/american-express.png') }}"
                                                    class="img-fluid">
                                            @elseif ($payment['card']['brand'] == 'mastercard')
                                                <img src="{{ asset('assets/images/master_card.png') }}"
                                                    class="img-fluid">
                                            @else
                                                <img src="{{ asset('assets/images/logo-blue.png') }}"
                                                    class="img-fluid">
                                            @endif

                                            <div class="radio-right-inner-blog">
                                                <span>{{ $payment['card']['brand'] }} ****
                                                    {{ $payment['card']['last4'] }}</span>
                                                <span>Expire
                                                    {{ date('F', strtotime($payment['card']['exp_year'] . '-' . $payment['card']['exp_month'])) }}
                                                    {{ $payment['card']['exp_year'] }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                        <div class="subscribe-btn-blog sub-inner">
                            <button type="submit">Subscribe Now</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/loyalty/index.js') }}"></script>
    <script src="{{ asset('assets/js/card/common.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\LoyaltyPaymentRequest', '#loyalty-payment') !!}
@endsection
