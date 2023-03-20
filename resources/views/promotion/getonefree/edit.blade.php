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
        {{ Form::open(array('route' => array('promotion.add.get.one.free.webView'),'id'=>'promotionForm','method'=>'POST','class'=>'','files'=>'true')) }}
        <input type="hidden" name="restaurant_user_id" value="{{$uid}}">
    @else
        {{ Form::open(array('route' => array('promotion.add.free.getonefree.post'),'id'=>'promotionForm','method'=>'POST','class'=>'','files'=>'true')) }}
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
                        <h2> Edit Buy one,get one free.</h2>
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
                          <input type="text" class="form-control" id="promotion_code" name="promotion_code" placeholder="Promo code(Optional)" value="{{$promotion->promotion_code}}" maxlength="15">
                          <input type="hidden" id="promotion_id" name="promotion_id" value="{{$promotion->promotion_id}}" />
                        </div>
                        <div class="form-group">
                          <img src="{{ asset('assets/images/speaker.png') }}">
                          <input type="text" class="form-control" id="promotion_name" name="promotion_name" placeholder="Enter Title" value="{{$promotion->promotion_name}}">
                        </div>
                        <div class="form-group">
                          <img src="{{ asset('assets/images/description.png') }}">
                          <textarea type="text" class="form-control" id="promotion_details" name="promotion_details" placeholder="Enter Description(Optional)">{{$promotion->promotion_details}}</textarea>
                        </div>
                    </div>
                    <div class="@if($webview == 1) col-md-7 @else col-lg-7 @endif promotion-add-border">

                        <div class="form-group select-input input-popup inputpop-inner">
                            <a href="#field-one" class="fill-inner fill-p-bog">
                               <img src="{{ asset('assets/images/modifiers-black.png') }}" class="items-inner-st wd-dr-wrapper">
                               <p name="slct" id="slct" class="form-control inner-p-wrapper-blog-sys">Eligible Items Group 1</p>
                            </a>
                        </div>

                        <div>
                            <input type="text" style="clip-path: circle(0);height: 0;padding: 0; width: 0; position: absolute; opacity: 0;" id="hidden_eligible_item_first" name="hidden_eligible_item_first" />
                        </div>

                        <div class="form-group select-input input-popup inputpop-inner">
                            <a href="#field-two" class="fill-inner fill-p-bog">
                                <img src="{{ asset('assets/images/modifiers-black.png') }}" class="items-inner-st wd-dr-wrapper">
                                <p name="slct-two" id="slct-two" class="form-control inner-p-wrapper-blog-sys">Eligible Items Group 2</p>
                            </a>
                        </div>

                        <div>
                            <input type="text" style="clip-path: circle(0);height: 0;padding: 0; width: 0; position: absolute; opacity: 0;" id="hidden_eligible_item_second" name="hidden_eligible_item_second" />
                        </div>

                        <div class="text-promotion">
                            <h5>Discount</h5>
                        </div>

                        <div class="tab-container">
                            <div class="tab-navigation">
                                <div class="form-group select-input">
                                    <img src="{{ asset('assets/images/Promotion Function.png') }}">
                                    <select id="select-box" class="form-control" name="auto_manually_discount">
                                        @foreach (Config::get('constants.AUTO_DISCOUNT') as $key=>$item)
                                            <option value="{{$item}}" {{($promotion->auto_manually_discount==$item)?'selected':''}}>{{$item}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @if ($promotion->auto_manually_discount == Config::get('constants.AUTO_DISCOUNT.2'))
                                <div id="tab-2" class="tab-content">
                            @else
                                <div id="tab-2" class="tab-content" style="display: none">
                            @endif

                                @foreach ($eligibleItems as $key => $item)
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text inner-text-blog">
                                                Items Group {{$key + 1}}:
                                            </span>
                                        </div>
                                        <input type="text" class="form-control discount_percentage" value="{{$item->item_group_discount}}" name="item_group_{{$key + 1}}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text input-group-text-first">%</span>
                                        </div>
                                    </div>
                                @endforeach
                                {{-- <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text inner-text-blog">
                                            Items Group 1:
                                        </span>
                                    </div>
                                    <input type="text" class="form-control discount_percentage" value="{{$promotion->item_group_1}}"  name="item_group_1" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text input-group-text-first">%</span>
                                    </div>
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text inner-text-blog">
                                            Items Group 2:
                                        </span>
                                    </div>
                                    <input type="text" class="form-control discount_percentage" value="{{$promotion->item_group_2}}"  name="item_group_2" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text input-group-text-first">%</span>
                                    </div>
                                </div> --}}
                            </div>
                            @if ($promotion->auto_manually_discount == Config::get('constants.AUTO_DISCOUNT.1'))
                                <div id="tab-1" class="tab-content">
                            @else
                                <div id="tab-1" class="tab-content" style="display: none">
                            @endif

                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text inner-text-blog">
                                            Discount for cheapest item:
                                        </span>
                                    </div>
                                    <input type="text" class="form-control discount_percentage" value="100"  name="discount_cheapest" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" readonly>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text input-group-text-first">%</span>
                                    </div>
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text inner-text-blog">
                                            Discount for most expensive item:
                                        </span>
                                    </div>
                                    <input type="text" class="form-control discount_percentage" value="0"  name="discount_expensive" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" readonly>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text input-group-text-first">%</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group select-input">
                            <img src="{{ asset('assets/images/modifiers-black.png') }}">
                            <select name="no_extra_charge" id="no_extra_charge" class="form-control">
                              @foreach (Config::get('constants.NO_EXTRA_CHARGES') as $key=>$item)
                                <option value="{{$item}}" {{($promotion->no_extra_charge_type == $item)?'selected':''}}>{{$item}}</option>
                              @endforeach
                            </select>
                        </div>

                        <div class="form-group select-input">
                            <img src="{{ asset('assets/images/modifiers-black.png') }}">
                            <select name="client_type" id="client_type" class="form-control">
                                  <option value="">Customer type</option>
                                  @foreach (Config::get('constants.CLIENT_TYPE') as $key=>$item)
                                      <option value="{{$item}}" {{($promotion->client_type == $item)?'selected':''}}>{{$item}}</option>
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
                            <img src="{{ asset('assets/images/client-t.png') }}">
                            <select name="mark_promo_as" id="mark_promo_as" class="form-control">
                              <option selected disabled>Mark Promo as</option>
                              @foreach (Config::get('constants.MARK_PROMO_AS') as $key=>$item)
                                <option value="{{$item}}" {{($promotion->mark_promoas_status == $item)?'selected':''}}>{{$item}}</option>
                              @endforeach
                            </select>
                        </div>

                        <div class="form-group select-input">
                            <img src="{{ asset('assets/images/Availability.png') }}">
                            <select name="availability" id="display_time" class="form-control">
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
                                        <label for="daysInput">Date</label>
                                        <input data-provide="datepicker"  value="<?php echo \Carbon\Carbon::parse($promotion->restricted_days)->format('m-d-Y'); ?>"  data-date-autoclose="true" class="form-control" placeholder="Select Date" data-date-format="mm-dd-yyyy" name="restricted_days" id="daysInput">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="hoursInput">Hours</label>
                                        <input type="text" id="start_time" name="restricted_hours" value="{{$promotion->restricted_hours}}" class="form-control input-sm" placeholder="Select Time" name="start_time" autocomplete="off" />
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
                                                        $category_selected =  \App\Models\PromotionCategoryItem::where(['category_id' => $value->category_id])->where(['promotion_id' => $promotion->promotion_id])->where('eligible_item_id',1)->count();
                                                        if($category_selected > 0){
                                                            $all = $value->category_item->count() === $category_selected;
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
                                                        $category_select_item =  \App\Models\PromotionCategoryItem::where(['category_id' => $value->category_id])->where(['item_id' => $value1->menu_id])->where(['promotion_id' => $promotion->promotion_id])->where('eligible_item_id',1)->first();
                                                        if($category_select_item){
                                                            $category_item_count = $category_item_count+1;
                                                        }
                                                    @endphp
                                                  <div class="form-group cs-checkbox">
                                                      <input type="checkbox" class="checkbox-custom category-item-first category{{$key}}" {{($category_select_item)?'checked':''}} id="item{{$value->category_id}}{{$key1}}" value="{{$value1->menu_id}}" name="category[{{$value->category_id}}][{{$value1->menu_id}}]">
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
                                  <a class="close eligible-popup-close-first eligible_popup-inner" href="#">Submit</a>
                              </div>
                            </div>
                        </div>

                        <div id="field-two" class="overlay field-popup">
                            <div class="popup text-center">
                              <h2>Eligible Items</h2>
                              <a class="close eligible_popup_close" href="#">&times;</a>
                              <div class="content">
                                  <div id="accordion" class="accordion">
                                    @php
                                        $second_category_item_count =0;
                                    @endphp
                                      @foreach($category as $key=>$value)
                                          <div class="card mb-0">
                                              <div class="form-group cs-checkbox">
                                                    @php
                                                        $category_selected =  \App\Models\PromotionCategoryItem::where(['category_id' => $value->category_id])->where(['promotion_id' => $promotion->promotion_id])->where('eligible_item_id',2)->count();
                                                        if($category_selected >0){
                                                            $all = $value->category_item->count() === $category_selected ;
                                                        }else{
                                                            $all = false;
                                                        }
                                                    @endphp
                                                  <input type="checkbox" class="checkbox-custom categoryList-two" {{($all)?'checked':''}} id="category-two{{$key}}" value="{{$value->category_id}}" name="category_two[{{$value->category_id}}]">
                                                  <label for="category-two{{$key}}">{{$value->category_name}}</label>
                                              </div>
                                              <div class="card-header collapsed" data-toggle="collapse" href="#collapse-two{{$key}}">
                                                  <a class="card-title">
                                                      <i class="fa fa-plus"></i>
                                                  </a>
                                              </div>
                                              <div id="collapse-two{{$key}}" class="card-body collapse" data-parent="#accordion" >
                                                 @foreach($value->category_item as $key1=>$value1)
                                                    @php
                                                        $category_select_item =  \App\Models\PromotionCategoryItem::where(['category_id' => $value->category_id])->where(['item_id' => $value1->menu_id])->where(['promotion_id' => $promotion->promotion_id])->where('eligible_item_id',2)->first();
                                                        if($category_select_item){
                                                            $second_category_item_count = $second_category_item_count+1;
                                                        }
                                                    @endphp
                                                  <div class="form-group cs-checkbox">
                                                      <input type="checkbox" class="checkbox-custom category-item-second category-two{{$key}}" {{($category_select_item)?'checked':''}} id="item-two{{$value->category_id}}{{$key1}}" value="{{$value1->menu_id}}" name="category_two[{{$value->category_id}}][{{$value1->menu_id}}]">
                                                      <label for="item-two{{$value->category_id}}{{$key1}}">{{$value1->item_name}}</label>
                                                  </div>
                                                  @endforeach
                                              </div>
                                          </div>
                                      @endforeach
                                  </div>
                              </div>
                              <div class="form-group form-btn justify-content-center">
                                  <a class="close eligible-popup-close-second eligible_popup-inner" href="#">Submit</a>
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
                        <button type="button" class="btn-grey btn-inner cancel"><span><a style="color:black" href="/close">Cancel</a></span></button>
                    </div>
                    <div class="btn-custom">
                        <button type="submit" class="btn-blue btn-inner formsubmit" ><span>Update</span></button>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        var first_item_count = {!! json_encode($category_item_count) !!};
        if(first_item_count){
            $("#slct").text(first_item_count+" Eligible items selected.");
            $("#hidden_eligible_item-first").val(first_item_count)
        }

        var second_item_count = {!! json_encode($second_category_item_count) !!};
        if(second_item_count){
            $("#slct-two").text(second_item_count+" Eligible items selected.");
            $("#hidden_eligible_item-second").val(second_item_count)
        }
        $("#display_time").change(function() {
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
    <script src="{{ asset('assets/js/type/getonefree.js')}}"></script>
    <script src="{{asset('vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{asset('vendor/timepicker-bs4.js')}}" defer="defer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dayjs/1.11.4/dayjs.min.js" integrity="sha512-Ot7ArUEhJDU0cwoBNNnWe487kjL5wAOsIYig8llY/l0P2TUFwgsAHVmrZMHsT8NGo+HwkjTJsNErS6QqIkBxDw==" crossorigin="anonymous" referrerpolicy="no-referrer" defer="defer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/js/bootstrap.bundle.min.js" integrity="sha512-igl8WEUuas9k5dtnhKqyyld6TzzRjvMqLC79jkgT3z02FvJyHAuUtyemm/P/jYSne1xwFI06ezQxEwweaiV7VA==" crossorigin="anonymous" referrerpolicy="no-referrer" defer="defer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js" integrity="sha512-Tn2m0TIpgVyTzzvmxLNuqbSJH3JP8jm+Cy3hvHrW7ndTDcJ1w5mBiksqDBb8GpE2ksktFvDB/ykZ0mDpsZj20w==" crossorigin="anonymous" referrerpolicy="no-referrer" defer="defer"></script>
    @if ($webview == 1)
        <script src="{{asset('assets/customer/js/jquery.validate.min.js')}}"></script>
        <script src="{{asset('assets/customer/js/additional-methods.min.js')}}"></script>
        <script src="{{asset('assets/js/type/getonefree-webview.js')}}"></script>
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
        {!! JsValidator::formRequest('App\Http\Requests\PromotionGetonefreeRequest','#promotionForm'); !!}
    @endif
@endsection
