@extends('customer-layouts.app')

@section('content')
	@include('customer-layouts.banner')

		{{-- <div class="container home-search">
	        <div class="row">
	            <div class="col-sm-6">
	                <form>
	                    <input type="text" placeholder="Search menu item" id="searchItem">
	                </form>
	            </div>
	            <div class="col-sm-6">
	                <div class="search-button">
	                    <div id="myDIV">
							@foreach($categories as $key => $category)
	                    		@php
	                    			if($key == 0)
	                    			{
	                    				$active = 'active';
	                    			}
	                    			else
	                    			{
	                    				$active = '';	
	                    			}
	                    		@endphp
	                        	<button class="btn item-type category {{$active}} category-{{$category->category_id}}" alt="{{$category->category_name}}" data-category-id="{{$category->category_id}}" data-restaurant-id="{{$category->restaurant_id}}">{{$category->category_name}}</button>
	                        @endforeach
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div> --}}
		<div class="container-fluid home-search">
			<div class="wd-dr-border">
				<div class="wd-der-inoutting-blog">
       				<div class="wd-dr-input-form">
						<form>
							<img src="{{asset('assets/customer/images/loupe.png')}}">
							<input type="text" placeholder="Search menu item" id="searchItem">
						</form>
					</div>
					<div class="search-input-form">
						<div class="search-button">
							<div id="myDIV">
								@foreach($categories as $key => $category)
									@php
										if($key == 0)
										{
											$active = 'active';
										}
										else
										{
											$active = '';	
										}
									@endphp
	                        		<button class="btn item-type category {{$active}} category-{{$category->category_id}}" alt="{{$category->category_name}}" data-category-id="{{$category->category_id}}" data-restaurant-id="{{$category->restaurant_id}}">{{$category->category_name}}</button>
	                        	@endforeach
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		{{-- <div class="container">
		    <div class="row" id="menuIteams">
		    	@foreach($menuItems as $key => $iteam)
		    		<div class="col-sm-3 col-md-3">
		    		    <div class="food-item tooltip1">
		    		        <div class="tooltiptext">
		    		            <h4>{{$iteam->item_name}}</h4>
		    		            <span>
		    		                {{$iteam->item_details}}
		    		            </span>
		    		        </div>
							<div class="food-img" style="background-image: url('{{(empty($iteam->getMenuImgAttribute())) ? asset('assets/customer/images/Logo-Round.png') : $iteam->getMenuImgAttribute()}}');background-repeat: no-repeat;background-size: 100% 100%;height: 200px;">
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
		    		            {{$iteam->item_details}}
		    		        </p>
		    			</div>
		    		</div>
		    	@endforeach
			</div>
			<div class="row" id="searchIteams"></div>
			<div id="snackbar"></div>
		    <div class="modal fade" id="decrease-modal" tabindex="-1" role="dialog" aria-labelledby="modifier-btn">
		        <div class="modal-dialog" role="document">
		            <div class="modal-content">
		                <div class="modal-header">
		                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
		                            aria-hidden="true">&times;</span></button>
		                </div>
		                <div class="modal-body">
		                	<p>This item have different modifiers Please go to cart to minus.</p>
		                </div>
		                <div class="modal-footer">
		                    <a href="{{route('customer.cart')}}" class="btn btn-primary btn-block">
		                        <h4>
		                            Go to cart
		                        </h4>
		                    </a>
		                </div>
		            </div>
		        </div>
		    </div>
		</div> --}}
		<div class="container-fluid">
			<div class="wd-dr-home-page">
				<div class="row" id="menuIteams">
					@foreach($menuItems as $key => $iteam)
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
									<button type="button" class="btn btn-primary add" data-toggle="modal" data-target="#modifier" alt="Add+">
										Add+
									</button>
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
								<p>
									{{mb_strimwidth($iteam->item_details,0,50,"....")}}
								</p>
		
							</div>
						</div>
					@endforeach
				</div>
				<div class="row" id="searchIteams"></div>
				<div id="snackbar"></div>
				{{-- <div class="row">
					<div class="col-sm-3 col-md-3">
						<div class="food-item tooltip1">
							<div class="tooltiptext">
								<h4>Bark Shrimp Boiled</h4>
								<span>
									Lorem Ipsum is simply dummy text of the printing and typesetting industry.
								</span>
							</div>
							<div class="food-img food-item-1">
								<img src="images/item_f.jpg">
								<button type="button" class="btn btn-primary add" data-toggle="modal" data-target="#BarkShrimpBoiled" alt="Add+">
									Add+
								</button>
								<div class="modal fade" id="BarkShrimpBoiled" tabindex="-1" role="dialog" aria-labelledby="modifier-btn">
									<div class="modal-dialog" role="document">
										<div class="modal-content">
											<div class="modal-header modifier-header">
												<button type="button" class="close" data-dismiss="modal" aria-label="Close" alt="Modal Close"><span aria-hidden="true">&times;</span></button>
												<h4>Bark Shrimp Boiled</h4>
											</div>
											<div class="modal-body">
												<form>
													<ul class="modifier-list">
														<li>
															Ice Cream
															<div class="checkbox">
																<label>
																	<input type="checkbox"> Thin Crust
																	<span class="mark"></span>
																</label>
																<label class="modifier-price">
																	$ 14.00
																</label>
															</div>
															<div class="checkbox">
																<label>
																	<input type="checkbox"> Mizari Cream
																	<span class="mark"></span>
																</label>
																<label class="modifier-price">
																	$ 16.00
																</label>
															</div>
															<div class="checkbox">
																<label>
																	<input type="checkbox"> Metal Paper Grace
																	<span class="mark"></span>
																</label>
																<label class="modifier-price">
																	$ 18.00
																</label>
															</div>
														</li>
													</ul>
													<ul class="modifier-list">
														<li>
															Dry Fruits
															<div class="checkbox">
																<label>
																	<input type="checkbox"> American Dry Fruits
																	<span class="mark"></span>
																</label>
																<label class="modifier-price">
																	$ 12.00
																</label>
															</div>
															<div class="checkbox">
																<label>
																	<input type="checkbox"> All Others ans Cream
																	<span class="mark"></span>
																</label>
																<label class="modifier-price">
																	$ 61.00
																</label>
															</div>
														</li>
													</ul>
													<ul class="modifier-list modifier-list-last">
														<li>
															Crrimal Balls
															<div class="checkbox">
																<label>
																	<input type="checkbox"> Aarcher star Ball
																	<span class="mark"></span>
																</label>
																<label class="modifier-price">
																	$ 61.00
																</label>
															</div>
	
														</li>
													</ul>
												</form>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-primary btn-block" alt="Add Item"> Add
													Item</button>
											</div>
										</div>
									</div>
								</div>
							</div>
							<ul>
								<li>
									<h4>Bark Shrimp Boiled</h4>
									<div class="price">
										$12.00
									</div>
									<div class="clearfix">
	
									</div>
								</li>
							</ul>
							<p>
								Lorem Ipsum is simply dummy text of the printing a
							</p>
						</div>
					</div>
					<div class="col-sm-3 col-md-3">
						<div class="food-item tooltip1">
							<div class="tooltiptext">
								<h4>Grapes Whites Wine</h4>
								<span>
									Lorem Ipsum is simply dummy text of the printing and typesetting industry.
								</span>
							</div>
							<div class="food-img food-item-2">
								<img src="images/item_g.jpg">
								<button type="button" class="btn btn-primary add" data-toggle="modal" data-target="#GrapesWhitesWine" alt="Add+">
									Add+
								</button>
								<div class="modal fade" id="GrapesWhitesWine" tabindex="-1" role="dialog" aria-labelledby="modifier-btn">
									<div class="modal-dialog" role="document">
										<div class="modal-content">
											<div class="modal-header modifier-header">
												<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
												<h4>Grapes Whites Wine</h4>
											</div>
											<div class="modal-body">
												<form>
													<ul class="modifier-list">
														<li>
															Ice Cream
															<div class="checkbox">
																<label>
																	<input type="checkbox"> Thin Crust
																	<span class="mark"></span>
																</label>
																<label class="modifier-price">
																	$ 14.00
																</label>
															</div>
															<div class="checkbox">
																<label>
																	<input type="checkbox"> Mizari Cream
																	<span class="mark"></span>
																</label>
																<label class="modifier-price">
																	$ 16.00
																</label>
															</div>
															<div class="checkbox">
																<label>
																	<input type="checkbox"> Metal Paper Grace
																	<span class="mark"></span>
																</label>
																<label class="modifier-price">
																	$ 18.00
																</label>
															</div>
														</li>
													</ul>
													<ul class="modifier-list">
														<li>
															Dry Fruits
															<div class="checkbox">
																<label>
																	<input type="checkbox"> American Dry Fruits
																	<span class="mark"></span>
																</label>
																<label class="modifier-price">
																	$ 12.00
																</label>
															</div>
															<div class="checkbox">
																<label>
																	<input type="checkbox"> All Others ans Cream
																	<span class="mark"></span>
																</label>
																<label class="modifier-price">
																	$ 61.00
																</label>
															</div>
														</li>
													</ul>
													<ul class="modifier-list modifier-list-last">
														<li>
															Crrimal Balls
															<div class="checkbox">
																<label>
																	<input type="checkbox"> Aarcher star Ball
																	<span class="mark"></span>
																</label>
																<label class="modifier-price">
																	$ 61.00
																</label>
															</div>
	
														</li>
													</ul>
												</form>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-primary btn-block" alt="Add Item"> Add
													Item</button>
											</div>
										</div>
									</div>
								</div>
							</div>
							<ul>
								<li>
									<h4>Grapes Whites Wine</h4>
									<div class="price">
										$09.00
									</div>
									<div class="clearfix">
	
									</div>
								</li>
							</ul>
							<p>
								Lorem Ipsum is simply dummy text of the printing a
							</p>
						</div>
					</div>
					<div class="col-sm-3 col-md-3">
						<div class="food-item tooltip1">
							<div class="tooltiptext">
								<h4>Shishini Prestry</h4>
								<span>
									Lorem Ipsum is simply dummy text of the printing and typesetting industry.
								</span>
							</div>
							<div class="food-img food-item-3">
								<img src="images/item_h.jpg">
								<button type="button" class="btn btn-primary add" data-toggle="modal" data-target="#ShishiniPrestry" alt="Add+">
									Add+
								</button>
								<div class="modal fade" id="ShishiniPrestry" tabindex="-1" role="dialog" aria-labelledby="modifier-btn">
									<div class="modal-dialog" role="document">
										<div class="modal-content">
											<div class="modal-header modifier-header">
												<button type="button" class="close" data-dismiss="modal" aria-label="Close" alt="Modal Close"><span aria-hidden="true">&times;</span></button>
												<h4>Shishini Prestry</h4>
											</div>
											<div class="modal-body">
												<form>
													<ul class="modifier-list">
														<li>
															Ice Cream
															<div class="checkbox">
																<label>
																	<input type="checkbox"> Thin Crust
																	<span class="mark"></span>
																</label>
																<label class="modifier-price">
																	$ 14.00
																</label>
															</div>
															<div class="checkbox">
																<label>
																	<input type="checkbox"> Mizari Cream
																	<span class="mark"></span>
																</label>
																<label class="modifier-price">
																	$ 16.00
																</label>
															</div>
															<div class="checkbox">
																<label>
																	<input type="checkbox"> Metal Paper Grace
																	<span class="mark"></span>
																</label>
																<label class="modifier-price">
																	$ 18.00
																</label>
															</div>
														</li>
													</ul>
													<ul class="modifier-list">
														<li>
															Dry Fruits
															<div class="checkbox">
																<label>
																	<input type="checkbox"> American Dry Fruits
																	<span class="mark"></span>
																</label>
																<label class="modifier-price">
																	$ 12.00
																</label>
															</div>
															<div class="checkbox">
																<label>
																	<input type="checkbox"> All Others ans Cream
																	<span class="mark"></span>
																</label>
																<label class="modifier-price">
																	$ 61.00
																</label>
															</div>
														</li>
													</ul>
													<ul class="modifier-list modifier-list-last">
														<li>
															Crrimal Balls
															<div class="checkbox">
																<label>
																	<input type="checkbox"> Aarcher star Ball
																	<span class="mark"></span>
																</label>
																<label class="modifier-price">
																	$ 61.00
																</label>
															</div>
	
														</li>
													</ul>
												</form>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-primary btn-block" alt="Add Item"> Add
													Item</button>
											</div>
										</div>
									</div>
								</div>
							</div>
							<ul>
								<li>
									<h4>Shishini Prestry</h4>
									<div class="price">
										$11.00
									</div>
									<div class="clearfix">
	
									</div>
								</li>
							</ul>
							<p>
								Lorem Ipsum is simply dummy text of the printing a
							</p>
						</div>
					</div>
					<div class="col-sm-3 col-md-3">
						<div class="food-item tooltip1">
							<div class="tooltiptext">
								<h4>Tikka Madurai</h4>
								<span>
									Lorem Ipsum is simply dummy text of the printing and typesetting industry.
								</span>
							</div>
							<div class="food-img food-item-4">
								<img src="images/item_i.jpg">
								<button type="button" class="btn btn-primary add" data-toggle="modal" data-target="#TikkaMadurai" alt="Add+">
									Add+
								</button>
								<div class="modal fade" id="TikkaMadurai" tabindex="-1" role="dialog" aria-labelledby="modifier-btn">
									<div class="modal-dialog" role="document">
										<div class="modal-content">
											<div class="modal-header modifier-header">
												<button type="button" class="close" data-dismiss="modal" aria-label="Close" alt="Modal Close"><span aria-hidden="true">&times;</span></button>
												<h4>Tikka Madurai</h4>
											</div>
											<div class="modal-body">
												<form>
													<ul class="modifier-list">
														<li>
															Ice Cream
															<div class="checkbox">
																<label>
																	<input type="checkbox"> Thin Crust
																	<span class="mark"></span>
																</label>
																<label class="modifier-price">
																	$ 14.00
																</label>
															</div>
															<div class="checkbox">
																<label>
																	<input type="checkbox"> Mizari Cream
																	<span class="mark"></span>
																</label>
																<label class="modifier-price">
																	$ 16.00
																</label>
															</div>
															<div class="checkbox">
																<label>
																	<input type="checkbox"> Metal Paper Grace
																	<span class="mark"></span>
																</label>
																<label class="modifier-price">
																	$ 18.00
																</label>
															</div>
														</li>
													</ul>
													<ul class="modifier-list">
														<li>
															Dry Fruits
															<div class="checkbox">
																<label>
																	<input type="checkbox"> American Dry Fruits
																	<span class="mark"></span>
																</label>
																<label class="modifier-price">
																	$ 12.00
																</label>
															</div>
															<div class="checkbox">
																<label>
																	<input type="checkbox"> All Others ans Cream
																	<span class="mark"></span>
																</label>
																<label class="modifier-price">
																	$ 61.00
																</label>
															</div>
														</li>
													</ul>
													<ul class="modifier-list modifier-list-last">
														<li>
															Crrimal Balls
															<div class="checkbox">
																<label>
																	<input type="checkbox"> Aarcher star Ball
																	<span class="mark"></span>
																</label>
																<label class="modifier-price">
																	$ 61.00
																</label>
															</div>
	
														</li>
													</ul>
												</form>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-primary btn-block" alt="Add Item"> Add
													Item</button>
											</div>
										</div>
									</div>
								</div>
							</div>
							<ul>
								<li>
									<h4>Tikka Madurai</h4>
									<div class="price">
										$15.00
									</div>
									<div class="clearfix">
	
									</div>
								</li>
							</ul>
							<p>
								Lorem Ipsum is simply dummy text of the printing a
							</p>
						</div>
					</div>
				</div> --}}
			</div>
		</div>
@endsection

@section('scripts')
	<script src="{{asset('assets/customer/js/jquery.validate.min.js')}}"></script>
	<script src="{{asset('assets/customer/js/additional-methods.min.js')}}"></script>
	<script src="{{asset('assets/customer/js/home/index.js')}}"></script>
@endsection