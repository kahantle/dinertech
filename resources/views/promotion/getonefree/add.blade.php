@extends('layouts.app')
@section('content')
{{ Form::open(array('route' => array('promotion.add.free.getonefree.post'),'id'=>'promotionForm','method'=>'POST','class'=>'','files'=>'true')) }}

<section id="wrapper">
  @include('layouts.sidebar')
  <div id="navbar-wrapper">
        <nav class="navbar navbar-inverse">
          <div class="container-fluid">
            <div class="navbar-header">
              <a href="#" class="navbar-brand" id="sidebar-toggle"><i class="fa fa-bars"></i></a>
              Buy one,get one free.
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
                <div class="form-group select-input input-popup">
                  <a href="#field-one">
                    <img src="{{ asset('assets/images/modifiers-black.png') }}">
                    <p name="slct" id="slct" class="form-control">Eligible Items 1</p>
                  </a>
                </div>

                <div class="form-group select-input input-popup">
                  <a href="#field-two">
                    <img src="{{ asset('assets/images/modifiers-black.png') }}">
                    <p name="slct" id="slct" class="form-control">Eligible Items 2</p>
                  </a>
                </div>





                <div class="text-promotion">
                  <h5>Discount</h5>
                </div>

                <div class="form-group select-input">
                  <img src="{{ asset('assets/images/client-t.png') }}">
                  <select name="auto_manually_discount" id="auto_manually_discount" class="form-control auto_manually_discount">
                    @foreach (Config::get('constants.AUTO_DISCOUNT') as $key=>$item)
                      <option value="{{$key}}">{{$item}}</option>
                    @endforeach
                  </select>
                </div>

                <div class="auto_fields" >
                <div class="form-group">   
                  <img src="{{ asset('assets/images/tag-d.png') }}">              
                  <input type="text" class="form-control" id="discount_cheapest" name="discount_cheapest" placeholder="Discount for cheapest item (%)">
                </div>

                <div class="form-group">   
                  <img src="{{ asset('assets/images/tag-d.png') }}">              
                  <input type="text" class="form-control" id="discount_expensive" name="discount_expensive" placeholder="Discount for most expensive item (%)">
                </div>
              </div>

                <div class="manually_fields" style="display: none">
                <div class="form-group">   
                  <img src="{{ asset('assets/images/tag-d.png') }}">              
                  <input type="text" class="form-control" id="item_group_1" name="item_group_1" placeholder="Item Group 1 (%)">
                </div>

                <div class="form-group">   
                  <img src="{{ asset('assets/images/tag-d.png') }}">              
                  <input type="text" class="form-control" id="item_group_2" name="item_group_2" placeholder="Item Group 2 (%)">
                </div>
              </div>

              <div class="form-group select-input">
                <img src="{{ asset('assets/images/modifiers-black.png') }}">
                <select name="client_type" id="client_type" class="form-control">
                  <option value="Client type">Client type</option>
                  @foreach (Config::get('constants.CLIENT_TYPE') as $key=>$item)
                  <option value="{{$key}}">{{$item}}</option>
                @endforeach
                </select>
              </div>

             


              <div class="form-group select-input">
                <img src="{{ asset('assets/images/modifiers-black.png') }}">
                <select name="order_type" id="order_type" class="form-control">
                  <option value="Order Type">Order Type</option>
                  @foreach (Config::get('constants.ORDER_TYPE') as $key=>$item)
                    <option value="{{$key}}">{{$item}}</option>
                  @endforeach
                </select>
              </div>

                <!-- <div class="form-group">   
                  <img src="{{ asset('assets/images/modifiers-black.png') }}">              
                  <input type="text" class="form-control" placeholder="Discount (USD)">
                </div> -->
                {{-- <div class="form-group select-input">
                  <img src="{{ asset('assets/images/modifiers-black.png') }}">
                  <select name="no_extra_charge" id="no_extra_charge" class="form-control">
                    @foreach (Config::get('constants.NO_EXTRA_CHARGES') as $key=>$item)
                      <option value="{{$key}}">{{$item}}</option>
                    @endforeach
                  </select>
                </div>

                --}}

                <div class="form-group cs-checkbox">
                <input type="checkbox" class="checkbox-custom onlyForSelectedPayment" id="payment" name="only_selected_payment_method">
                <label for="payment">Only for selected payment methods</label>

                <div class="form-group cs-checkbox onlyForSelectedPaymentDiv" style="display: none">
                  <input type="checkbox" name="onlySelectedPayment" class="checkbox-custom" id="cash" name="only_selected_cash">
                  <label for="cash">Cash</label>

                  <input type="checkbox" name="onlySelectedPayment" class="checkbox-custom" id="cardtodelivery" name="only_selected_cash_delivery_person">
                  <label for="cardtodelivery">Card to delivery person or at pickup counter</label>
                </div>

              </div>
                <div class="form-group cs-checkbox">
                <input type="checkbox" class="checkbox-custom" id="client" name="only_once_per_client">
                  <label for="client">Only once per client</label>
                </div>

                <div class="form-group select-input">
                  <img src="{{ asset('assets/images/modifiers-black.png') }}">
                  <select name="mark_promo_as" id="mark_promo_as" class="form-control">
                       @foreach (Config::get('constants.MARK_PROMO_AS') as $key=>$item)
                        <option value="{{$key}}">{{$item}}</option>
                      @endforeach
                  </select>
                </div>
                <div class="form-group select-input">
                  <img src="{{ asset('assets/images/modifiers-black.png') }}">
                  <select name="display_time" id="display_time" class="form-control">
                      @foreach (Config::get('constants.DISPLAY_TIME') as $key=>$item)
                         <option value="{{$key}}">{{$item}}</option>
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



                <div id="field-two" class="overlay field-popup">
                  <div class="popup text-center">
                    <h2>Eligible Items</h2>
                    <a class="close" href="#">&times;</a>
                    <div class="content">
                      <div id="accordion1" class="accordion">
                      @foreach($category as $key=>$value)
                              <div class="card mb-0">
                                  <div class="form-group cs-checkbox">
                                  <input type="checkbox" class="checkbox-custom categoryListTwo" id="category_two_{{$key}}" value="{{$value->category_id}}" name="eligible_item[2][{{$value->category_id}}]">
                                  <label for="category_two_{{$key}}">{{$value->category_name}}</label>
                                </div>
                                <div class="card-header collapsed" data-toggle="collapse" href="#collapse_two_{{$key}}">
                                    <a class="card-title">
                                        <i class="fa fa-plus"></i>
                                    </a>
                                </div>
                                  <div id="collapse_two_{{$key}}" class="card-body collapse" data-parent="#accordion1" >
                                  @foreach($value->category_item as $key1=>$value1)
                                      <div class="form-group cs-checkbox">
                                        <input type="checkbox" class="checkbox-custom category_two_{{$key}}" id="item_two_{{$value->category_id}}{{$key1}}" value="{{$value1->menu_id}}" name="eligible_item[2][{{$value->category_id}}][{{$value1->menu_id}}]">
                                        <label for="item_two_{{$value->category_id}}{{$key1}}">{{$value1->item_name}}</label>
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
<script>
    $(document).on('click', '.categoryList', function() {
       var id =$(this).attr('id')
        if($(this).prop("checked") == true){
            $("."+id).prop("checked",true)        }
        else if($(this).prop("checked") == false){
            $("."+id).prop("checked",false)        }
    });


    $(document).on('click', '.categoryListTwo', function() {
       var id =$(this).attr('id')
        if($(this).prop("checked") == true){
            $("."+id).prop("checked",true)        }
        else if($(this).prop("checked") == false){
            $("."+id).prop("checked",false)        }
    });


    $(document).on('change', '.auto_manually_discount', function() {
       if($(this).val()==1){
          $(".auto_fields").show();
          $(".manually_fields").hide();
       }else{
          $(".auto_fields").hide();
          $(".manually_fields").show();
       }
    });

    
</script>
{!! JsValidator::formRequest('App\Http\Requests\PromotionRequest','#promotionForm'); !!}
@endsection