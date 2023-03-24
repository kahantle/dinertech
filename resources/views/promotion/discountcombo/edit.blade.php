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
                                <h2>Edit % Discount On Combo Deal</h2>
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
                            <input type="text" class="form-control" id="promotion_name" name="promotion_name" placeholder="Enter Headline" value="{{$promotion->promotion_name}}">
                        </div>
                        <div class="form-group">
                            <img src="{{ asset('assets/images/description.png') }}">
                            <textarea type="text" class="form-control" id="promotion_details" name="promotion_details" placeholder="Enter Description(Optional)">{{$promotion->promotion_details}}</textarea>
                        </div>
                    </div>
                    <div class="@if($webview == 1) col-md-7 @else col-lg-7 @endif promotion-add-border">
                        <div class="text-promotion">
                            <h5>Eligible Items</h5>
                        </div>

                        <div id="inputFormRow">
                            <div class="input-group">
                                <div class="input-popup inputpop-inner w-100" id="eligibleItems">
                                    @for ($i = 1;$i <= $eligibleItems;$i++)
                                        <div id="eligible-item-{{convertNumberToWord($i)}}" class="form-group eligible-item">
                                            <a href="#field-{{convertNumberToWord($i)}}" class="fill-inner w-100 fill-sec">
                                                <img src="{{ asset('assets/images/order-cart.png')}}" class="items-inner-st-sec wd-dr-wrapper">
                                                <p name="slct" id="slct-{{convertNumberToWord($i)}}" class="form-control inner-p-wrapper-blog-sys">Eligible Items Group {{$i}}</p>
                                            </a>
                                            <button type="button" class="btn btn-remove btn-remove-1" data-remove="{{convertNumberToWord($i)}}">✕</button>

                                            <div>
                                                <input type="text" style="clip-path: circle(0);height: 0;padding: 0; width: 0; position: absolute; opacity: 0;" id="hidden_eligible_item_{{convertNumberToWord($i)}}" name="hidden_eligible_item_{{convertNumberToWord($i)}}" />
                                            </div>
                                        </div>
                                    @endfor
                                </div>
                            </div>
                        </div>

                        <div class="d-flex">
                            <button id="addEligibleItems" type="button" class="btn btn-info add-button">Add</button>
                        </div>

                        <div class="form-group minimumAmountDiv">
                            <img src="{{ asset('assets/images/tag-d.png')}}">
							<input type="text" class="form-control discount_percentage" id="minimumAmount" name="discount_usd_percentage_amount" placeholder="Discount (%)" value="{{$promotion->discount}}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
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
                                  <option value="{{$item}}" {{($promotion->order_type == $item)? 'selected':''}}>{{$item}}</option>
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
                            <input type="checkbox" class="checkbox-custom" id="client" name="only_once_per_client" @if($promotion->only_once_per_client == "true") checked @endif>
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

                        <!-- <div id="restricted-duration" class="overlay field-popup">
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
                        </div> -->
                        <div class="modal fade" id="Admin" role="dialog" tabindex="-1">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h2 class="modal-title">Restricted Duration</h2><button aria-label="Close"
                                            class="close" data-dismiss="modal" type="button"><span
                                                aria-hidden="true">&times;</span></button>
                                    </div>
                                    <div class="modal-body text-center">
                                        <div class="accordion row" id="accordion">
                                            <div class="form-group col-md-6">
                                                <label for="daysInput">Date</label>
                                                <input data-provide="datepicker"
                                                    value="<?php echo \Carbon\Carbon::parse($promotion->restricted_days)->format('m-d-Y'); ?>"
                                                    data-date-autoclose="true" class="form-control"
                                                    placeholder="Select Date" data-date-format="mm-dd-yyyy"
                                                    name="restricted_days" id="daysInput">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="hoursInput">Hours</label>
                                                <input type="text" id="start_time" name="restricted_hours"
                                                    value="{{$promotion->restricted_hours}}"
                                                    class="form-control input-sm" placeholder="Select Time"
                                                    name="start_time" autocomplete="off" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer justify-content-center">
                                        <button class="btn btn-submit" data-dismiss="modal"
                                            type="button">Submit</button>
                                        {{-- <button class="btn btn-primary" type="button">Save changes</button> --}}
                                    </div>
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                        </div><!-- /.modal -->

                        <div id="addEligiblePopup">
                            @for ($i = 1;$i <= $eligibleItems;$i++)
                                <div id="field-{{convertNumberToWord($i)}}" class="overlay field-popup">
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
                                                                    $category_selected =  \App\Models\PromotionCategoryItem::where(['category_id' => $value->category_id])->where(['promotion_id' => $promotion->promotion_id])->where('eligible_item_id',$i)->count();
                                                                    if($category_selected >0){
                                                                        $all = $value->category_item->count()===$category_selected ;
                                                                    }else{
                                                                        $all=false;
                                                                    }
                                                                @endphp
                                                                <input type="checkbox" class="checkbox-custom categoryList" {{($all)?'checked':''}} id="category_{{convertNumberToWord($i)}}{{$key}}" value="{{$value->category_id}}" name="category[{{$i}}][{{$value->category_id}}]" data-category="{{convertNumberToWord($i)}}">
                                                                <label for="category_{{convertNumberToWord($i)}}{{$key}}">{{$value->category_name}}</label>
                                                            </div>
                                                            <div class="card-header collapsed" data-toggle="collapse" href="#collapse_{{convertNumberToWord($i)}}{{$key}}">
                                                                <a class="card-title">
                                                                    <i class="fa fa-plus"></i>
                                                                </a>
                                                            </div>
                                                            <div id="collapse_{{convertNumberToWord($i)}}{{$key}}" class="card-body collapse" data-parent="#accordion" >
                                                                @foreach($value->category_item as $key1=>$value1)
                                                                    @php
                                                                        $category_select_item =  \App\Models\PromotionCategoryItem::where(['category_id' => $value->category_id])->where(['item_id' => $value1->menu_id])->where(['promotion_id' => $promotion->promotion_id])->where('eligible_item_id',$i)->first();
                                                                        if($category_select_item){
                                                                            $category_item_count = $category_item_count+1;
                                                                        }
                                                                    @endphp
                                                                    <div class="form-group cs-checkbox">
                                                                        <input type="checkbox" class="checkbox-custom category_item_{{convertNumberToWord($i)}} category_{{convertNumberToWord($i)}}{{$key}}" id="item{{$value->category_id}}{{$key1}}" {{($category_select_item)?'checked':''}} value="{{$value1->menu_id}}" name="category[{{$i}}][{{$value->category_id}}][{{$value1->menu_id}}]" data-category="{{convertNumberToWord($i)}}">
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
                                            <input type="hidden" class="total_item_count_{{convertNumberToWord($i)}}" value="{{$category_item_count}}">
                                            <a class="close eligible_popup_remove eligible_popup-inner" href="#" data-popup="{{convertNumberToWord($i)}}">Submit</a>
                                        </div>
                                    </div>
                                </div>
                            @endfor
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
    $("#display_time").on("change", function() {
        var sOptionVal = $(this).val();
        if (sOptionVal == 'Restricted') {
            $('#Admin').modal('show');
        }
    });
    </script>
    <!-- <script>
        $("#display_time").change(function() {
            if (this.value == "Restricted") {
                var overlay_url = window.location.href.replace("#","");
                window.location.href = overlay_url += "#restricted-duration";
            }
        });
    </script> -->
     <script>
            document.addEventListener('DOMContentLoaded', function () {
                jQuery('#start_time, #end_time, #appt_time, #meet_time, #odd_time').timepicker({

                });
            });
    </script>
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    <script src="{{ asset('assets/js/common.js')}}"></script>
    <script src="{{ asset('assets/js/type/buyTwoThree.js')}}"></script>
    <script src="{{asset('vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{asset('vendor/timepicker-bs4.js')}}" defer="defer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dayjs/1.11.4/dayjs.min.js" integrity="sha512-Ot7ArUEhJDU0cwoBNNnWe487kjL5wAOsIYig8llY/l0P2TUFwgsAHVmrZMHsT8NGo+HwkjTJsNErS6QqIkBxDw==" crossorigin="anonymous" referrerpolicy="no-referrer" defer="defer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/js/bootstrap.bundle.min.js" integrity="sha512-igl8WEUuas9k5dtnhKqyyld6TzzRjvMqLC79jkgT3z02FvJyHAuUtyemm/P/jYSne1xwFI06ezQxEwweaiV7VA==" crossorigin="anonymous" referrerpolicy="no-referrer" defer="defer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js" integrity="sha512-Tn2m0TIpgVyTzzvmxLNuqbSJH3JP8jm+Cy3hvHrW7ndTDcJ1w5mBiksqDBb8GpE2ksktFvDB/ykZ0mDpsZj20w==" crossorigin="anonymous" referrerpolicy="no-referrer" defer="defer"></script>
    @if ($webview == 1)
        <script src="{{asset('assets/customer/js/jquery.validate.min.js')}}"></script>
        <script src="{{asset('assets/customer/js/additional-methods.min.js')}}"></script>
        <script src="{{asset('assets/js/type/buyTwoThree-webview.js')}}"></script>
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
        {!! JsValidator::formRequest('App\Http\Requests\PromotionFixeddiscountRequest','#promotionForm'); !!}
    @endif
@endsection
