@extends('layouts.app')
@section('content')
{{ Form::open(array('route' => array('promotion.add.free.mealbundle.post'),'id'=>'promotionForm','method'=>'POST','class'=>'')) }}
<section id="wrapper">
  @include('layouts.sidebar')
  <div id="navbar-wrapper">
        <nav class="navbar navbar-inverse">
          <div class="container-fluid">
            <div class="navbar-header">
              <a href="#" class="navbar-brand" id="sidebar-toggle"><i class="fa fa-bars"></i></a>
              Add Meal Bundle.
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
                <input type="text" class="form-control" id="promotion_code" name="promotion_code" placeholder="Promo code (optional)">
              </div>
              <div class="form-group">   
                <img src="{{ asset('assets/images/speaker.png') }}">              
                <input type="text" class="form-control" id="promotion_name" name="promotion_name" placeholder="Enter Headline">
              </div>
              <div class="form-group">   
                <img src="{{ asset('assets/images/description.png') }}">              
                <textarea type="text" class="form-control" id="promotion_details" name="promotion_details" placeholder="Enter Description"></textarea>
              </div>
            </div>
            <div class="col-lg-7">
              <div class="shadow">
                  <div id="dynamic-field-1" class="form-group dynamic-field">
                    <div class="form-group select-input input-popup">
                        <a href="#field-1" class="first_link">
                          <img src="{{ asset('assets/images/modifiers-black.png') }}">
                          <p name="slct" id="slct" class="form-control display_count">Eligible Items 1</p>
                        </a>
                    </div>
                  </div>
                  <div class="clearfix mt-4">
                    <button type="button" id="add-button" class="float-left text-uppercase">Add <i class="fa fa-plus"></i></button>
                    <button type="button" id="remove-button" class="float-left text-uppercase" disabled="disabled">Remove <i class="fa fa-minus"></i></button>
                   <!--  <button type="submit" class="btn btn-primary float-right text-uppercase shadow-sm">Submit</button> -->
                  </div>
            </div>




          <div class="text-promotion">
            <h5>Flat Price</h5>
          </div>


          <div class="form-group">   
            <img src="{{ asset('assets/images/tag-d.png') }}">              
            <input type="text" class="form-control" id="discount_usd" name="discount_usd" placeholder="Discount(USD)">
          </div>
           
          <div class="form-group select-input">
            <img src="{{ asset('assets/images/modifiers-black.png') }}">
            <select name="no_extra_charge" id="no_extra_charge" class="form-control">
              @foreach (Config::get('constants.NO_EXTRA_CHARGES') as $key=>$item)
                <option value="{{$key}}">{{$item}}</option>
              @endforeach
            </select>
          </div>
              <div class="form-group select-input">   
                <img src="{{ asset('assets/images/client-t.png') }}">
                <select name="client_type" id="client_type" class="form-control">
                  <option selected disabled>Client type</option>
                  @foreach (Config::get('constants.CLIENT_TYPE') as $key=>$item)
                    <option value="{{$key}}">{{$item}}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group select-input">   
                <img src="{{ asset('assets/images/order-cart.png') }}">
                <select name="order_type" id="order_type" class="form-control">
                  <option selected disabled>Order type</option>
                    @foreach (Config::get('constants.ORDER_TYPE') as $key=>$item)
                      <option value="{{$key}}">{{$item}}</option>
                    @endforeach
                </select>
              </div>
              <div class="form-group cs-checkbox">
                <input type="checkbox" class="checkbox-custom onlyForSelectedPayment" id="payment" name="only_selected_payment_method">
                <label for="payment">Only for selected payment methods</label>

                <div class="form-group cs-checkbox onlyForSelectedPaymentDiv" style="display: none">
                  <input type="checkbox"  class="checkbox-custom" id="cash" name="only_selected_cash">
                  <label for="cash">Cash</label>

                  <input type="checkbox" class="checkbox-custom" id="cardtodelivery" name="only_selected_cash_delivery_person">
                  <label for="cardtodelivery">Card to delivery person or at pickup counter</label>
                </div>

              </div>
              <div class="form-group cs-checkbox">
                <input type="checkbox" class="checkbox-custom" id="client" name="only_once_per_client">
                <label for="client">Only once per client</label>
              </div>
              <div class="form-group select-input">   
                <img src="{{ asset('assets/images/client-t.png') }}">
                <select name="mark_promo_as" id="mark_promo_as" class="form-control">
                  <option selected disabled>Mark Promo as</option>
                  @foreach (Config::get('constants.MARK_PROMO_AS') as $key=>$item)
                  <option value="{{$key}}">{{$item}}</option>
                @endforeach
                </select>
              </div>
              <div class="form-group select-input">   
                <img src="{{ asset('assets/images/order-cart.png') }}">
                <select name="display_time" id="display_time" class="form-control">
                  <option selected disabled>Display Time</option>
                  @foreach (Config::get('constants.DISPLAY_TIME') as $key=>$item)
                  <option value="{{$key}}">{{$item}}</option>
                @endforeach
                </select>
              </div>
            </div>
          </div>

          <div id="field-1" class="overlay field-popup popup_intial">
            <div class="popup text-center">
              <h2>Eligible Items</h2>
              <a class="close" href="#">&times;</a>
              <div class="content">
                <div id="accordion" class="accordion">
                @foreach($category as $key=>$value)
                <div class="card mb-0">
                  <div class="form-group cs-checkbox">
                  <input type="checkbox" class="checkbox-custom categoryList" id="category{{$key}}" value="{{$value->category_id}}" name="eligible_item[1][{{$value->category_id}}]">
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
                        <input type="checkbox" class="checkbox-custom category{{$key}}" id="item{{$value->category_id}}{{$key1}}" value="{{$value1->menu_id}}" name="eligible_item[1][{{$value->category_id}}][{{$value1->menu_id}}]">
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

        </div></div>

         
        </div>
        <div class="form-group form-btn-menu">
          <div class="btn-custom">
            <a href="{{route('promotion')}}" class="btn-grey"><span>Cancel</span></a>
          </div>
          <div class="btn-custom">
            <button type="submit" class="btn-blue"><span>Add</span></button>
          </div>
        </div>
      </div>
</section>
</form>
@endsection
@section('scripts')
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
<script src="{{ asset('assets/js/common.js')}}"></script>
<script src="{{ asset('assets/js/type/mealbundle.js')}}"></script>
<script>
var category = {!! json_encode($category) !!};
var is_edit = 0;
</script>
{!! JsValidator::formRequest('App\Http\Requests\PromotionCartRequest','#promotionForm'); !!}
@endsection