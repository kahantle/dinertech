<div class="modal modal-inner-third-vlog repeat-last-modal-{{ $menuItem->menu_id }}">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header border-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h5 class="modal-title" id="exampleModalCenterTitle">Repeat last used customization?</h5>
                @foreach ($modifierGroups as $modifierGroup)
                    {{ $modifierGroup->modifier_group_name }} :
                    @foreach ($modifierGroup->modifier_item as $modifireIteam)
                        @if ($modifireIteam->modifier_group_id == $modifierGroup->modifier_group_id)
                            {{ $modifireIteam->modifier_group_item_name }}
                        @endif
                    @endforeach
                @endforeach
            </div>
            <div class="modal-footer border-0 justify-content-center">
                <button type="button" class="choose-blog add-new-item" data-menu-id="{{ $menuItem->menu_id }}">I’LL
                    CHOOSE</button>
                <button type="button" class="repeate-last repeat-last-cart" data-menu-id="{{ $menuItem->menu_id }}"
                    data-cart-key="{{ $cartKey }}">REPEAT LAST</button>
            </div>
        </div>
    </div>
</div>
