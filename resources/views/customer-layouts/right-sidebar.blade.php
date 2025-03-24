<style>
    /* redeem buttom style */

    /* Base Styling */
    .iconbutton {
        display: flex;
        align-items: center;
        justify-content: center; /* Center content */
        color: red;
        text-decoration: none;
        font-size: 16px;
        padding: 10px;
        border-radius: 6px;
        transition: all 0.3s ease-in-out;
        width: 100%;
    }

    /* Icon Styling */
    .iconbutton i {
        margin-right: 8px; /* Space between icon and text */
        font-size: 18px;
    }

    /* Text Styling */
    .iconbutton p {
        margin: 0;
        font-weight: bold;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .iconbutton {
            font-size: 10px;
            padding: 8px;
        }

        .iconbutton i {
            font-size: 12px;
        }
    }

    @media (max-width: 480px) {
        .iconbutton {
            font-size: 12px;
            flex-direction: column; /* Stack icon & text */
            text-align: center;
            padding: 6px;
        }

        .iconbutton i {
            font-size: 10px;
            margin-bottom: 4px;
        }
    }

    /* End redeem buttom style */
    .fulll-div {
        width: 100%;
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        gap: 8px; /* Adds spacing */
    }
    .custom-tip-btn {
            border: 2px solid #007bff; /* Blue border to make it pop */
            background-color: transparent; /* Transparent background */
            color: #007bff; /* Text matches border */
            border-radius: 20px; /* Rounded corners */
            padding: 5px 10px; /* Proper spacing */
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease-in-out;
        }

        .custom-tip-btn:hover {
            background-color: #007bff; /* Blue background on hover */
            color: white; /* White text on hover */
        }

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

    /* .tipbutton{
        border-radius: 4px 3 0px 1px;
        margin-right: 6px;
    } */

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

    /* .stafftip{
        width: 40px;
        height: 37px;
        padding: 0px;
    } */

    .iconbutton {
        margin-top: 5px;
        border: 1px solid red;
        padding: 3px 12px;
        border-radius: 50px;
        color: red;
    }
    .d-flex.first {
        display: flex;
        justify-content: space-between; /* Default: buttons spaced apart */
        flex-wrap: wrap; /* Allow wrapping for responsiveness */
    }
    .d-flex.first .d-flex .btn {
        width: 46%; /* Make each button take full width on small screens */
        margin-bottom: 10px; /* Add space between the buttons */
        align-items: center; /* Center the buttons */
    }
   /* @media screen and (min-width: 1200px) {
        .d-flex {
            margin-left: -40px;
            width: 400px; 
            flex-direction: column; 
            align-items: center;
        }

        .btn {
            width: 100%; 
            text-align: center;
        }
    }*/
    @media (max-width: 768px) {
       .d-flex.first{
            flex-direction: column; /* Stack buttons vertically on small screens */
            align-items: center; /* Center the buttons */
        }

        .d-flex.first .d-flex .btn {
            width: 100%; /* Make each button take full width on small screens */
            margin-bottom: 10px; /* Add space between the buttons */
        }
    }
   
/* Responsive Design */
@media (max-width: 768px) {
    .owl-next, .owl-prev {
        pointer-events: none; /* Disables clicking */
        opacity: 0; /* Hides the button */
        visibility: hidden; /* Ensures it's fully removed */
    }
    .fulll-div {
        flex-direction: column;
        align-items: center;
    }

    .tip-group {
        width: 100%;
        display: flex;
        justify-content: space-between;
    }

    /* .stafftip {
        width: 45px;
        height: 35px;
        font-size: 12px;
    } */

    /* .tipbutton {
        flex-grow: 1;
        text-align: center;
        padding: 10px;
        font-size: 14px;
    } */
}

/* Extra Small Screens (Mobile) */
 @media (max-width: 480px) {
    .owl-next, .owl-prev {
        pointer-events: none; /* Disables clicking */
        opacity: 0; /* Hides the button */
        visibility: hidden; /* Ensures it's fully removed */
    }
    .fulll-div {
        flex-direction: wrap;
        align-items: center;
    }

    .tip-group {
        flex-direction: column;
        align-items: center;
        /* width: 100%; */
        /* gap: 6px; */
    }

    /* .stafftip {
        width: 40px;
        height: 30px;
        font-size: 10px;
    } */

    /* .tipbutton {
        text-align: center;
        padding: 12px;
        font-size: 14px;
        border-radius: 6px;
    } */
} 
    /* .stafftip {
        background-color: #007bff;  
        color: white;  
        font-weight: bold;
        padding: 8px 3px;
    } */

