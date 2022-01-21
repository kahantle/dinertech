@extends('layouts.app')
@section('content')
 <section id="wrapper">
    @include('layouts.sidebar')
    <div id="navbar-wrapper">
      <nav class="navbar navbar-inverse">
        <div class="container-fluid">
          <div class="navbar-header">
            <div class="profile-title-new">
            <a href="javaScript:void(0);" class="navbar-brand" id="sidebar-toggle"><i class="fa fa-bars"></i></a>
            <h2>Modifiers / Add- ons</h2>
            </div>
            <div class="plus">
              <a href="javaScript:void(0);" class="openModifierForm open"><i class="fa fa-plus" aria-hidden="true"></i></a>
            </div>
          </div>
        </div>
      </nav>
    </div>
    <div class="dashboard category modifiers-ctm content-wrapper">
      <div class="container">
        @include('common.flashMessage')
        @if($modifiers)

        <div id="accordion" class="accordion">
          @foreach ($modifiers as $item)
          <div class="order">
            <div class="collapsed a-order" data-toggle="collapse" href="#collapseOne{{$item->modifier_group_name}}">
              <div class="order-name">
                <div class="circle"></div>
              <h4>{{$item->modifier_group_name}}<a href="javaScript:void(0);" class="ml-1 badge badge-info">{{$item->modifier_item->count()}}</a>
              </h4>
              </div>
              <div class="order-detail">
                <a href="#modifierItem" class="openModifierItemForm open" data-id={{$item->modifier_group_id}}>Add Item <i class="fa fa-plus" aria-hidden="true"></i></a>
                <div class="order-icons">
                  <a  data-route="{{route('edit.modifier.post',[$item->modifier_group_id])}}" href="javaScript:void(0);" class="openModifierForm action-edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                  <a  data-route="{{route('delete.modifier.post',[$item->modifier_group_id])}}" href="javaScript:void(0);" class="delete action-delete"><i class="fa fa-trash" aria-hidden="true"></i></a>
            </div>
              </div>
            </div>
            <div id="collapseOne{{$item->modifier_group_name}}" class="collapse c-order" data-parent="#accordion" >
             @foreach ($item->modifier_item as $item)
              <div class="child">
                <div class="order-name">
                  <div class="circle"></div>
                <h4>{{$item->modifier_group_item_name}}</h4>
                </div>
                <div class="order-detail">
                  <div class="number">
                    <p>${{ number_format($item->modifier_group_item_price,2)}}</p>
                  </div>
                  <div class="order-icons">
                    <a  data-route="{{route('edit.modifier.item.post',$item->modifier_item_id)}}" href="javaScript:void(0);" class="openModifierItemForm action-edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                    <a  data-route="{{route('delete.modifier.item.post',[$item->modifier_item_id])}}" href="javaScript:void(0);" class="delete action-delete"><i class="fa fa-trash" aria-hidden="true"></i></a>
                  </div>
                </div>
              </div>
             @endforeach
            </div>
          </div>
          @endforeach
        </div>

        <div class="float-right"> {{ $modifiers->links() }}</div>
        @else
            <p>No records found.</p>
        @endif
      </div>
    </section>

    <div id="modifierGroupPopUp" class="modifierGroupPopUp closeAllModal overlay w-100">
      <div class="popup text-center">
        <a class="close closeModal" href="javaScript:void(0);">&times;</a>
        <div class="content">
          <h5 class="groupHeading">Add Modifier Group</h5>
          {{ Form::open(array('route' => array('add.modifier.post'),'id'=>'modifierForm','method'=>'POST',
          'class'=>'')) }}
          <div class="form-group">                
              <input type="hidden" id="modifier_group_id" name="modifier_group_id"  />
              <input type="text" class="form-control" id="modifier_group_name" name="modifier_group_name" placeholder="Modifier Group Name">
            </div>
            <div class="form-group">                
                <input type="checkbox" class="styled-checkbox"  id="allow_multiple" name="allow_multiple" />
                <label for="allow_multiple">Allow Multiple</label>
            </div>
          <div class="btn-custom">
            <button class="groupBtn btn-blue"><span>Add</span></button>
          </div>
        </form>
        </div>
      </div>
    </div>

    <div id="openModifierItemFormPopUp" class="openModifierItemFormPopUp closeAllModal overlay w-100">
      @include('common.flashMessage')
      <div class="popup text-center">
        <a class="close closeModal" href="javaScript:void(0);">&times;</a>
        <div class="content">
          <h5 class="itemHeading">Add modifier item</h5>
          {{ Form::open(array('route' => array('add.modifier.item.post'),'id'=>'modifierItemForm','method'=>'POST',
          'class'=>'')) }}
          <div class="form-group">                
              <input type="text" class="form-control" id="modifier_group_item_name" name="modifier_group_item_name" placeholder="Enter Modifier Item Name">
            </div>
            <div class="form-group"> 
              <input type="hidden" id="modifier_item_group_id" name="modifier_item_group_id" />  
              <input type="hidden" id="modifier_item_id" name="modifier_item_id" />               
              <input type="text" class="form-control" id="modifier_group_item_price" name="modifier_group_item_price" placeholder="Enter Modifier Price">
            </div>
          <div class="btn-custom">
            <button class="btn-blue itemBtn"><span>Add</span></button>
          </div>
        </form>
        </div>
      </div>
    </div>
@endsection
@section('scripts')
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
{!! JsValidator::formRequest('App\Http\Requests\ModifierGroupRequest','#modifierForm'); !!}
{!! JsValidator::formRequest('App\Http\Requests\ModifierItemPriceRequest','#modifierItemForm'); !!}
<script src="{{asset('/assets/js/modifier.js')}}"></script>    
@endsection