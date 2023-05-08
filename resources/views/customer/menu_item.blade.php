
<h2 class="mb-0 mt-4">{{ $category->category_name ?? "" }}</h2>
<div class="row">
    @forelse($menuItems as $item)
        <div class="col-md-6">
            <div class="card">
                <img class="card-img-top" src="{{ $item->item_img ? $item->getMenuImgAttribute() : 'https://w7.pngwing.com/pngs/156/887/png-transparent-local-food-ottawa-computer-icons-restaurant-others-miscellaneous-food-company.png' }}" alt="Card image cap" width="489" height="224">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between w-100 wd-dr-menu-item mb-1">
                        <p>{{ $item->item_name }}</p>
                        <p>$ {{ number_format($item->item_price, 2) }}</p>
                    </div>
                    <div class="p-0 rateYo" data-rating="5"></div>
                    <p class="more wd-dr-lor">{{ $item->item_details }}</p>
                    <div class="d-flex justify-content-end w-100 align-items-center">
                        <div class="product-quantity product-quantity-{{ $item->menu_id }} {{ in_array($item->menu_id, $cartMenuItemIds) ? 'd-inline-flex' : 'd-none' }} ">
                            <span class="product-quantity-minus" data-cart-menu-item-id="{{ in_array($item->menu_id, $cartMenuItemIds) ? array_keys($cartMenuItemIds, $item->menu_id)[0] : ""  }}"></span>
                            <input type="number" value="{{ in_array($item->menu_id, $cartMenuItemIds) ? $cart->cartMenuItems->where('menu_id',$item->menu_id)->first()->menu_qty : 1 }}" class="quantity-{{ in_array($item->menu_id, $cartMenuItemIds) ? array_keys($cartMenuItemIds, $item->menu_id)[0] : "" }}" readonly />
                            <span class="product-quantity-plus {{ $item->modifierList->count() > 0 ? 'have-modifiers' : '' }}" data-menu-id="{{$item->menu_id}}" data-cart-menu-item-id="{{ in_array($item->menu_id, $cartMenuItemIds) ? array_keys($cartMenuItemIds, $item->menu_id)[0] : ""    }}"></span>
                        </div>
                        @if(auth()->check() == true)
                        <button type="button"
                            class="btn btn-dark add-to-order add-order-{{ $item->menu_id }} {{ $item->modifierList->count() > 0 ? 'have-modifiers' : '' }} {{ in_array($item->menu_id, $cartMenuItemIds) ? 'd-none' : '' }}"
                            data-menu-id="{{ $item->menu_id  }}">
                            Add To Order
                        </button>
                        @else
                        <div class="text-center" id="loginbutton">
                            <button type="button" class="btn btn-dark" title="Login" data-toggle="modal" data-target="#yourModal"> Add To Order</button>
                        </div>
                        @endif
                        <div class="repeat-last-add-modal-{{ in_array($item->menu_id, $cartMenuItemIds) ? array_keys($cartMenuItemIds, $item->menu_id)[0] : "" }}"></div>
                    </div>
                    <div class="modifiers-{{ $item->menu_id }}"></div>
                </div>
            </div>
        </div>
    @empty

    <div class="menu-item-found-blog">
        <h4>No Item Found</h4>
    </div>

    @endforelse
</div>