/* .tipbutton {
    border: 2px solid #007bff;  
    background-color: transparent;  
    color: #007bff; 
    font-weight: bold;
    padding: 8px 10px;
    border-radius: 8px;
    transition: all 0.3s ease-in-out;
    cursor: pointer;
} */

/* .tipbutton:hover {
    background-color: #007bff;
    color: white;
} */

.input-group {
    display: flex;
    gap: 10px; /* Adds space between elements */
}

.customtip {
    padding: 10px 16px;
    font-weight: bold;
    border-radius: 8px;
}

.custom-tip-btn {
    padding: 5px 10px;
    border: 2px solid #007bff; /* Blue border */
    background-color: white; /* White background */
    color: #007bff; /* Blue text */
    font-weight: bold;
    border-radius: 8px;
    transition: all 0.3s ease-in-out;
    cursor: pointer;
}

.custom-tip-btn:hover {
    background-color: #007bff;
    color: white;
}

.no-tip-btn {
    border-color: #dc3545; /* Red border for 'No Tip' */
    color: #dc3545;
}

.no-tip-btn:hover {
    background-color: #dc3545;
    color: white;
}

.set-order-msg {
    display: block; /* Ensures it takes full width */
    text-align: center !important;
    font-family: 'Poppins', sans-serif; /* Keeps consistency */
}
.order-note {
    color: white !important;
    background-color: #5657DB;
    width: 100%;
    border-radius: 100px;
    width: 100%;
    height: 40px;
}
.order-note .notes input {
    color: white !important;
    caret-color: white; /* Ensures cursor remains white */
}

.order-note .notes input::placeholder {
    color: rgba(255, 255, 255, 0.8); /* Slight transparency for placeholder */
}

.order-note .notes input:focus,
.order-note .notes input:hover {
    color: white !important;
    background-color: transparent !important;
    outline: none;
    box-shadow: none;
    border: none;
}

.order-note .note-input {
    /* background-color: #5657DB; */
    border: none !important;
    color: white;
    font-size: 12px;
    
    /* margin-top: 14px !important;
    margin-bottom: 14px !important; */
}

.order-note .form-control {
    color: white !important;
    font-size: 12px;
    height: 40px;
    border: none;
    border-radius: 50px; 
    padding-left: 15px;
}

.order-note .form-control::placeholder {
    color: white !important;
    opacity: 0.8;
}


/* partial */


/* item in the cart */
.wp-border-size-blog {
    /* height: 67px !important; */
    border: none !important; /* Removes any existing border */
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.15); /* Uniform shadow on all sides */
    padding: 10px; /* Adds spacing inside */
    background: white; /* Ensures shadow is visible */
    border-radius: 12px !important; /* Optional: Soft rounded corners */
}
.wb-inner-system img{
    height: 100%;
    object-fit: cover;
    display: block;
}
.cart-item-bt-div{
    margin-bottom: -10px !important;
}
.cart-item-bt-div .price{
    color: #4E4E4E;
    font-family: 'Lato', sans-serif;
    font-weight: 600;
    font-size: 14px;
}
.m-p-btn{
    background-color: #636363;
    color: #fff;
    border-radius: 3px;
}
.product-quantity{
    border: none;
    display: flex;
    align-items: center; /* Vertically centers content */
    justify-content: center; /* Centers horizontally (optional) */
}
.product-quantity .quantity{
    color: #007AFF;
    text-align: center;
    display: block;
    margin-top: -1px;
}



/* Promotions button */
.promotions-btn{
    text-align: center;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 100px !important;
    background-color: #5657DB;
    color: white;
    padding: 3px 3px;
    height: 50px;
}
.promotions-btn .body {
    display: flex;
    justify-content: center; /* Centers horizontally */
    text-align: center; /* Ensures text inside behaves properly */
}

.promotions-btn .body h5{
    text-align: center;
    display: block;
    font-size: 16px;
    font-weight: 600;
    font-family: 'Poppins', sans-serif !important;
    color: white !important;
}

.promotions-btn img{
    background-color: none !important;
    color: white !important;
}
.promotions-btn .row-btn{
    display: flex;
    align-items: center;
    justify-content: center;
    width: 44px !important;
    height: 44px !important;
    border-radius: 50%;
    background-color: white !important;

}
.promotions-btn .row-btn i{
    color: #5657DB !important;
}

.payment-blog-title{
    font-family: 'Poppins', sans-serif !important;
    font-weight: 500;
    font-size: 16px;
}

