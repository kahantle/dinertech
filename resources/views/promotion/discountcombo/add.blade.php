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
    @endif
@endsection

@section('content')

    @if ($webview == 1)
        {{ Form::open(array('route' => array('promotion.add.discount-combo.webView'),'id'=>'promotionForm','method'=>'POST','class'=>'')) }}
        <input type="hidden" name="restaurant_user_id" value="{{$uid}}">
    @else
        {{ Form::open(array('route' => array('promotion.add.free.discountcombo.post'),'id'=>'promotionForm','method'=>'POST','class'=>'')) }}
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
                                <h2>% Discount On Combo Deal</h2>
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
                            <input type="text" class="form-control" id="promotion_code" name="promotion_code" placeholder="Promo code(Optional)" maxlength="15">
                        </div>
                        <div class="form-group">
                            <img src="{{ asset('assets/images/speaker.png') }}">
                            <input type="text" class="form-control" id="promotion_name" name="promotion_name" placeholder="Enter Headline">
                        </div>
                        <div class="form-group">
                            <img src="{{ asset('assets/images/description.png') }}">
                            <textarea type="text" class="form-control" id="promotion_details" name="promotion_details" placeholder="Enter Description(Optional)"></textarea>
                        </div>
                    </div>
                    <div class="@if($webview == 1) col-md-7 @else col-lg-7 @endif promotion-add-border">
                        <div class="text-promotion">
                            <h5>Eligible Items</h5>
                        </div>

                        <div id="inputFormRow">
                            <div class="input-group">
                                <div class="input-popup inputpop-inner w-100" id="eligibleItems">
                                    <div id="eligible-item-one" class="eligible-item form-group">
                                        <a href="#field-one" class="fill-inner w-100 fill-sec">
                                            <img src="{{ asset('assets/images/order-cart.png')}}" class="items-inner-st-sec wd-dr-wrapper">
                                            <p name="slct-two" id="slct-one" class="form-control inner-p-wrapper-blog-sys">Eligible Items Group 1</p>
                                        </a>
                                        <button type="button" class="btn btn-remove btn-remove-one" data-remove="one">✕</button>

                                        <div>
                                            <input type="text" style="clip-path: circle(0);height: 0;padding: 0; width: 0; position: absolute; opacity: 0;" id="hidden_eligible_item_one" name="hidden_eligible_item_one" />
                                        </div>
                                    </div>

                                    <div id="eligible-item-two" class="eligible-item form-group">
                                      <a href="#field-two" class="fill-inner w-100 fill-sec">
                                          <img src="{{ asset('assets/images/order-cart.png')}}" class="items-inner-st-sec wd-dr-wrapper">
                                          <p name="slct-two" id="slct-two" class="form-control inner-p-wrapper-blog-sys">Eligible Items Group 2</p>
                                      </a>
                                      <button  type="button" class="btn btn-remove btn-remove-two" data-remove="two">✕</button>

                                      <div>
                                          <input type="text" style="clip-path: circle(0);height: 0;padding: 0; width: 0; position: absolute; opacity: 0;" id="hidden_eligible_item_two" name="hidden_eligible_item_two" />
                                      </div>
                                    </div>


                                    <div id="eligible-item-three" class="eligible-item form-group">
                                      <a href="#field-three" class="fill-inner w-100 fill-sec">
                                          <img src="{{ asset('assets/images/order-cart.png')}}" class="items-inner-st-sec wd-dr-wrapper">
                                          <p name="slct-three" id="slct-three" class="form-control inner-p-wrapper-blog-sys">Eligible Items Group 3</p>
                                      </a>
                                      <button  type="button" class="btn btn-remove btn-remove-three" data-remove="three">✕</button>

                                      <div>
                                          <input type="text" style="clip-path: circle(0);height: 0;padding: 0; width: 0; position: absolute; opacity: 0;" id="hidden_eligible_item_three" name="hidden_eligible_item_three" />
                                      </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="d-flex">
                            <button id="addEligibleItems" type="button" class="btn btn-info add-button">Add</button>
                        </div>

                        <div class="form-group minimumAmountDiv">
                            <img src="{{ asset('assets/images/tag-d.png')}}">
							<input type="text" class="form-control discount_percentage" id="minimumAmount" name="discount_usd_percentage_amount" placeholder="Discount (%)" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                        </div>

                        <div class="form-group select-input">
                            <img src="{{ asset('assets/images/modifiers-black.png') }}">
                            <select name="no_extra_charge" id="no_extra_charge" class="form-control">
                              @foreach (Config::get('constants.NO_EXTRA_CHARGES') as $key=>$item)
                                <option value="{{$item}}">{{$item}}</option>
                              @endforeach
                            </select>
                        </div>

                        <div class="form-group select-input">
                            <img src="{{ asset('assets/images/modifiers-black.png') }}">
                            <select name="client_type" id="client_type" class="form-control">
                                  <option value="">Customer type</option>
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

                        <div class="form-group cs-checkbox">
                            <input type="checkbox" class="checkbox-custom onlyForSelectedPayment" id="payment" name="only_selected_payment_method">
                            <label for="payment">Apply To Selected Payment Methods</label>

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


                        <div class="form-group cs-checkbox">
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
                                        <input type="number" name="restricted_hours" max="23" class="form-control input-sm" id="hoursInput">
                                    </div>
                                </div>
                                <div class="form-group form-btn justify-content-center">
                                    <a class="close eligible_popup_close eligible_popup-inner" href="#">Submit</a>
                                </div>
                              </div>
                            </div>
                        </div>

                        <div id="addEligiblePopup">
                            <div id="field-one" class="overlay field-popup">
                                <div class="popup text-center">
                                  <h2>Eligible Items</h2>
                                  <a class="close eligible_popup_close" href="#">&times;</a>
                                  <div class="content">
                                    <div id="accordion" class="accordion">
                                        @foreach($category as $key=>$value)
                                            @if($value->category_item->count() != 0)
                                                <div class="card mb-0">
                                                    <div class="form-group cs-checkbox">
                                                        <input type="checkbox" class="checkbox-custom categoryList" id="category_one{{$key}}" value="{{$value->category_id}}" name="category[1][{{$value->category_id}}]" data-category="one">
                                                        <label for="category_one{{$key}}">{{$value->category_name}}</label>
                                                    </div>
                                                    <div class="card-header collapsed" data-toggle="collapse" href="#collapse_one{{$key}}">
                                                        <a class="card-title">
                                                            <i class="fa fa-plus"></i>
                                                        </a>
                                                    </div>
                                                    <div id="collapse_one{{$key}}" class="card-body collapse" data-parent="#accordion" >
                                                        @foreach($value->category_item as $key1 => $value1)
                                                            <div class="form-group cs-checkbox">
                                                                <input type="checkbox" class="checkbox-custom category_item_one category_one{{$key}}" id="item{{$value->category_id.$key1}}1" value="{{$value1->menu_id}}" name="category[1][{{$value->category_id}}][{{$value1->menu_id}}]" data-category="one">
                                                                <label for="item{{$value->category_id.$key1}}1">{{$value1->item_name}}</label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                  </div>
                                  <div class="form-group form-btn justify-content-center">
                                    <a class="close eligible_popup_remove eligible_popup-inner" href="#" data-popup="one">Submit</a>
                                  </div>
                                </div>
                            </div>

                            <div id="field-two" class="overlay field-popup">
                                <div class="popup text-center">
                                  <h2>Eligible Items</h2>
                                  <a class="close eligible_popup_close" href="#">&times;</a>
                                  <div class="content">
                                    <div id="accordion" class="accordion">
                                        @foreach($category as $key=>$value)
                                            @if($value->category_item->count() != 0)
                                                <div class="card mb-0">
                                                    <div class="form-group cs-checkbox">
                                                        <input type="checkbox" class="checkbox-custom categoryList" id="category_two{{$key}}" value="{{$value->category_id}}" name="category[2][{{$value->category_id}}]" data-category="two">
                                                        <label for="category_two{{$key}}">{{$value->category_name}}</label>
                                                    </div>
                                                    <div class="card-header collapsed" data-toggle="collapse" href="#collapse_two{{$key}}">
                                                        <a class="card-title">
                                                            <i class="fa fa-plus"></i>
                                                        </a>
                                                    </div>
                                                    <div id="collapse_two{{$key}}" class="card-body collapse" data-parent="#accordion" >
                                                        @foreach($value->category_item as $key1=>$value1)
                                                            <div class="form-group cs-checkbox">
                                                                <input type="checkbox" class="checkbox-custom category_item_two category_two{{$key}}" id="item{{$value->category_id.$key1}}2" value="{{$value1->menu_id}}" name="category[2][{{$value->category_id}}][{{$value1->menu_id}}]">
                                                                <label for="item{{$value->category_id.$key1}}2">{{$value1->item_name}}</label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                  </div>
                                  <div class="form-group form-btn justify-content-center">
                                    <a class="close eligible_popup_remove eligible_popup-inner" href="#" data-popup="two">Submit</a>
                                  </div>
                                </div>
                            </div>

                            <div id="field-three" class="overlay field-popup">
                                <div class="popup text-center">
                                  <h2>Eligible Items</h2>
                                  <a class="close eligible_popup_close" href="#">&times;</a>
                                  <div class="content">
                                    <div id="accordion" class="accordion">
                                        @foreach($category as $key=>$value)
                                            <div class="card mb-0">
                                                <div class="form-group cs-checkbox">
                                                    <input type="checkbox" class="checkbox-custom categoryList" id="category_three{{$key}}" value="{{$value->category_id}}" name="category[3][{{$value->category_id}}]" >
                                                    <label for="category_three{{$key}}">{{$value->category_name}}</label>
                                                </div>
                                                <div class="card-header collapsed" data-toggle="collapse" href="#collapse_three{{$key}}">
                                                    <a class="card-title">
                                                        <i class="fa fa-plus"></i>
                                                    </a>
                                                </div>
                                                <div id="collapse_three{{$key}}" class="card-body collapse" data-parent="#accordion" >
                                                    @foreach($value->category_item as $key1=>$value1)
                                                        <div class="form-group cs-checkbox">
                                                            <input type="checkbox" class="checkbox-custom category_item_three category_three{{$key}}" id="item{{$value->category_id.$key1}}3" value="{{$value1->menu_id}}" name="category[3][{{$value->category_id}}][{{$value1->menu_id}}]" data-category="three">
                                                            <label for="item{{$value->category_id.$key1}}3">{{$value1->item_name}}</label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                  </div>
                                  <div class="form-group form-btn justify-content-center">
                                    <a class="close eligible_popup_remove eligible_popup-inner" href="#" data-popup="three">Submit</a>
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
                        <button type="submit" class="btn-blue"><span>Submit</span></button>
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

@endsection


@section('scripts')
    <script>
        $("#display_time").change(function() {
            if (this.value == "Restricted") {
                var overlay_url = window.location.href.replace("#","");
                window.location.href = overlay_url += "#restricted-duration";
            }
        });
    </script>
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    <script src="{{ asset('assets/js/common.js')}}"></script>
    <script src="{{ asset('assets/js/type/buyTwoThree.js')}}"></script>
    <script src="{{asset('vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    @if ($webview == 1)
        <script src="{{asset('assets/customer/js/jquery.validate.min.js')}}"></script>
        <script src="{{asset('assets/customer/js/additional-methods.min.js')}}"></script>
        <script src="{{asset('assets/js/type/buyTwoThree-webview.js')}}"></script>
    @else
        {!! JsValidator::formRequest('App\Http\Requests\PromotionFixeddiscountRequest','#promotionForm'); !!}
    @endif
@endsection
