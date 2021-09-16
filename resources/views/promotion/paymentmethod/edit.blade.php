@extends('layouts.app')
@section('content')
{{ Form::open(array('route' => array('promotion.add.paymentmethod.post'),'id'=>'promotionForm','method'=>'POST','class'=>'','files'=>'true')) }}
<section id="wrapper">
  @include('layouts.sidebar')
  <div id="navbar-wrapper">
        <nav class="navbar navbar-inverse">
          <div class="container-fluid">
            <div class="navbar-header">
              <a href="#" class="navbar-brand" id="sidebar-toggle"><i class="fa fa-bars"></i></a>
              Edit Payment Method Reward
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
                <input type="text" class="form-control" id="promotion_code" name="promotion_code" 
                value="{{$promotion->promotion_code}}" 
                placeholder="Promo code (optional)">
              </div>
              <div class="form-group">   
                <img src="{{ asset('assets/images/speaker.png') }}">              
                <input type="text" class="form-control" 
                value="{{$promotion->promotion_name?$promotion->promotion_name:''}}" 
                id="promotion_name" name="promotion_name" placeholder="Enter Headline">
              </div>
              <div class="form-group">   
                <img src="{{ asset('assets/images/description.png') }}">              
                <textarea type="text" class="form-control" id="promotion_details" 
                name="promotion_details" placeholder="Enter Description">{{$promotion->promotion_details?$promotion->promotion_details:''}}</textarea>
              </div>
            </div>
            <div class="col-lg-7">
              <div class="text-promotion">
                <h5>Discount</h5>
              </div>
              <div class="form-group mb-0">   
                <input type="radio" id="usd" name="dicount_usd_percentage" value="usd" class="discountUsdPercentage"  
                {{($promotion->dicount_usd_percentage=='usd')?'checked':''}}>
                <label for="usd">Discount in USD</label>
              </div>
              {{-- <div class="form-group">   
                <input type="radio" id="percentage" name="dicount_usd_percentage" value="percentage" class="discountUsdPercentage" 
                {{($promotion->dicount_usd_percentage=='percentage')?'checked':''}}>
                <label for="percentage">Discount in Percentage</label>
              </div> --}}
              <div class="form-group">   
                <img src="{{ asset('assets/images/tag-d.png') }}">              
                <input type="text" class="form-control" id="discount_amount" name="dicount_usd_percentage_amount" 
                class="discount_amount" 
                value="{{$promotion->promotion_details?$promotion->dicount_usd_percentage_amount:''}}"
                placeholder="Discount (USD)">
              </div>
              <div class="text-promotion">
                <h5>Minimum Order Amount</h5>
              </div>
              <div class="form-group cs-checkbox">
                <input type="checkbox" 
                class="checkbox-custom setMinimumOrderAmount" 
                value="allow" 
                id="setMinimumOrderAmount" 
                {{($promotion->set_minimum_order)?'checked':''}}
                name="set_minimum_order">
                <label for="setMinimumOrderAmount">set a minimum order value (recommended)</label>
              </div>
              @if($promotion->set_minimum_order)
               <div class="form-group minimumAmountDiv"  >   
                <img src="{{ asset('assets/images/tag-d.png') }}">              
                <input type="text" class="form-control" id="minimumAmount" name="set_minimum_order_amount"                 
                value="{{$promotion->set_minimum_order_amount?$promotion->set_minimum_order_amount:''}}"
                placeholder="Amount (USD)">
              </div> 
              @else
              <div class="form-group minimumAmountDiv" style="display: none" >   
                <img src="{{ asset('assets/images/tag-d.png') }}">              
                <input type="text" class="form-control" id="minimumAmount" name="set_minimum_order_amount" placeholder="Amount (USD)">
              </div> 

              @endif
              <div class="form-group select-input">   
                <img src="{{ asset('assets/images/client-t.png') }}">
                <select name="client_type" id="client_type" class="form-control">
                  <option selected disabled>Client type</option>
                  @foreach (Config::get('constants.CLIENT_TYPE') as $key=>$item)
                    <option value="{{$key}}"
                    {{($promotion->client_type==$key)?'selected':''}}
                    
                    >{{$item}}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group select-input">   
                <img src="{{ asset('assets/images/order-cart.png') }}">
                <select name="order_type" id="order_type" class="form-control">
                  <option selected disabled>Order type</option>
                    @foreach (Config::get('constants.ORDER_TYPE') as $key=>$item)
                      <option value="{{$key}}" {{($promotion->order_type==$key)?'selected':''}}
                        >{{$item}}</option>
                    @endforeach
                </select>
              </div>
              <div class="form-group cs-checkbox">
                <input type="checkbox" class="checkbox-custom onlyForSelectedPayment" {{($promotion->only_selected_payment_method)?'checked':''}}
                id="payment" name="only_selected_payment_method">
                <label for="payment">Only for selected payment methods</label>

                @if($promotion->only_selected_payment_method)
                <div class="form-group cs-checkbox onlyForSelectedPaymentDiv" >
                @else
                <div class="form-group cs-checkbox onlyForSelectedPaymentDiv" style="display: none">

                @endif
                <input type="checkbox" name="only_selected_cash" class="checkbox-custom"  id="cash" {{($promotion->only_selected_cash)?'checked':''}} >
                  <label for="cash">Cash</label>

                  <input type="checkbox" class="checkbox-custom" id="cardtodelivery" name="only_selected_cash_delivery_person" {{($promotion->only_selected_cash_delivery_person)?'checked':''}}  >
                  <label for="cardtodelivery">Card to delivery person or at pickup counter</label>
                </div>

              </div>
              <div class="form-group cs-checkbox">
                <input type="checkbox" class="checkbox-custom" id="client" name="only_once_per_client" {{($promotion->only_once_per_client)?'checked':''}}>
                <label for="client">Only once per client</label>
              </div>
              <div class="form-group select-input">   
                <img src="{{ asset('assets/images/client-t.png') }}">
                <select name="mark_promo_as" id="mark_promo_as" class="form-control">
                  <option selected disabled>Mark Promo as</option>
                  @foreach (Config::get('constants.MARK_PROMO_AS') as $key=>$item)
                  <option value="{{$key}}" {{($promotion->mark_promo_as==$key)?'selected':''}}>{{$item}}</option>
                @endforeach
                </select>
              </div>
              {{-- <div class="form-group select-input">   
                <img src="{{ asset('assets/images/order-cart.png') }}">
                <select name="display_time" id="display_time" class="form-control">
                  <option selected disabled>Display Time</option>
                  @foreach (Config::get('constants.DISPLAY_TIME') as $key=>$item)
                  <option value="{{$key}}" {{($promotion->display_time==$key)?'selected':''}}>{{$item}}</option>
                @endforeach
                </select>
              </div> --}}
            </div>
          </div>
       
        </div>
        <div class="form-group form-btn-menu">
          <div class="btn-custom">
            <a href="{{route('promotion')}}" class="btn-grey"><span>Cancel</span></a>
          </div>
          <div class="btn-custom">
            <input type="hidden" id="promotion_id" name="promotion_id" value="{{$promotion->promotion_id}}" />
            <button type="submit" class="btn-blue"><span>Update </span></button>
          </div>
        </div>
      </div>
</section>
</form>
@endsection
@section('scripts')
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
<script src="{{ asset('assets/js/common.js')}}"></script>
<script src="{{ asset('assets/js/type/cart.js')}}"></script>
{!! JsValidator::formRequest('App\Http\Requests\PromotionCartRequest','#promotionForm'); !!}
@endsection