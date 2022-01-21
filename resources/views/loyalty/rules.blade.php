@extends('layouts.app')

@section('content')
    <section id="wrapper">
        <div class="d-lg-block d-sm-none d-md-none header-sidebar-menu">
            @include('layouts.sidebar')
            <div id="navbar-wrapper">
                <nav class="navbar navbar-inverse">
                    <div class="container-fluid">
                        <div class="navbar-header">
                            <div class="profile-title-new">
                                <a href="{{ url()->previous() }}" class="sidebar-left-inner-blog"><i
                                        class="fa fa-angle-left"></i></a>
                                <h2>Loyalty Rules</h2>
                            </div>
                            <div class="add-campaign-blog">
                                <button class="add-campaign product-quantity-plus" data-toggle="modal"
                                    data-target="#addRule">Add
                                    Loyalty Rules</button>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
        <div class="dashboard category content-wrapper pt-1">
            <div class="dashboard promotions">
                @include('common.flashMessage')
                <div class="dash-second">
                    <div class="container-fluid">
                        <div class="profile-inner-blog py-3">
                            <h2>Loyalty Rules List </h2>
                        </div>
                        <div class="number-table number-blog-table">
                            <table class="table">
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
                                                @foreach ($rules->rulesItems as $itemkey => $items)
                                                    @if ($itemkey == 0)
                                                        {{$items->categories->category_name}} :    
                                                    @endif
                                                    @foreach ($items->menuItems as $menukey => $item)
                                                        {{$item->item_name}},
                                                    @endforeach    
                                                @endforeach
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
                                                <button class="btn-edit btn-inner product-quantity-plus1"
                                                    data-rule-id="{{ $rules->rule_id }}">Edit</button>
                                                <button class="btn-delete" data-rule-id="{{ $rules->rules_id }}"
                                                    data-rule-point="{{ $rules->point }}">Delete</button>
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
    <div class="modal modal-inner-third-vlog" style="display: none;" aria-hidden="true" id="addRule">
        <div class="modal-dialog modal-dialog-centered modal-inner-system" role="document">
            <div class="modal-content">
                <div class="modal-body modal-inner-blog">
                    <h6 id="modal-title">Add Loyalty Rules</h6>
                    {{ Form::open(['route' => ['loyalty.rules.add'], 'id' => 'loyalty-rule-add', 'method' => 'POST']) }}
                    <input type="hidden" name="rule_id" id="ruleId">
                    <div class="form-group">
                        <input type="number" name="point" class="form-control" placeholder="Add Points" min="1"
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
    <div id="editMenuItemModal">
        <div class="modal second-part" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-inner-system" role="document">
                <div class="modal-content modal-conting-blog">

                    <div class="modal-body modal-inner-blog">
                        <h6>Seleted Items </h6>
                        <div class="content">
                            <div class="table-scroll-y-blog table-active-blog">
                                <table class="table-inner-sec">
                                    @foreach ($categories as $item)
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
                                                        <div
                                                            class="form-item form-type-checkbox form-item-node-types-forum subOption">
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
                                    @endforeach
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
    <script src="{{ asset('assets/js/loyalty/rules.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\LoyaltyRuleRequest', '#loyalty-rule-add') !!}
@endsection
