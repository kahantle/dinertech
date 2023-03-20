@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('/assets/css/promotion_style.css') }}">
    <link rel="stylesheet" href="{{asset('vendor/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}">
    @if ($webview == 1)
        <style>
            #wrapper{
                padding-left : 0px
            }
        </style>
          <!-- datepicker and time -->
          <link rel="stylesheet" href="{{asset('vendor/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}">
    @endif
@endsection
@section('content')
    @if ($webview == 1)
        {{ Form::open(array('route' => array('promotion.add.cart.post.webview'),'id'=>'promotionForm','method'=>'POST','class'=>'','files'=>'true')) }}
        <input type="hidden" name="restaurant_user_id" value="{{$uid}}">
    @else
        {{ Form::open(array('route' => array('promotion.add.cart.post'),'id'=>'promotionForm','method'=>'POST','class'=>'','files'=>'true')) }}
    @endif

    <section id="wrapper">
            @if ($webview == 0)
                @include('layouts.sidebar')
                <div id="navbar-wrapper">
                    <nav class="navbar navbar-inverse">
                        <div class="container-fluid">
                        <div class="navbar-header">
                            <div class="profile-title-new">
                            <a href="#" class="navbar-brand" id="sidebar-toggle"><i class="fa fa-bars"></i></a>
                            <h2>Add % Or Discount In Cart</h2>
                            </div>
                        </div>
                        </div>
                    </nav>
                </div>
            @endif

            <div class="add-category Promotion content-wrapper inner-content-wrapper">
				<div class="container-fluid">
					<div class="row">
						<div class="col-md-5">
							<div class="form-group">
                                <img src="{{ asset('assets/images/percentage.png') }}">
								<input type="text" class="form-control" id="promotion_code" name="promotion_code" placeholder="Promo code(Optional)" maxlength="15">
                            </div>
							<div class="form-group">
                                <img src="{{ asset('assets/images/speaker.png') }}">
								<input type="text" class="form-control" id="promotion_name" name="promotion_name" placeholder="Enter Title">
                            </div>
							<div class="form-group">
                                <img src="{{ asset('assets/images/description.png') }}">
								<textarea type="text" class="form-control" id="promotion_details" name="promotion_details" placeholder="Enter Description(Optional)"></textarea>
							</div>
						</div>
						<div class="col-md-7 promotion-add-border">
							<div class="text-promotion">
								<h5>Discount</h5>
                            </div>
							<div class="form-group mb-0 d-flex flex-column">
								<input type="radio" id="usd" name="discount_usd_percentage" value="USD" class="discountUsdPercentage" checked>
								<label for="usd">Discount in $</label>
								<input type="radio" id="percentage" name="discount_usd_percentage" value="PERCENT" class="discountUsdPercentage">
								<label for="percentage">Discount in %</label>
							</div>
							<div class="form-group">
                                <img src="{{ asset('assets/images/tag-d.png') }}">
								<input type="text" class="form-control" id="discount_amount" name="discount_usd_percentage_amount" placeholder="Discount (USD)" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                            </div>
							<div class="text-promotion">
								<h5>Minimum Order Amount</h5>
                            </div>
							<div class="form-group cs-checkbox">
								<input type="checkbox" class="checkbox-custom setMinimumOrderAmount" value="allow" id="setMinimumOrderAmount" name="set_minimum_order">
								<label for="setMinimumOrderAmount">set a minimum order value (recommended)</label>
							</div>
							<div class="form-group minimumAmountDiv" style="display: none">
                                <img src="{{ asset('assets/images/tag-d.png') }}">
								<input type="text" class="form-control" id="minimumAmount" name="set_minimum_order_amount" placeholder="Minimum Order Amount (USD)" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                            </div>
							<div class="form-group select-input">
                                <img src="{{ asset('assets/images/client-t.png') }}">
								<select name="client_type" id="client_type" class="form-control">
									<option selected="" value="">Customer type</option>
                                    @foreach (Config::get('constants.CLIENT_TYPE') as $key=>$item)
                                        <option value="{{$item}}">{{$item}}</option>
                                    @endforeach
								</select>
							</div>
							<div class="form-group select-input">
                                <img src="{{ asset('assets/images/order-cart.png') }}">
								<select name="order_type" id="order_type" class="form-control">
									<option selected="" value="">Order Type</option>
                                    @foreach (Config::get('constants.ORDER_TYPE') as $key=>$item)
                                        <option value="{{$item}}">{{$item}}</option>
                                    @endforeach
								</select>
							</div>
							<div class="form-group cs-checkbox mb-2">
								<input type="checkbox" class="checkbox-custom onlyForSelectedPayment" id="payment" name="only_selected_payment_method">
								<label for="payment">Apply To Selected Payment Methods </label>
								<div class="form-group cs-checkbox onlyForSelectedPaymentDiv" style="display: none">
									<div class="cash-blog mt-1">
										<input type="checkbox" class="checkbox-custom cash" id="cash" name="only_selected_cash">
										<label for="cash">Cash</label>
									</div>
									<div class="cash-blog">
										<input type="checkbox" class="checkbox-custom cardtodelivery" id="cardtodelivery" name="only_selected_cash_delivery_person">
										<label for="cardtodelivery">Credit Card</label>
									</div>
								</div>
							</div>
							<div class="form-group cs-checkbox mb-2">
								<input type="checkbox" class="checkbox-custom" id="client" name="only_once_per_client">
								<label for="client">Single Use Per Customer</label>
							</div>
							<div class="form-group select-input">
                                <img src="{{ asset('assets/images/NoExtraCharge.png') }}">
                                <select name="no_extra_charge" id="no_extra_charge" class="form-control">
                                    @foreach (Config::get('constants.NO_EXTRA_CHARGES') as $key=>$item)
                                      <option value="{{$item}}">{{$item}}</option>
                                    @endforeach
                                </select>
							</div>
							<div class="form-group select-input">
                                <img src="{{ asset('assets/images/Promotion_Function.png') }}">
                                <select name="promotion_function" id="promotion_function" class="form-control">
									<option selected="" value="">Promotion Function</option>
                                    @foreach (Config::get('constants.PROMOTION_FUNCTION') as $key=>$item)
                                        <option value="{{$item}}">{{$item}}</option>
                                    @endforeach
								</select>
							</div>
							<div class="form-group select-input">
                                <img src="{{ asset('assets/images/Availability.png') }}">
                                <select name="availability" id="availability" class="form-control">
                                    <option selected disabled>Availability</option>
									@foreach (Config::get('constants.AVAILABILITY') as $key=>$item)
                                        <option value="{{$item}}">{{$item}}</option>
                                    @endforeach
								</select>
							</div>
                            <div id="restricted-duration" class="overlay field-popup">
                                <div class="popup text-center">
                                    <h2>Restricted Duration</h2>
                                    <a class="close eligible_popup_close" href="#">&times;</a>
                                    <div class="content">
                                    <div id="accordion" class="accordion row">
                                        <div class="form-group col-md-6">
                                            <label for="daysInput">Date</label>
                                            <input data-provide="datepicker"  value=""  data-date-autoclose="true" class="form-control" placeholder="Select Date" data-date-format="mm-dd-yyyy" name="restricted_days" id="daysInput">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="hoursInput">Hours</label>
                                            <input type="text" id="start_time" name="restricted_hours" class="form-control input-sm" placeholder="Select Time" name="start_time" autocomplete="off" />
                                        </div>
                                    </div>
                                        <div class="form-group form-btn justify-content-center">
                                            <a class="close eligible_popup_close eligible_popup-inner" href="#">Submit</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
						</div>
					</div>
				</div> 
                @if ($webview == 0)
                    <div class="form-group form-btn-menu from-inner">
                        <div class="btn-custom">
                            <a href="{{route('promotion')}}" class="btn-grey"><span>Cancel</span></a>
                        </div>
                        <div class="btn-custom">
                            <button type="submit" class="btn-blue"><span>Add</span></button>
                        </div>
                    </div>
                @else
                    <div class="form-group form-btn-menu from-inner">
                        <div class="btn-custom">
                            <button type="button" class="btn-grey btn-inner cancel"><span><a style="color:black" href="/close">Cancel</a></span></button>
                        </div>
                        <div class="btn-custom">
                            <button type="submit" class="btn-blue btn-inner formsubmit" ><span>Add</span></button>
                        </div>
                    </div>
                @endif
			</div>
    </section>
  </form>
