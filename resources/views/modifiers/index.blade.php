{{-- @extends('layouts.app')
@section('content')
    <section id="wrapper">
        @include('layouts.sidebar')
        <div id="navbar-wrapper">
            <nav class="navbar navbar-inverse">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <div class="profile-title-new">
                            <a href="javaScript:void(0);" class="navbar-brand" id="sidebar-toggle"><i
                                    class="fa fa-bars"></i></a>
                            <h2>Modifiers / Add- ons</h2>
                        </div>
                        <div class="plus">
                            <a href="javaScript:void(0);" class="openModifierForm open"><i class="fa fa-plus"
                                    aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
        <div class="dashboard category modifiers-ctm content-wrapper">
            <div class="container">
                @include('common.flashMessage')
                @if ($modifiers)
                    <div id="accordion" class="accordion">
                        @foreach ($modifiers as $item)
                            <div class="order">
                                <div class="collapsed a-order" data-toggle="collapse"
                                    href="#collapseOne{{ $item->modifier_group_name }}">
                                    <div class="order-name">
                                        <div class="circle"></div>
                                        <h4>{{ $item->modifier_group_name }}</h4>
                                    </div>
                                    <div class="order-detail">
                                        <div class="bage_main">
                                            <a href="javaScript:void(0);"
                                                class="ml-1 badge badge-info">{{ $item->modifier_item->count() }}</a>
                                        </div>
                                        <div class="order-icons icon_add_item">
                                            <a href="#modifierItem" class="openModifierItemForm open"
                                                data-id={{ $item->modifier_group_id }}>Add Item <i class="fa fa-plus"
                                                    aria-hidden="true"></i></a>
                                        </div>
                                        <div class="order-icons">
                                            <a data-route="{{ route('edit.modifier.post', [$item->modifier_group_id]) }}"
                                                href="javaScript:void(0);" class="openModifierForm action-edit"><i
                                                    class="fa fa-pencil" aria-hidden="true"></i></a>
                                            <a data-route="{{ route('delete.modifier.post', [$item->modifier_group_id]) }}"
                                                href="javaScript:void(0);" class="delete action-delete"><i
                                                    class="fa fa-trash" aria-hidden="true"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div id="collapseOne{{ $item->modifier_group_name }}" class="collapse c-order"
                                    data-parent="#accordion">
                                    @foreach ($item->modifier_item as $item)
                                        <div class="child">
                                            <div class="order-name">
                                                <div class="circle"></div>
                                                <h4>{{ $item->modifier_group_item_name }}</h4>
                                            </div>
                                            <div class="order-detail">
                                                <div class="number">
                                                    <p>${{ number_format($item->modifier_group_item_price, 2) }}</p>
                                                </div>
                                                <div class="order-icons">
                                                    <a data-route="{{ route('edit.modifier.item.post', $item->modifier_item_id) }}"
                                                        href="javaScript:void(0);"
                                                        class="openModifierItemForm action-edit"><i class="fa fa-pencil"
                                                            aria-hidden="true"></i></a>
                                                    <a data-route="{{ route('delete.modifier.item.post', [$item->modifier_item_id]) }}"
                                                        href="javaScript:void(0);" class="delete action-delete"><i
                                                            class="fa fa-trash" aria-hidden="true"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="float-right"> {{ $modifiers->links() }}</div>
                @else
                    <p>No records found.</p>
                @endif
            </div>
    </section>

    <div id="modifierGroupPopUp" class="modifierGroupPopUp closeAllModal overlay w-100">
        <div class="popup text-center">
            <a class="close closeModal" href="javaScript:void(0);">&times;</a>
            <div class="content">
                <h5 class="groupHeading">Add A Modifier Group</h5>
                {{ Form::open(['route' => ['add.modifier.post'], 'id' => 'modifierForm', 'method' => 'POST', 'class' => '']) }}
                <div class="form-group">
                    <input type="hidden" id="modifier_group_id" name="modifier_group_id" />
                    <h5 class="modifier_sub_title">Modifier Group Name</h5>
                    <input type="text" class="form-control" id="modifier_group_name" name="modifier_group_name"
                        placeholder="Modifier Group Name">
                </div>
                <div class="form-group form-check-insides">
                    <input type="checkbox" class="styled-checkbox is_required" id="allow_multiple1" name="is_required" />
                    <label for="allow_multiple1"></label>
                    <p>Required <br> <span class="font-small"> If Selected, customer must complete modifier selection before
                            proceeding</span> </p>
                </div>
                <div class="form-group form-check-insides">
                    <input type="radio" id="single_modifier" name="allow_multiple" checked
                        class="modifier_type styled-radio-button"
                        value="{{ Config::get('constants.MODIFIER_TYPE.SINGLE_MODIFIER') }}" />
                    <label for="single_modifier"></label>
                    <p>Single Modifier Section <br> <span class="font-small">If selected, customer may select one modifier
                            from this group</span> </p>

                </div>
                <div class="form-group form-check-insides">
                    <input type="radio" id="multiple_modifier" name="allow_multiple"
                        class="modifier_type styled-radio-button"
                        value="{{ Config::get('constants.MODIFIER_TYPE.MULTIPLE_MODIFIER') }}" />
                    <label for="multiple_modifier"> </label>
                    <p>Multiple Modifiers Section <br> <span class="font-small">If selected, customer may select multiple
                            modifiers from this group</span> </p>
                </div>
                <div class="form-group form-align-blog row align-items-center d-none" id="min_max_modifierBox">
                    <input type="number" class="form-control input-first" id="minimum" placeholder="min"
                        min="1" name="minimum">
                    <span class="px-3">to</span>
                    <input type="number" class="form-control input-second" id="maximum" placeholder="max"
                        min="1" name="maximum">
                    <span class="pl-3">modifiers from this group</span>
                </div>
                <div class="btn-custom">
                    <button class="groupBtn btn-blue"><span>Add</span></button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <div id="openModifierItemFormPopUp" class="openModifierItemFormPopUp closeAllModal overlay w-100">
        @include('common.flashMessage')
        <div class="popup text-center">
            <a class="close closeModal" href="javaScript:void(0);">&times;</a>
            <div class="content">
                <h5 class="itemHeading">Add modifier item</h5>
                {{ Form::open([
                    'route' => ['add.modifier.item.post'],
                    'id' => 'modifierItemForm',
                    'method' => 'POST',
                    'class' => '',
                ]) }}
                <div class="form-group">
                    <input type="text" class="form-control" id="modifier_group_item_name"
                        name="modifier_group_item_name" placeholder="Enter Modifier Item Name">
                </div>
                <div class="form-group">
                    <input type="hidden" id="modifier_item_group_id" name="modifier_item_group_id" />
                    <input type="hidden" id="modifier_item_id" name="modifier_item_id" />
                    <input type="text" class="form-control" id="modifier_group_item_price"
                        name="modifier_group_item_price" placeholder="Enter Modifier Price">
                </div>
                <div class="btn-custom">
                    <button class="btn-blue itemBtn"><span>Add</span></button>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\ModifierGroupRequest', '#modifierForm') !!}
    {!! JsValidator::formRequest('App\Http\Requests\ModifierItemPriceRequest', '#modifierItemForm') !!}
    <script src="{{ asset('/assets/js/modifier.js') }}"></script>
@endsection --}}