/* cash/card */
.payment-option {
    background-color: #fff;
    width: 166px !important;
    height: 37px !important;
    position: relative;
    margin: 0 20px;
}

.payment-option input {
    opacity: 0.001;
    /* left: 10px; */
    /* display: none; */
    /* visibility: hidden;
    position: absolute;
    width: 0;
    height: 0; */
}

.payment-option label {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    width: 166px;
    padding: 10px 20px;
    border-radius: 50px;
    font-weight: bold;
    font-family: 'Poppins', sans-serif;
    background-color: #fff;
    color: #6c63ff;
    border: 2px solid #ddd;
    cursor: pointer;
    transition: all 0.3s ease-in-out;
}

.payment-option input:checked + label {
    background-color: #3f3dff;
    color: #fff;
    border: none;
}

.payment-option label::before {
    content: "";
    width: 18px;
    height: 18px;
    border-radius: 50%;
    border: 2px solid #6c63ff;
    display: inline-block;
    background-color: #fff;
    transition: all 0.3s ease-in-out;
}

.payment-option input:checked + label::before {
    background-color: #fff;
    border: 4px solid #fff;
    box-shadow: 0 0 0 2px #3f3dff;
}

.Promotion-content .order-content{
    border: none !important; /* Removes any existing border */
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.15); /* Uniform shadow on all sides */
    padding: 10px; /* Adds spacing inside */
    background: white; /* Ensures shadow is visible */
    border-radius: 20px !important; /* Optional: Soft rounded corners */
}

/* Tip style */
/* .tips.input-group {
    display: flex;
    flex-wrap: wrap !important;
    gap: 10px; 
}

.tips .input-group-prepend {
    display: flex;
    flex-direction: column; 
    align-items: center;
} */

.tip-item{
    width: 118px;
    /* padding: 10px 1px; */
    padding-top: 10px;
    border: 1.2px solid #4E4E4E;
    border-radius: 12px;
    margin-left: 2px;
}
.tip-item.selected{
    background-color: #0080FD;
}
.tip-item.selected .stafftip{
    color: #FFF;
}
.tip-item .tipbutton{
    width: 106px !important;
    border: 1.2px solid #4E4E4E;
    background-color: white;
    border-bottom-left-radius: 12px; /* Rounded bottom-left */
    border-bottom-right-radius: 12px; /* Rounded bottom-right */
    margin: 3px 3px;
}
.tip-item .stafftip{
    width: 113px;
    color: #4E4E4E;
    background-color: none;
}
.input-group-custom{
    margin-top: -10px;
}
.tip-item.custom{
    width: 236px;
}
.custom .tipbutton-custom{
    width: 228px; 
    border: 1.2px solid #4E4E4E;
    background-color: white;
    border-bottom-left-radius: 12px; /* Rounded bottom-left */
    border-bottom-right-radius: 12px; /* Rounded bottom-right */
    margin: 3px 3px;
}

.tip-item.no{
    padding: 10px 5px;
}

.tipbutton-no{
    color: #A7A9AC;
    width: 106px !important;
    height: 100%;
    /* border: 1.2px solid #4E4E4E; */
    background-color: transparent;
    padding: 20px;
}
.rounded-full{
    border-radius: 100px;
    width: 100%;
}

/* CARD pagination */
.pagination-container {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    width: 100%;
}

.pagination-btn {
    width: 27px;
    height: 27px;
    border: none;
    border-radius: 50%;
    background-color: #2f54eb;
    color: white;
    font-size: 20px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
}
.pagination-btn i{
    width: 6px;
    height: 9px;
}

.pagination {
    display: flex;
    align-items: center;
    gap: 10px;
}

.page {
    width: 30px;
    height: 6px;
    background-color: #ccc;
    border-radius: 3px;
}

.page.active {
    background-color: #2f54eb;
    width: 40px;
}