@endsection
@section('scripts')
    <script>
        $("#availability").change(function() {
            if (this.value == "Restricted") {
                var overlay_url = window.location.href.replace("#","");
                window.location.href = overlay_url += "#restricted-duration";
            }
        });
    </script>
      <script>
        document.addEventListener('DOMContentLoaded', function () {
            jQuery('#start_time, #end_time, #appt_time, #meet_time, #odd_time').timepicker({

            });
        });
    </script>
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    <script src="{{ asset('assets/js/common.js')}}"></script>
    <script src="{{ asset('assets/js/type/cart.js')}}"></script>
    <script src="{{asset('vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{asset('vendor/timepicker-bs4.js')}}" defer="defer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dayjs/1.11.4/dayjs.min.js" integrity="sha512-Ot7ArUEhJDU0cwoBNNnWe487kjL5wAOsIYig8llY/l0P2TUFwgsAHVmrZMHsT8NGo+HwkjTJsNErS6QqIkBxDw==" crossorigin="anonymous" referrerpolicy="no-referrer" defer="defer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/js/bootstrap.bundle.min.js" integrity="sha512-igl8WEUuas9k5dtnhKqyyld6TzzRjvMqLC79jkgT3z02FvJyHAuUtyemm/P/jYSne1xwFI06ezQxEwweaiV7VA==" crossorigin="anonymous" referrerpolicy="no-referrer" defer="defer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js" integrity="sha512-Tn2m0TIpgVyTzzvmxLNuqbSJH3JP8jm+Cy3hvHrW7ndTDcJ1w5mBiksqDBb8GpE2ksktFvDB/ykZ0mDpsZj20w==" crossorigin="anonymous" referrerpolicy="no-referrer" defer="defer"></script>
    @if ($webview == 1)
        <script src="{{asset('assets/customer/js/jquery.validate.min.js')}}"></script>
        <script src="{{asset('assets/customer/js/additional-methods.min.js')}}"></script>
        <script src="{{asset('assets/js/type/cart-webview.js')}}"></script>
          <!-- datepicker and time -->
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                jQuery('#start_time, #end_time, #appt_time, #meet_time, #odd_time').timepicker({

                });
            });
        </script>
        <script src="{{asset('vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
        <script src="{{asset('vendor/timepicker-bs4.js')}}" defer="defer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/dayjs/1.11.4/dayjs.min.js" integrity="sha512-Ot7ArUEhJDU0cwoBNNnWe487kjL5wAOsIYig8llY/l0P2TUFwgsAHVmrZMHsT8NGo+HwkjTJsNErS6QqIkBxDw==" crossorigin="anonymous" referrerpolicy="no-referrer" defer="defer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/js/bootstrap.bundle.min.js" integrity="sha512-igl8WEUuas9k5dtnhKqyyld6TzzRjvMqLC79jkgT3z02FvJyHAuUtyemm/P/jYSne1xwFI06ezQxEwweaiV7VA==" crossorigin="anonymous" referrerpolicy="no-referrer" defer="defer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js" integrity="sha512-Tn2m0TIpgVyTzzvmxLNuqbSJH3JP8jm+Cy3hvHrW7ndTDcJ1w5mBiksqDBb8GpE2ksktFvDB/ykZ0mDpsZj20w==" crossorigin="anonymous" referrerpolicy="no-referrer" defer="defer"></script>
    @else
        {!! JsValidator::formRequest('App\Http\Requests\PromotionCartRequest','#promotionForm'); !!}
    @endif
@endsection