<style>
    .customeInput{
        padding-left: 20px;
		border-radius: 15px;
		height: 60px;
		padding-top: 15px;
		padding-bottom: 15px;
		box-shadow: none;
		background: transparent;
		border: 2px solid #495057;
		font-family: 'SFProDisplay-Bold';
		font-size: 18px;
		-webkit-appearance: none;
    }

    .btc {
        color: black;
    }

    .blue-btn {
        	position: relative;
		font-family: 'SFProDisplay-Regular';
		font-size: 20px;
		display: inline-block;
		overflow: hidden;
		padding: 14px 30px;
		font-weight: 600;
		letter-spacing: 0.02em;
		background: #5e5ed6;
		transition: 0.5s ease-in-out;
		color: #fff;
		cursor: pointer;
		border-radius: 100px;
		width: 100%;
		text-align: center;
		border: 0 !important;
		outline: 0 !important;
		box-shadow: none !important;
    }

    .small-blue-btn {
        background: #5e5ed6 !important;
        border-radius: 100px !important;
    }

    div.displayNone {
        display: none;
    }
</style>

@extends('layouts.app')
@section('content')
    <section id="wrapper">
        @include('layouts.sidebar')
        <div id="navbar-wrapper">
            <nav class="navbar navbar-inverse">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <div class="profile-title-new">
                            <a href="javaScript:void(0);" class="navbar-brand" id="sidebar-toggle"><i
                                    class="fa fa-bars"></i></a>
                            <h2>Modifiers / Add- ons</h2>
                        </div>
                        <div class="plus">
                            <a href="javaScript:void(0);" data-toggle="modal" data-target="#AddModifierGroup"><i class="fa fa-plus" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>
            </nav>
        </div>

        <div class="dashboard category modifiers-ctm content-wrapper">
            <div class="container">
                @include('common.flashMessage')
                @if ($modifiers)
                    <div id="accordion" class="accordion">
                        @foreach ($modifiers as $item)
                            <div class="order">
                                <div class="collapsed a-order" data-toggle="collapse"
                                    href="#collapseOne{{ $item->modifier_group_name }}">
                                    <div class="order-name">
                                        <div class="circle"></div>
                                        <h4>{{ $item->modifier_group_name }}</h4>
                                    </div>
                                    <div class="order-detail">
                                        <div class="bage_main">
                                            <a href="javaScript:void(0);"
                                                class="ml-1 badge badge-info">{{ $item->modifier_item->count() }}</a>
                                        </div>
                                        <div class="order-icons icon_add_item">
                                            <span style="margin-right: 15px !important;" data-id="{{ $item->modifier_group_id }}" class="AddModifierItemBtn">Add Item <i class="fa fa-plus" aria-hidden="true"></i></span>
                                        </div>
                                        <div class="order-icons">
                                            <a href="javaScript:void(0);" data-id="{{ $item->modifier_group_id }}" class="action-edit EditModifierBtn"><i class="fa fa-pencil" aria-hidden="true"></i></a>

                                            {{-- <a data-route="{{ route('delete.modifier.post', [$item->modifier_group_id]) }}" href="javaScript:void(0);" class="delete action-delete"><i class="fa fa-trash" aria-hidden="true"></i></a> --}}
                                            <a href="javaScript:void(0);" data-id="{{ $item->modifier_group_id }}" class="delete action-delete confirmDelete"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                        </div>
                                    </div>
                                </div>

                                <div id="collapseOne{{ $item->modifier_group_name }}" class="collapse c-order_{{ $item->modifier_group_id }}"
                                    data-parent="#accordion">

                                    <div class="d-flex justify-content-between my-2" style="width: 93%;">
                                        <div>
                                            <button class="btn btn-link dropdown-toggle filterName" id-filterd="{{ $item->modifier_group_id }}">Item Name</button>
                                        </div>
                                        <div>
                                            <button class="btn btn-link dropdown-toggle filterPrice" id-filterd="{{ $item->modifier_group_id }}">Price</button>
                                            <button class="btn btn-success saveModifierItems" id-filterd="{{ $item->modifier_group_id }}">Save</button>
                                        </div>

                                    </div>

                                    <div class="rolleplay sortable sortable_{{ $item->modifier_group_id }}">
                                        @foreach ($item->modifier_item_custome as $item)
                                            {{-- <div class="child" item_name ={{ $item->modifier_group_item_name }} item_price ={{ $item->modifier_group_item_price }}>
                                                <div class="order-name">
                                                    <div class="circle"></div>
                                                    <h4>{{ $item->modifier_group_item_name }}</h4>
                                                </div>
                                                <div class="order-detail">
                                                    <div class="number">
                                                        <p>${{ number_format($item->modifier_group_item_price, 2) }}</p>
                                                    </div>
                                                    <div class="order-icons">
                                                        <a href="javaScript:void(0);" class="action-edit editModifierItemModal" data-id="{{ $item->modifier_item_id }}"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                                        <a href="javaScript:void(0);" class="deleteModifierItem action-delete" data-id="{{ $item->modifier_item_id }}"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                                    </div>
                                                </div>
                                            </div> --}}

                                            <li class="ui-state-default" style=" list-style-type: none;" >
                                                <div class="child" item_name ={{ $item->modifier_group_item_name }} item_price ={{ $item->modifier_group_item_price }}>
                                                    <div class="order-name" id-modId="{{ $item->modifier_item_id }}">
                                                        <div class="circle"></div>
                                                        <h4>{{ $item->modifier_group_item_name }}</h4>
                                                    </div>
                                                    <div class="order-detail">
                                                        <div class="number">
                                                            <p>${{ number_format($item->modifier_group_item_price, 2) }}</p>
                                                        </div>
                                                        <div class="order-icons">
                                                            <a href="javaScript:void(0);" class="action-edit editModifierItemModal" data-id="{{ $item->modifier_item_id }}"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                                            <a href="javaScript:void(0);" class="deleteModifierItem action-delete" data-id="{{ $item->modifier_item_id }}"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="float-right"> {{ $modifiers->links() }}</div>
                @else
                    <p>No records found.</p>
                @endif
            </div>
        </div>
    </section>

    <!-- Add Modifier Group Modal -->
    <div class="modal fade" id="AddModifierGroup" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header ">
                    <h5 class="modal-title btc" id="exampleModalLongTitle">Add Modifier Group</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="m-4" action="" >
                        <div class="form-group">
                            <h5 class="modifier_sub_title btc">Modifier Group Name</h5>
                            <input type="text" class="form-control customeInput" id="modifier_group_name" name="modifier_group_name"
                                placeholder="Modifier Group Name">
                        </div>

                        <div class="form-group d-flex my-4">
                            <input type="checkbox" class="styled-checkbox is_required" id="is_required" name="is_required" />
                            <label for="is_required"></label>
                            <p> <span class="font-weight-bold btc">Required</span> <br> <span class="font-small"> If Selected, customer must complete modifier selection before proceeding</span> </p>
                        </div>

                        <div class="form-group d-flex my-4">
                            <input type="radio" id="single_modifier" name="allow_multiple" checked
                                class="modifier_type styled-radio-button"
                                value="{{ Config::get('constants.MODIFIER_TYPE.SINGLE_MODIFIER') }}" />
                            <label for="single_modifier"></label>
                            <p> <span class="font-weight-bold btc">Single Modifier Section</span> <br> <span class="font-small">If selected, customer may select one modifier from this group</span> </p>
                        </div>

                        <div class="form-group d-flex my-4">
                            <input type="radio" id="multiple_modifier" name="allow_multiple"
                                class="modifier_type styled-radio-button"
                                value="{{ Config::get('constants.MODIFIER_TYPE.MULTIPLE_MODIFIER') }}" />
                            <label for="multiple_modifier"> </label>
                            <p> <span class="font-weight-bold btc">Multiple Modifiers Section</span> <br> <span class="font-small">If selected, customer may select multiple modifiers from this group</span> </p>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="SaveModifierBtn" class="blue-btn" >Add</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modifier Group Modal -->
    <div class="modal fade" id="editModifierGroup" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="btc" id="exampleModalLongTitle">Edit Modifier Group</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form class="m-4" action="" >
                        <div class="form-group">
                            <input type="hidden" id="edit_modifier_group_id" name="edit_modifier_group_id" />
                            <h5 class="modifier_sub_title btc">Modifier Group Name</h5>
                            <input type="text" class="form-control customeInput" id="edit_modifier_group_name" name="edit_modifier_group_name"
                                placeholder="Modifier Group Name">
                        </div>

                        <div class="form-group d-flex my-3">
                            <input type="checkbox" class="styled-checkbox is_required" id="edit_is_required" name="edit_is_required" />
                            <label for="edit_is_required"></label>
                            <p> <span class="font-weight-bold btc">Required</span> <br> <span class="font-small"> If Selected, customer must complete modifier selection before proceeding</span> </p>
                        </div>

                        <div class="form-group d-flex my-3">
                            <input type="radio" id="edit_single_modifier" name="edit_allow_multiple"
                                class="modifier_type styled-radio-button"
                                value="{{ Config::get('constants.MODIFIER_TYPE.SINGLE_MODIFIER') }}" />
                            <label for="edit_single_modifier"></label>
                            <p> <span class="font-weight-bold btc">Single Modifier Section</span> <br> <span class="font-small">If selected, customer may select one modifier from this group</span> </p>
                        </div>

                        <div class="form-group d-flex my-3">
                            <input type="radio" id="edit_multiple_modifier" name="edit_allow_multiple"
                                class="modifier_type styled-radio-button"
                                value="{{ Config::get('constants.MODIFIER_TYPE.MULTIPLE_MODIFIER') }}" />
                            <label for="edit_multiple_modifier"> </label>
                            <p> <span class="font-weight-bold btc">Multiple Modifiers Section</span> <br> <span class="font-small">If selected, customer may select multiple modifiers from this group</span> </p>
                        </div>

                        <div class="form-group form-align-blog row align-items-center" id="edit_min_max_modifierBox">
                            <span class="font-weight-bold btc">Modifier selection range</span>
                            <br> <span class="font-small">you can restrict customer to select limited modifiers.</span>

                            <br>
                            <div class="d-flex">
                                <input type="number" class="form-control " id="minimum" placeholder="min"
                                    min="1" name="minimum">
                                <span class="mx-2">To</span>
                                <input type="number" class="form-control " id="maximum" placeholder="max"
                                    min="1" name="maximum">
                            </div>
                            <span class="">You may selected up to a maximum of <span id='modifierMinMaxCount'>9</span></span><br>
                        </div>
                        <span class="mt-2 text-danger" id="minmaxalert"></span>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="UpdateModifierBtn" class="blue-btn" >Update</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Modifier Group Items Modal -->
    <div class="modal fade" id="AddModifierItemsModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header" style="border-bottom: 0px;">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center mx-4">
                    <span class="h3">Add Modifier Item</span>

                    <div class="mt-3">
                        <div class="form-group">
                            <input type="text" class="form-control" id="modifier_group_item_name"
                            name="modifier_group_item_name" placeholder="Enter Modifier Item Name">
                        </div>

                        <div class="form-group">
                            <input type="hidden" id="modifier_group_id" name="modifier_group_id" />
                            <input type="number" class="form-control" id="modifier_group_item_price"
                                name="modifier_group_item_price" placeholder="Enter Modifier Price">
                        </div>
                    </div>

                    <div class="d-flex justify-content-around">
                        <button type="button" class="btn btn-primary small-blue-btn ModifierAddCommanBtn" data-name="AddClose">Add & Close</button>
                        <button type="button" class="btn btn-primary small-blue-btn ModifierAddCommanBtn" data-name="AddMore">Add More</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modifier Group Items Modal -->
    <div class="modal fade" id="EditModifierItemsModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header" style="border-bottom: 0px;">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center mx-4">
                    <span class="h3">Edit Modifier Item</span>

                    <div class="mt-3">
                        <div class="form-group">
                            <input type="text" class="form-control" id="edit_modifier_group_item_name"
                            name="edit_modifier_group_item_name" placeholder="Enter Modifier Item Name">
                        </div>

                        <div class="form-group">
                            <input type="hidden" id="edit_modifier_item_group_id" name="edit_modifier_item_group_id" />
                            <input type="hidden" id="edit_modifier_item_id" name="edit_modifier_item_id" />
                            <input type="number" class="form-control" id="edit_modifier_group_item_price"
                                name="edit_modifier_group_item_price" placeholder="Enter Modifier Price">
                        </div>
                    </div>

                    <div class="d-flex justify-content-around">
                        <button type="button" class="btn btn-primary small-blue-btn ModifierEditCommanBtn" data-name="AddClose">Update & Close</button>
                        <button type="button" class="btn btn-primary small-blue-btn ModifierEditCommanBtn" data-name="AddMore">Add More</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" type="text/javascript"></script>

