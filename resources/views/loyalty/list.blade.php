@extends('layouts.app')

@section('css')
    <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <section id="wrapper">
        <div class="d-lg-block d-sm-none d-md-none header-sidebar-menu">
            @include('layouts.sidebar')
            <div id="navbar-wrapper">
                <nav class="navbar navbar-inverse">
                    <div class="container-fluid">
                        <div class="navbar-header">
                            <div class="profile-title-new">
                                <a href="#" class="navbar-brand sidebar-nav-blog" id="sidebar-toggle"><i
                                        class="fa fa-bars"></i></a>
                                <h2>Loyalty</h2>
                            </div>
                            <div class="add-campaign-blog">
                                <a href="{{ route('loyalty.rules') }}"><button class="add-campaign">Loyalty
                                        Rules</button></a>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
        <div class="dashboard category content-wrapper pt-1">
            @include('common.flashMessage')
            <div class="dashboard promotions">
                <div class="container-fluid">
                    <div class="profile-inner-blog mb-4">
                        <h2>Select Loyalty Type </h2>
                        <p>Your Loyality type determines how your customers will earn points and rewards.</p>
                    </div>

                    <div class="row">
                        <div class="col-xl-9 col-lg-8 col-md-12 profile-two-inner profile-third-inner">
                            <div class="row my-4">
                                <div class="col-lg-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <h6>Number of Orders</h6>
                                            <p>Customers earn points for each order they place.</p>
                                            <div class="add-order-button">
                                                <a href="javascript:;" class="add-loyalty-blog" data-toggle="modal"
                                                    data-target="#orderLoyalty">Add Loyalty</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <h6>Amount Spent</h6>
                                            <p>Customers earn points for each dollar they spend.</p>
                                            <div class="add-order-button">
                                                <a href="javascript:;" class="add-loyalty-blog" data-toggle="modal"
                                                    data-target="#amount_spent">Add Loyalty</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <h6>Category Based </h6>
                                            <p>Customers earn points for items purchased from select categories.</p>
                                            <div class="add-order-button">
                                                <a href="javascript:;" class="add-loyalty-blog" data-toggle="modal"
                                                    data-target="#category_based">Add Loyalty</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-md-12 product-details-blog-f">
                            <div class="wd-dr-current-plan wd-plan-first m-0">
                                <div class="card wd-dr-current-first">
                                    <div class="card-body">
                                        <p>Plan price: <span>&nbsp;${{$subscription['price']}} / {{ucfirst(strtolower($subscription['type']))}}</span></p>
                                        <p>Billing cycle:<span>&nbsp;{{$subscription['start_date']}} to {{$subscription['end_date']}} </span></p>
                                    </div>
                                    <div class="card-footer-inner-first">
                                        <a href="{{route('loyalty.plan.cancel',$subscription['stripe_subscription_id'])}}" class="mr-3">
                                            <button type="button" class="upgrade-plan-bog">Cancel Plan</button>
                                        </a>
                                        {{-- <a href="javascripts:;">
                                            <button type="button" class="upgrade-plan-bog">Upgrade
                                                Plan</button>
                                        </a> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="dash-second mt-4">
                    <div class="container-fluid">
                        <div class="profile-inner-blog pt-2 pb-1">
                            <h2>Loyalty List </h2>
                        </div>
                        <div class="number-table">
                            <table class="table table-responsive-blog">
                                <thead>
                                    <tr>
                                        <th scope="col" class="dr-title-blog dr-inner-d-first">Title</th>
                                        <th scope="col" class="dr-title-blog dr-c-blog dr-inner-d-first">Details</th>
                                        <th scope="col" class="dr-inner-t-blog text-center dr-inner-d-first">Status</th>
                                    </tr>
                                </thead>
                            </table>
                            @foreach ($loyalties as $item)
                                <table class="table table-responsive">
                                    <tbody>
                                        <tr class="header-url header-desk-board header-desk-board">
                                            <td class="inner-second-blog inner-second-d-blog">
                                                <span class="order-numerber-blog"></span>
                                                @if ($item->loyalty_type == Config::get('constants.LOYALTY_TYPE.NO_OF_ORDERS'))
                                                    <p class="m-0">{{Config::get('constants.LOYALTY_TYPE.NO_OF_ORDERS')}}</p>
                                                @elseif ($item->loyalty_type == Config::get('constants.LOYALTY_TYPE.AMOUNT_SPENT'))
                                                    <p class="m-0">{{Config::get('constants.LOYALTY_TYPE.AMOUNT_SPENT')}}</p>
                                                @elseif ($item->loyalty_type == Config::get('constants.LOYALTY_TYPE.CATEGORY_BASED'))
                                                    <p class="m-0">{{Config::get('constants.LOYALTY_TYPE.CATEGORY_BASED')}}</p>
                                                @endif
                                            </td>
                                            <td class="inner-blog inner-first-blog inner-second-d-blog">{{$item->point}}</td>
                                            <td class="check-d-blog">
                                                <input type="checkbox" class="check-inner change-status" id="status-{{$item->loyalty_id}}" @if($item->status == Config::get('constants.STATUS.ACTIVE')) checked @endif data-loyalty-id="{{$item->loyalty_id}}">
                                                <label for="status-{{$item->loyalty_id}}" class="check-one"></label>
                                                <button class="btn-edit btn-edit-inner-desk edit-loyalty" data-loyalty-id="{{$item->loyalty_id}}" data-loyalty-type="{{$item->loyalty_type}}">Edit</button>
                                                <button class="btn-delete btn-edit-inner-desk delete-loyalty" data-loyalty-id="{{$item->loyalty_id}}" data-loyalty-type="{{$item->loyalty_type}}">Delete</button>
                                            </td>
                                        </tr>
                                        <tr class="mobile-inner-blog">
                                            <td>
                                                <button class="btn-edit btn-edit-inner-mobile btn-example-edit-blog edit-loyalty" data-loyalty-id="{{$item->loyalty_id}}" data-loyalty-type="{{$item->loyalty_type}}">Edit</button>
                                                <button class="btn-delete btn-edit-inner-mobile delete-loyalty" data-loyalty-id="{{$item->loyalty_id}}" data-loyalty-type="{{$item->loyalty_type}}">Delete</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>        
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" id="orderLoyalty" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-inner-system" role="document">
            <div class="modal-content">
                <div class="modal-body modal-inner-blog">
                    <h6>No Of Orders </h6>
                    <p>Reward customers every time they make a new Orders.</p>
                    {{-- <form id="addOrderLoyalty" method="POST" action="{{route('loyalty.add')}}"> --}}
                    {{ Form::open(['route' => ['loyalty.add'], 'id' => 'addOrderLoyaltyPoint', 'method' => 'POST']) }}
                        <input type="hidden" name="loyaltyId" class="loyalty-id">
                        <div class="form-group">
                            <input type="number" class="form-control" name="no_of_order" placeholder="Enter Number Of Orders" id="noOfOrders">
                        </div>
                        <div class="form-group">
                            <input type="number" class="form-control" name="point" placeholder="Enter Number Of Loyalty Points" id="points">
                            <input type="hidden" name="loyalty_type" value="{{Config::get('constants.LOYALTY_TYPE.NO_OF_ORDERS')}}">
                        </div>
                        <div class="modal-footer-blog">
                            <button type="submit" class="btn btn-first loyalty-edit">Add Loyalty</button>
                            <button type="button" class="btn btn-second" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="amount_spent" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-inner-system" role="document">
            <div class="modal-content">
                <div class="modal-body modal-inner-blog">
                    <h6>Amount Spent</h6>
                    <p>Reward customers every time they make a new Orders.</p>
                    <form id="addAmountLoyalty" method="POST" action="{{route('loyalty.add')}}">
                        @csrf
                        <input type="hidden" name="loyaltyId" class="loyalty-id">
                        <input type="hidden" name="loyalty_type" value="{{Config::get('constants.LOYALTY_TYPE.AMOUNT_SPENT')}}">
                        <div class="form-group">
                            <input type="number" class="form-control" name="amount" placeholder="Enter Amount" id="amount">
                        </div>

                        <div class="form-group">
                            <input type="number" class="form-control" name="point" placeholder="Enter Number Of Loyalty points" min="1" id="amount-points">
                        </div>
                    
                        <div class="modal-footer-blog">
                            <button type="submit" class="btn btn-first loyalty-edit">Add Loyalty</button>
                            <button type="button" class="btn btn-second" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="category_based" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-inner-system" role="document">
            <div class="modal-content">
                <div class="modal-body modal-inner-blog">
                    <h6>Category Based</h6>
                    <p>Reward customers every time they make a new Orders.</p>
                    <form action="{{ route('loyalty.add')}}" method="POST" id="addCategoryLoyalty">
                        @csrf
                        <input type="hidden" name="loyaltyId" class="loyalty-id">
                        <input type="hidden" name="loyalty_type" value="{{Config::get('constants.LOYALTY_TYPE.CATEGORY_BASED')}}">
                        <div class="form-group select-inst-blog">
                            <select class="select2 form-control" multiple="multiple" name="categories[]" id="categories">
                                <option value="">Select</option>
                                @foreach ($categories as $category)
                                    <option value="{{$category->category_id}}">{{$category->category_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group from-points-blog">
                            <input type="number" class="form-control" name="point"
                                placeholder="Enter Number Of Loyalty Points" min="1" id="category-points">
                        </div>
                    
                        <div class="modal-footer-blog">
                            <button type="submit" class="btn btn-first loyalty-edit">Add Loyalty</button>
                            <button type="button" class="btn btn-second" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-inner-system" role="document">
            <div class="modal-content">
                <div class="modal-body modal-inner-blog modal-fif-blog">
                    <h6>Are you sure? </h6>
                    <p id="delete-message"></p>
                    <form action="{{route('loyalty.delete')}}" method="POST">
                        @csrf
                        <input type="hidden" name="loyaltyId" id="loyaltyId">
                        <div class="modal-footer-blog">
                            <button type="submit" class="btn btn-first btn-yes">Yes</button>
                            <button type="button" class="btn btn-second" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script src="{{ asset('assets/js/select2.min.js') }}"></script>
<script src="{{ asset('assets/js/loyalty/list.js') }}"></script>
{{-- <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script> --}}
{{-- {!! JsValidator::formRequest('App\Http\Requests\LoyaltyRequest', '#addOrderLoyaltyPoint') !!} --}}
    {{-- {!! JsValidator::formRequest('App\Http\Requests\LoyaltyAmountRequest', '#addAmountLoyalty') !!} --}}
    {{-- {!! JsValidator::formRequest('App\Http\Requests\LoyaltyRequest', '#addCategoryLoyalty') !!} --}}
@endsection
