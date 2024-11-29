<style>
    .btn-area {
        background-color: rgb(241, 241, 241);
        border: none;
        padding: 20px;
        line-height: 20px;
        border-radius: 10px;

    }

    .btn-big {
        background-color: rgb(241, 241, 241);
        border: none;
        padding: 20px 45px;
        line-height: 20px;
        border-radius: 10px;
    }

    .btn-area a {
        text-decoration: none;
    }

    .btn-area span {
        color: #000;
        font-weight: 500;


    }

    .line-button-area,
    .line-button {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .tipbutton{
        border-radius: 4px 3 0px 1px;
        margin-right: 6px;
    }

    .custombutton
    {
        border-radius: 4px 3 0px 1px;
        margin-right: 6px;
        width: 105px;
    }

    .customtip
    {
        height: 37px;
    }

    .stafftip{
        width: 40px;
        height: 37px;
        padding: 0px;
    }

    .iconbutton {
        margin-top: 5px;
        border: 1px solid red;
        padding: 3px 12px;
        border-radius: 50px;
        color: red;
    }
</style>
<div class="col-xl-4 col-lg-12 col-md-12 wd-dr-dashboart-inner">
    <div class="Promotion-content">
        <div class="card order-content">
            <div class="card-body p-2">
                <form action="{{ route('customer.cart.submit.order') }}" method="post">
                    @csrf
                    <div class="card-inner-body">
                        <div class="d-flex align-items-center w-100 justify-content-between mb-4">
                            <h5 class="card-title m-0">My Order</h5>
                        </div>
                        <div class="text-center pb-2" style="font-weight: bold;">
                            <span> When Would You Like Your Order?</span>
                        </div>

                        <div class="d-flex align-items-center wd-dr-now">
                            {{-- <div class="input-group w-auto mr-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i class="fas fa-clock"></i></span>
                                </div>
                            </div> --}}
                            <div class="d-flex">
                                {{-- <button type="button" class="btn btn-later btn-innr selected set-now">Now</button>
                                <button type="button" class="btn btn-later btn-innr set-later" data-toggle="modal"
                                    data-target="#exampleModalCenter1">Later</button> --}}
                                <button type="button" class="btn btn-primary btn-later selected set-now">Now <br> <span style="font-size: 10px;">Get Your Order Made Now </span></button>
                                <button type="button" class="btn btn-primary btn-later set-later" data-toggle="modal"
                                    data-target="#exampleModalCenter1">Later <br> <span style="font-size: 10px;">Scedule For a Future Time </span></button>
                               
                            </div>
                        </div>
                         <!-- Modal -->
                                <div class="modal fade modal-inner-first selectTime" id="exampleModalCenter1"
                                    tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body timing-content">
                                                <h5 class="modal-title text-center" id="exampleModalCenterTitle">Select
                                                    Date
                                                    or time for future order</h5>
                                                <div class="input">
                                                    <input type="date" id="orderDate" name="date" class="mt-3">
                                                    <input type="time" id="orderTime" name="time" class="my-3"
                                                        step="2700">
                                                </div>
                                                <button type="button" class="btn btn-okey mb-3 btokey">Okey</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        <hr>
                        <input type="hidden" name="promotion_id" class="promotion_id_field">
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
                                    <span class="input-group-text" id="basic-addon1"><i
                                            class="fas fa-envelope"></i></span>
                                    <input type="text" class="form-control ml-3" placeholder="Order Note"
                                        name="instruction">
                                </div>
                            </div>
                        </div>
                        <div class="text-center" id="loginbutton">
                                <button type="button" class="btn btn-primary btn-lg" title="Login" data-toggle="modal" data-target="#yourModal">Login</button>
                        </div>
                    </div>
                    @auth
                        @php
                            $cartTotal = 0;
                            $modifierTotal = 0;
                        @endphp
                        <div class="scroll-inner-blog mt-4" id="cart_items">
                            @php
                                $cart = getCart($restaurantId = 1);
                                $menuItem= [];
                            @endphp
                            @if (!empty($cart->cartMenuItems))
                                @forelse ($cart->cartMenuItems as $key => $item)
                                    @php
                                        $cartTotal += $item['menu_price'] * $item['menu_qty'] + $item['modifier_total'] * $item['menu_qty'];

                                        $menuItem[] = ['menu_id' => $item['menu_id'], 'menu_name' => $item['menu_name'],'menu_price' => $item['menu_price'],'menu_total' => $item['menu_total'], 'menu_qty' => $item['menu_qty'], 'modifier_total' => $item['modifier_total']];

                                    @endphp
                                    <div
                                        class="d-flex rounded wp-border-size-blog @if ($key != 0) mt-2 @endif">
                                        <div class="wb-inner-system">
                                            <img src="{{ $item['item_img'] }}" class="img-fluid">
                                        </div>
                                        <div class="wb-inner-system-first">
                                            <div class="d-flex wd-menu-photo justify-content-between w-100">
                                                <div class="no-photos-blog">
                                                    <p class="m-0"> {{ $item['menu_name'] }} </p>
                                                    <!-- <p>( ${{ $item['menu_price'] }} × {{ $item['menu_qty'] }} )</p> -->
                                                    @if($item->is_loyalty==1)
                                                        <div class="iconbutton d-flex  align-items-center">
                                                            <i class="fa fa-gift pr-3" aria-hidden="true"></i>
                                                            <p class="mb-0">{{ $item->loyalty_point }} pts</p>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="d-flex">
                                                    <p class="m-0">
                                                        ${{ number_format($item['menu_price'] * $item['menu_qty'] + $item['modifier_total'] * $item['menu_qty'], 2) }}
                                                    </p>
                                                    <a href="#" class="cart-remove"
                                                        data-cart-menu-item-id="{{ $item['cart_menu_item_id'] }}"><span
                                                            aria-hidden="true" class="ml-2">&#9940</span>
                                                    </a>
                                                </div>
                                            </div>
                                            @if($item->is_loyalty==0)
                                            <div
                                                class="product-quantity product-quantity-{{ $item->menu_id }} d-inline-flex mt-2">
                                                <span class="product-quantity-minus"
                                                    data-cart-menu-item-id="{{ $item->cart_menu_item_id }}"></span>
                                                <input type="hidden" value="{{ $cart->cart_id }}" name="cartid"
                                                    id="cartid" class="" />
                                                <input type="number"
                                                    value="{{ $cart->cartMenuItems->where('cart_menu_item_id', $item->cart_menu_item_id)->first()->menu_qty }}"
                                                    class="quantity-{{ $item->cart_menu_item_id }}" readonly />
                                                <span class="product-quantity-plus" data-menu-id="{{$item->menu_id}}"
                                                    data-cart-menu-item-id="{{ $item->cart_menu_item_id }}"></span>
                                            </div>
                                            @endif
                                            <div class="my-2">
                                                @foreach ($item->CartMenuGroups as $modifier_group)
                                                    <div>
                                                        <span
                                                            class="font-weight-bold text-primary">{{ $modifier_group->modifier_group_name }}
                                                            : </span>

                                                        @foreach ($modifier_group->CartMenuGroupItems as $modifier_item)
                                                            <span
                                                                class="font-weight-bold">{{ $modifier_item->modifier_group_item_name . "( $" . $modifier_item->modifier_group_item_price . ')' }}</span>
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
                        <hr>
                        <input type="hidden" name="menuItem"
                            value="{{ isset($menuItem) ? base64_encode(json_encode($menuItem)) : '' }}">
                        <div class="promotion-iner-blog mt-3 Promotion-btn-click  bgcolorchange">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <img width="35px" src="{{ asset('assets/images/divition-icon.png') }}"
                                        alt="" />
                                    <div class="mx-2">
                                        <h5 class="mb-0 promotion_text-cololr">Promotion</h5>
                                        <p>Lorem ipsum dolor sit amet consectetur adipisicing
                                            elit.
                                        </p>
                                    </div>
                                </div>
                                <div>
                                    <i class="fas fa-chevron-right"></i>
                                </div>
                            </div>
                        </div>
                        <div class="promotion-iner-blog-close bgcolorchange">
                            <div class="d-flex align-items-center">
                                <div class="mx-2">
                                    <a href="javascript:void(0)" onclick="remove_coupon_code()"
                                        class="remove_coupon_code_link coupenremove"> <i
                                            class="bg-danger b-redic-50 text-white" data-feather="x-circle"></i></a>
                                    <div id="coupon_code_msgs" style="color:red"></div>
                                </div>
                                <div id="prmotioncode">
                                    @php
                                        $promotion_code ="";
                                        $prmotion_id = $cart['promotion_id'] ?? "0";
                                        if($prmotion_id)
                                        $promotion_code = \App\Models\Promotion::where('restaurant_id', 1)
                                                ->where('promotion_id',$prmotion_id)
                                                ->first()->promotion_code;
                                    @endphp
                                    <input type="hidden" name="promotion_id" id="promotion_id" value={{$prmotion_id}}>

                                    <h6 class="mb-0 text-dark couponcode"></h6>
                                    @if($prmotion_id !== "0") <!-- Check if there is a valid promotion_id -->
                                        <!-- JavaScript Code to handle the background color change and element visibility -->
                                        <script>
                                            // This will run during the page load
                                            window.onload = function() {
                                                // Only execute if there is a valid promotion code
                                                if ("{{ $prmotion_id }}" !== "0") {
                                                    $('.couponcode').html("{{$promotion_code}}");
                                                    $('#coupon_code').val("{{$promotion_code}}");
                                                    $('.coupenremove').show();
                                                    // Change background color
                                                    $(".bgcolorchange").css("background-color", "#54ba72");

                                                    // Hide the .apply-content and show the .Promotion-content
                                                    $(".apply-content").css("display", "none");
                                                    $(".Promotion-content").css("display", "block");

                                                    // Optionally, if you need to use the $prmotion_id in JavaScript:
                                                    var promotionId = "{{ $prmotion_id }}";  // Pass the PHP variable to JavaScript
                                                    console.log('Promotion ID:', promotionId);  // You can use this value in further JS logic if needed
                                                }
                                            };
                                        </script>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="text-center" id="tips">
                            <h4 class="mb-2 promotion_text-cololr mb-4">Add Tip For</h4>
                            @php
                                $totalwithsalestax = ($cart['sub_total'] ?? 0.00) + ($cart['tax_charge'] ?? 0.00);
                            @endphp
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-primary text-white stafftip" >15%</span>
                                </div>
                                <button type="button" style="padding: 6px" value="{{ round($totalwithsalestax * 15) / 100 ,2}}"
                                    class="btn btn-light tip tipbutton text-left">${{round($totalwithsalestax * 15) / 100 ,2}}</button>
                                {{-- <button type="button" style="boarder-radius:20px" class="btn btn-light tipbutton">Light</button> --}}
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-primary text-white stafftip">18%</span>
                                </div>
                                <button type="button" style="padding: 6px" value="{{ round($totalwithsalestax * 18) / 100 ,2}}" class="btn btn-light tip tipbutton">${{round($totalwithsalestax * 18) / 100 ,2}}</button>
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-primary text-white stafftip">20%</span>
                                </div>
                                <button type="button" style="padding: 6px" value="{{ round($totalwithsalestax * 20) / 100 ,2}}" class="btn btn-light tip tipbutton">${{ round ($totalwithsalestax * 20) / 100 ,2}}</button>
                            </div>
                            <br>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-primary text-white customtip">CUSTOM</span>
                                </div>
                                <button type="button" style="boarder-radius:20px" class="btn btn-light custom custombutton" id="cutomtip">0.00</button>
                                <button type="button" style="width: 140px" class="btn btn-light">No Tip</button>
                            </div>
                        </div>
                        <hr>
                        <div class="card-inner-body">
                            <h5 class="md-payment-blog">Payment Methods</h5>

                            <div class="form-check w-100 align-items-center d-flex custom-radio">
                                <input class="form-check-input" type="radio" name="paymentType" value="Credit Card"
                                    id="card_payment" checked>
                                <label class="form-check-label payment-label" for="card_payment">
                                    Card
                                </label>
                            </div>
                            <div class="form-check w-100 align-items-center d-flex">
                                <input class="form-check-input" type="radio" name="paymentType" value="Cash"
                                    id="cash_payment">
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
                                                        <div
                                                            class="d-flex align-items-center justify-content-between w-100">
                                                            <i class="fa fa-check" aria-hidden="true"></i>
                                                            @if ($card->card_type == Config::get('constants.CARD_TYPE.AMERICAN_EXPRESS'))
                                                                <img src="{{ asset('assets/customer/images/chat/express.png') }}"
                                                                    class="img-fluid visa-blog">
                                                            @elseif ($card->card_type == Config::get('constants.CARD_TYPE.VISA'))
                                                                <img src="{{ asset('assets/customer/images/chat/visa.png') }}"
                                                                    class="img-fluid visa-blog">
                                                            @elseif ($card->card_type == Config::get('constants.CARD_TYPE.DISCOVER'))
                                                                <img src="{{ asset('assets/customer/images/chat/discover.png') }}"
                                                                    class="img-fluid visa-blog">
                                                            @elseif ($card->card_type == Config::get('constants.CARD_TYPE.MASTER_CARD'))
                                                                <img src="{{ asset('assets/customer/images/chat/master_card.png') }}"
                                                                    class="img-fluid visa-blog">
                                                            @endif
                                                        </div>
                                                        <div class="d-flex align-items-center w-100 mt-3 mb-4">
                                                            <p class="mb-0 mt-1 mr-2">**** **** **** </p>
                                                            <p class="mb-0">
                                                                {{ Str::substr($card->card_number, 15, 19) }}</p>
                                                        </div>
                                                        <div
                                                            class="d-flex align-items-center w-100 justify-content-between">
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

                            {{-- <div class="text-center" id="tips">
                                <h4 class="mb-2 promotion_text-cololr">Add Tip For</h4>
                                @php
                                    $totalwithsalestax = ($cart['sub_total'] ?? 0.00) + ($cart['tax_charge'] ?? 0.00);
                                @endphp

                                <div class="line-button-area mb-2">
                                    <button type="button" value="{{ round($totalwithsalestax * 15) / 100 ,2}}"
                                        class="btn-area tip"><span>15%</span><br><span>${{round($totalwithsalestax * 15) / 100 ,2}}</button>
                                    <button type="button" value="{{ round($totalwithsalestax * 18) / 100 ,2}}"
                                        class="btn-area tip"><span>18%
                                        </span><br><span>${{ round($totalwithsalestax * 18) / 100 ,2}}</span></button>
                                    <button type="button" value="{{ round($totalwithsalestax * 20) / 100 ,2}}"
                                        class="btn-area tip"><span>20%
                                        </span><br><span>${{ round ($totalwithsalestax * 20) / 100 ,2}}</button>
                                </div>
                                <div class="line-button">
                                    <button type="button" class="btn-big custom"> <span> Custom</span><br><span>$<span
                                                id="cutomtip">0.00</span></span></button>
                                    <button type="button" value="0.00" class="btn-big notip" disabled><span> No Tip
                                        </span><br><span></span></button>
                                </div>
                            </div> --}}

                            <div class="modal fade" id="custommodel" role="dialog" tabindex="-1">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h2 class="modal-title">Add A Custom Tip</h2><button aria-label="Close"
                                                class="close" data-dismiss="modal" type="button"><span
                                                    aria-hidden="true">&times;</span></button>
                                        </div>
                                        <div class="modal-body text-center">
                                            <div class="accordion row" id="accordion">
                                                <div class="form-group col-md-12">
                                                    <input type="text" name="customtip" placeholder="Add Tip"
                                                        id="customtips" value="" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer justify-content-center">
                                            <button class="btn btn-submit btn-primary" data-dismiss="modal" id="custom_tip_ajax"
                                                type="button">Add</button>
                                            {{-- <button class="btn btn-primary" type="button">Save changes</button> --}}
                                        </div>
                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div><!-- /.modal -->

                            @php
                                $finalTotal = $cartTotal;
                            @endphp
                            <hr>
                            <div id="checkout">
                                <div
                                    class="d-flex align-items-center justify-content-between w-100 wd-wrapper-total-first">
                                    <span>Subtotal</span>
                                    <!-- <span>${{ number_format($cartTotal, '2') }}</span> -->
                                    <?php
                                        $cartSubTotal = $cart['sub_total'] ?? "0";
                                    ?>
                                    <span>${{ number_format($cartSubTotal, '2') }}</span>
                                    <input type="hidden" name="cart_charge" id="cart_charge"
                                        value="{{ number_format($cartTotal, '2') }}">
                                </div>
                                <div
                                    class="d-flex align-items-center justify-content-between w-100 wd-wrapper-total-first">
                                    <span>Discount</span>
                                    <?php
                                    $cartdiscountcharge = $cart['discount_charge'] ?? "0";
                                    ?>
                                    <span id="discount">${{ number_format($cartdiscountcharge, '2') }}</span>
                                    <input type="hidden" name="discount_charge"
                                        value="{{ number_format($cartdiscountcharge, '2') }}">
                                </div>
                                <div
                                    class="d-flex align-items-center justify-content-between w-100 wd-wrapper-total-first">
                                    <span>Sales Tax</span>
                                    <?php
                                    $cartsalestaxcharge = $cart['tax_charge'] ?? "0";
                                    ?>
                                    <span id="sales_tax">${{ number_format($cartsalestaxcharge , '2') }}</span>
                                    <input type="hidden" name="sales_tax" id="sales_tax"
                                        value="{{ number_format($cartsalestaxcharge,'2')  }}">
                                </div>
                                <div
                                    class="d-flex align-items-center justify-content-between w-100 wd-wrapper-total-first">
                                    <span>Tips</span>
                                    <span>$<span id="tipsres">0.00</span></span>
                                    <input type="hidden" name="newtips" id="newtips" value="">
                                </div>
                                <div
                                    class="align-items-center justify-content-between w-100 wd-wrapper-total d-none wd-wrapper-total-first">
                                    <span>Delivery Charge</span>
                                    <span>$0.00</span>
                                </div>
                                <div class="d-flex align-items-center justify-content-between w-100 wd-wrapper-total">
                                    <span>Total</span>
                                    <?php
                                        $carttotaldue = $cart['total_due'] ?? "0";
                                    ?>
                                    <span id="total_price">${{ number_format($carttotaldue, '2')}}</span>
                                    <input type="hidden" name="grand_total" id="grand_total"
                                        value="{{$carttotaldue}}">
                                    <input type="hidden" name="grand_total_ajax" id="grand_total_ajax"
                                        value="{{$carttotaldue}}">
                                </div>
                            </div>
                            <input type="hidden" name="order_status" id="order_status" value="0">
                            <input type="hidden" name="card_id" id="card_id">
                            <input type="hidden" name="orderDate" id="setDate">
                            <input type="hidden" name="orderTime" id="setTime">


                            <div class="btn-inner-blog mt-2">
                                <button class="btn btn-submit-inner sendToken" type="submit">Checkout</button>
                            </div>
                        </div>

                    @endauth
                </form>
            </div>
        </div>
    </div>
    <div class="apply-content">
        <div class="card ">
            <div class="card-body p-0.60">
                <!-- header Apply Coupons -->
                <div class="d-flex align-items-center promotion_text-cololr">
                    <i class="fas fa-arrow-left btn-back-Promotion cursor-pointer"></i>
                    <h3 class="t-center w-100">
                        Apply Coupons
                    </h3>
                </div>
                <form action="">
                    @csrf
                    <div class="card p-3 Apply-schar mt-3">
                        <div class="input-group">
                            <div class="input-group-prepend mx-2">
                                <img width="30px" src="./assets/images/divition-icon.png" alt="" />
                            </div>
                            <input type="text" placeholder="Coupon Code"
                                class="aa-coupon-code apply_coupon_code_box" name="coupon_code" id="coupon_code">
                            <div class="input-group-append">
                                <input type="button" value="Apply" class="aa-browsw-btn"
                                    onclick="applyCoupenCode()"> 
                            </div>
                            <div id="coupen_code_msg" style="color:red"></div>
                        </div>
                    </div>
                </form>
                <h3 class="my-4">Best Offers</h3>
                    <div style="max-height: 700px;overflow-y: auto;">
                        @php
                            $promotions = \App\Models\Promotion::where('restaurant_id', 1)
                                ->with('promotion_item')
                                ->get();
                        @endphp
                        @foreach ($promotions as $promotion)
                            <div class="card mt-2 a-card-all-css">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <input type="hidden" id="id" value="{{ $promotion->promotion_id }}"
                                                name="id">
                                            <h5 class="text-uppercase mb-0 promotion_text-cololr">
                                                {{ $promotion->promotion_code }}
                                            </h5>
                                            <p class="text-capitalize mb-0">{{ $promotion->promotion_name }}</p>
                                        </div>
                                        <div>
                                            <!-- <h5 class="text-capitalize cursor-pointer" onclick="applyPromotion({{ $promotion->promotion_id }})">apply</h5> -->
                                            <input type="button" value="Apply" class="aa-browse-btn"
                                                onclick="applyPromotion()">
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer bg-white border-top a-card-footer">
                                    <p class="text-capitalize text-capitalize">Lorem, ipsum dolor
                                        sit
                                        amet consectetur adipisicing elit.</p>
                                    <div id="coupen_code_msg"></div>

                                </div>
                            </div>
                        @endforeach
                    </div>
            </div>
        </div>
    </div>
</div>






