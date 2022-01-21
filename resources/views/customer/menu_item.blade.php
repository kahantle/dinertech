@php
$counter = 1;
@endphp

<h2 class="mb-0 mt-4">{{ $category->category_name }}</h2>
@forelse($menuItems as $item)
    @if ($counter == 1)
        <div class="row">
    @endif

    @if ($item->item_img != null)
        <div class="col-md-6">
            <div class="card">
                <img class="card-img-top" src="{{ $item->getMenuImgAttribute() }}" alt="Card image cap" width="489"
                    height="224">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between w-100 wd-dr-menu-item mb-1">
                        <p>{{ $item->item_name }}</p>
                        <p>$ {{ number_format($item->item_price, 2) }}</p>
                    </div>
                    <div class="p-0 rateYo" data-rating="3.6"></div>
                    <p class="more wd-dr-lor">{{ $item->item_details }}</p>
                    @if ($item->modifierList->count() == 0)
                        <div class="d-flex justify-content-end w-100 align-items-center"
                            id="menu-{{ $item->menu_id }}">
                            @if (in_array($item->menu_id, $menuIds))
                                @php
                                    $itemQuantity = 0;
                                    foreach ($quantities as $quantity) {
                                        if ($quantity['menu_id'] == $item->menu_id) {
                                            $itemQuantity += $quantity['quantity'];
                                        }
                                    }
                                @endphp
                                <div class="product-quantity without-modifier-quantity-{{ $item->menu_id }}">
                                    <span class="product-quantity-minus without-modifier-minus"
                                        data-menu-id="{{ $item->menu_id }}"
                                        data-cart-item="{{ getCartKey('without-modifier', $item->menu_id) }}"></span>
                                    <input type="number" value="{{ $itemQuantity }}"
                                        class="quantity-{{ $item->menu_id }}" readonly />
                                    <span class="product-quantity-plus without-modifier-plus"
                                        data-menu-id="{{ $item->menu_id }}"
                                        data-cart-item="{{ getCartKey('without-modifier', $item->menu_id) }}"></span>
                                </div>
                                <button type="button" class="btn d-none btn-dark without-modifier"
                                    id="add-order-{{ $item->menu_id }}" data-menu-id="{{ $item->menu_id }}">Add To
                                    Order</button>
                            @else
                                <button type="button" class="btn btn-dark without-modifier"
                                    id="add-order-{{ $item->menu_id }}" data-menu-id="{{ $item->menu_id }}">Add To
                                    Order</button>
                                <div class="product-quantity d-none without-modifier-quantity-{{ $item->menu_id }}">
                                    <span class="product-quantity-minus without-modifier-minus"
                                        data-menu-id="{{ $item->menu_id }}"
                                        data-cart-item="{{ getCartKey('without-modifier', $item->menu_id) }}"></span>
                                    <input type="number" value="1" class="quantity-{{ $item->menu_id }}" readonly />
                                    <span class="product-quantity-plus without-modifier-plus"
                                        data-menu-id="{{ $item->menu_id }}"
                                        data-cart-item="{{ getCartKey('without-modifier', $item->menu_id) }}"></span>
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="d-flex justify-content-end w-100 align-items-center">
                            @php $menuCount = 1; @endphp
                            @if (in_array($item->menu_id, $menuIds))
                                @php
                                    $menuCount++;
                                    
                                    if ($menuCount == 2) {
                                        $cartClass = 'decrease-repeat-last';
                                    } else {
                                        $cartClass = 'with-modifier-minus';
                                    }
                                    $itemQuantity = 0;
                                    
                                    foreach ($quantities as $quantity) {
                                        if ($quantity['menu_id'] == $item->menu_id) {
                                            $itemQuantity += $quantity['quantity'];
                                        }
                                    }
                                @endphp
                                <div class="product-quantity modifier-quantity-{{ $item->menu_id }}">
                                    <span class="product-quantity-minus {{ $cartClass }}"
                                        data-menu-id="{{ $item->menu_id }}"
                                        data-cart-item="{{ getCartKey('with-modifier', $item->menu_id) }}"></span>
                                    <input type="number" value="{{ $itemQuantity }}"
                                        class="quantity-{{ $item->menu_id }}" readonly />
                                    <span class="product-quantity-plus with-modifier-plus"
                                        data-menu-id="{{ $item->menu_id }}"
                                        data-cart-item="{{ getCartKey('with-modifier', $item->menu_id) }}"></span>
                                </div>
                            @else
                                <button type="button"
                                    class="btn btn-dark with-modifier add-order-{{ $item->menu_id }}"
                                    data-menu-id="{{ $item->menu_id }}">Add To Order</button>
                                <div class="product-quantity d-none modifier-quantity-{{ $item->menu_id }}">
                                    <span class="product-quantity-minus with-modifier-minus"
                                        data-menu-id="{{ $item->menu_id }}"
                                        data-cart-item="{{ getCartKey('with-modifier', $item->menu_id) }}"></span>
                                    <input type="number" value="1" class="quantity-{{ $item->menu_id }}" readonly />
                                    <span class="product-quantity-plus with-modifier-plus"
                                        data-menu-id="{{ $item->menu_id }}"
                                        data-cart-item="{{ getCartKey('with-modifier', $item->menu_id) }}"></span>
                                </div>
                            @endif
                            <div class="repeat-last-add-modal-{{ $item->menu_id }}"></div>
                        </div>
                        <div class="modifiers-{{ $item->menu_id }}"></div>
                    @endif
                </div>
            </div>
        </div>
    @else
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between w-100 wd-dr-menu-item mb-1">
                        <p>{{ $item->item_name }}</p>
                        <p>$ {{ number_format($item->item_price, 2) }}</p>
                    </div>
                    <div class="p-0 rateYo" data-rating="3.6"></div>
                    <p class="more wd-dr-lor">{{ $item->item_details }}</p>
                    @if ($item->modifierList->count() == 0)
                        <div class="d-flex justify-content-end w-100 align-items-center">
                            @if (in_array($item->menu_id, $menuIds))
                                @php
                                    $itemQuantity = 0;
                                    foreach ($quantities as $quantity) {
                                        if ($quantity['menu_id'] == $item->menu_id) {
                                            $itemQuantity += $quantity['quantity'];
                                        }
                                    }
                                @endphp
                                <div class="product-quantity without-modifier-quantity-{{ $item->menu_id }}">
                                    <span class="product-quantity-minus without-modifier-minus"
                                        data-menu-id="{{ $item->menu_id }}"
                                        data-cart-item="{{ getCartKey('without-modifier', $item->menu_id) }}"></span>
                                    <input type="number" value="{{ $itemQuantity }}"
                                        class="quantity-{{ $item->menu_id }}" readonly />
                                    <span class="product-quantity-plus without-modifier-plus"
                                        data-menu-id="{{ $item->menu_id }}"
                                        data-cart-item="{{ getCartKey('without-modifier', $item->menu_id) }}"></span>
                                </div>
                            @else
                                <button type="button" class="btn btn-dark without-modifier"
                                    id="add-order-{{ $item->menu_id }}" data-menu-id="{{ $item->menu_id }}">Add To
                                    Order</button>
                                <div class="product-quantity d-none without-modifier-quantity-{{ $item->menu_id }}">
                                    <span class="product-quantity-minus without-modifier-minus"
                                        data-menu-id="{{ $item->menu_id }}"
                                        data-cart-item="{{ getCartKey('without-modifier', $item->menu_id) }}"></span>
                                    <input type="number" value="1" class="quantity-{{ $item->menu_id }}" readonly />
                                    <span class="product-quantity-plus without-modifier-plus"
                                        data-menu-id="{{ $item->menu_id }}"
                                        data-cart-item="{{ getCartKey('without-modifier', $item->menu_id) }}"></span>
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="d-flex justify-content-end w-100 align-items-center">
                            @php $menuCount = 1; @endphp
                            @if (in_array($item->menu_id, $menuIds))
                                @php
                                    $menuCount++;
                                    
                                    if ($menuCount == 2) {
                                        $cartClass = 'decrease-repeat-last';
                                    } else {
                                        $cartClass = 'with-modifier-minus';
                                    }
                                    
                                    $itemQuantity = 0;
                                @endphp
                                @foreach ($quantities as $quantity)
                                    @if ($quantity['menu_id'] == $item->menu_id)
                                        @php
                                            $itemQuantity += $quantity['quantity'];
                                        @endphp
                                    @endif
                                @endforeach
                                <div class="product-quantity modifier-quantity-{{ $item->menu_id }}">
                                    <span class="product-quantity-minus {{ $cartClass }}"
                                        data-menu-id="{{ $item->menu_id }}"
                                        data-cart-item="{{ getCartKey('with-modifier', $item->menu_id) }}"></span>
                                    <input type="number" value="{{ $itemQuantity }}"
                                        class="quantity-{{ $item->menu_id }}" readonly />
                                    <span class="product-quantity-plus with-modifier-plus"
                                        data-menu-id="{{ $item->menu_id }}"
                                        data-cart-item="{{ getCartKey('with-modifier', $item->menu_id) }}"></span>
                                </div>
                            @else
                                <button type="button" class="btn btn-dark with-modifier"
                                    id="add-order-{{ $item->menu_id }}" data-menu-id="{{ $item->menu_id }}">Add To
                                    Order</button>
                                <div class="product-quantity d-none modifier-quantity-{{ $item->menu_id }}">
                                    <span class="product-quantity-minus with-modifier-minus"
                                        data-menu-id="{{ $item->menu_id }}"
                                        data-cart-item="{{ getCartKey('with-modifier', $item->menu_id) }}"></span>
                                    <input type="number" value="1" class="quantity-{{ $item->menu_id }}" readonly />
                                    <span class="product-quantity-plus with-modifier-plus"
                                        data-menu-id="{{ $item->menu_id }}"
                                        data-cart-item="{{ getCartKey('with-modifier', $item->menu_id) }}"></span>
                                </div>
                            @endif
                            <div class="repeat-last-add-modal-{{ $item->menu_id }}"></div>
                        </div>
                        <div class="modifiers-{{ $item->menu_id }}"></div>
                    @endif
                </div>
            </div>
        </div>
    @endif
    @php
        if ($counter == 2) {
            echo '</div>';
            $counter = 1;
        } else {
            $counter++;
        }
    @endphp
@empty
    <div class="menu-item-found-blog">
        <h4>No Item Found</h4>
    </div>
@endforelse
