<div class="modal fade cart-alert" id="future-order" tabindex="-1" role="dialog" aria-labelledby="modifier-btn">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4>Repeat last used customiztion ?</h4>
            </div>
            <form class="form-group">
                <div class="modal-body">
                     <h4>{{$menuItem->item_name}}</h4>
                     <ul>
                        @foreach($modifierGroups as $modifierGroup)
                            <li>
                                {{$modifierGroup->modifier_group_name}} : 
                                @foreach($modifierGroup->modifier_item as $modifireIteam)
                                    @if($modifireIteam->modifier_group_id == $modifierGroup->modifier_group_id)
                                        {{$modifireIteam->modifier_group_item_name}}
                                    @endif
                                @endforeach
                            </li>
                        @endforeach
                     </ul>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-md-5 pull-left">
                            <button type="button" class="btn btn-primary btn-block add-new-item" data-menu-id="{{$menuItem->menu_id}}">
                                <h4>
                                    Add New
                                </h4>
                            </button>
                        </div>
                        <div class="col-md-5 pull-right">
                            <button type="button" class="btn btn-danger btn-block repeat-last repeat-last-cart" data-menu-id="{{$menuItem->menu_id}}" data-cart-key="{{$cartKey}}">
                                <h4>
                                    Repeat Last
                                </h4>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>