@extends('customer-layouts.app')

@section('css')
    <!-- Rating bar css -->
    <link rel="stylesheet" href="{{ asset('assets/customer/css/rateYo/2.3.2/jquery.rateyo.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/customer/css/promotion_page.css')}}">
@endsection

@section('content')
<section class="dash-body-ar wd-dr-dash-inner">
	<div class="wrp-ar-nav-body">
		@include('customer-layouts.navbar')
		<div id="chatdesk" class="chart-board ">
			@include('customer.messages')
			<div class="row flex-row flex-nowrap">
				<div class="col-xl-8 col-lg-12 col-md-12 dashbord-home dashbord-home-cart active">
					<div class="order-content payment-table-detail p-4">
						<h2 class="mb-5">
                            <a href="{{route('customer.profile')}}" class="btn bg-transparent mx-2 payment-methods-btn-back">
                                <i data-feather="arrow-left"></i>
                            </a>
                            Payment Methods
                        </h2>
						 <div class="table-responsive">
							<table class="table table-inner table-payment-detail">
								<tbody>
									@foreach($cards as $card)
									<tr>
										<td style="width: 16%;" class="wd-dr-text-line">
											@if($card->card_type == Config::get('constants.CARD_TYPE.AMERICAN_EXPRESS'))
												<img src="{{asset('assets/customer/images/chat/express.png')}}" class="img-fluid">
											@elseif ($card->card_type == Config::get('constants.CARD_TYPE.VISA'))
												<img src="{{asset('assets/customer/images/chat/visa.png')}}" class="img-fluid">
											@elseif ($card->card_type == Config::get('constants.CARD_TYPE.DISCOVER'))
												<img src="{{asset('assets/customer/images/chat/discover.png')}}" class="img-fluid">
											@elseif ($card->card_type == Config::get('constants.CARD_TYPE.MASTER_CARD'))
												<img src="{{asset('assets/customer/images/chat/master_card.png')}}" class="img-fluid">
											@endif
										</td>
										<td style="width: 50%;">XXXX - XXXX - XXXX - {{ Str::substr($card->card_number,15,19)}}</td>
										<td class="wd-dr-text-line">{{$card->card_expire_date}}</td>
										<td rowspan="1" class="wd-dr-text-line">
											<div class="wd-dr-next-line">
												<i class="fas fa-cog"></i>
												<a href="javascript:void(0)" class="delete-card" data-card-id={{$card->card_id}}>
													<i class="fas fa-trash-alt"></i>
												</a>
											</div>
										</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
						<button type="button" class="add-payment-new mt-2">Add A New Payment Method</button>
					</div>
                    <div class="card order-content add-card-detail">
                        <div class="card-body wd-dr-dashboart-inner">
                            <h2 class="card-title">
                                <button class="btn bg-transparent payment-table-detail-back d-inline-flex">
                                    <i data-feather="arrow-left"></i>
                                </button>
                                Add Card Details
                            </h2>
                            <div class="row">
                                <div class="col-md-6 col-lg-6 mb-4">
                                    <div class="wd-dr-background add-payment add-pay-inner-d">
                                        <h4>
                                            <img src="{{asset('assets/images/logo-payment.png')}}"
                                                class="show-card-image show">
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
                                    <form id="addCardForm" class="cardit-card-form" method="POST" action="{{ route('customer.cards.store') }}">
                                        @csrf
                                        <input type="hidden" name="card_type" id="cardType">
                                        <div class="form-group my-4">
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1"><img
                                                            src="{{asset('assets/images/credit-card-numbar.png')}}"
                                                            alt=""></span>
                                                </div>
                                                <input id="card-number" type="tel" name="card_number"
                                                    class="form-control address" inputmode="numeric"
                                                    pattern="[0-9\s]{13,19}" autocomplete="cc-number"
                                                    maxlength="19" placeholder="Card Number">
                                            </div>
                                        </div>
                                        <div class="row form-group my-4">
                                            <div class="col-sm-6">
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"
                                                            id="basic-addon1"><img
                                                                src="{{asset('assets/images/credit-card-cut.png')}}"
                                                                alt=""></span>
                                                    </div>
                                                    <input type="text" class="form-control address"
                                                        name="card_expire_date" id="card-exp-date"
                                                        placeholder="Exp Date" maxlength="5">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"
                                                            id="basic-addon1"><img
                                                                src="{{asset('assets/images/credit-card-cvv.png')}}"
                                                                alt=""></span>
                                                    </div>
                                                    <input type="text" class="form-control address"
                                                        name="card_cvv" id="card-cvv" placeholder="CVV"
                                                        maxlength="3">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group my-4">
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1"><img
                                                            src="{{asset('assets/images/creadit catd name.png')}}"
                                                            alt=""></span>
                                                </div>
                                                <input type="text" class="form-control address"
                                                    name="card_holder_name" id="card-holder-name"
                                                    placeholder="Card Holder Name">
                                            </div>
                                        </div>
                                        <div class="row form-group my-4">
                                            <div class="col-md-12" align="end">
                                                <button type="submit"
                                                    class="btn btn-primary btn-add-to-cart px-3"
                                                    alt="Add Card">
                                                    <h6 class="mb-0">
                                                        <img width="32px"
                                                            src="{{asset('assets/images/credit-card-icon-png-4401.png')}}"
                                                            alt="">
                                                        Add Card
                                                    </h6>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="row mx-auto mt-4">
                                    <div class="col-md-3 col-6 text-center">
                                        <img src="{{asset('assets/images/visa.png')}}" class="rounded card-image">
                                    </div>
                                    <div class="col-md-3 col-6 text-center">
                                        <img src="{{asset('assets/images/master_card.png')}}"
                                            class="rounded card-image">
                                    </div>
                                    <div class="col-md-3 col-6 text-center">
                                        <img src="{{asset('assets/images/american-express_1.png')}}"
                                            class="rounded card-image">
                                    </div>
                                    <div class="col-md-3 col-6 text-center">
                                        <img src="{{asset('assets/images/discover.png')}}" class="rounded card-image">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
				</div>
				@include('customer-layouts.right-sidebar')
			</div>
		</div>
	</div>
