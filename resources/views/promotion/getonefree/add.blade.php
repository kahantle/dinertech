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
                        <h2>  Buy one,get one free.</h2>
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
                                            <option value="{{$item}}">{{$item}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div id="tab-2" class="tab-content" style="display: none">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend"> 
                                        <span class="input-group-text inner-text-blog">
                                            Items Group 1:
                                        </span>
                                    </div>
                                    <input type="text" class="form-control discount_percentage" value="100"  name="item_group_1" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
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
                                    <input type="text" class="form-control discount_percentage" value="0"  name="item_group_2" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                    <div class="input-group-prepend"> 
                                        <span class="input-group-text input-group-text-first">%</span> 
                                    </div>
                                </div>
                            </div>
                            <div id="tab-1" class="tab-content">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend"> 
                                        <span class="input-group-text inner-text-blog">
                                            Discount for cheapest item:
                                        </span>
                                    </div>
                                    <input type="text" class="form-control discount_percentage" value="100"  name="discount_cheapest" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
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
                                    <input type="text" class="form-control discount_percentage" value="0"  name="discount_expensive" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
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
                                              <div id="collapse{{$key}}" class="card-body collapse" data-parent="#accordion">
                                                @foreach($value->category_item as $key1=>$value1)
                                                  <div class="form-group cs-checkbox">
                                                      <input type="checkbox" class="checkbox-custom category-item-first category{{$key}}" id="item{{$value->category_id}}{{$key1}}" value="{{$value1->menu_id}}" name="category[{{$value->category_id}}][{{$value1->menu_id}}]">
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
                                      @foreach($category as $key=>$value)
                                          <div class="card mb-0">
                                              <div class="form-group cs-checkbox">
                                                  <input type="checkbox" class="checkbox-custom categoryList-two" id="category-two{{$key}}" value="{{$value->category_id}}" name="category_two[{{$value->category_id}}]">
                                                  <label for="category-two{{$key}}">{{$value->category_name}}</label>
                                              </div>
                                              <div class="card-header collapsed" data-toggle="collapse" href="#collapse-two{{$key}}">
                                                  <a class="card-title">
                                                      <i class="fa fa-plus"></i>
                                                  </a>
                                              </div>
                                              <div id="collapse-two{{$key}}" class="card-body collapse" data-parent="#accordion" >
                                                 @foreach($value->category_item as $key1=>$value1)
                                                  <div class="form-group cs-checkbox">
                                                      <input type="checkbox" class="checkbox-custom category-item-second category-two{{$key}}" id="item-two{{$value->category_id}}{{$key1}}" value="{{$value1->menu_id}}" name="category_two[{{$value->category_id}}][{{$value1->menu_id}}]">
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
                        <button type="submit" class="btn-blue"><span>Submit</span></button>
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
    <script src="{{ asset('assets/js/type/getonefree.js')}}"></script>
    @if ($webview == 1)
        <script src="{{asset('assets/customer/js/jquery.validate.min.js')}}"></script>
        <script src="{{asset('assets/customer/js/additional-methods.min.js')}}"></script>
        <script src="{{asset('assets/js/type/getonefree-webview.js')}}"></script>
    @else
        {!! JsValidator::formRequest('App\Http\Requests\PromotionGetonefreeRequest','#promotionForm'); !!}
    @endif
@endsection