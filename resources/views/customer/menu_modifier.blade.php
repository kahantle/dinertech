<form action="{{ route('customer.addToCart') }}" method="POST" id="addToCart">
    @csrf 
    <input type="hidden" value="{{ $item->menu_id }}" name="menuId">
    <div class="modal fade modal-second-inner modifier-modal-{{ $item->menu_id }} modifier-modal" id="exampleModalCenter"
        tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">{{ $item->item_name }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        {{-- <span class="closing-logo">
                            <span aria-hidden="true">&times;</span>
                        </span> --}}
                        {{-- <svg width="27" height="27" viewBox="0 0 27 27" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g filter="url(#filter0_i_6_778)">
                            <circle cx="13.5" cy="13.5" r="13.5" fill="#2B34FB"/>
                            </g>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M14 14.6855L17.5317 17.7783C17.6113 17.8486 17.7059 17.9043 17.8102 17.9424C17.9145 17.9804 18.0263 18 18.1393 18C18.2523 18 18.3641 17.9804 18.4684 17.9424C18.5727 17.9043 18.6673 17.8486 18.7469 17.7783C18.8271 17.7087 18.8907 17.6258 18.9342 17.5345C18.9776 17.4431 19 17.3452 19 17.2463C19 17.1473 18.9776 17.0494 18.9342 16.9581C18.8907 16.8668 18.8271 16.7839 18.7469 16.7142L15.0673 13.4994L18.7469 10.2845C18.908 10.1434 18.9985 9.95201 18.9985 9.75245C18.9985 9.65364 18.9763 9.55579 18.9331 9.4645C18.89 9.37321 18.8267 9.29026 18.7469 9.22039C18.5857 9.07928 18.3672 9 18.1393 9C18.0265 9 17.9147 9.01946 17.8105 9.05728C17.7063 9.09509 17.6115 9.15052 17.5317 9.22039L14 12.3132L10.4683 9.22039C10.3885 9.15052 10.2937 9.09509 10.1895 9.05728C10.0853 9.01946 9.97352 9 9.86069 9C9.63281 9 9.41426 9.07928 9.25312 9.22039C9.17334 9.29026 9.11005 9.37321 9.06686 9.4645C9.02368 9.55579 9.00146 9.65364 9.00146 9.75245C9.00146 9.95201 9.09199 10.1434 9.25312 10.2845L12.9327 13.4994L9.25312 16.7142C9.17292 16.7839 9.10926 16.8668 9.06581 16.9581C9.02237 17.0494 9 17.1473 9 17.2463C9 17.3452 9.02237 17.4431 9.06581 17.5345C9.10926 17.6258 9.17292 17.7087 9.25312 17.7783C9.33267 17.8486 9.42732 17.9043 9.5316 17.9424C9.63587 17.9804 9.74772 18 9.86069 18C9.97365 18 10.0855 17.9804 10.1898 17.9424C10.2941 17.9043 10.3887 17.8486 10.4683 17.7783L14 14.6855Z" fill="white"/>
                            <defs>
                            <filter id="filter0_i_6_778" x="0" y="0" width="27" height="31" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                            <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                            <feBlend mode="normal" in="SourceGraphic" in2="BackgroundImageFix" result="shape"/>
                            <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                            <feOffset dy="4"/>
                            <feGaussianBlur stdDeviation="2"/>
                            <feComposite in2="hardAlpha" operator="arithmetic" k2="-1" k3="1"/>
                            <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.1 0"/>
                            <feBlend mode="normal" in2="shape" result="effect1_innerShadow_6_778"/>
                            </filter>
                            </defs>
                            </svg> --}}
                            <img class="closing-logo" src={{asset('images/close.png')}} alt="close" />

                    </button>
                </div>
                <div class="modal-body">
                    @foreach ($item->modifierList as $modifierlist)
                        <input type="hidden" name="modifierGroupIds[]" value="{{ $modifierlist->modifier_group_id }}">
                        <h6>{{ $modifierlist->modifier_group_name }}</h6>
                        <span class="modifier-modal sub-tile mb-3">Select Item(s)</span>
                        <div class="item-list">
                        @foreach ($modifierlist->modifier_item as $modifierItem)
                            <div class="wd-check-input">
                                <label>
                                    <input type="{{ $modifierlist->allow_multiple == 0 ? 'radio' : 'checkbox' }}"
                                    name="modifierItems[{{ $modifierlist->modifier_group_id }}][]"
                                    class="slct-btn {{ $modifierlist->allow_multiple == 0 ? 'radioModifierItem' : 'modifierItem' }}" value="{{ $modifierItem->modifier_item_id }}"
                                    data-modifier-item="{{ $modifierItem->modifier_group_item_name }}" />
                                    {{ $modifierItem->modifier_group_item_name }}
                                </label>
                                <span class="price">$ {{ $modifierItem->modifier_group_item_price }}</span>
                            </div>
                        @endforeach
                        </div>
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
                        data-menu-id="{{ $item->menu_id }}"> Add to order</button>
                </div>
            </div>
        </div>
    </div>
</form>
