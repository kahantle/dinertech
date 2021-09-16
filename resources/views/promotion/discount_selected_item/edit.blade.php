@extends('layouts.app')
@section('content')
{{ Form::open(array('route' => array('promotion.add.selecte.items.post'),'id'=>'promotionForm','method'=>'POST','class'=>'','files'=>'true')) }}

<section id="wrapper">
  @include('layouts.sidebar')
  <div id="navbar-wrapper">
        <nav class="navbar navbar-inverse">
          <div class="container-fluid">
            <div class="navbar-header">
              <a href="#" class="navbar-brand" id="sidebar-toggle"><i class="fa fa-bars"></i></a>
              Edit % or $ Discount on selected items.
            </div>
          </div>
        </nav>
      </div>
      <div class="add-category Promotion content-wrapper">
        <div class="container-fluid">
            <div class="row">
              <div class="col-lg-5">
                <div class="form-group">   
                  <img src="{{ asset('assets/images/percentage.png') }}">              
                  <input type="text" class="form-control" id="promotion_code" name="promotion_code" value="{{$promotion->promotion_code}}" placeholder="Promo code (optional)">
                  <input type="hidden" id="promotion_id" name="promotion_id" value="{{$promotion->promotion_id}}" />

                </div>
                <div class="form-group">   
                  <img src="{{ asset('assets/images/speaker.png') }}">              
                  <input type="text" class="form-control" id="promotion_name" name="promotion_name" value="{{$promotion->promotion_name}}" placeholder="Enter Headline">
                </div>
                <div class="form-group">   
                  <img src="{{ asset('assets/images/description.png') }}">              
                  <textarea type="text" class="form-control" id="promotion_details" name="promotion_details" placeholder="Enter Description">{{$promotion->promotion_details}}</textarea>
                </div>
              </div>
              <div class="col-lg-7">
                <div class="form-group select-input input-popup">
                  <a href="#field-one">
                    <img src="{{ asset('assets/images/modifiers-black.png') }}">
                    <p name="slct" id="slct" class="form-control">Eligible Items</p>
                  </a>
                </div>

                <div class="text-promotion">
                  <h5>Discount</h5>
                </div>
                <div class="form-group mb-0">   
                <input type="radio" id="usd" name="dicount_usd_percentage" value="usd" class="discountUsdPercentage" {{($promotion->dicount_usd_percentage=='usd')?'checked':''}}>
                  <label for="usd">Discount in USD</label>
                </div>
                <div class="form-group">   
                <input type="radio" id="percentage" name="dicount_usd_percentage" value="percentage" class="discountUsdPercentage" {{($promotion->dicount_usd_percentage=='percentage')?'checked':''}}>
                  <label for="percentage">Discount in Percentage</label>
                </div>
                <div class="form-group">   
                <img src="{{ asset('assets/images/tag-d.png') }}">              
                <input type="text" class="form-control" id="discount_amount" name="dicount_usd_percentage_amount" value="{{$promotion->dicount_usd_percentage_amount}}" class="discount_amount" placeholder="Discount (USD)">
              </div>
                <!-- <div class="form-group">   
                  <img src="{{ asset('assets/images/modifiers-black.png') }}">              
                  <input type="text" class="form-control" value="{{$promotion->dicount_usd_percentage_amount}}"  placeholder="Discount (USD)">
                </div> -->
                <div class="form-group select-input">
                  <img src="{{ asset('assets/images/modifiers-black.png') }}">
                  <select name="no_extra_charge" id="no_extra_charge" class="form-control" >
                    <option value="">No Extra charges</option>
                    @foreach (Config::get('constants.NO_EXTRA_CHARGES') as $key=>$item)
                      <option value="{{$key}}" {{($promotion->no_extra_charge==$key)?'selected':''}}>{{$item}}</option>
                    @endforeach
                  </select>
                </div>

                <div class="form-group select-input">
                  <img src="{{ asset('assets/images/modifiers-black.png') }}">
                  <select name="client_type" id="client_type" class="form-control" >
                    <option value="">Client type</option>
                    @foreach (Config::get('constants.CLIENT_TYPE') as $key=>$item)
                    <option value="{{$key}}" {{($promotion->client_type==$key)?'selected':''}}>{{$item}}</option>
                  @endforeach
                  </select>
                </div>

                <div class="form-group select-input">
                  <img src="{{ asset('assets/images/modifiers-black.png') }}">
                  <select name="order_type" id="order_type" class="form-control">
                    <option value="">Order Type</option>
                    @foreach (Config::get('constants.ORDER_TYPE') as $key=>$item)
                      <option value="{{$key}}" {{($promotion->order_type==$key)?'selected':''}}>{{$item}}</option>
                    @endforeach
                  </select>
                </div>

                <div class="form-group cs-checkbox">
                <input type="checkbox" class="checkbox-custom onlyForSelectedPayment" id="payment" name="only_selected_payment_method"   {{($promotion->only_selected_payment_method)?'checked':''}}>
                <label for="payment">Only for selected payment methods</label>

                @if($promotion->only_selected_payment_method)
                <div class="form-group cs-checkbox onlyForSelectedPaymentDiv" >
                @else
                <div class="form-group cs-checkbox onlyForSelectedPaymentDiv" style="display: none">

                @endif
                  <input type="checkbox"  class="checkbox-custom" id="cash" name="only_selected_cash"   {{($promotion->only_selected_cash)?'checked':''}}>
                  <label for="cash">Cash</label>

                  <input type="checkbox" class="checkbox-custom" id="cardtodelivery" name="only_selected_cash_delivery_person"   {{($promotion->only_selected_cash_delivery_person)?'checked':''}}>
                  <label for="cardtodelivery">Card to delivery person or at pickup counter</label>
                </div>

              </div>
                <div class="form-group cs-checkbox">
                <input type="checkbox" class="checkbox-custom" id="client" name="only_once_per_client"   {{($promotion->only_once_per_client)?'checked':''}}>
                  <label for="client">Only once per client</label>
                </div>

                <div class="form-group select-input">
                  <img src="{{ asset('assets/images/modifiers-black.png') }}">
                  <select name="mark_promo_as" id="mark_promo_as" class="form-control">
                       @foreach (Config::get('constants.MARK_PROMO_AS') as $key=>$item)
                        <option value="{{$key}}" {{($promotion->mark_promo_as==$key)?'selected':''}}>{{$item}}</option>
                      @endforeach
                  </select>
                </div>
                <div class="form-group select-input">
                  <img src="{{ asset('assets/images/modifiers-black.png') }}">
                  <select name="display_time" id="display_time" class="form-control">
                      @foreach (Config::get('constants.DISPLAY_TIME') as $key=>$item)
                         <option value="{{$key}}" {{($promotion->display_time==$key)?'selected':''}}>{{$item}}</option>
                      @endforeach
                  </select>
                </div>

                <div id="field-one" class="overlay field-popup">
                  <div class="popup text-center">
                    <h2>Eligible Items</h2>
                    <a class="close" href="#">&times;</a>
                    <div class="content">
                      <div id="accordion" class="accordion">
                      @foreach($category as $key=>$value)
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

                                  <input type="checkbox" class="checkbox-custom categoryList" {{($all)?'checked':''}}  id="category{{$key}}" value="{{$value->category_id}}" name="category[{{$value->category_id}}]">
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
                                  @endphp
                                      <div class="form-group cs-checkbox">
                                        <input type="checkbox" class="checkbox-custom category{{$key}}" {{($category_select_item)?'checked':''}}  id="item{{$value->category_id}}{{$key1}}" value="{{$value1->menu_id}}" name="category[{{$value->category_id}}][{{$value1->menu_id}}]">
                                        <label for="item{{$value->category_id}}{{$key1}}">{{$value1->item_name}}</label>
                                      </div>
                                      @endforeach
                                  </div>
                              </div>
                          @endforeach
                      </div>
                  
                    </div>
                    <div class="form-group form-btn justify-content-center">   
                            <div class="btn-custom">
                             
                            </div>
                          </div>
                  </div>
                </div>
              </div>
            </div>
    
        </div>
        <div class="form-group form-btn-menu">
          <div class="btn-custom">
            <a href="{{route('promotion')}}" class="btn-grey"><span>Cancel</span></a>
          </div>
          <div class="btn-custom">
            <button type="submit" class="btn-blue"><span>Submit</span></button>
          </div>
        </div>
      </div></section>
      </form>
@endsection
@section('scripts')
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
<script src="{{ asset('assets/js/common.js')}}"></script>
<script src="{{ asset('assets/js/type/discountselected.js')}}"></script>
{!! JsValidator::formRequest('App\Http\Requests\PromotionRequest','#promotionForm'); !!}
@endsection