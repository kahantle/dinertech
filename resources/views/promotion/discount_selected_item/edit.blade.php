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
        {{ Form::open(array('route' => array('promotion.add.selected.items.webView'),'id'=>'promotionForm','method'=>'POST','class'=>'','files'=>'true')) }}
        <input type="hidden" name="restaurant_user_id" value="{{$uid}}">
    @else
        {{ Form::open(array('route' => array('promotion.add.selecte.items.post'),'id'=>'promotionForm','method'=>'POST','class'=>'','files'=>'true')) }}
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
                                <h2>  Edit % or Discount on selected items.</h2>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        @endif

        <div class="add-category Promotion content-wrapper">
            <div class="container-fluid">
                <div class="row">
                  <div class="col-md-5">
                    <div class="form-group">
                      <img src="{{ asset('assets/images/percentage.png') }}">
                      <input type="text" class="form-control" id="promotion_code" name="promotion_code" value="{{$promotion->promotion_code}}" placeholder="Promo code(Optional)" maxlength="15">
                      <input type="hidden" id="promotion_id" name="promotion_id" value="{{$promotion->promotion_id}}" />
                    </div>
                    <div class="form-group">
                      <img src="{{ asset('assets/images/speaker.png') }}">
                      <input type="text" class="form-control" id="promotion_name" name="promotion_name" value="{{$promotion->promotion_name}}" placeholder="Enter Title">
                    </div>
                    <div class="form-group">
                      <img src="{{ asset('assets/images/description.png') }}">
                      <textarea type="text" class="form-control" id="promotion_details" name="promotion_details" placeholder="Enter Description(Optional)">{{$promotion->promotion_details}}</textarea>
                    </div>
                  </div>
                  <div class="col-md-7 promotion-add-border">
                    <div class="form-group select-input input-popup">
                      <a href="#field-one">
                        <img src="{{ asset('assets/images/modifiers-black.png') }}">
                        <p name="slct" id="slct" class="form-control">Eligible Items</p>
                      </a>
                    </div>

                    <div>
                      <input type="text" style="clip-path: circle(0);height: 0;padding: 0; width: 0; position: absolute; opacity: 0;" id="hidden_eligible_item" name="hidden_eligible_item" />
                    </div>

                    <div class="text-promotion">
                      <h5>Discount</h5>
                    </div>

                    <div class="form-group">
                        <img src="{{ asset('assets/images/tag-d.png') }}">
                        <input type="text" class="form-control" id="discount_amount" name="discount_usd_percentage_amount" class="discount_amount" value="{{$promotion->discount}}" placeholder="Discount (USD)" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                    </div>

                    <div class="text-promotion">
                        <h5>Minimum Order Amount</h5>
                    </div>

                    <div class="form-group cs-checkbox">
                        <input type="checkbox" class="checkbox-custom setMinimumOrderAmount" value="allow" id="setMinimumOrderAmount" name="set_minimum_order" {{($promotion->set_minimum_order)?'checked':''}}>
                        <label for="setMinimumOrderAmount">set a minimum order value (recommended)</label>
                    </div>
                    @if ($promotion->set_minimum_order)
                        <div class="form-group minimumAmountDiv">
                    @else
                        <div class="form-group minimumAmountDiv" style="display: none">
                    @endif
                        <img src="{{ asset('assets/images/tag-d.png') }}">
                        <input type="text" class="form-control" id="minimumAmount" name="set_minimum_order_amount" placeholder="Minimum Order Amount (USD)" value="{{$promotion->set_minimum_order_amount}}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                    </div>

                    <div class="form-group select-input">
                      <img src="{{ asset('assets/images/modifiers-black.png') }}">
                      <select name="client_type" id="client_type" class="form-control">
                            <option value="">Customer type</option>
                            @foreach (Config::get('constants.CLIENT_TYPE') as $key=>$item)
                                <option value="{{$item}}"  {{($promotion->client_type==$item)?'selected':''}}>{{$item}}</option>
                            @endforeach
                      </select>
                    </div>

                    <div class="form-group select-input">
                      <img src="{{ asset('assets/images/modifiers-black.png') }}">
                      <select name="order_type" id="order_type" class="form-control">
                        <option selected="" value="">Order Type</option>
                        @foreach (Config::get('constants.ORDER_TYPE') as $key=>$item)
                            <option value="{{$item}}" {{($promotion->order_type==$item)?'selected':''}}>{{$item}}</option>
                        @endforeach
                      </select>
                    </div>

                    <div class="form-group cs-checkbox">
                        <input type="checkbox" class="checkbox-custom onlyForSelectedPayment" id="payment" name="only_selected_payment_method" {{($promotion->only_selected_payment_method)?'checked':''}}>
                        <label for="payment">Apply To Selected Payment Methods</label>

                        @if($promotion->only_selected_payment_method)
                            <div class="form-group cs-checkbox onlyForSelectedPaymentDiv">
                        @else
                            <div class="form-group cs-checkbox onlyForSelectedPaymentDiv" style="display: none">
                        @endif

                            <div class="cash-blog mt-1">
                                <input type="checkbox" class="checkbox-custom cash" id="cash" name="only_selected_cash" {{($promotion->only_selected_cash)?'checked':''}}>
                                <label for="cash">Cash</label>
                            </div>

                            <div class="cash-blog">
                                <input type="checkbox" class="checkbox-custom cardtodelivery" id="cardtodelivery" name="only_selected_cash_delivery_person" {{($promotion->only_selected_cash_delivery_person)?'checked':''}}>
                                <label for="cardtodelivery">Credit Card</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group cs-checkbox">
                        <input type="checkbox" class="checkbox-custom" id="client" name="only_once_per_client" {{($promotion->only_once_per_client == "true")?'checked':''}}>
                        <label for="client">Single Use Per Customer</label>
                    </div>

                    <div class="form-group select-input">
                        <img src="{{ asset('assets/images/modifiers-black.png') }}">
                        <select name="no_extra_charge" id="no_extra_charge" class="form-control">
                            @foreach (Config::get('constants.NO_EXTRA_CHARGES') as $key=>$item)
                              <option value="{{$item}}" {{($promotion->no_extra_charge_type==$item)?'selected':''}}>{{$item}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group select-input">
                        <img src="{{ asset('assets/images/Promotion_Function.png') }}">
                        <select name="promotion_function" id="promotion_function" class="form-control">
                            <option selected="" value="">Promotion Function</option>
                            @foreach (Config::get('constants.PROMOTION_FUNCTION') as $key=>$item)
                                <option value="{{$item}}" {{($promotion->promotion_function==$item)?'selected':''}}>{{$item}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group select-input">
                        <img src="{{ asset('assets/images/Availability.png') }}">
                        <select name="availability" id="availability" class="form-control">
                            <option disabled>Availability</option>
                            @foreach (Config::get('constants.AVAILABILITY') as $key=>$item)
                                <option value="{{$item}}" {{($promotion->availability==$item)?'selected':''}}>{{$item}}</option>
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
                                    <label for="daysInput">Days</label>
                                    <input type="number" name="restricted_days" value="{{$promotion->restricted_days}}" class="form-control input-sm" id="daysInput">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="hoursInput">Hours</label>
                                    <input type="number" name="restricted_hours" value="{{$promotion->restricted_hours}}" max="23" class="form-control input-sm" id="hoursInput">
                                </div>
                            </div>
                            <div class="form-group form-btn justify-content-center">
                                <a class="close eligible_popup_close eligible_popup-inner" href="#">Submit</a>
                            </div>
                            </div>
                        </div>
                    </div>

                    <div id="field-one" class="overlay field-popup">
                      <div class="popup text-center">
                        <h2>Eligible Items</h2>
                        <a class="close eligible_popup_close" href="#">&times;</a>
                        <div class="content">
                            <div id="accordion" class="accordion">
                                @php
                                    $category_item_count =0;
                                @endphp
                                @foreach($category as $key=>$value)
                                    @if($value->category_item->count() != 0)
                                        <div class="card mb-0">
                                            <div class="form-group cs-checkbox">
                                                @php
                                                    $category_selected =  \App\Models\PromotionCategoryItem::where(['category_id' => $value->category_id])->where(['promotion_id' => $promotion->promotion_id])->count();
                                                    if($category_selected >0){
                                                        $all = $value->category_item->count()===$category_selected ;
                                                    }else{
                                                        $all=false;
                                                    }
                                                @endphp
                                                <input type="checkbox" class="checkbox-custom categoryList" {{($all)?'checked':''}} id="category{{$key}}" value="{{$value->category_id}}" name="category[{{$value->category_id}}]">
                                                <label for="category{{$key}}">{{$value->category_name}}</label>
                                            </div>
                                            <div class="card-header collapsed" data-toggle="collapse" href="#collapse{{$key}}">
                                                <a class="card-title">
                                                    <i class="fa fa-plus"></i>
                                                </a>
                                            </div>
                                            <div id="collapse{{$key}}" class="card-body collapse" data-parent="#accordion" >
                                            @foreach($value->category_item as $key1=>$value1)
                                                @php
                                                    $category_select_item =  \App\Models\PromotionCategoryItem::where(['category_id' => $value->category_id])->where(['item_id' => $value1->menu_id])->where(['promotion_id' => $promotion->promotion_id])->first();
                                                    if($category_select_item){
                                                        $category_item_count = $category_item_count+1;
                                                    }
                                                @endphp
                                                <div class="form-group cs-checkbox">
                                                    <input type="checkbox" class="checkbox-custom category_item category{{$key}}" {{($category_select_item)?'checked':''}} id="item{{$value->category_id}}{{$key1}}" value="{{$value1->menu_id}}" name="category[{{$value->category_id}}][{{$value1->menu_id}}]">
                                                    <label for="item{{$value->category_id}}{{$key1}}">{{$value1->item_name}}</label>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
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
            @if ($webview == 0)
                <div class="form-group form-btn-menu from-inner">
                    <div class="btn-custom">
                        <a href="{{route('promotion')}}" class="btn-grey"><span>Cancel</span></a>
                    </div>
                    <div class="btn-custom">
                        <button type="submit" class="btn-blue"><span>Update</span></button>
                    </div>
                </div>
            @else
                <div class="form-group form-btn-menu from-inner">
                    <div class="btn-custom">
                        <button type="button" class="btn-grey btn-inner cancel" ><span>Cancel</span></button>
                    </div>
                    <div class="btn-custom">
                        <button type="submit" class="btn-blue btn-inner formsubmit" ><span>Update</span></button>
                    </div>
                </div>
            @endif
        </div>
    </section>
</form>
@endsection

@section('scripts')
<script>
    var item_count = {!! json_encode($category_item_count) !!};
    if(item_count){
      $("#slct").text(item_count+" Eligible items selected.");
      $("#hidden_eligible_item").val(item_count)
    }
    $("#availability").change(function() {
        if (this.value == "Restricted") {
            var overlay_url = window.location.href.replace("#","");
            window.location.href = overlay_url += "#restricted-duration";
        }
    });
</script>
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
<script src="{{ asset('assets/js/common.js')}}"></script>
<script src="{{ asset('assets/js/type/discountselected.js')}}"></script>
@if ($webview == 1)
    <script src="{{asset('assets/customer/js/jquery.validate.min.js')}}"></script>
    <script src="{{asset('assets/customer/js/additional-methods.min.js')}}"></script>
    <script src="{{asset('assets/js/type/discountselected-webview.js')}}"></script>
@else
    {!! JsValidator::formRequest('App\Http\Requests\PromotionSelectedItemRequest','#promotionForm'); !!}
@endif
@endsection
