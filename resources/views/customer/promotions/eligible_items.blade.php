@extends('customer-layouts.app')

@section('css')
    <!-- Rating bar css -->
    <link rel="stylesheet" href="{{ asset('assets/customer/css/rateYo/2.3.2/jquery.rateyo.min.css') }}">
@endsection

@section('content')
    <section class="dash-body-ar wd-dr-dash-inner">
        <div class="wrp-ar-nav-body">
            @include('customer-layouts.navbar')
            <div id="chatdesk" class="chart-board ">
                <div class="row">
                    <div class="col-xl-8 col-lg-12 col-md-12">
                        <div class="content">
                            <h2>{{ $promotion->promotion_name }}</h2>
                            <div class="scrollbar border-0 " id="style-4">
                                <div class="row">
                                    @foreach ($promotionCategoryItems as $promotionCategory)
                                        @foreach ($promotionCategory->category_item as $item)
                                            @if ($item->item_img != null)
                                                <div class="col-md-6">
                                                    <div class="card">
                                                        <img class="card-img-top lazy"
                                                            data-src="{{ $item->getMenuImgAttribute() ? $item->getMenuImgAttribute() : $item->getDefaultImage() }}"
                                                            alt="Card image cap" width="489" height="224">
                                                        <div class="card-body">
                                                            <div
                                                                class="d-flex align-items-center justify-content-between w-100 wd-dr-menu-item mb-1">
                                                                <p>{{ $item->item_name }}</p>
                                                                <p>${{ number_format($item->item_price, 2) }}</p>
                                                            </div>
                                                            <div class="p-0 rateYo" data-rating="3.6"></div>
                                                            <p class="more wd-dr-lor">{{ $item->item_details }}</p>
                                                            @if ($item->modifierList->count() == 0)
                                                                <div
                                                                    class="d-flex justify-content-end w-100 align-items-center">
                                                                    @if (in_array($item->menu_id, $menuIds))
                                                                        @php
                                                                            $itemQuantity = 0;
                                                                            foreach ($quantities as $quantity) {
                                                                                if ($quantity['menu_id'] == $item->menu_id) {
                                                                                    $itemQuantity += $quantity['quantity'];
                                                                                }
                                                                            }
                                                                        @endphp
                                                                        <div
                                                                            class="product-quantity without-modifier-quantity-{{ $item->menu_id }}">
                                                                            <span
                                                                                class="product-quantity-minus pro-without-modifier-minus"
                                                                                data-menu-id="{{ $item->menu_id }}"
                                                                                data-cart-item="{{ getCartKey('without-modifier', $item->menu_id) }}"></span>
                                                                            <input type="number"
                                                                                value="{{ $itemQuantity }}"
                                                                                class="quantity-{{ $item->menu_id }}" />
                                                                            <span
                                                                                class="product-quantity-plus pro-without-modifier-plus"
                                                                                data-menu-id="{{ $item->menu_id }}"
                                                                                data-cart-item="{{ getCartKey('without-modifier', $item->menu_id) }}"></span>
                                                                        </div>
                                                                    @else
                                                                        <button type="button"
                                                                            class="btn btn-dark pro-without-modifier"
                                                                            id="add-order-{{ $item->menu_id }}"
                                                                            data-menu-id="{{ $item->menu_id }}"
                                                                            data-promotion="{{ $promotion->promotion_id }}">Add
                                                                            To
                                                                            Order</button>
                                                                        <div
                                                                            class="product-quantity d-none without-modifier-quantity-{{ $item->menu_id }}">
                                                                            <span
                                                                                class="product-quantity-minus pro-without-modifier-minus"
                                                                                data-menu-id="{{ $item->menu_id }}"
                                                                                data-cart-item="{{ getCartKey('without-modifier', $item->menu_id) }}"></span>
                                                                            <input type="number" value="1"
                                                                                class="quantity-{{ $item->menu_id }}" />
                                                                            <span
                                                                                class="product-quantity-plus without-modifier-plus pro-without-modifier-plus"
                                                                                data-menu-id="{{ $item->menu_id }}"
                                                                                data-cart-item="{{ getCartKey('without-modifier', $item->menu_id) }}"></span>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            @else
                                                                <div
                                                                    class="d-flex justify-content-end w-100 align-items-center">
                                                                    @php $menuCount = 1; @endphp
                                                                    @if (in_array($item->menu_id, $menuIds))
                                                                        @php
                                                                            $menuCount++;
                                                                            if ($menuCount == 2) {
                                                                                $cartClass = 'pro-decrease-repeat-last';
                                                                            } else {
                                                                                $cartClass = 'pro-with-modifier-minus';
                                                                            }
                                                                            $itemQuantity = 0;
                                                                            
                                                                            foreach ($quantities as $quantity) {
                                                                                if ($quantity['menu_id'] == $item->menu_id) {
                                                                                    $itemQuantity += $quantity['quantity'];
                                                                                }
                                                                            }
                                                                        @endphp

                                                                        <div
                                                                            class="product-quantity modifier-quantity-{{ $item->menu_id }}">
                                                                            <span
                                                                                class="product-quantity-minus {{ $cartClass }}"
                                                                                data-cart-item="{{ getCartKey('with-modifier', $item->menu_id) }}"></span>
                                                                            <input type="number"
                                                                                value="{{ $itemQuantity }}"
                                                                                class="quantity-{{ $item->menu_id }}" />
                                                                            <span
                                                                                class="product-quantity-plus pro-with-modifier-plus"
                                                                                data-menu-id="{{ $item->menu_id }}"
                                                                                data-cart-item="{{ getCartKey('with-modifier', $item->menu_id) }}"></span>
                                                                        </div>
                                                                    @else
                                                                        <button type="button"
                                                                            class="btn btn-dark pro-menu-modifier"
                                                                            id="add-order-{{ $item->menu_id }}"
                                                                            data-menu-id="{{ $item->menu_id }}"
                                                                            data-promotion="{{ $promotion->promotion_id }}">Add
                                                                            To
                                                                            Order</button>
                                                                        <div
                                                                            class="product-quantity d-none modifier-quantity-{{ $item->menu_id }}">
                                                                            <span
                                                                                class="product-quantity-minus pro-with-modifier-minus"
                                                                                data-menu-id="{{ $item->menu_id }}"
                                                                                data-cart-item="{{ getCartKey('with-modifier', $item->menu_id) }}"></span>
                                                                            <input type="number" value="1"
                                                                                class="quantity-{{ $item->menu_id }}" />
                                                                            <span
                                                                                class="product-quantity-plus pro-with-modifier-plus"
                                                                                data-menu-id="{{ $item->menu_id }}"
                                                                                data-cart-item="{{ getCartKey('with-modifier', $item->menu_id) }}"></span>
                                                                        </div>
                                                                    @endif
                                                                    <div
                                                                        class="repeat-last-add-modal-{{ $item->menu_id }}">
                                                                    </div>
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
                                                            <div
                                                                class="d-flex align-items-center justify-content-between w-100 wd-dr-menu-item mb-1">
                                                                <p>{{ $item->item_name }}</p>
                                                                <p>${{ number_format($item->item_price, 2) }}</p>
                                                            </div>
                                                            <div class="p-0 rateYo" data-rating="3.6"></div>
                                                            <p class="more wd-dr-lor">{{ $item->item_details }}</p>
                                                            @if ($item->modifierList->count() == 0)
                                                                <div
                                                                    class="d-flex justify-content-end w-100 align-items-center">
                                                                    @if (in_array($item->menu_id, $menuIds))
                                                                        @php
                                                                            $itemQuantity = 0;
                                                                            foreach ($quantities as $quantity) {
                                                                                if ($quantity['menu_id'] == $item->menu_id) {
                                                                                    $itemQuantity += $quantity['quantity'];
                                                                                }
                                                                            }
                                                                        @endphp
                                                                        <div
                                                                            class="product-quantity without-modifier-quantity-{{ $item->menu_id }}">
                                                                            <span
                                                                                class="product-quantity-minus pro-without-modifier-minus quantity__minus_{{ $item->menu_id }}"
                                                                                data-menu-id="{{ $item->menu_id }}"
                                                                                data-cart-item="{{ getCartKey('without-modifier', $item->menu_id) }}"></span>
                                                                            <input type="number"
                                                                                value="{{ $itemQuantity }}"
                                                                                class="quantity-{{ $item->menu_id }}"
                                                                                readonly />
                                                                            <span
                                                                                class="product-quantity-plus pro-without-modifier-plus quantity__plus_{{ $item->menu_id }}"
                                                                                data-menu-id="{{ $item->menu_id }}"
                                                                                data-cart-item="{{ getCartKey('without-modifier', $item->menu_id) }}"></span>
                                                                        </div>
                                                                    @else
                                                                        <button type="button"
                                                                            class="btn btn-dark without-modifier add-order-{{ $item->menu_id }}"
                                                                            data-menu-id="{{ $item->menu_id }}">Add To
                                                                            Order</button>
                                                                        <div
                                                                            class="product-quantity d-none without-modifier-quantity-{{ $item->menu_id }}">
                                                                            <span
                                                                                class="product-quantity-minus pro-without-modifier-minus quantity__minus_{{ $item->menu_id }}"
                                                                                data-menu-id="{{ $item->menu_id }}"
                                                                                data-cart-item="{{ getCartKey('without-modifier', $item->menu_id) }}"></span>
                                                                            <input type="number" value="1"
                                                                                class="quantity-{{ $item->menu_id }}"
                                                                                readonly />
                                                                            <span
                                                                                class="product-quantity-plus pro-without-modifier-plus quantity__plus_{{ $item->menu_id }}"
                                                                                data-menu-id="{{ $item->menu_id }}"
                                                                                data-cart-item="{{ getCartKey('without-modifier', $item->menu_id) }}"></span>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            @else
                                                                <div
                                                                    class="d-flex justify-content-end w-100 align-items-center">
                                                                    @php $menuCount = 1; @endphp
                                                                    @if (in_array($item->menu_id, $menuIds))
                                                                        @php
                                                                            if ($menuCount == 2) {
                                                                                $cartClass = 'decrease-repeat-last';
                                                                            } else {
                                                                                $cartClass = 'pro-with-modifier-minus';
                                                                            }
                                                                            
                                                                            $itemQuantity = 0;
                                                                            
                                                                            foreach ($quantities as $quantity) {
                                                                                if ($quantity['menu_id'] == $item->menu_id) {
                                                                                    $itemQuantity += $quantity['quantity'];
                                                                                }
                                                                            }
                                                                        @endphp
                                                                        <div
                                                                            class="product-quantity modifier-quantity-{{ $item->menu_id }}">
                                                                            <span
                                                                                class="product-quantity-minus {{ $cartClass }}"
                                                                                data-menu-id="{{ $item->menu_id }}"
                                                                                data-cart-item="{{ getCartKey('with-modifier', $item->menu_id) }}"></span>
                                                                            <input type="number"
                                                                                value="{{ $itemQuantity }}"
                                                                                calss="quantity-{{ $item->menu_id }}"
                                                                                readonly />
                                                                            <span
                                                                                class="product-quantity-plus pro-with-modifier-plus"
                                                                                data-menu-id="{{ $item->menu_id }}"
                                                                                data-cart-item="{{ getCartKey('with-modifier', $item->menu_id) }}"></span>
                                                                        </div>
                                                                    @else
                                                                        <button type="button"
                                                                            class="btn btn-dark with-modifier add-order-{{ $item->menu_id }}"
                                                                            data-menu-id="{{ $item->menu_id }}">Add To
                                                                            Order</button>
                                                                        <div
                                                                            class="product-quantity d-none modifier-quantity-{{ $item->menu_id }}">
                                                                            <span
                                                                                class="product-quantity-minus pro-with-modifier-minus"
                                                                                data-menu-id="{{ $item->menu_id }}"
                                                                                data-cart-item="{{ getCartKey('with-modifier', $item->menu_id) }}"></span>
                                                                            <input type="number" value="1"
                                                                                id="quantity-{{ $item->menu_id }}"
                                                                                readonly />
                                                                            <span
                                                                                class="product-quantity-plus pro-with-modifier-plus"
                                                                                data-menu-id="{{ $item->menu_id }}"
                                                                                data-cart-item="{{ getCartKey('with-modifier', $item->menu_id) }}"></span>
                                                                        </div>
                                                                    @endif
                                                                    <div
                                                                        class="repeat-last-add-modal-{{ $item->menu_id }}">
                                                                    </div>
                                                                </div>
                                                                <div class="modifiers-{{ $item->menu_id }}"></div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    @if (!isMobile())
                        @include('customer-layouts.right-sidebar')
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script src="{{ asset('assets/customer/js/jquery.lazy.min.js') }}"></script>
    <!-- Rating bar js -->
    <script src="{{ asset('assets/customer/js/rateYo/2.3.2/jquery.rateyo.min.js') }}"></script>
    <script src="{{ asset('assets/customer/js/custom-js/promotion/eligible.js') }}"></script>
@endsection
