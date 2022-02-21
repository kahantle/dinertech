@extends('layouts.app')
@section('content')
    <section id="wrapper">
        @include('layouts.sidebar')
        <div id="navbar-wrapper">
            <nav class="navbar navbar-inverse">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <div class="profile-title-new">
                            <a href="#" class="navbar-brand" id="sidebar-toggle"><i class="fa fa-bars"></i></a>
                            <h2>Add Menu</h2>
                        </div>
                        <div id="clearForm" class="clear">
                            <span>Clear</span>
                            <i class="fa fa-repeat" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
        <div class="add-category Promotion menu dashboard content-wrapper category category-insides-blog">
            @include('common.flashMessage')

            <div class="container-fluid">
                {{ Form::open(['route' => ['add.menu.post'],'id' => 'menuForm','method' => 'POST','class' => '','files' => 'true']) }}
                <span class="slt-img">

                </span>
                <input id="image" type="file" name="item_img" placeholder="Photo" required="" capture=""
                    style="display: none;">
                <label class="label-a"><i class="fa fa-camera" aria-hidden="true"></i>Select
                    Picture</label>
                <div class="row">
                    <div class="col-lg-6">


                        <div class="form-group">
                            <img src="{{ asset('assets/images/category-menu-icon.png') }}">
                            <input type="text" class="form-control" name="item_name" value="{{ old('item_name') }}"
                                placeholder="Enter Menu Item">
                        </div>
                        <div class="form-group">
                            <img src="{{ asset('assets/images/category-detail.png') }}">
                            <textarea type="text" class="form-control" name="item_details"
                                placeholder="Enter Menu Details"></textarea>
                        </div>

                    </div>
                    <div class="col-lg-6">
                        <div class="form-group select-input">
                            <img src="{{ asset('assets/images/catagory-black.png') }}">
                            <select type="text" class="form-control" name="category_id" placeholder="Enter Item Catagory">
                                <option value="" disabled selected>Select Item Catagory</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->category_id }}">{{ $category->category_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <img src="{{ asset('assets/images/modifiers-black.png') }}">
                            <input type="text" class="form-control" name="item_price" placeholder="Enter Item Price" />
                        </div>
                        <div class="form-group select-input">
                            <img style="    z-index: 1;" src="{{ asset('assets/images/category-detail.png') }}">
                            <select type="text" class="select2 form-control " name="modifier_group_id[]" id="modifier_id"
                                multiple="multiple" placeholder="Enter Modifiers">
                                @foreach ($modifiers as $modifier)
                                    <option value="{{ $modifier->modifier_group_id }}">
                                        {{ $modifier->modifier_group_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        {{-- <div class="grey-line">
                            <div class="text-title">
                                <h6>Modifiers / Add-ons</h6>
                            </div>
                            <div class="plus">
                                <a href="javaScript:void(0);" class="openModifierForm open"><i class="fa fa-plus"
                                        aria-hidden="true"></i></a>
                            </div>
                        </div>
                        <div id="accordion" class="accordion">

                        </div> --}}
                    </div>
                </div>
            </div>
            <div class="form-group form-btn-menu">
                <div class="btn-custom">
                    <a href="{{ route('add.menu') }}" class="btn-grey"><span>Cancel</span></a>
                </div>
                <div class="btn-custom">
                    <button class="btn-blue"><span>Add Menu</span></button>
                </div>
            </div>
            </form>

        </div>


        </div>
        <div id="modifierGroupPopUp" class="modifierGroupPopUp open closeAllModal overlay w-100">
            <div class="popup text-center">
                <a class="close closeModal" href="javaScript:void(0);">&times;</a>
                <div class="content">
                    <h5 class="groupHeading">Add Modifier Group</h5>
                    {{ Form::open(['route' => ['add.menu.modifier.post'],'id' => 'modifierForm','method' => 'POST','class' => '']) }}
                    <div class="form-group">
                        <input type="hidden" id="modifier_group_id" name="modifier_group_id" />
                        <input type="text" class="form-control" id="modifier_group_name" name="modifier_group_name"
                            placeholder="Modifier Group Name">
                    </div>
                    <div class="form-group">
                        <input type="checkbox" class="styled-checkbox" id="allow_multiple" name="allow_multiple" />
                        <label for="allow_multiple"> Allow Multiple </label>
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
                    {{ Form::open(['route' => ['add.menu.modifier.item.post'],'id' => 'modifierItemForm','method' => 'POST','class' => '']) }}
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
    @section('scripts')
        <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
        {!! JsValidator::formRequest('App\Http\Requests\MenuItemRequest', '#menuForm') !!}
        {!! JsValidator::formRequest('App\Http\Requests\ModifierGroupRequest', '#modifierForm') !!}
        {!! JsValidator::formRequest('App\Http\Requests\ModifierItemPriceRequest', '#modifierItemForm') !!}
        <script src="{{ asset('/assets/js/menu-modifier.js') }}"></script>
        <script>
            var route = "{{ route('ajax.modifier.list') }}";
            $(document).ready(function() {
                $(document).on('click', '#clearForm', function() {
                    $('#menuForm').trigger("reset");
                    $(".slt-img img").remove();
                });
            });

            $(document).ready(function() {
                $('.select2').select2({
                    placeholder: "Select a Modifiers",
                });
            });
        </script>
        <script src="{{ asset('assets/js/common.js') }}"></script>
    @endsection
