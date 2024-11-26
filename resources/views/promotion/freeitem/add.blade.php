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
        {{ Form::open(array('route' => array('promotion.add.freeItem.webView'),'id'=>'promotionForm','method'=>'POST','class'=>'','files'=>'true')) }}
        <input type="hidden" name="restaurant_user_id" value="{{$uid}}">
    @else
        {{ Form::open(array('route' => array('promotion.add.free.items.post'),'id'=>'promotionForm','method'=>'POST','class'=>'','files'=>'true')) }}
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
                            <h2>  Get a Free Item.</h2>
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
                            <input type="text" class="form-control" id="promotion_name" name="promotion_name" placeholder="Enter Title">
                        </div>
                        <div class="form-group">
                            <img src="{{ asset('assets/images/description.png') }}">
                            <textarea type="text" class="form-control" id="promotion_details" name="promotion_details" placeholder="Enter Description(Optional)"></textarea>
                        </div>
                    </div>

                    <div class="@if($webview == 1) col-md-7 @else col-lg-7 @endif promotion-add-border">

                        <div class="form-group select-input input-popup">
                            <a href="#field-one">
                              <img src="{{ asset('assets/images/modifiers-black.png') }}">
                              <p name="slct" id="slct" class="form-control">Eligible Items</p>
                            </a>
                        </div>

                        <div>
                            <input type="text" style="clip-path: circle(0);height: 0;padding: 0; width: 0; position: absolute; opacity: 0;" id="hidden_eligible_item" name="hidden_eligible_item" />
                        </div>

                        {{-- <div class="text-promotion">
                            <h5>Discount</h5>
                        </div>

                        <div class="form-group">
                            <img src="{{ asset('assets/images/tag-d.png') }}">
                            <input type="text" class="form-control discount_percentage" id="discount_amount" name="discount_usd_percentage_amount" class="discount_amount" placeholder="Discount (%)">
                        </div> --}}

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
                            <img src="{{ asset('assets/images/modifiers-black.png') }}">
                            <select name="no_extra_charge" id="no_extra_charge" class="form-control">
                                @foreach (Config::get('constants.NO_EXTRA_CHARGES') as $key=>$item)
                                  <option value="{{$item}}">{{$item}}</option>
                                @endforeach
                            </select>
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

                        <!-- <div id="restricted-duration" class="overlay field-popup">
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
                                                <input data-provide="datepicker"  value=""  data-date-autoclose="true" class="form-control" placeholder="Select Date" data-date-format="mm-dd-yyyy" name="restricted_days" id="daysInput">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="hoursInput">Hours</label>
                                                <input type="text" id="start_time" name="restricted_hours" class="form-control input-sm" placeholder="Select Time" name="start_time" autocomplete="off" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer justify-content-center">
                                        <button class="btn btn-submit" data-dismiss="modal" type="button">Submit</button>
                                        {{-- <button class="btn btn-primary" type="button">Save changes</button> --}}
                                    </div>
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                        </div><!-- /.modal -->

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
                                                  <input type="checkbox" class="checkbox-custom categoryList" id="category{{$key}}" value="{{$value->category_id}}" name="category[{{$value->category_id}}]">
                                                  <label for="category{{$key}}">{{$value->category_name}}</label>
                                              </div>
                                              <div class="card-header collapsed" data-toggle="collapse" href="#collapse{{$key}}">
                                                  <a class="card-title">
                                                      <i class="fa fa-plus"></i>
                                                  </a>
                                              </div>
                                              <div id="collapse{{$key}}" class="card-body collapse" data-parent="#accordion" >
                                                    @foreach($value->category_item as $key1=>$value1)
                                                        <div class="form-group cs-checkbox">
                                                            <input type="checkbox" class="checkbox-custom category_item category{{$key}}" id="item{{$value->category_id}}{{$key1}}" value="{{$value1->menu_id}}" name="category[{{$value->category_id}}][{{$value1->menu_id}}]">
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
</form>
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
    <script src="{{ asset('assets/js/type/freeitem.js')}}"></script>
    <script src="{{asset('vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{asset('vendor/timepicker-bs4.js')}}" defer="defer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dayjs/1.11.4/dayjs.min.js" integrity="sha512-Ot7ArUEhJDU0cwoBNNnWe487kjL5wAOsIYig8llY/l0P2TUFwgsAHVmrZMHsT8NGo+HwkjTJsNErS6QqIkBxDw==" crossorigin="anonymous" referrerpolicy="no-referrer" defer="defer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/js/bootstrap.bundle.min.js" integrity="sha512-igl8WEUuas9k5dtnhKqyyld6TzzRjvMqLC79jkgT3z02FvJyHAuUtyemm/P/jYSne1xwFI06ezQxEwweaiV7VA==" crossorigin="anonymous" referrerpolicy="no-referrer" defer="defer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js" integrity="sha512-Tn2m0TIpgVyTzzvmxLNuqbSJH3JP8jm+Cy3hvHrW7ndTDcJ1w5mBiksqDBb8GpE2ksktFvDB/ykZ0mDpsZj20w==" crossorigin="anonymous" referrerpolicy="no-referrer" defer="defer"></script>
    @if ($webview == 1)
        <script src="{{asset('assets/customer/js/jquery.validate.min.js')}}"></script>
        <script src="{{asset('assets/customer/js/additional-methods.min.js')}}"></script>
        <script src="{{asset('assets/js/type/getfreeItem-webview.js')}}"></script>
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
        {!! JsValidator::formRequest('App\Http\Requests\PromotionFreeitemRequest','#promotionForm'); !!}
    @endif
@endsection
