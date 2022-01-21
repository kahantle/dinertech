@extends('customer-layouts.app')

@section('content')
<section class="dash-body-ar wd-dr-dash-inner">
	<div class="wrp-ar-nav-body">
		@include('customer-layouts.navbar')
		<div id="chatdesk" class="chart-board ">
			@include('customer.messages')
			<div class="row">
				<div class="col-xl-8 col-lg-12 col-md-12">
					<div class="content mt-5">
						<h2 class="mb-5">Payment Methods</h2>
						 <div class="table-responsive">
							<table class="table table-inner">
								<tbody>
									@foreach($cards as $card)
									<tr>
										<td style="width: 16%;" class="wd-dr-text-line">
											@if($card->card_type == Config::get('constants.CARD_TYPE.AMERICAN_EXPRESS'))
												<img src="{{asset('assets/customer/images/chat/express.png')}}" class="img-fluid">
											@elseif ($card->card_type == Config::get('constants.CARD_TYPE.VISA'))
												<img src="{{asset('assets/customer/images/chat/visa.png')}}" class="img-fluid">
											@elseif ($card->card_type == Config::get('constants.CARD_TYPE.DISCOVER'))
												<img src="{{asset('assets/customer/images/chat/discover.png')}}" class="img-fluid">
											@elseif ($card->card_type == Config::get('constants.CARD_TYPE.MASTER_CARD'))
												<img src="{{asset('assets/customer/images/chat/master_card.png')}}" class="img-fluid">
											@endif
										</td>
										<td style="width: 50%;">XXXX - XXXX - XXXX - {{ Str::substr($card->card_number,15,19)}}</td>
										<td class="wd-dr-text-line">{{$card->card_expire_date}}</td>
										<td rowspan="1" class="wd-dr-text-line">
											<div class="wd-dr-next-line">
												<i class="fas fa-cog"></i>
												<a href="javascript:void(0)" class="delete-card" data-card-id={{$card->card_id}}>
													<i class="fas fa-trash-alt"></i>
												</a>
											</div>
										</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
						{{-- <button type="button" class="add-payment-new">Add A New Payment Method</button> --}}
						<a href="{{route('customer.cards.create')}}" class="add-payment-new">Add New Card</a>
					</div>
				</div>
				@include('customer-layouts.right-sidebar')
			</div>
		</div>
	</div>
</section>
@endsection

@section('scripts')
	<script src="{{asset('assets/customer/js/custom-js/card/index.js')}}"></script>
@endsection
