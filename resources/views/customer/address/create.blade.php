@extends('customer-layouts.app')

@section('content')
	<div class="add-address-banner wd-dr-inner-blog">
        <div class="container">
           <div class="wd-dr-chat-left">
				<div class="wd-dr-chat-inner"> 
					<h1>
						Address
					</h1>
				</div>
				<div class="clearfix"></div>
			</div>
        </div>
    </div>

	<div class="container search-address">
	    <div class="jumbotron">
	        <div class="row">
	            <div class="col-sm-12">
	                <form>
	                    <input type="text" class="form-control s-address" ng-model="ctrl.searchService.searchTerm" ng-change="ctrl.search()" name="autocomplete" id="searchTextField" placeholder="Search Address" />
	                    <a class="glyphicon glyphicon-remove form-control-feedback form-control-clear" ng-click="ctrl.clearSearch()" style="pointer-events: auto; text-decoration: none;cursor: pointer;"></a>
	                </form>
	                <h3>
	                    Additional Information
	                </h3>
	                <form action="{{route('customer.address.store')}}" method="post" id="createAddress">
	                	@csrf
	                    <div class="form-group">
	                        <input type="text" class="form-control address" name="address" id="addressTextBox" placeholder="Address">
	                        @error('address')
	                        	<span class="error">{{$message}}</span>
	                        @enderror
	                    </div>
	                    <div class="row form-group">
	                        <div class="col-sm-6">
	                            <input type="text" class="form-control address" name="address_type" placeholder="Address Type (Work / Home Etc)">
	                            @error('address_type')
	                            	<span class="error">{{$message}}</span>
	                            @enderror
	                        </div>
	                        <div class="col-sm-6">
	                            <input type="text" class="form-control address" name="zipcode" placeholder="Zipcode">
	                            @error('zipcode')
	                            	<span class="error">{{$message}}</span>
	                            @enderror
	                        </div>
	                    </div>
	                    <input type="hidden" name="lat" id="latitude">
	                    <input type="hidden" name="long" id="longitude">
	                    <input type="hidden" name="state" id="stateName">
	                    <input type="hidden" name="city" id="cityName">
	                    <div class="row form-group">
	                        <div class="col-md-6 col-md-offset-3">
	                            <button type="submit" class="btn btn-primary btn-lg add-address" alt="Add Address"> Add Address </button>
	                        </div>
	                    </div>
	                </form>
	            </div>
	        </div>
	    </div>
	</div>
@endsection

@section('scripts')
	<script src="{{asset('assets/customer/js/jquery.validate.min.js')}}"></script>
	<script src="{{asset('assets/customer/js/additional-methods.min.js')}}"></script>
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCQ9SQuWVAgTYy7c5aYea7PdW3j-hAMFmY&libraries=places"></script>
	<script src="{{asset('assets/customer/js/address/create.js')}}"></script>
@endsection
	
	