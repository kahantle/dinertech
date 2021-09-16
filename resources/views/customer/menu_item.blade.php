@forelse($menuItems as $iteam)
	<div class="col-sm-3 col-md-3">
	    <div class="food-item tooltip1">
	        <div class="tooltiptext">
	            <h4>{{$iteam->item_name}}</h4>
	            <span>
	                {{$iteam->item_details}}
	            </span>
	        </div>
	        <div class="food-img food-item-1">
				<img src="{{(empty($iteam->getMenuImgAttribute())) ? asset('assets/customer/images/Logo-Round.png') : $iteam->getMenuImgAttribute()}}">
				<div class="cart-quantity-counter-{{$iteam->menu_id}}">
					@if($iteam->modifierList->count() > 0)
						@if(in_array($iteam->menu_id,$menuIds))
							@php $menuCount = 1; @endphp
							@if(in_array($iteam->menu_id,$menuIds))
								@php $menuCount++; @endphp
							@endif
							@if($menuCount == 2)
								@php $cartClass = 'decrease-with-modifire'; @endphp	
							@else
								@php $cartClass = 'cart-decrease'; @endphp
							@endif
							<div class="add quantity-counter quantity-counter-{{Str::of($iteam->item_name)->replace(' ', '-')}}">
								<div class="value-button {{$cartClass}}" id="decrease-{{$iteam->menu_id}}" value="Decrease Value" data-menu-id="{{$iteam->menu_id}}">-</div>
								@php
									$itemQuantity = 0;
								@endphp
								@foreach($quantityArray as $quantity)
									@if($quantity['menu_id'] == $iteam->menu_id)
										@php
											$itemQuantity += $quantity['quantity'];
										@endphp
									@endif
								@endforeach
								<input type="number" id="quantity-{{$iteam->menu_id}}" value="{{$itemQuantity}}" class="number"/>
								<div class="value-button increase-with-modifire" id="increase-{{$iteam->menu_id}}" value="Increase Value" data-menu-id="{{$iteam->menu_id}}">+</div>
							</div>
							<div class="cart-alert-popup"></div>
						@else
							<button type="button" class="btn btn-primary add cart cart-{{Str::of($iteam->item_name)->replace(' ', '-')}}" data-menu-id="{{$iteam->menu_id}}" data-menu-name="{{Str::of($iteam->item_name)->replace(' ', '-')}}" data-category-id="{{$iteam->category_id}}" alt="Add+">
								Add+
							</button>
							<div class="add quantity-counter hide quantity-counter-{{Str::of($iteam->item_name)->replace(' ', '-')}}">
								<div class="value-button decrease modifier-decrease" id="decrease-{{$iteam->menu_id}}" value="Decrease Value" data-menu-id="{{$iteam->menu_id}}">-</div>
									<input type="number" id="quantity-{{$iteam->menu_id}}" value="0" class="number"/>
								<div class="value-button increase modifier-increase" id="increase-{{$iteam->menu_id}}" value="Increase Value" data-menu-id="{{$iteam->menu_id}}">+</div>
							</div>
						@endif
					@else
						@if(in_array($iteam->menu_id,$menuIds))
							<div class="add quantity-counter quantity-counter-{{Str::of($iteam->item_name)->replace(' ', '-')}}">
								<div class="value-button decrease" id="decrease-{{$iteam->menu_id}}" value="Decrease Value" data-menu-id="{{$iteam->menu_id}}">-</div>
									@foreach($quantityArray as $quantity)
										@if($quantity['menu_id'] == $iteam->menu_id)
											<input type="number" id="quantity-{{$iteam->menu_id}}" value="{{$quantity['quantity']}}" class="number" max="10"/>
										@endif
									@endforeach	
								<div class="value-button increase" id="increase-{{$iteam->menu_id}}" value="Increase Value" data-menu-id="{{$iteam->menu_id}}">+</div>
							</div>
						@else
							<button type="button" class="btn btn-primary add add-to-cart cart-{{Str::of($iteam->item_name)->replace(' ', '-')}}" data-menu-id="{{$iteam->menu_id}}" data-menu-name="{{Str::of($iteam->item_name)->replace(' ', '-')}}" data-category-id="{{$iteam->category_id}}" alt="Add+">
								Add+
							</button>
							<div class="add quantity-counter hide quantity-counter-{{Str::of($iteam->item_name)->replace(' ', '-')}}">
								<div class="value-button decrease" id="decrease-{{$iteam->menu_id}}" value="Decrease Value" data-menu-id="{{$iteam->menu_id}}">-</div>
									<input type="number" id="quantity-{{$iteam->menu_id}}" value="0" class="number" max="10"/>
								<div class="value-button increase" id="increase-{{$iteam->menu_id}}" value="Increase Value" data-menu-id="{{$iteam->menu_id}}">+</div>
							</div>
						@endif
					@endif
				</div>
	            <div class="modifierItems-{{$iteam->menu_id}}"></div>
	        </div>
	        <ul>
	            <li>
	                <h4>{{$iteam->item_name}}</h4>
	                <div class="price">
	                    ${{number_format($iteam->item_price,'2')}}
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