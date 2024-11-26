@extends('admin.layouts.app')

@section('css')
    <link rel="stylesheet" href="{{asset('assets/admin/css/select2.min.css')}}">
@endsection

@section('content')
    <section id="right-content-wrapper" class="ps-container ps-active-y" data-ps-id="c878bcb0-cdfa-ab28-2fce-7147f311d569">
        <div class="right-content-outter">
            <div class="right-content-inner" style="opacity: 1;">
                <form class="info info-res-add" action="{{route('admin.restaurants.menu.store')}}" method="POST" id="addMenuForm" enctype="multipart/form-data">
                    @csrf
                    <section class="page-header alternative-header">
                        <div class="page-header_title user-page-header_title">
                            <a href="{{url()->previous()}}" class="back-btn">
                                <img src="{{asset('assets/admin/img/back-white-small.png')}}">
                            </a>
                            <!--<img src="img/2-2.png" class="res-logo">-->
                            <h1>
                                <span data-i18n="dashboard1.dashboard">{{$restaurant->restaurant_name}}</span>
                                <span class="page-header_subtitle" data-i18n="dashboard1.welcomeMsg" data-i18n-options="{&quot;username&quot;: &quot;John Doe&quot;}">Wel come back {{Auth::guard('admin')->user()->full_name}}</span>
                            </h1>
                            <div class="del-ref-btn-grp">
                                <button type="button" class="btn btn-default btn-lg del-ref-btn">
                                    <img src="{{asset('assets/admin/img/refresh-white-small.png')}}">
                                </button>
                                <button type="submit" class="btn btn-default btn-lg del-ref-btn menuFormSubmit">
                                    <img src="{{asset('assets/admin/img/tick-white.png')}}">
                                </button>
                                <!--<button type="button" class="btn btn-default btn-lg title-text">ADD USERS +</button>-->
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </section>
                    {{-- <section class="row captureImgParent">
                        <div class="captureImgIcon">
                            <button type="button" class="btn btn-default btn-lg file-upload-btn">
                                <img src="{{asset('assets/admin/img/select_picture.png')}}">
                            </button>
                        </div>
                    </section> --}}
                    @if(session()->has('error'))
                        <div class="alert alert-error">
                            {{ session()->get('error') }}
                        </div>
                    @endif
                    <section class="row captureImgParent">
                        <div class="image-upload-container">
                            <div class="image-upload-one">
                            <div class="center">
                                <div class="form-input">
                                    <label for="file-ip-1">
                                        <img id="file-ip-1-preview" src="{{asset('assets/admin/img/default.png')}}" class="img-responsive">
                                        {{-- <button type="button" class="imgRemove" onclick="myImgRemove(1)"></button> --}}
                                        <button type="button" class="imgRemove"></button>
                                    </label>
                                    {{-- <input type="file"  name="img_one" id="file-ip-1" accept="image/*" onchange="showPreview(event, 1);"> --}}
                                    <input type="file" name="menu_img" id="file-ip-1" accept="image/*" >
                                    @error('menu_img')
                                        {{$message}}
                                    @enderror
                                </div>
                                <small class="small">Use the &#8634; icon to reset the image</small>
                            </div>
                            </div>
                        
                        </div>
                    </section>
                    <section class="page-content user-page-content">
                        <div class="row">
                            <div class="col-sm-4 col-sm-offset-4">
                                    <div class="form-group">
                                        <input type="text" name="item_name" class="form-control"  placeholder="ADD MENU NAME">
                                        @error('item_name')
                                            {{$message}}
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="item_price" class="form-control"  placeholder="ADD MENU PRICE">
                                        @error('item_price')
                                            {{$message}}
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        {{-- <input type="text" name="item_details" class="form-control"  placeholder="ADD MENU DETAILS "> --}}
                                        <textarea class="form-control" name="item_details" placeholder="ADD MENU DETAILS "></textarea>
                                        @error('item_details')
                                            {{$message}}
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <select class="minimal" name="category">
                                            <option value="">SELECT CATEGORY</option>
                                            @forelse ($categories as $category)
                                                <option value="{{$category->category_id}}">{{$category->category_name}}</option>
                                            @empty
                                                <option value="">Not Found</option>
                                            @endforelse
                                        </select>
                                        @error('category')
                                            {{$message}}
                                        @enderror
                                    </div>
                                    <div  class="form-group">
                                        <select id="multiple" class="js-states form-control" multiple name="modifier[]">
                                            <option value=""></option>
                                            @forelse ($modifierGroups as $modifier)
                                                <option value="{{$modifier->modifier_group_id}}">{{$modifier->modifier_group_name}}</option>
                                            @empty
                                                <option>Not Found</option>
                                            @endforelse
                                        </select>
                                        @error('modifier')
                                            {{$message}}
                                        @enderror
                                    </div>
                                    <input type="hidden" name="stockType" id="stockType">
                                    <input type="hidden" name="restaurant_id" value="{{$restaurantId}}">
                                    <div class="form-group selectdate hide">
                                        <input type="text" class="form-control" name="date" id="dateValue" placeholder="DD-MM-YY TO DD-MM-YY" data-toggle="modal" data-target="#custom-date">
                                    </div>
                                    <div class="modal fade date-modal" id="custom-date" tabindex="-1" role="dialog" aria-labelledby="modifier-btn" style="display: none;">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>  
                                                    <h3>Custom Date</h3>
                                                </div>
                                                <div class="modal-body">
                                                    <div id="datepicker" class="input-group date" data-date-format="mm-dd-yyyy">
                                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                        <input class="form-control formdate" type="text" onfocus="(this.type='date')" onfocusout="(this.type='text')" placeholder="From Date">
                                                    </div>                                                            
                                                
                                                    <div id="datepicker" class="input-group date" data-date-format="mm-dd-yyyy">
                                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                        <input class="form-control todate" type="text" onfocus="(this.type='date')" onfocusout="(this.type='text')" placeholder="To Date">
                                                    </div>                                                            
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default btn-lg res-add-btn appendDate">Select</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <input type="submit" name="submit" value="Submit"> --}}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3 res-add-btn-center">
                                <button type="button" class="btn btn-default btn-lg not-active menuType removeSelect-Available" data-type="Available">Available</button>
                            </div>
                            <div class="col-sm-3 res-add-btn-center">
                                <button type="button" class="btn btn-default btn-lg not-active menuType removeSelect-Rest" data-type="Rest of Day">Rest of Day</button>
                            </div>
                            <div class="col-sm-3 res-add-btn-center">
                                <button type="button" class="btn btn-default btn-lg not-active menuType removeSelect-Indefinitely" data-type="Indefinitely">Indefinetly</button>
                            </div>
                            <div class="col-sm-3 res-add-btn-center">
                                {{-- <button onclick="window.location.href='Res_Add_Menu_Custom_Date.html'" type="button" class="btn btn-default btn-lg res-add-btn" data-type="Custom Date">Custom Date</button> --}}
                                <button type="button" class="btn btn-default btn-lg not-active menuType removeSelect-Custom" data-type="Custom Date">Custom Date</button>
                            </div>
                        </div>
                    </section>
                    <!-- /#page-content -->
                </form>
            </div>
        </div>
    </section>
    <!-- /#right-content-wrapper -->
@endsection

@section('script')
    <script src="{{asset('assets/admin/js/select2.min.js')}}"></script>
    <script src="{{asset('assets/customer/js/jquery.validate.min.js')}}"></script>
    <script src="{{asset('assets/admin/js/menuItem/add_menu.js')}}"></script>
@endsection