</section>
@endsection

@section('scripts')

    <script src="{{asset('assets/js/jquery.min.js')}}"></script>
    <script src="{{asset('assets/js/jquery.validate.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"> </script>
	<script src="{{asset('assets/customer/js/custom-js/card/index.js')}}"></script>

    <script>
        $(document).ready(function () {
            $('.add-payment-new').click(function () {
                $('.payment-table-detail').css('display', 'none');
                $('.add-card-detail').css('display', 'block');
            });
            $('.payment-table-detail-back').click(function () {
                $('.add-card-detail').css('display', 'none');
                $('.payment-table-detail').css('display', 'block');
            });
        });
    </script>

    <script>
        $(document).ready(function () {
            $("#card-number").keyup(function () {
                var cardNumber = $('#card-number').val();
                // console.log(cardNumber);
                if (cardNumber == "" && cardNumber.length == 0) {
                    $(".card-number").text('XXXX XXXX XXXX XXXX');
                } else {
                    $(".card-number").text(cardNumber);
                }
            });
            // card-exp-date
            $("#card-exp-date").keyup(function () {
                var cardExpDate = $('#card-exp-date').val();
                // console.log(cardExpDate);
                if (cardExpDate == "" && cardExpDate.length == 0) {
                    $(".card-exp-date").text('MM / YY');
                } else {
                    $(".card-exp-date").text(cardExpDate);
                }
            });
            $("#card-cvv").keyup(function () {
                var cardCvv = $('#card-cvv').val();
                // console.log(cardCvv);
                if (cardCvv == "" && cardCvv.length == 0) {
                    $(".card-cvv").text('***');
                } else {
                    $(".card-cvv").text(cardCvv);
                }
            });
            $("#card-holder-name").keyup(function () {
                var cardHolderName = $('#card-holder-name').val();
                // console.log(cardHolderName);
                if (cardHolderName == "" && cardHolderName.length == 0) {
                    $(".card-holder-name").text('XXXX XXXX XXXX.');
                } else {
                    $(".card-holder-name").text(cardHolderName);
                }
            });


            // var inputspece = document.getElementById("card-number");

            // inputspece.onkeydown = function () {
            //     if (inputspece.value.length > 0) {

            //         if (inputspece.value.length == 4 || inputspece.value.length == 9 || inputspece.value.length == 14) {
            //             inputspece.value += " ";
            //         }
            //     }
            // }
            var inputcells = document.getElementById("card-exp-date");

            inputcells.onkeydown = function () {
                if (inputcells.value.length > 0) {

                    if (inputcells.value.length == 2) {
                        inputcells.value += "/";
                    }
                }
            }
            document.getElementById('card-number').addEventListener('input', function (e) {
                e.target.value = e.target.value.replace(/[^\dA-Z]/g, '').replace(/(.{4})/g, '$1 ').trim();
            });
            // document.getElementById('card-exp-date').addEventListener('input', function (e) {
            //     e.target.value = e.target.value.replace(/[^\dA-Z]/g, '/').replace(/(.{2})/g, '$1 ').trim();
            // });
            $("#addCardForm").validate({
                rules: {
                    card_number: 'required',
                    card_expire_date: 'required',
                    card_cvv: 'required',
                    card_holder_name: 'required',
                    u_email: {
                        required: true,
                        email: true,
                        //add an email rule that will ensure the value entered is valid email id.
                        maxlength: 255,
                    },
                },
                messages: {
                    card_number: '	Please enter a valid credit card number.',
                    card_expire_date: 'Incorrect credit card expiration year.',
                    card_cvv: 'Please enter a valid credit card verification number.',
                    card_holder_name: '	Please enter a valid credit card holder name.',
                },
            });
        });
    </script>
@endsection
