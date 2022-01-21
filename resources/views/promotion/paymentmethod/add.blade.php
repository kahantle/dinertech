@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('/assets/css/promotion_style.css') }}">
    @if ($webview == 1)
        <style>
            #wrapper{
                padding-left : 0px
            }
        </style>
    @endif
@endsection


@section('content')
    @if ($webview == 1)
        {{ Form::open(array('route' => array('promotion.add.payment.method.webView'),'id'=>'promotionForm','method'=>'POST','class'=>'','files'=>'true')) }}
        <input type="hidden" name="restaurant_user_id" value="{{$uid}}">
    @else
        {{ Form::open(array('route' => array('promotion.add.paymentmethod.post'),'id'=>'promotionForm','method'=>'POST','class'=>'','files'=>'true')) }}
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
                                <h2>  Add Payment Method Reward </h2>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        @endif

        <div class="add-category Promotion content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="@if($webview == 1) col-md-5 @else col-lg-5 @endif">
                        <div class="form-group">   
                            <img src="{{ asset('assets/images/percentage.png') }}">              
                            <input type="text" class="form-control" id="promotion_code" name="promotion_code"  placeholder="Promo code(Optional)" maxlength="15">
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
                    <div class="@if($webview == 1) col-md-7 @else col-lg-7 @endif promotion-add-border">
                        <div class="text-promotion">
                            <h5>Discount</h5>
                        </div>

                        <div class="form-group"> 
                            <img src="{{ asset('assets/images/tag-d.png') }}">
                            <input type="text" class="form-control discount_percentage" id="discount_amount" name="discount_usd_percentage" placeholder="Discount in %" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"> 
                        </div>

                        <div class="form-group cs-checkbox">
                            <input type="checkbox" class="checkbox-custom setMinimumOrderAmount" value="allow" id="setMinimumOrderAmount" name="set_minimum_order">
                            <label for="setMinimumOrderAmount">set a minimum order value (recommended)</label>
                        </div>

                        <div class="form-group minimumAmountDiv" style="display: none"> 
                            <img src="{{ asset('assets/images/tag-d.png') }}">
                            <input type="text" class="form-control" id="minimumAmount" name="set_minimum_order_amount" placeholder="Minimum Order Amount" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
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
                            <img src="{{ asset('assets/images/modifiers-black.png') }}">
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
                            <img src="{{ asset('assets/images/client-t.png') }}">
                            <select name="mark_promo_as" id="mark_promo_as" class="form-control">
                              <option selected disabled>Mark Promo as</option>
                              @foreach (Config::get('constants.MARK_PROMO_AS') as $key=>$item)
                                <option value="{{$item}}">{{$item}}</option>
                              @endforeach
                            </select>
                        </div>

                        <div class="form-group select-input"> 
                            <img src="{{ asset('assets/images/Availability.png') }}">
                            <select name="availability" id="display_time" class="form-control">
                                @foreach (Config::get('constants.AVAILABILITY') as $key=>$item)
                                    <option value="{{$key}}">{{$item}}</option>
                                @endforeach
                            </select>
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
                        <button type="button" class="btn-grey btn-inner cancel" ><span>Cancel</span></button>
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
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    <script src="{{ asset('assets/js/common.js')}}"></script>
    <script src="{{ asset('assets/js/type/cart.js')}}"></script>
    @if ($webview == 1)
        <script src="{{asset('assets/customer/js/jquery.validate.min.js')}}"></script>
        <script src="{{asset('assets/customer/js/additional-methods.min.js')}}"></script>
        <script src="{{asset('assets/js/type/paymentMethodReward-webview.js')}}"></script>
    @else
        {!! JsValidator::formRequest('App\Http\Requests\PromotionPaymentmethodRequest','#promotionForm'); !!}
    @endif
@endsection


