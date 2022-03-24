<div class="modal fade" id="exampleModalCenter4" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-width-blog" role="document">
        <div class="modal-content">
            <div class="modal-body modal-inner-blog-based">
                <div class="subscribe-blog-modal">
                    <h6>Subscription</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <h5>$ {{ $subscription->price }} / {{ $sub_type }}</h5>
                {{-- <p>Main subscription cycle is from 15 to 15 of each month and you're
                    subscribing for loyalty on 1st December 2021 so we will charge you $14.4
                    this month and from next month cycle $29.00.</p> --}}

                <p class="border-0">Subscribe today for just ____________ with a recurring subscription of $29.00
                    occurring on your
                    account bill date of the 15th.</p>
                <p>

                    Underlined text should be conditional to the client’s account subscription date. The first should be
                    their pro-rated price in the following format: $xx.xx and the second should be the day of their
                    renewal in the format shown above (1st, 3rd, 7th, 15th, 21st, 23rd, etc)
                </p>
                <h4>Enter Your Credit / Debit Card Details</h4>
                {{-- <h4>Enter Your credit/debit card details</h4> --}}
                <form action="{{ route('subscription.pay') }}" method="POST" class="paymentForm">
                    @csrf
                    <input type="hidden" name="subscription_id" value="{{ $subscription->subscription_id }}">
                    <input type="hidden" name="payment_method" id="payment-method">
                    @if ($upgrade == true)
                        <input type="hidden" name="upgrade" value="true">
                    @endif
                    <div class="form-group vist-t-blog">
                        <input class="credit-card-number form-control  vist-t-blog card-number" type="text"
                            inputmode="numeric" placeholder="XXXX XXXX XXXX XXXX" name="card_number" id="card-number"
                            data-image-path="{{ asset('assets/images/') }}" pattern="[0-9\s]{13,19}" maxlength="19">
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
                                    type="text" id="card-cvv" placeholder="CVV" name="cvv" maxlength="3">
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
