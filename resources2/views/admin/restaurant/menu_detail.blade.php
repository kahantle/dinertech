@extends('admin.layouts.app')

@section('content')
    <section id="right-content-wrapper" class="ps-container ps-active-y" data-ps-id="c878bcb0-cdfa-ab28-2fce-7147f311d569">
        <div class="right-content-outter">
            <div class="right-content-inner" style="opacity: 1;">
                <section class="page-header alternative-header">
                    <div class="page-header_title user-page-header_title">
                        <a href="{{route('admin.restaurants.manage_menu',$menuItem->restaurant->restaurant_id)}}" class="back-btn">
                            <img src="{{asset('assets/admin/img/back-white-small.png')}}">
                        </a>
                        <!--<img src="img/2-2.png" class="res-logo">-->
                        <h1>

                            <span data-i18n="dashboard1.dashboard">{{$menuItem->restaurant->restaurant_name}}</span>
                            <span class="page-header_subtitle" data-i18n="dashboard1.welcomeMsg" data-i18n-options="{&quot;username&quot;: &quot;John Doe&quot;}">{{$menuItem->restaurant->restaurant_address}}</span>
                        </h1>
                        <div class="del-ref-btn-grp">
                            <!--<button type="button" class="btn btn-default btn-lg del-ref-btn" onclick="window.location.href='UserDetail.html'">
                                <img src="img/user-(1).png">
                            </button>-->
                            <!--<button type="button" class="btn btn-default btn-lg title-text">Managed Menu</button>-->
                            <button type="button" class="btn btn-default btn-lg del-ref-btn" onclick="window.location.href='{{route('admin.restaurants.menu.edit',$menuItem->menu_id)}}'">
                                <img src="{{asset('assets/admin/images/Edit.png')}}">
                            </button>
                            <button type="button" class="btn btn-default btn-lg del-ref-btn refresh">
                                <img src="{{asset('assets/admin/img/refresh-white-small.png')}}">
                            </button>
                            <button type="button" class="btn btn-default btn-lg del-ref-btn">
                                <img src="{{asset('assets/admin/img/delete-white.png')}}">
                            </button>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </section>

                <section class="page-content res-manage-menu">
                    <div class="row zmd-hierarchical-display in" data-animation="hierarchical-display">
                        <div>
                            <ol class="breadcrumb">
                                <li class="active"><a href="{{route('admin.restaurants.manage_menu',$menuItem->restaurant_id)}}">{{$menuItem->category['category_name']}}</a></li>
                                <li><a href="#">{{$menuItem->item_name}}</a></li>
                            </ol>
                        </div>
                    </div>
                </section>
                <section class="page-content">
                    <div class="row zmd-hierarchical-display in" data-animation="hierarchical-display">
                        <div class="col-sm-6 col-sm-offset-3 menu_detail zoomIn animated" style="animation-delay: 0.12s;">
                            <img src="{{$menuItem->getMenuImgAttribute()}}" width="225">
                            <h1>{{$menuItem->item_name}}</h1>
                            <h2>$ {{number_format($menuItem->item_price,2)}}</h2>
                            <p>
                                {{$menuItem->item_details}}
                            </p>
                            @if (!empty($menuItem->start_date) && !empty($menuItem->end_date))
                                <p>
                                    <b style="font-weight: bold;">Custom Date : </b>{{date('d/m/Y',strtotime($menuItem->start_date))}} TO {{date('d/m/Y',strtotime($menuItem->end_date))}}
                                </p>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <input type="hidden" value="{{$menuItem->menu_id}}" id="menuId">
                        <div class="col-sm-3 res-add-btn-center">
                            <button type="button" class="btn btn-default btn-lg type @if($menuItem->out_of_stock_type == 'Available') res-add-btn @else not-active @endif" data-type="Available">Available</button>
                        </div>
                        
                        <div class="col-sm-3 res-add-btn-center">
                            <button type="button" class="btn btn-default btn-lg type @if($menuItem->out_of_stock_type == 'Rest Of Day') res-add-btn @else not-active @endif" data-type="Rest of Day">Rest of Day</button>
                        </div>
                        
                        <div class="col-sm-3 res-add-btn-center">
                            <button type="button" class="btn btn-default btn-lg type @if($menuItem->out_of_stock_type == 'Indefinitely') res-add-btn @else not-active @endif" data-type="Indefinitely">Indefinitely</button>
                        </div>

                        <div class="col-sm-3 res-add-btn-center">
                            <button type="button" class="btn btn-default btn-lg type @if($menuItem->out_of_stock_type == 'Custom Date') res-add-btn @else not-active @endif" data-type="Custom Date" data-toggle="modal" data-target="#custom-date">Custom Date</button>
                        </div>
                        <div class="modal fade date-modal" id="custom-date" tabindex="-1" role="dialog" aria-labelledby="modifier-btn" style="display: none;">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>  
                                        <h3>Custom Date</h3>
                                    </div>
                                    <form class="form-group" action="{{route('admin.restaurants.menu.typeChange')}}" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <input type="hidden" name="menuId" id="customDateMenuId">
                                            <input type="hidden" name="type" id="stockType">
                                            <div id="datepicker" class="input-group date" data-date-format="mm-dd-yyyy">
                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                <input class="form-control" name="start_date" type="text" onfocus="(this.type='date')" onfocusout="(this.type='text')" placeholder="From Date" required>
                                            </div>                                                            
                                        
                                            <div id="datepicker" class="input-group date" data-date-format="mm-dd-yyyy">
                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                <input class="form-control" name="end_date" type="text" onfocus="(this.type='date')" onfocusout="(this.type='text')" placeholder="To Date" required>
                                            </div>                                                            
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-default btn-lg res-add-btn">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- /#page-content -->
                
            </div>
        </div>
    </section>
    <!-- /#right-content-wrapper -->
@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="{{asset('assets/admin/js/menuItem/menu_detail.js')}}"></script>
@endsection