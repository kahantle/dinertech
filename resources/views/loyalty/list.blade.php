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
                            {{-- <div class="add-campaign-blog">
                                <a href="{{ route('loyalty.rules') }}"><button class="add-campaign">Loyalty
                                        Rules</button></a>
                            </div> --}}
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

                    {{-- <div class="row"> --}}
                        {{-- <div class="col-xl-9 col-lg-8 col-md-12 profile-two-inner profile-third-inner">
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
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                    {{-- </div> --}}
                    <div class="row my-4 profile-two-inner profile-third-tinner-blog d-flex align-itemes-center justify-content-center">
                        <div class="col-lg-3 col-lg-two-inner">
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
                        <div class="col-lg-3 col-lg-two-inner">
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
                        <div class="col-lg-3 col-lg-two-inner">
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
                <div class="dash-second mt-4 rounded">
                    <!-- Loyalties Programs Start -->
                    <div class="container-fluid">
                        <div class="profile-inner-blog pt-2 pb-1">
                            <h2>Current Loyalty Programs </h2>
                        </div>
                        <div class="number-table">
                            <table class="table table-responsive-blog">
                                <thead>
                                    <tr>
                                        <th scope="col" class="dr-title-blog dr-inner-d-first">Title</th>
                                        <th scope="col" class="dr-title-blog dr-c-blog dr-inner-d-first">Details</th>
                                        <th scope="col" class="dr-inner-t-blog text-center dr-inner-d-first-tittle">Status</th>
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
                    <!-- Loyalties Programs End -->
                </div>
                <div class="dash-second mt-4 rounded">
                    <!-- Loyalties Rules Start -->
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="profile-inner-blog">
                                    <h2 class="m-0">Loyalty Rules List </h2>
                                </div>
                            </div>
                            <div class="col-md-6 text-right">
                                <div class="add-campaign-blog">
                                    <button class="add-campaign product-quantity-plus" data-toggle="modal"
                                        data-target="#addRule">Add
                                        Loyalty Rules</button>
                                </div>
                            </div>
                        </div>
                        <div class="number-table">
                            <table class="table table-responsive-blog">
                                <thead>
                                    <tr>
                                        <th scope="col" class="dr-title-t-inner-blog d-campaign-inner rules-blog-first">
                                            Points</th>
                                        <th scope="col" class="dr-title-t-inner-blog d-status-inner-blog rules-blog-second">
                                            Items
                                        </th>
                                        <th scope="col" class="dr-title-t-inner-blog d-creates rules-blog-third"></th>
                                    </tr>
                                </thead>
                            </table>
                            @foreach ($loyaltyRules as $rules)
                                <table class="table table-responsive">
                                    <tbody>
                                        <tr class="header-url header-desk-board">
                                            <td class="inner-second-rules-inner "><span class="order-numerber-blog "></span>
                                                <p class="m-0 pl-5 ">{{ $rules->point }} Points </p>
                                            </td>

                                            <td class="reports-blog-swc">
                                                <span class="more">
                                                    @foreach ($rulesItems[$rules->rules_id] as $categoryName => $items)
                                                        {{$categoryName}} :
                                                        @php
                                                            $menu = implode(", ",$items);
                                                        @endphp
                                                        {{$menu}},<br>
                                                    @endforeach
                                                </span>
                                            </td>
                                            <td class="btn-blog-group btn-rules-desktop btn-rules-desktop btn-rules-desktop">
                                                <button class="btn-edit btn-inner product-quantity-plus1 edit-rule"
                                                    data-rule-id="{{ $rules->rules_id }}">Edit</button>
                                                <button class="btn-delete delete-rule"
                                                    data-rule-id="{{ $rules->rules_id }}"
                                                    data-rule-point="{{ $rules->point }}">Delete</button>
                                            </td>
                                        </tr>
                                        <tr class="mobile-inner-blog">
                                            <td>
                                                <button class="btn-edit btn-inner edit-rule product-quantity-plus1"
                                                    data-rule-id="{{ $rules->rule_id }}">Edit</button>
                                                <button class="btn-delete delete-rule" data-rule-id="{{ $rules->rules_id }}"
                                                    data-rule-point="{{ $rules->point }}">Delete</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            @endforeach
                        </div>
                    </div>
                    <!-- Loyalties Rules End -->
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
                    <form action="{{route('loyalty.rules.delete')}}" method="POST">
                        @csrf
                        <input type="hidden" name="rule_id" id="rule_id">
                        <div class="modal-footer-blog">
                            <button type="submit" class="btn btn-first btn-yes">Yes</button>
                            <button type="button" class="btn btn-second" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Loyalties Rules Modal -->
    <div class="modal modal-inner-third-vlog" style="display: none;" aria-hidden="true" id="addRule">
        <div class="modal-dialog modal-dialog-centered modal-inner-system" role="document">
            <div class="modal-content">
                <div class="modal-body modal-inner-blog">
                    <h6 id="modal-title">Add Loyalty Rules</h6>
                    {{ Form::open(['route' => ['loyalty.rules.add'], 'id' => 'loyalty-rule-add', 'method' => 'POST']) }}
                        <input type="hidden" name="rule_id" id="ruleId">
                        <div class="form-group">
                            <input type="number" name="point" class="form-control set-point" placeholder="Add Points" min="1"
                                id="points">
                        </div>
                        <div class="form-group form-item form-type-textfield form-item-count-checked-checkboxes">
                            <input type="text" id="count-checked-checkboxes" name="menuItems"
                                placeholder="Selected Category Or Menu Items" value="" size="60" maxlength="50"
                                class="choose-blog form-text required">
                            <input type="hidden" name="items" id="items-ids">
                            <input type="hidden" name="categoryIds" id="categoryIds">
                        </div>
                        <div class="modal-footer-blog">
                            <button type="submit" class="btn btn-first modal-submit">Add Loyalty</button>
                            <button type="button" class="btn btn-second btn-d-inner-blog cancel-button add-rule">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Select Items Pop Up --}}
    <div id="editMenuItemModal">
        <div class="modal second-part" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-inner-system" role="document">
                <div class="modal-content modal-conting-blog">
                    <div class="modal-body modal-inner-blog">
                        <h6>Seleted Items </h6>
                        <div class="content">
                            <div class="table-scroll-y-blog table-active-blog">
                                <table class="table-inner-sec">

                                    @if (count($categories) > 1)
                                        @foreach ($categories as $item)
                                            @if (count($item->category_item) != 0)
                                                <tbody class="t-b-blog">
                                                    <tr class="odd">
                                                        <td class="table-tag-blog add">
                                                            <div>
                                                                <input type="checkbox" class="selectall inner-checkin-blog"
                                                                    data-category-id="{{ $item->category_id }}"
                                                                    id="modifier-group-{{ $item->category_id }}">
                                                            </div>
                                                        </td>
                                                        <td class="forum-topic-blog">{{ $item->category_name }}</td>
                                                    </tr>
                                                    @foreach ($item->category_item as $menuItem)
                                                        <tr class="even">
                                                            <td class="table-tag add">
                                                                <div class="form-item form-type-checkbox form-item-node-types-forum subOption">
                                                                    <input type="checkbox" id="edit-node-types-forum"
                                                                        name="modifier_item" value="forum"
                                                                        class="form-checkbox individual inner-checkin-blog item-group-{{ $menuItem->category_id }}"
                                                                        data-item-id={{ $menuItem->menu_id }}
                                                                        data-category-id="{{ $menuItem->category_id }}">
                                                                </div>
                                                            </td>
                                                            <td class="forum-topic-blog">
                                                                {{ $menuItem->item_name }}
                                                            </td>
                                                            <td class="forum-blog">
                                                                <small>${{ number_format($menuItem->item_price, 2) }}</small>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            @endif
                                        @endforeach
                                    @else
                                        <div style="text-align: center;">
                                            <span>Data Not Found</span>
                                        </div>
                                    @endif
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer-blog">
                        <button type="button" class="btn btn-first second-close count-item">Add </button>
                        <button type="button" class="btn btn-second second-cancle-in modifier-modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteModal" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-inner-system" role="document">
            <div class="modal-content">
                <div class="modal-body modal-inner-blog modal-fif-blog">
                    <h6>Are you sure? </h6>
                    <p id="deleteMessage"></p>
                    <form action="{{ route('loyalty.rules.delete') }}" method="POST">
                        @csrf
                        <input type="hidden" name="rule_id" id="rule_id">
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
<script src="{{ asset('assets/js/loyalty/rules.js') }}"></script>
{{-- <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script> --}}
{{-- {!! JsValidator::formRequest('App\Http\Requests\LoyaltyRequest', '#addOrderLoyaltyPoint') !!} --}}
    {{-- {!! JsValidator::formRequest('App\Http\Requests\LoyaltyAmountRequest', '#addAmountLoyalty') !!} --}}
    {{-- {!! JsValidator::formRequest('App\Http\Requests\LoyaltyRequest', '#addCategoryLoyalty') !!} --}}
@endsection
