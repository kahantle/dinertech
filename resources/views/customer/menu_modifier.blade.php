<div class="modal fade modifier-menu-{{$menuItem->menu_id}}" tabindex="-1"  role="dialog" aria-labelledby="modifier-btn">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header modifier-header">
                <button type="button" class="close modalClose" aria-label="Close" data-menu-id="{{$menuItem->menu_id}}"><span aria-hidden="true">&times;</span></button>
                <h4>{{$menuItem->item_name}}</h4>
            </div>
            <form action="{{route('customer.addToCart')}}" method="post" class="cartform">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="menuId" class="menuId">
                    <input type="hidden" name="categoryId" value="{{$menuItem->category_id}}">
                    <input type="hidden" name="menuName" value="{{$menuItem->item_name}}">
                    @foreach($menuItem->modifierList as $modifirelist)
                        <input type="hidden" name="modifierGroupId[]" value="{{$modifirelist->modifier_group_id}}">
                        <ul class="modifier-list">
                            <li>
                                {{$modifirelist->modifier_group_name}}
                                @if($modifirelist->allow_multiple == 1)
                                    @foreach($modifirelist->modifier_item as $modifireItem)
    	                                <div class="checkbox">
    	                                    <label>
    	                                        <input type="checkbox" name="modifierItems[{{$modifirelist->modifier_group_id}}][]" value="{{$modifireItem->modifier_item_id}}"> {{$modifireItem->modifier_group_item_name}}
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
                                          <input class="form-check-input" type="radio" name="modifierItems[{{$modifirelist->modifier_group_id}}][]" id="flexRadioDefault1" value="{{$modifireItem->modifier_item_id}}">
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
                    <button type="button" class="btn btn-primary btn-block add-item add-item-{{Str::of($menuItem->item_name)->replace(' ', '-')}}" data-menu-name="{{Str::of($menuItem->item_name)->replace(' ', '-')}}" data-menu-id="{{$menuItem->menu_id}}" alt="Add Item"> Add
                        Item</button>
                     <!-- <button type="submit" class="btn btn-primary btn-block" alt="Add Item"> Add Item</button> -->
                </div>
            </form>
        </div>
    </div>
</div>