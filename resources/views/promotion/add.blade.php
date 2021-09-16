@extends('layouts.app')
@section('content')
<section id="wrapper">
  @include('layouts.sidebar')
  <div id="navbar-wrapper">
        <nav class="navbar navbar-inverse">
          <div class="container-fluid">
            <div class="navbar-header">
              <a href="#" class="navbar-brand" id="sidebar-toggle"><i class="fa fa-bars"></i></a>
              <h2>Add Promotion For Cart</h2>
            </div>
          </div>
        </nav>
      </div>
  <div class="add-category Promotion content-wrapper">
        <div class="container-fluid">
          {{ Form::open(array('route' => array('promotion.add.post'),'id'=>'promotionForm','method'=>'POST','class'=>'','files'=>'true')) }}
            <div class="row">
              <div class="col-lg-6">
                <div class="form-group">   
                  <img src="{{ asset('assets/images/percentage.png') }}">              
                  <input type="text" class="form-control" name="promotion_code" placeholder="Enter Promocode">
                </div>
                <div class="form-group">   
                  <img src="{{ asset('assets/images/speaker.png') }}">              
                  <input type="text" class="form-control" name="promotion_name" placeholder="Enter Headline">
                </div>
                <div class="form-group">   
                  <img src="{{ asset('assets/images/description.png') }}">              
                  <textarea type="text" class="form-control" name="promotion_details" placeholder="Enter Description"></textarea>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">   
                  <img src="{{ asset('assets/images/tag-d.png') }}">              
                  <input type="text" class="form-control" name="discount" placeholder="Discount (%)">
                </div>
                <div class="text-promotion">
                  <h5>Minimum Order Amount</h5>
                  <input id="checkbox-1" class="checkbox-custom" name="checkbox-1" type="checkbox" checked="">
                  <label>set a minimum order value (recommended)</label>
                </div>
                <div class="form-group">   
                  <img src="{{ asset('assets/images/tag-d.png') }}">              
                  <input type="text" class="form-control" name="discount_type" placeholder="Billing Ammount (USD)">
                </div>
                <div class="form-group select-input">   
                  <img src="{{ asset('assets/images/client-t.png') }}">
                  <select name="promotion_type_id" id="promotion_type_id" class="form-control">
                    <option selected disabled>Select promotion type</option>
                    @foreach($promotionType as $type)
                    <option value="{{$type->promotion_type_id}}">{{$type->promotion_name}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>

            <div class="form-group form-btn justify-content-center">   
              <div class="btn-custom">
                <button class="btn-blue"><span>Add Promotion</span></button>
              </div>
            </div>
          </form>
        </div>
      </div>
</section>
@endsection
@section('scripts')
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
<script src="{{ asset('assets/js/common.js')}}"></script>
{!! JsValidator::formRequest('App\Http\Requests\PromotionRequest','#promotionForm'); !!}
@endsection