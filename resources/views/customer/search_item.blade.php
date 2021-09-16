@forelse($menuItems as $key => $item)
    <div class="col-sm-3 col-md-3">
        <div class="food-item tooltip1">
            <div class="tooltiptext">
                <h4>{{$item->item_name}}</h4>
                <span>
                    {{$item->item_details}}
                </span>
            </div>
            <div class="food-img" style="background-image: url('{{(empty($item->getMenuImgAttribute())) ? asset('assets/customer/images/Logo-Round.png') : $item->getMenuImgAttribute()}}');background-repeat: no-repeat;background-size: 100% 100%;height: 200px;">
                <div class="cart-quantity-counter-{{$item->menu_id}}">
                    @if($item->modifierList->count() > 0)
                        <button type="button" class="btn btn-primary add cart cart-{{Str::of($item->item_name)->replace(' ', '-')}}" data-menu-id="{{$item->menu_id}}" data-menu-name="{{Str::of($item->item_name)->replace(' ', '-')}}" data-category-id="{{$item->category_id}}" alt="Add+">
                            Add+
                        </button>
                        <div class="add quantity-counter hide quantity-counter-{{Str::of($item->item_name)->replace(' ', '-')}}">
                            <div class="value-button decrease modifier-decrease" id="decrease-{{$item->menu_id}}" value="Decrease Value" data-menu-id="{{$item->menu_id}}">-</div>
                                <input type="number" id="quantity-{{$item->menu_id}}" value="0" class="number"/>
                            <div class="value-button increase modifier-increase" id="increase-{{$item->menu_id}}" value="Increase Value" data-menu-id="{{$item->menu_id}}">+</div>
                        </div>
                    @else
                        <button type="button" class="btn btn-primary add add-to-cart cart-{{Str::of($item->item_name)->replace(' ', '-')}}" data-menu-id="{{$item->menu_id}}" data-menu-name="{{Str::of($item->item_name)->replace(' ', '-')}}" data-category-id="{{$item->category_id}}" alt="Add+">
                            Add+
                        </button>
                        <div class="add quantity-counter hide quantity-counter-{{Str::of($item->item_name)->replace(' ', '-')}}">
                            <div class="value-button decrease" id="decrease-{{$item->menu_id}}" value="Decrease Value" data-menu-id="{{$item->menu_id}}">-</div>
                                <input type="number" id="quantity-{{$item->menu_id}}" value="0" class="number" max="10"/>
                            <div class="value-button increase" id="increase-{{$item->menu_id}}" value="Increase Value" data-menu-id="{{$item->menu_id}}">+</div>
                        </div>
                    @endif
                </div>
                <div class="modifierItems-{{$item->menu_id}}"></div>
            </div>
            <ul>
                <li>
                    <h4>{{$item->item_name}}</h4>
                    <div class="price">
                        ${{number_format($item->item_price,'2')}}
                    </div>
                    <div class="clearfix">

                    </div>
                </li>
            </ul>
            <p style="height: 40px;">
                {{mb_strimwidth($iteam->item_details,0,50,"....")}}
            </p>
        </div>
    </div>
@empty
    <div class="text-center not_found">
        <span>No Item Found</span>
    </div>
@endforelse