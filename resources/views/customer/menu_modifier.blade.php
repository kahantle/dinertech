<form action="{{ route('customer.addToCart') }}" method="POST" id="addToCart">
    @csrf
    <input type="hidden" value="{{ $item->menu_id }}" name="menuId">
    <div class="modal fade modal-second-inner modifier-modal-{{ $item->menu_id }}" id="exampleModalCenter"
        tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">{{ $item->item_name }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @foreach ($item->modifierList as $modifierlist)
                        <input type="hidden" name="modifierGroupId[]" value="{{ $modifierlist->modifier_group_id }}">
                        <h6>{{ $modifierlist->modifier_group_name }}</h6>
                        @if ($modifierlist->allow_multiple == 0)
                            @foreach ($modifierlist->modifier_item as $modifierItem)
                                <div class="wd-check-input">
                                    <label>
                                        <input type="radio" name="modifierItems[{{ $modifierlist->modifier_group_id }}][]"
                                            class="radioModifierItem" value="{{ $modifierItem->modifier_item_id }}"
                                            data-modifier-item="{{ $modifierItem->modifier_group_item_name }}" />
                                        {{ $modifierItem->modifier_group_item_name }}
                                    </label>
                                    <span>$ {{ $modifierItem->modifier_group_item_price }}</span>
                                </div>
                            @endforeach
                        @else
                            @foreach ($modifierlist->modifier_item as $modifierItem)
                                <div class="wd-check-input">
                                    <input type="checkbox"
                                        name="modifierItems[{{ $modifierlist->modifier_group_id }}][]"
                                        class="modifierItem" value="{{ $modifierItem->modifier_item_id }}"
                                        data-modifier-item="{{ $modifierItem->modifier_group_item_name }}" /><label>{{ $modifierItem->modifier_group_item_name }}</label>
                                    <span>$ {{ $modifierItem->modifier_group_item_price }}</span>
                                </div>
                            @endforeach
                        @endif
                    @endforeach
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-lg-4 col-md-4">
                            <p> Select items: <span class="radiobuttonItem"></span> <span class="primarycardnow"></span>
                            </p>
                        </div>
                    </div>
                    <button class="btn btn-submit-inner my-3 with-modifier-add" type="button"
                        data-menu-id="{{ $item->menu_id }}">Add to order</button>
                </div>
            </div>
        </div>
    </div>
</form>
