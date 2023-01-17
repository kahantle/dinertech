<div class="col-xl-4 col-lg-12 col-md-12 wd-dr-dashboart-inner">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('customer.cart.submit.order') }}" method="post">
                @csrf
                <div class="card-inner-body">
                    <div class="d-flex align-items-center w-100 justify-content-between mb-4">
                        <h5 class="card-title m-0">My Order</h5>
                    </div>

                    <div class="d-flex align-items-center wd-dr-now">
                        <div class="input-group w-auto mr-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i class="fas fa-clock"></i></span>
                            </div>
                        </div>
                        <div class="d-flex">
                            <button type="button" class="btn btn-later btn-innr selected set-now">Now</button>
                            <button type="button" class="btn btn-later btn-innr set-later" data-toggle="modal"
                                data-target="#exampleModalCenter1">Later</button>
                            <!-- Modal -->
                            <div class="modal fade modal-inner-first selectTime" id="exampleModalCenter1" tabindex="-1"
                                role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <h5 class="modal-title text-center" id="exampleModalCenterTitle">Select Date
                                                or time for future order</h5>
                                            <input type="date" id="orderDate" name="date" class="mt-3">
                                            <input type="time" id="orderTime" name="time" class="my-3"
                                                step="2700">
                                            <button type="button" class="btn btn-okey mb-3 btokey">Okey</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <p id="output" class="set-order-msg">Current Timing Is set in Your Order</p>
                    <div class="align-items-center wd-dr-now my-4 d-none">
                        <div class="input-group w-auto">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i class="fa fa-map-marker"
                                        aria-hidden="true"></i></span>
                                <input type="text" class="form-control ml-3" placeholder="Address">
                            </div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center wd-dr-now wd-innerborder pb-4">
                        <div class="input-group w-auto">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i class="fas fa-envelope"></i></span>
                                <input type="text" class="form-control ml-3" placeholder="Order Note"
                                    name="instruction">
                            </div>
                        </div>
                    </div>
                </div>
                @auth
                @php
                    $cartTotal = 0;
                    $modifierTotal = 0;
                @endphp
                <div class="scroll-inner-blog mt-4">
                    @php
                        $cart = getCart($restaurantId = 1)
                    @endphp
                    @if (!empty($cart->cartMenuItems))
                        @forelse ($cart->cartMenuItems as $key => $item)
                            @php
                                $cartTotal += $item['menu_price']*$item['menu_qty'];
                                $menuItem[] = ['menu_id' => $item['menu_id'], 'menu_name' => $item['menu_name'], 'menu_total' => 0, 'menu_qty' => $item['menu_qty'], 'modifier_total' => 0];
                            @endphp
                            <div class="d-flex rounded wp-border-size-blog @if ($key != 0) mt-2 @endif">
                                <div class="wb-inner-system">
                                    <img src="{{ $item['item_img'] }}" class="img-fluid">
                                </div>
                                <div class="wb-inner-system-first">
                                    <div class="d-flex wd-menu-photo justify-content-between w-100">
                                        <div class="no-photos-blog">
                                            <p class="m-0"> {{ $item['menu_name'] }}  ( ${{ $item['menu_price']}} × {{$item['menu_qty'] }} ) </p>
                                        </div>
                                        <div class="d-flex">
                                            <p class="m-0">${{ number_format($item['menu_price']*$item['menu_qty'], 2) }}</p>
                                            <a href="#" class="cart-remove"
                                                data-cart-menu-item-id="{{ $item['cart_menu_item_id'] }}"><span aria-hidden="true"
                                                class="ml-2">&#9940</span>
                                            </a>
                                        </div>
                                    </div>
                                        <div class="product-quantity product-quantity-{{ $item->menu_id }} d-inline-flex mt-2">
                                        <span class="product-quantity-minus" data-cart-menu-item-id="{{ $item->cart_menu_item_id }}"></span>
                                        <input type="number" value="{{ $cart->cartMenuItems->where('cart_menu_item_id',$item->cart_menu_item_id)->first()->menu_qty }}" class="quantity-{{ $item->cart_menu_item_id }}" readonly />
                                        <span class="product-quantity-plus" data-cart-menu-item-id="{{ $item->cart_menu_item_id }}"></span>
                                    </div>
                                    <div class="my-2">
                                        @foreach ($item->CartMenuGroups as $modifier_group)
                                            <div>
                                                <span class="font-weight-bold text-primary">{{ $modifier_group->modifier_group_name }} : </span>

                                                @foreach ($modifier_group->CartMenuGroupItems as $modifier_item)
                                                    <span class="font-weight-bold">{{ $modifier_item->modifier_group_item_name."( $".$modifier_item->modifier_group_item_price.")" }}</span>
                                                    @php
                                                        $modifierTotal += $modifier_item->modifier_group_item_price;
                                                    @endphp
                                                @endforeach

                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="iconic-blog text-center">
                                <i class="fa fa-cart-plus" aria-hidden="true"></i>
                                <p>Cart empty</p>
                            </div>
                        @endforelse
                    @endif
                    </div>
                    <input type="hidden" name="menuItem" value="{{ base64_encode(json_encode($menuItem)) }}">
                    <div class="card-inner-body mt-5">
                        <h5 class="md-payment-blog">Payment Methods</h5>

                        <div class="form-check w-100 align-items-center d-flex custom-radio">
                            <input class="form-check-input" type="radio" name="paymentType" value="card" id="card_payment"
                                checked>
                            <label class="form-check-label payment-label" for="card_payment">
                                Card
                            </label>
                        </div>
                        <div class="form-check w-100 align-items-center d-flex">
                            <input class="form-check-input" type="radio" name="paymentType" value="cash" id="cash_payment">
                            <label class="form-check-label payment-label" for="cash_payment">
                                Cash
                            </label>
                        </div>

                        <div class="cards">
                            <div id="testinomial" class="pt-1 pb-3">
                                @if ($cards->count() != 0)
                                    <div class="owl-carousel owl_1">
                                        @foreach ($cards as $card)
                                            <div class="item" data-card-id={{ $card->card_id }}>
                                                <div class="wd-dr-background">
                                                    <div class="d-flex align-items-center justify-content-between w-100">
                                                        <i class="fa fa-check" aria-hidden="true"></i>
                                                        @if ($card->card_type == Config::get('constants.CARD_TYPE.AMERICAN_EXPRESS'))
                                                            <img src="{{ asset('assets/customer/images/chat/express.png') }}"
                                                                class="img-fluid visa-blog">
                                                        @elseif ($card->card_type ==
                                                            Config::get('constants.CARD_TYPE.VISA'))
                                                            <img src="{{ asset('assets/customer/images/chat/visa.png') }}"
                                                                class="img-fluid visa-blog">
                                                        @elseif ($card->card_type ==
                                                            Config::get('constants.CARD_TYPE.DISCOVER'))
                                                            <img src="{{ asset('assets/customer/images/chat/discover.png') }}"
                                                                class="img-fluid visa-blog">
                                                        @elseif ($card->card_type ==
                                                            Config::get('constants.CARD_TYPE.MASTER_CARD'))
                                                            <img src="{{ asset('assets/customer/images/chat/master_card.png') }}"
                                                                class="img-fluid visa-blog">
                                                        @endif
                                                    </div>
                                                    <div class="d-flex align-items-center w-100 mt-3 mb-4">
                                                        <p class="mb-0 mt-1 mr-2">**** **** **** </p>
                                                        <p class="mb-0">
                                                            {{ Str::substr($card->card_number, 15, 19) }}</p>
                                                    </div>
                                                    <div class="d-flex align-items-center w-100 justify-content-between">
                                                        <div class="dr-johan-blog">
                                                            <span>{{ $card->card_holder_name }}</span>
                                                        </div>
                                                        <div class="d-flex wd-exp-blog">
                                                            <div class="mr-5">
                                                                <p class="m-0">EXPIRES</p>
                                                                <span>{{ $card->card_expire_date }}</span>
                                                            </div>
                                                            <div class="">
                                                                <p class="m-0">CVV</p>
                                                                <span>{{ $card->card_cvv }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-center">
                                        <h4>Cards not found</h4>
                                    </div>
                                @endif
                            </div>
                        </div>
                        @php
                            $finalTotal = $cartTotal;
                        @endphp
                        <div id="checkout">
                            <div class="d-flex align-items-center justify-content-between w-100 wd-wrapper-total-first">
                                <span>Subtotal</span>
                                <span>${{ number_format($cartTotal, '2') }}</span>
                                <input type="hidden" name="cart_charge" value="{{ number_format($cartTotal, '2') }}">
                            </div>
                            <div class="d-flex align-items-center justify-content-between w-100 wd-wrapper-total-first">
                                <span>Discount</span>
                                <span>$0.00</span>
                                <input type="hidden" name="discount_charge" value="{{ number_format(0, '2') }}">
                            </div>
                            <div class="d-flex align-items-center justify-content-between w-100 wd-wrapper-total-first">
                                <span>Sales Tax</span>
                                <span>$0.00</span>
                                <input type="hidden" name="sales_tax" value="{{ number_format(0, '2') }}">
                            </div>
                            <div
                                class="align-items-center justify-content-between w-100 wd-wrapper-total d-none wd-wrapper-total-first">
                                <span>Delivery Charge</span>
                                <span>$0.00</span>
                            </div>
                            <div class="d-flex align-items-center justify-content-between w-100 wd-wrapper-total">
                                <span>Total</span>
                                <span>${{ number_format($finalTotal + $modifierTotal, '2') }}</span>
                                <input type="hidden" name="grand_total" value="{{ $finalTotal + $modifierTotal }}">
                            </div>
                        </div>
                        <input type="hidden" name="order_status" id="order_status" value="0">
                        <input type="hidden" name="card_id" id="card_id">
                        <input type="hidden" name="orderDate" id="setDate">
                        <input type="hidden" name="orderTime" id="setTime">

                        <div class="btn-inner-blog mt-2">
                            <button class="btn btn-submit-inner" type="submit">Checkout</button>
                        </div>
                    </div>

                @endauth
            </form>
        </div>
    </div>
</div>
