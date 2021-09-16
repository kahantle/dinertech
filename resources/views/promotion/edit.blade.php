@extends('layouts.app')
@section('content')
<section id="wrapper">
  @include('layouts.sidebar')
  <div id="navbar-wrapper">
    <nav class="navbar navbar-inverse">
      <div class="container-fluid">
        <div class="navbar-header">
          <a href="#" class="navbar-brand" id="sidebar-toggle"><i class="fa fa-bars"></i></a>
          <h2>Edit Promotion</h2>
        </div>
      </div>
    </nav>
  </div>
  <div class="add-category Promotion content-wrapper">
    @include('common.flashMessage')
    <div class="container-fluid">
      {{ Form::open(array('route' => array('promotion.add.post'),'id'=>'promotionForm','method'=>'POST','class'=>'','files'=>'true')) }}
      <div class="row">
        <div class="col-lg-6">
          <div class="form-group">   
            <select id="promotion_type_id" name="promotion_type_id" class="form-control">
                <option value="">Select promotion type</option>
                @foreach ($promotionTypes as $item)
                  <option value="{{$item->promotion_type_id}}" 
                    {{($promotion->promotion_type_id==$item->promotion_type_id)?'selected':''}}>{{$item->promotion_name}}
                  </option>
                @endforeach
            </select>
          </div>
          <div class="form-group">   
            <img src="{{ asset('assets/images/percentage.png') }}">              
          <input type="text" id="promotion_code" name="promotion_code" class="form-control" value="{{$promotion->promotion_code}}" placeholder="Enter Promocode">
          </div>
          <div class="form-group">   
            <img src="{{ asset('assets/images/speaker.png') }}">              
            <input type="text" id="promotion_name" name="promotion_name" class="form-control" value="{{$promotion->promotion_name}}" placeholder="Enter Headline">
          </div>
          <div class="form-group">   
            <img src="{{ asset('assets/images/description.png') }}">              
            <textarea type="text" id="promotion_details" name="promotion_details" class="form-control"  placeholder="Enter Description">{{$promotion->promotion_details}}</textarea>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="form-group">   
            <img src="{{ asset('assets/images/tag-d.png') }}">              
            <input type="text" id="discount" name="discount" class="form-control" value="{{$promotion->discount}}" placeholder="Discount (%)">
          </div>
          <div class="text-promotion">
            <h5>Minimum Order Amount</h5>
            <input id="checkbox-1" class="checkbox-custom" name="checkbox-1" type="checkbox" checked="">
            <input type="hidden" id="promotion_id" name="promotion_id" value="{{$promotion->promotion_id}}" />
            <label>set a minimum order value (recommended)</label>
          </div>
          <div class="form-group">   
            <img src="{{ asset('assets/images/tag-d.png') }}">              
            <input type="text" id="discount_type" name="discount_type" class="form-control" value="{{$promotion->discount_type}}" placeholder="Billing Ammount (USD)">
          </div>
        </div>
      </div>
      <div class="form-group form-btn justify-content-center">   
        <div class="btn-custom">
          <button class="btn btn-sm btn-blue"><span>Update Promotion</span></button>
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