<script>
$(document).ready(function() {
    $(function () {
        $(".sortable").sortable({
            placeholder: "ui-state-highlight"
        });
        $(".sortable").disableSelection();
    });

    $(".saveModifierItems").click(function() {
        var corderid = $(this).attr("id-filterd");

        var globleSequence = [];
        $.each($('.sortable_'+corderid).find('li .order-name'), function(key) {
            var sequence = key+1;
            var modifier_item_id = $(this).attr("id-modId");

            var array = {
                'sequence':sequence,
                'modifier_item_id':modifier_item_id
            };

            globleSequence.push(array);
        });

        var url = '{{route('store.modifier.sequence')}}';
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url : url,
            type : 'POST',
            data : {
                'data' : globleSequence,
            },
            dataType:'json',
            success : function(data) {
                if (data.type) {
                    location.reload();
                }
            },

        });

    });

    $(".filterName").click(function() {
        var corderid = $(this).attr("id-filterd");
        var datas = $(".c-order_"+corderid+" div.child");
        var temp = datas.sort(function(a,b){
            return $(b).attr("item_name").localeCompare($(a).attr("item_name"));
            // return parseInt($(b).attr("item_name")) - parseInt($(a).attr("item_name"));
        });
        $(".c-order_"+corderid+" .rolleplay").html(temp);
    });

    $(".filterPrice").click(function() {
        var corderid = $(this).attr("id-filterd");
        var datas = $(".c-order_"+corderid+" div.child");
        var temp = datas.sort(function(a,b){
            return parseInt($(b).attr("item_price")) - parseInt($(a).attr("item_price"));
        });
        $(".c-order_"+corderid+" .rolleplay").html(temp);
    });

    /* Minimum Input Logic */
    $("#minimum").on("keyup change", function(e) {
        var modifierMinMaxCount = $('#modifierMinMaxCount').text();
        var getminimumvalue = $('#minimum').val();
        var getmaximumvalue = $('#maximum').val();

        if (Number(getminimumvalue) <= Number(modifierMinMaxCount)  ) {
            if (getmaximumvalue <= getminimumvalue) {
                $('#maximum').val(getminimumvalue);
            }
            $('#minimum').val(getminimumvalue);

        }else{
            $('#minimum').val(modifierMinMaxCount);
        }
    });

    /* Maximum Input Logic */
    $("#maximum").on("keyup change", function(e) {
        var modifierMinMaxCount = $('#modifierMinMaxCount').text();
        var getminimumvalue = $('#minimum').val();
        var getmaximumvalue = $('#maximum').val();

        if (Number(getminimumvalue) <= Number(getmaximumvalue)) {
            if (Number(getmaximumvalue) <= Number(modifierMinMaxCount)  ) {
                $('#maximum').val(getmaximumvalue);
            }else{
                $('#maximum').val(modifierMinMaxCount);
            }
        }else{
            if (getmaximumvalue) {
                $('#maximum').val(getminimumvalue);
            }
        }
    });

    /* CheckBox Validation */
    $('input[name=edit_allow_multiple]').change(function(){
        var modifierType = $( 'input[name=edit_allow_multiple]:checked' ).val();
        if (modifierType === 'SINGLE') {
            $("#edit_min_max_modifierBox").addClass('d-none');
        } else {
            $("#edit_min_max_modifierBox").removeClass("d-none");
        }
    });

    /* Save Modifier Group Data */
    $("#SaveModifierBtn").click(function () {

        var modifier_group_name = $('#modifier_group_name').val();
        var is_required = 0;
        if ($('#is_required').is(":checked"))
        {
            var is_required = 1;
        }
        var modifier = $('input[name="allow_multiple"]:checked').val();

        var url = '{{route('store.modifier.post')}}';
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url : url,
            type : 'POST',
            data : {
                'modifier_group_name' : modifier_group_name,
                'is_required' : is_required,
                'allow_multiple' : modifier,
                'minimum' : 0,
                'maximum' : 0,
            },
            dataType:'json',
            success : function(data) {
                if (data.type === 'success') {
                    $('#AddModifierGroup').modal('hide');
                    AddModifierItem(data.modifier_group_id);
                }
            },

        });

    });

    /* Open Edit Modal For Modifier Group */
    $(".EditModifierBtn").click(function(){
        var id = $(this).attr("data-id");

        var url = '{{route('edit.modifier.post.new')}}';
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url : url,
            type : 'POST',
            data : {
                'id' : id,
            },
            dataType:'json',
            success : function(responce) {
                if (responce.type == 'success') {
                    var value = responce.data;
                    $('#edit_modifier_group_id').val(value.modifier_group_id);
                    $('#edit_modifier_group_name').val(value.modifier_group_name);

                    if (value.is_required == 1) {
                        $('#edit_is_required').prop('checked', true);
                    }

                    if (value.allow_multiple == 0) {
                        $("#edit_single_modifier").attr('checked', 'checked');
                        $("#edit_min_max_modifierBox").addClass('d-none');
                    } else {
                        $('#edit_multiple_modifier').attr("checked", "checked");
                        $("#edit_min_max_modifierBox").removeClass("d-none");
                        $('#minimum').val(value.minimum);
                        $('#maximum').val(value.maximum);
                        $('#modifierMinMaxCount').html(value.ModifierGroupItemCount);
                    }

                    $('#editModifierGroup').modal('show');
                }
            }
        });
    });

    /* Update Modifier Group Data */
    $("#UpdateModifierBtn").click(function () {

        var modifier_group_id = $('#edit_modifier_group_id').val();
        var modifier_group_name = $('#edit_modifier_group_name').val();
        var minimum = $('#minimum').val();
        var maximum = $('#maximum').val();
        var edit_modifier_group_id = $('#edit_modifier_group_id').val();
        var is_required = 0;
        if ($('#edit_is_required').is(":checked"))
        {
            var is_required = 1;
        }
        var modifier = $('input[name="edit_allow_multiple"]:checked').val();

        if (modifier === 'MULTIPLE') {
            if (minimum && maximum) {
                $('#minmaxalert').html('');
            }else{
                $('#minmaxalert').html('please Insert valid value');
                return false;
            }
        }

        var url = '{{route('store.modifier.post')}}';
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url : url,
            type : 'POST',
            data : {
                'modifier_group_name' : modifier_group_name,
                'is_required' : is_required,
                'allow_multiple' : modifier,
                'minimum' : minimum,
                'maximum' : maximum, 
                'modifier_group_id' : edit_modifier_group_id,
            },
            dataType:'json',
            success : function(data) {
                if (data.type === "success") {
                    location.reload();
                }
            },
            error : function(request,error)
            {

            }
        });

    });

    /* Open Modifier Items Modal */
    $(".AddModifierItemBtn").click(function () {
        var id = $(this).attr("data-id");
        AddModifierItem(id);
    });

    /* Open Modal Add Modifier Item */
    function AddModifierItem(id) {
        $('#modifier_group_id').val(id);
        $('#AddModifierItemsModal').modal('show');
    }

    /* Add Modifier Item */
    $(".ModifierAddCommanBtn").click(function () {
        var btnType = $(this).attr("data-name");

        var modifier_group_id = $('#modifier_group_id').val();
        var modifier_group_item_name = $('#modifier_group_item_name').val();
        var modifier_group_item_price = $('#modifier_group_item_price').val();

        var url = '{{route('add.modifier.item.post.new')}}';
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url : url,
            type : 'POST',
            data : {
                'modifier_item_group_id' : modifier_group_id,
                'modifier_group_item_name' : modifier_group_item_name,
                'modifier_group_item_price' : modifier_group_item_price,
                'btnType' : btnType,
            },
            dataType:'json',
            success : function(responce) {
                if (responce.type == "success") {
                    if (responce.btnType == 'AddClose') {
                        $('#AddModifierItemsModal').modal('hide');
                        location.reload();
                    }else{
                        $('#modifier_group_item_name').val('');
                        $('#modifier_group_item_price').val('');
                        AddModifierItem(responce.modifier_group_id);
                    }
                }
            },
        });
    });

    /* Destroy Modifier Group*/
    $(".confirmDelete").click(function () {
        var id = $(this).attr("data-id");

        var url = '{{route('delete.modifier.post.new')}}';
        Swal.fire({
            title: "Are you sure?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete it!"
        }).then(function(result) {
            if (result.value) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
                type: "GET",
                dataType: "json",
                data: {
                    'id' : id
                },
                beforeSend: function() {
                    $("body").preloader();
                },
                complete: function(){
                    $("body").preloader('remove');
                },
                success: function (res) {
                    toastr.success(res.alert);
                    window.location.href = res.route;
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    swal.fire("Error deleting!", "Please try again", "error");
                }
            });
            } else if (result.dismiss === "cancel") {

            }
        });
    });

    /* Open Edit Modal For Modifier Items */
    $(".editModifierItemModal").click(function(){
        var id = $(this).attr("data-id");
        var url = '{{route('edit.modifier.item.post.new')}}';
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url : url,
            type : 'POST',
            data : {
                'id' : id,
            },
            dataType:'json',
            success : function(responce) {
                if (responce.success) {
                    var value = responce.data;
                    $("#edit_modifier_group_item_name").val(value.modifier_group_item_name);
                    $("#edit_modifier_group_item_price").val(value.modifier_group_item_price);
                    $("#edit_modifier_item_group_id").val(value.modifier_group_id);
                    $("#edit_modifier_item_id").val(value.modifier_item_id);

                    $('#EditModifierItemsModal').modal('show');
                }
            }
        });
    });

    /* Add Modifier Item */
    $(".ModifierEditCommanBtn").click(function () {
        var btnType = $(this).attr("data-name");

        var edit_modifier_item_group_id = $('#edit_modifier_item_group_id').val();
        var edit_modifier_item_id = $('#edit_modifier_item_id').val();
        var edit_modifier_group_item_name = $('#edit_modifier_group_item_name').val();
        var edit_modifier_group_item_price = $('#edit_modifier_group_item_price').val();

        var url = '{{route('add.modifier.item.post.new')}}';
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url : url,
            type : 'POST',
            data : {
                'modifier_item_group_id' : edit_modifier_item_group_id,
                'modifier_item_id' : edit_modifier_item_id,
                'modifier_group_item_name' : edit_modifier_group_item_name,
                'modifier_group_item_price' : edit_modifier_group_item_price,
                'btnType' : btnType,
            },
            dataType:'json',
            success : function(responce) {
                if (responce.type == "success") {
                    if (responce.btnType == 'AddClose') {
                        $('#AddModifierItemsModal').modal('hide');
                        location.reload();
                    }else{
                        $('#modifier_group_item_name').val('');
                        $('#modifier_group_item_price').val('');
                        $('#EditModifierItemsModal').modal('hide');
                        AddModifierItem(responce.modifier_group_id);
                    }
                }
            },
        });
    });

    /* Destroy Modifier Items*/
    $(".deleteModifierItem").click(function () {
        var id = $(this).attr("data-id");

        var url = '{{route('delete.modifier.item.post.new')}}';
        Swal.fire({
            title: "Are you sure?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete it!"
        }).then(function(result) {
            if (result.value) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
                type: "GET",
                dataType: "json",
                data: {
                    'id' : id
                },
                beforeSend: function() {
                    $("body").preloader();
                },
                complete: function(){
                    $("body").preloader('remove');
                },
                success: function (res) {
                    toastr.success(res.alert);
                    window.location.href = res.route;
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    swal.fire("Error deleting!", "Please try again", "error");
                }
            });
            } else if (result.dismiss === "cancel") {

            }
        });
    });

});
</script>
