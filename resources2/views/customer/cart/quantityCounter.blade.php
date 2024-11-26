@if($menuItems->modifier_list_count > 0)
    @if(in_array($menuId,$menuIds))
        @php $menuCount = 1; @endphp
        @if(in_array($menuId,$menuIds))
            @php $menuCount++; @endphp
        @endif
        @if($menuCount == 2)
            @php $cartClass = 'decrease-with-modifire'; @endphp
        @else
            @php $cartClass = 'cart-decrease'; @endphp
        @endif
        <div class="add quantity-counter quantity-counter-{{Str::of($menuName)->replace(' ', '-')}}">
            <div class="value-button {{$cartClass}}" id="decrease-{{$menuId}}" value="Decrease Value" data-menu-id="{{$menuId}}">-</div>
                @php
                    $itemQuantity = 0;
                @endphp
                @foreach($quantityArray as $quantity)
                    @if($quantity['menu_id'] == $menuId)
                        @php
                            $itemQuantity += $quantity['quantity'];
                        @endphp
                    @endif
                @endforeach
                <input type="number" id="quantity-{{$menuId}}" value="{{$itemQuantity}}" class="number"/>
            <div class="value-button increase-with-modifire" id="increase-{{$menuId}}" value="Increase Value" data-menu-id="{{$menuId}}">+</div>
        </div>
        <div class="cart-alert-popup"></div>
    @else
        <div class="add quantity-counter quantity-counter-{{Str::of($menuName)->replace(' ', '-')}}">
            <div class="value-button decrease modifier-decrease" id="decrease-{{$menuId}}" value="Decrease Value" data-menu-id="{{$menuId}}">-</div>
                <input type="number" id="quantity-{{$menuId}}" value="0" class="number"/>
            <div class="value-button increase modifier-increase" id="increase-{{$menuId}}" value="Increase Value" data-menu-id="{{$menuId}}">+</div>
        </div>
    @endif
@else
    @if(in_array($menuId,$menuIds))
        <div class="add quantity-counter quantity-counter-{{Str::of($menuName)->replace(' ', '-')}}">
            <div class="value-button decrease" id="decrease-{{$menuId}}" value="Decrease Value" data-menu-id="{{$menuId}}">-</div>
                @foreach($quantityArray as $quantity)
                    @if($quantity['menu_id'] == $menuId)
                        <input type="number" id="quantity-{{$menuId}}" value="{{$quantity['quantity']}}" class="number" max="10"/>
                    @endif
                @endforeach
            <div class="value-button increase" id="increase-{{$menuId}}" value="Increase Value" data-menu-id="{{$menuId}}">+</div>
        </div>
    @else
        <div class="add quantity-counter quantity-counter-{{Str::of($menuName)->replace(' ', '-')}}">
            <div class="value-button decrease" id="decrease-{{$menuId}}" value="Decrease Value"
                data-menu-id="{{$menuId}}">-</div>
            <input type="number" id="quantity-{{$menuId}}" value="0" class="number" max="10" />
            <div class="value-button increase" id="increase-{{$menuId}}" value="Increase Value"
                data-menu-id="{{$menuId}}">+</div>
        </div>
    @endif
@endif
<input type="hidden" value="{{$cartCount}}" class="cartCount"/>