</style>
<div class="col-xl-4 col-lg-12 col-md-12 wd-dr-dashboart-inner">
    <div class="Promotion-content">
        <form action="{{ route('customer.cart.submit.order') }}" method="post">
            <div class="card order-content">
                <div class="card-body p-2">
                        @csrf
                        <div class="card-inner-body">
                            <div class="d-flex align-items-center w-100 justify-content-center mb-4">
                                <h5 class="card-title m-0">My Order</h5>
                            </div>
                            {{-- <div class="text-center pb-2" style="font-weight: bold;">
                                <span> When Would You Like Your Order?</span>
                            </div> --}}

                            <div class="d-flex first align-items-center wd-dr-now" >
                                {{-- <div class="input-group w-auto mr-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><i class="fas fa-clock"></i></span>
                                    </div>
                                </div> --}}
                                <div class="d-flex flex-wrap w-100 justify-content-between ">
                                    <button type="button" class="btn btn-primary btn-later px-4 py-10 selected set-now">Now <span class="justify-content-center align-items-center" style="font-size: 12px; font-weight: 400;">(Get Your Order Made Now)</span></button>
                                    <button type="button" class="btn btn-primary btn-later set-later btn-circle" data-toggle="modal"
                                        data-target="#exampleModalCenter1">Later <span class="justify-content-center align-items-center" style="font-size: 12px; font-weight: 400;">(Scedule For a Future Time)</span></button>
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
                                                    <h5 class="modal-title text-center" id="exampleModalCenterTitle">Please select a day and time to have your order ready</h5>
                                                    <div class="input">
                                                        <p id="formattedDate" class="my-3">Select a date</p>
                                                        {{-- <input type="date" id="orderDate" name="date" class="mt-3" min="<?= date('Y-m-d'); ?>"> --}}

                                                        <input type="date" id="orderDate" name="date" class="mt-3" min="<?php echo date('Y-m-d'); ?>">
                                                        <select id="orderTime" name="time" class="my-3">
                                                            <option value="">Select Time</option>
                                                        </select>
                                                        {{-- <input type="time" id="orderTime" name="time" class="my-3"> --}}
                                                        {{-- <input type="time" id="orderTime" name="time" class="my-3" step="2700"> --}}
                                                    </div>
                                                    <button type="button" class="btn btn-okey mb-3 btokey" id="confirm_time">Confirm</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            <div style="display: flex; align-items: center; justify-content: center; height: 100%;">
                                <hr style="height: 70%; width: 263.5px; background-color: #CECECE; color: #CECECE; ">
                            </div>
                            <input type="hidden" name="promotion_id" class="promotion_id_field">
                            <p id="output" class="set-order-msg align-items-center w-100 justify-content-center mt-1">Current Timing Is set in Your Order</p>
                            <div class="align-items-center wd-dr-now my-4 d-none">
                                <div class="input-group w-auto">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-map-marker"
                                                aria-hidden="true"></i></span>
                                        <input type="text" class="form-control ml-3" placeholder="Address">
                                    </div>
                                </div>
                            </div> 
                            <div class="d-flex align-items-center wd-dr-now wd-innerborder pb-4 w-100">
                                <div class="input-group w-100 text-center order-note">
                                    <div class="input-group-prepend notes">
                                        {{-- <span class="input-group-text" id="basic-addon1"><img src="{{ asset('assets/customer/images/envelop.png') }}" width="25" height="25"></span> --}}
                                        <span class="input-group-text note-input ml-3" id="basic-addon1"><i class="fas fa-envelope"></i></span>
                                        <input type="text" class="form-control " placeholder="Write Order Note Here"
                                            name="instruction">
                                    </div>
                                </div>
                            </div>
                            <div class="text-center" id="loginbutton">
                                    <button type="button" class="btn btn-primary btn-lg rounded-full" title="Login" data-toggle="modal" data-target="#yourModal">Login</button>
                            </div>
                        </div>
                        @auth
                            @php
                                $cartTotal = 0;
                                $modifierTotal = 0;
                            @endphp
                            <div class="scroll-inner-blog mt-4" id="cart_items">
                                @php
                                    $userId = auth()->id(); 
                                    $cart = getCart($restaurantId = 1);
                                    $user = \App\Models\User::where('uid', $userId)->first();
                                    // Retrieve the authenticated user's ID
                                    $menuItem= []; 
                                @endphp
                                @if (!empty($cart->cartMenuItems))
                                    @forelse ($cart->cartMenuItems as $key => $item)
                                        @php
                                        
                                            $loyalties = \App\Models\CartItem::where("cart_id", $cart->cart_id)
                                                    ->where("is_loyalty", '1')
                                                    ->get();
                                            $loyaltyCount = $loyalties->count();
                                            $isRedeemable = \App\Models\LoyaltyRuleItem::where("menu_id", $item['menu_id'])
                                                        ->where('restaurant_id',$restaurantId = 1)
                                                        ->first();
                                            //find the loyalty point
                                            if($isRedeemable)
                                                {
                                                    $loyaltyPoint = \App\Models\LoyaltyRule::where('restaurant_id',$restaurantId = 1)
                                                                ->where('rules_id', $isRedeemable->loyalty_rule_id)
                                                                ->first()->point;
                                                }
                                            $cartTotal += $item['menu_price'] * $item['menu_qty'] + $item['modifier_total'] * $item['menu_qty'];

                                            $menuItem[] = ['menu_id' => $item['menu_id'], 'menu_name' => $item['menu_name'],'menu_price' => $item['menu_price'],'menu_total' => $item['menu_total'], 'menu_qty' => $item['menu_qty'], 'modifier_total' => $item['modifier_total']];

                                        @endphp
                                        <div
                                            class="d-flex rounded wp-border-size-blog @if ($key != 0) mt-2 @endif mb-4">
                                            <div class="wb-inner-system">
                                                @php
                                                    $imagePath = public_path('uploads/menu/' . $item->item_img); // Adjust the path as per your storage
                                                @endphp
                                                <img src="{{ $item['item_img'] ?  $item['item_img'] : asset('images/d-logo.png') }}" class="img-fluid">
                                                {{-- <img src="{{ $item['item_img'] && file_exists($imagePath) ?  $item['item_img'] : asset('images/d-logo.png') }}" class="img-fluid"> --}}
                                            </div>
                                            <div class="wb-inner-system-first">
                                                <div class="d-flex wd-menu-photo justify-content-between w-100">
                                                    <div class="no-photos-blog">
                                                        <p class="m-0" style="color: #007AFF; font-weight: 500; font-size: 12px;"> {{ $item['menu_name'] }} </p>
                                                        <!-- <p>( ${{ $item['menu_price'] }} × {{ $item['menu_qty'] }} )</p> -->
                                                        @if($item->is_loyalty==1) 
                                                            <div class="iconbutton d-flex  align-items-center">
                                                                <i class="fa fa-gift pr-3" aria-hidden="true"></i>
                                                                <p class="mb-0">{{ $item->loyalty_point }} pts</p>
                                                            </div>
                                                        @endif
                                                        
                                                    </div>
                                                    <div class="d-flex">
                                                        
                                                        <a href="#" class="cart-remove"
                                                            data-cart-menu-item-id="{{ $item['cart_menu_item_id'] }}"><span
                                                                aria-hidden="true" class="ml-2">&#9940</span>
                                                        </a>
                                                    </div>
                                                </div>
                                                @if($item->is_loyalty==0)
                                                <div class="d-flex justify-content-between align-items-center mb-0 mt-3 cart-item-bt-div">
                                                    <p class="mt-2 mb-0 price">
                                                        ${{ number_format($item['menu_price'] * $item['menu_qty'] + $item['modifier_total'] * $item['menu_qty'], 2) }}
                                                    </p>
                                                    <div class="product-quantity product-quantity-{{ $item->menu_id }} d-inline-flex ">
                                                        <span class="m-p-btn product-quantity-minus"
                                                            data-cart-menu-item-id="{{ $item->cart_menu_item_id }}"></span>
                                                        <input type="hidden" value="{{ $cart->cart_id }}" name="cartid"
                                                            id="cartid" class="" />
                                                        <input type="number"
                                                            value="{{ $cart->cartMenuItems->where('cart_menu_item_id', $item->cart_menu_item_id)->first()->menu_qty }}"
                                                            class="quantity quantity-{{ $item->cart_menu_item_id }}" readonly />
                                                        <span class="m-p-btn product-quantity-plus" data-menu-id="{{$item->menu_id}}"
                                                            data-cart-menu-item-id="{{ $item->cart_menu_item_id }}"></span>
                                                    </div>
                                                </div>
                                                @if( $user && $isRedeemable && !$loyaltyCount && (int)$loyaltyPoint < (int)$user->total_points)
                                                    {{-- <a href="#" style="color: red; text-decoration: none;" class="iconbutton d-flex  align-items-center col-6 redeemProduct" data-cartLoyaltyRuleId = "{{$isRedeemable->loyalty_rule_id}}" data-cartMenuId="{{$item->menu_id}}">
                                                        <i class="fa fa-gift pr-3" aria-hidden="true"></i>
                                                        <p class="mb-0">Redeem for {{ $loyaltyPoint }} pts</p>
                                                    </a> --}}
                                                    <a href="#" class="iconbutton d-flex align-items-center justify-content-center col-6 redeemProduct"
                                                        data-cartLoyaltyRuleId="{{$isRedeemable->loyalty_rule_id}}" 
                                                        data-cartMenuId="{{$item->menu_id}}">
                                                        
                                                        <i class="fa fa-gift" aria-hidden="true"></i>
                                                        <p>Redeem for {{ $loyaltyPoint }} pts</p>

                                                    </a>
                                                @endif
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
                            <div style="display: flex; align-items: center; justify-content: center; height: 100%;">
                                <hr style="height: 70%; width: 263.5px; background-color: #CECECE; color: #CECECE; ">
                            </div>
                            <input type="hidden" name="menuItem"
                                value="{{ isset($menuItem) ? base64_encode(json_encode($menuItem)) : '' }}">
                            <div class="promotion-iner-blog mt-3 Promotion-btn-click  bgcolorchange">
                                <div class="d-flex align-items-center justify-content-between promotions-btn">
                                    <div class="d-flex align-items-center">
                                        <img width="35px" src="{{ asset('assets/images/promo-percent.png') }}"
                                        {{-- <img width="35px" src="{{ asset('assets/images/divition-icon.png') }}" --}}
                                            alt="" />
                                        <div class="mx-2 body">
                                            <h5 class="mb-0 promotion_text-cololr">Promotions</h5>
                                            <p id="promo_description">
                                            </p>
                                        </div>
                                    </div>
                                    <div class="row-btn">
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
                                            if($prmotion_id){
                                                $promotion_code = \App\Models\Promotion::where('restaurant_id', 1)
                                                    ->where('promotion_id',$prmotion_id)
                                                    ->first();
                                            }
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
                                                        $('.couponcode').html("{{$promotion_code->promotion_code ?? ''}}");
                                                        $('#promo_description').html("{{$promotion_code->promotion_details ?? ''}}");
                                                        $('#coupon_code').val("{{$promotion_code}}");
                                                        $('.coupenremove').show();
                                                        // Change background color
                                                        $(".bgcolorchange").css("background-color", "#54ba72");

                                                        // Hide the .apply-content and show the .Promotion-content
                                                        $(".apply-content").css("display", "none");
                                                        $(".Promotion-content").css("display", "block");

                                                        // Optionally, if you need to use the $prmotion_id in JavaScript:
                                                        var promotionId = "{{ $prmotion_id }}";  // Pass the PHP variable to JavaScript
                                                        //console.log('Promotion ID:', promotionId);  // You can use this value in further JS logic if needed
                                                    }
                                                };
                                            </script>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div style="display: flex; align-items: center; justify-content: center; height: 100%;">
                                <hr style="height: 70%; width: 263.5px; background-color: #CECECE; color: #CECECE; ">
                            </div>
                            {{--
                            <div class="text-center" id="tips">
                                <h4 class="mb-2 promotion_text-cololr mb-4">Add Tip For</h4>
                                @php
                                    $totalwithsalestax = ($cart['sub_total'] ?? 0.00) + ($cart['tax_charge'] ?? 0.00);
                                @endphp <div class="input-group mb-3 full-div">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-primary text-white stafftip" >15%</span>
                                    </div>
                                    <button type="button" style="padding: 6px" value="{{ round($totalwithsalestax * 15) / 100 ,2}}"
                                        class="btn btn-light tip tipbutton text-left">${{round($totalwithsalestax * 15) / 100 ,2}}</button>
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
                                        <span class="input-group-text custom-tip-btn bg-primary text-white customtip">CUSTOM</span>
                                    </div>
                                    <button type="button" class="btn custom-tip-btn  custom custombutton" id="cutomtip">0.00</button>

                                    <button type="button" class="btn custom-tip-btn">No Tip</button>
                                    
                                </div>
                            </div> --}}
                            <div class="text-center" id="tips">
                                <h4 class="mb-2 promotion_text-cololr mb-4">Add Tip For</h4>
                                @php
                                    $totalwithsalestax = ($cart['sub_total'] ?? 0.00) + ($cart['tax_charge'] ?? 0.00);
                                @endphp
                                <div class="tips input-group mb-0 full-div  flex-wrap">
                                    <div class="input-group-prepend flex-row w-100 d-flex justify-content-between">
                                        <div class="tip-item d-flex flex-column align-items-center selected">
                                            <span class="stafftip" >15%</span>
                                            <button type="button" value="{{ round($totalwithsalestax * 15) / 100 ,2}}" class="btn btn-light tip tipbutton ">${{round($totalwithsalestax * 15) / 100 ,2}}</button>
                                        </div>
                                        <div class="tip-item d-flex flex-column align-items-center">
                                            <span class="stafftip">18%</span>
                                            <button type="button" value="{{ round($totalwithsalestax * 18) / 100 ,2}}" class="btn btn-light tip tipbutton">${{round($totalwithsalestax * 18) / 100 ,2}}</button>
                                        </div>
                                        <div class="tip-item d-flex flex-column align-items-center">
                                            <span class=" stafftip">20%</span>
                                            <button type="button" value="{{ round($totalwithsalestax * 20) / 100 ,2}}" class="btn btn-light tip tipbutton">${{ round ($totalwithsalestax * 20) / 100 ,2}}</button>
                                        </div>
                                    </div>
                                </div>
                                
                                <br>
                                <div class="input-group input-group-custom mb-0 full-div  flex-wrap">
                                    <div class="input-group-prepend flex-row w-100 d-flex justify-content-between">
                                        <div class="tip-item custom d-flex flex-column align-items-center">
                                            <span class="stafftip" >CUSTOM</span>
                                            <button type="button"  class="btn btn-light tip  tipbutton-custom" id="cutomtip">0.00</button>
                                        </div>
                                        <div class="tip-item no d-flex flex-column align-items-center">
                                            <button type="button"class="btn btn-light tip tipbutton-no">No Tip</button>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text custom-tip-btn bg-primary text-white customtip">CUSTOM</span>
                                    </div>
                                    <button type="button" class="btn custom-tip-btn  custom custombutton" id="cutomtip">0.00</button>

                                    <button type="button" class="btn custom-tip-btn">No Tip</button>
                                    
                                </div> --}}
                            </div>
                           
                            <div style="display: flex; align-items: center; justify-content: center; height: 100%;">
                                <hr style="height: 70%; width: 263.5px; background-color: #CECECE; color: #CECECE; ">
                            </div>

                            <div class="card-inner-body">
                                
                                <div class="d-flex align-items-center w-100 justify-content-center mb-2">
                                    <h5 class="payment-blog-title m-0 ">Payment Methods</h5>
                                </div>


                                <div class="d-flex justify-content-center w-100 mb-5">
                                    <div class="payment-option mr-2">
                                        <input type="radio" name="paymentType" value="Credit Card" id="card_payment" checked>
                                        <label for="card_payment">Card</label>
                                    </div>
                                    <div class="payment-option">
                                        <input type="radio" name="paymentType" value="Cash" id="cash_payment">
                                        <label for="cash_payment">Cash</label>
                                    </div>
                                </div>
                                
                                {{--  <div class="d-flex">
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
                                </div> --}}
                                <div class="cards mt-3">
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
                                             {{-- pagination --}}
                                                    <div class="pagination-container mt-3">
                                                        <div class="pagination-btn">
                                                            <i class="fas fa-chevron-left"></i>
                                                        </div>
                                                        {{-- <button class="pagination-btn" id="prevBtn">&lt;</button> --}}
                                                        <div class="pagination">
                                                            @foreach ($cards as $key=>$card)
                                                                <span class="page {{ $key==0 ? 'active' : '' }}"></span>
                                                            @endforeach
                                                        </div>
                                                        {{-- <button class="pagination-btn" id="nextBtn">></button> --}}
                                                        <div class="pagination-btn">
                                                            <i class="fas fa-chevron-right"></i>
                                                        </div>
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


                                {{-- <div class="btn-inner-blog mt-2">
                                    <button class="btn btn-submit-inner sendToken" type="submit">Checkout</button>
                                </div> --}}
                            </div>

                        @endauth
                </div>
            </div>
            @auth
                <div class="btn-inner-blog mt-2">
                    <button class="btn btn-submit-inner sendToken" type="submit">Checkout</button>
                </div>
            @endauth
        </form>
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

