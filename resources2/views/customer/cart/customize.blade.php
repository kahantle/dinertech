<div class="modal fade customize"  tabindex="-1" role="dialog" aria-labelledby="modifier-btn">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header modifier-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4>{{$menuItem->item_name}}</h4>
            </div>
            <form action="{{route('customer.cart.customize.update')}}" method="post" id="customizeCartItem">
            	@csrf
	            <div class="modal-body">
	                <input type="hidden" name="menuId" class="menuId">
					<input type="hidden" name="cartKey" value="{{$cartKey}}">
	                @foreach($menuItem->modifierList as $modifirelist)
	                    <input type="hidden" name="modifierGroupId[]" value="{{$modifirelist->modifier_group_id}}">
	                    <ul class="modifier-list">
	                        <li>
	                            {{$modifirelist->modifier_group_name}}
	                            @if($modifirelist->allow_multiple == 1)
	                                @foreach($modifirelist->modifier_item as $modifireItem)
		                                <div class="checkbox">
		                                    <label>
		                                        <input type="checkbox" name="modifierItems[{{$modifirelist->modifier_group_id}}][]" value="{{$modifireItem->modifier_item_id}}" @if(in_array($modifireItem->modifier_item_id,$modifierGroupItems)) checked @endif> {{$modifireItem->modifier_group_item_name}}
		                                        <span class="mark"></span>
		                                    </label>
		                                    <label class="modifier-price">
		                                        $ {{$modifireItem->modifier_group_item_price}}
		                                    </label>
		                                </div>
	                                @endforeach
	                            @else
									@foreach($modifirelist->modifier_item as $modifireItem)
	                                    <div class="form-check">
	                                      <input class="form-check-input" type="radio" name="modifierItems[{{$modifirelist->modifier_group_id}}][]" id="flexRadioDefault1" value="{{$modifireItem->modifier_item_id}}" @if(in_array($modifireItem->modifier_item_id,$modifierGroupItems)) checked @endif>
	                                      <label class="form-check-label" for="flexRadioDefault1" style="font-weight: unset;">
	                                        {{$modifireItem->modifier_group_item_name}}
	                                      </label>
	                                      <label class="modifier-price" style="font-weight: unset;">
	                                          $ {{$modifireItem->modifier_group_item_price}}
	                                      </label>
	                                    </div>
	                                @endforeach
	                            @endif
	                        </li>
	                    </ul>
	                @endforeach       
	            </div>
	            <div class="modal-footer">
	                <button type="submit" class="btn btn-primary btn-block UpdateItem" alt="Add Item"> Update</button>
	            </div>
            </form>
        </div>
    </div>
</div>