<script>
    document.getElementById("confirm_time").disabled = true;
    let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
    document.addEventListener("DOMContentLoaded", function () {
    let orderDateInput = document.getElementById("orderDate");
    let orderTimeSelect = document.getElementById("orderTime");
    let orderStatus = document.getElementById("order_status");
    const formattedDateP = document.getElementById("formattedDate");

    // Fetch available days and times from your API
    fetch("/api/customer/get-hours",{
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrfToken // Add CSRF token here
            },
            body: JSON.stringify({
                restaurant_id: 1, 
                debug_mode: "ON"
            }),
        })
        .then(response => response.json())
        .then(data => {
                console.log(data)
                if (data.success) {
                setupDateSelector(data.list);
            } else {
                console.error("Error fetching restaurant hours.");
            }
        })
        .catch(error => console.error("Fetch error:", error));

    function setupDateSelector(daysData) {
        let today = new Date();
        let availableDates = {};

        daysData.forEach(entry => {
            let weekday = entry.groupDayS.toLowerCase();
            availableDates[weekday] = entry.all_times; // Store available times for each weekday
        });
        console.log(availableDates)
        // Enable only the available days in the date picker
        orderDateInput.addEventListener("change", function () {

            let selectedDate = new Date(this.value);
            let options = { month: "long", day: "numeric", year: "numeric" };
            let selectedDay = selectedDate.toLocaleDateString("en-US", options); 
            let checkDay = selectedDate.toLocaleString("en-US", { weekday: "long" }).toLowerCase();

            console.log(selectedDay)
            // Set the initial <p> text if there's already a value
            formattedDateP.textContent = selectedDay;
            if (availableDates[checkDay]) {
                // document.getElementById("confirm_time").disabled = false;
                populateTimeOptions(availableDates[checkDay]);
            } else {
                document.getElementById("confirm_time").disabled = true;
                alert("Restaurant is closed on this day.");
                orderTimeSelect.innerHTML = ""; // Clear previous options
            }
        });
    }

    // function populateTimeOptions(timeSlots) {
    //     orderTimeSelect.innerHTML = ""; // Clear previous options
    //     document.getElementById("confirm_time").disabled = false;

    //     timeSlots.forEach(slot => {
    //         let option = document.createElement("option");
    //         option.value = slot.opening_time;
    //         option.textContent = `${slot.opening_time} - ${slot.closing_time} (${slot.hour_type || "Any"})`;
    //         orderTimeSelect.appendChild(option);
    //     });
    // }
    function populateTimeOptions(timeSlots) {
    const orderTimeSelect = document.getElementById("orderTime");
    orderTimeSelect.innerHTML = ""; // Clear previous options

    timeSlots.forEach(slot => {
        let { opening_time, closing_time, hour_type } = slot;

        let times = generateTimeIntervals(opening_time, closing_time, 15); // Generate slots every 15 min

        times.forEach(time => {
            let option = document.createElement("option");
            option.value = time;
            option.textContent = `${time} (${hour_type || "Any"})`;
            orderTimeSelect.appendChild(option);
        });
    });
    document.getElementById("confirm_time").disabled = false;
}

// ✅ Function to Generate Time Intervals
function generateTimeIntervals(startTime, endTime, stepMinutes) {
    let timeList = [];
    let start = parseTime(startTime);
    let end = parseTime(endTime);

    while (start < end) {
        timeList.push(formatTime(start));
        start.setMinutes(start.getMinutes() + stepMinutes); // Increase by stepMinutes (e.g., 15 min)
    }

    return timeList;
}

// ✅ Convert "07:00 AM" to a Date object
function parseTime(timeStr) {
    let [time, modifier] = timeStr.split(" ");
    let [hours, minutes] = time.split(":").map(Number);

    if (modifier === "PM" && hours !== 12) hours += 12;
    if (modifier === "AM" && hours === 12) hours = 0;

    let date = new Date();
    date.setHours(hours, minutes, 0, 0);
    return date;
}

// ✅ Format Date object to "HH:mm AM/PM"
function formatTime(date) {
    let hours = date.getHours();
    let minutes = date.getMinutes();
    let ampm = hours >= 12 ? "PM" : "AM";

    hours = hours % 12 || 12; // Convert 24h to 12h format
    minutes = minutes.toString().padStart(2, "0"); // Ensure two digits

    return `${hours}:${minutes} ${ampm}`;
}

// Example usage:
let timeSlots = [
    { opening_time: "07:00 AM", closing_time: "08:15 AM", hour_type: "Morning" },
    { opening_time: "02:00 PM", closing_time: "04:00 PM", hour_type: "Afternoon" }
];

populateTimeOptions(timeSlots);

});
    //  document.getElementById("orderTime").addEventListener("change", function () {
    //     const allowedTimes = ["09:00", "09:45", "10:30", "11:15", "12:00", "12:45", "13:30", "14:15", "15:00"]; // Allowed times
    //     let selectedTime = this.value;

    //     if (!allowedTimes.includes(selectedTime)) {
    //         alert("Please select a valid time slot!");
    //         document.getElementById("confirm_time").disabled = true;
    //         this.value = ""; // Clear the input
    //     }
    // });
document.addEventListener("DOMContentLoaded", function() {
    const tipItems = document.querySelectorAll(".tip-item");

    tipItems.forEach(item => {
        item.addEventListener("click", function() {
            // Remove 'selected' class from all tip items
            tipItems.forEach(el => el.classList.remove("selected"));

            // Add 'selected' class to the clicked item
            this.classList.add("selected");
        });
    });
});
</script>





