<div role="tabpanel" class="tab-pane fade in active active" id="{{$category->category_name}}">
    <div class="row zmd-hierarchical-display in" data-animation="hierarchical-display">
        @forelse ($menuItems as $menuItem)
            <div class="col-lg-4 col-sm-6 zoomIn animated" style="animation-delay: 0.12s;">
                <div class="panel panel-default panel-user">
                    <div class="panel-body no-padding">
                        <div class="mini-card user-mini-card">
                            <div class="media">
                                <div class="media-left">
                                    <a href="#">
                                        <img class="media-object dish-img" src="{{$menuItem->getMenuImgAttribute()}}" alt="">
                                    </a>
                                </div>
                                <div class="media-body">
                                    <h3 class="media-heading">{{$menuItem->item_name}}.</h3>
                                    <div class="panel-heading-tools">
                                        <div class="btn-group">
                                            <button type="button" class="btn" data-toggle="modal" data-target="#myModal-{{\Str::slug($menuItem->item_name)}}">
                                                <i class="material-icons">more_vert</i>
                                            </button>
                                            <div id="myModal-{{\Str::slug($menuItem->item_name)}}" class="modal fade" role="dialog">
                                                <div class="modal-dialog modal-sm">
                                                    <!-- Modal content-->
                                                    <div class="modal-content">
                                                        <div class="modal-body">
                                                            <button type="button" class="close" data-dismiss="modal">×</button>
                                                            <div class="row" style="float: left; width: 100%;">
                                                                <div class="col-sm-4 modal-cols" style="height: 120px;">
                                                                    <a href="{{route('admin.restaurants.menu.detail',$menuItem->menu_id)}}">
                                                                        <img src="{{asset('assets/admin/img/information.png')}}">
                                                                        <h5>
                                                                            Information
                                                                        </h5>
                                                                    </a>
                                                                </div>
                                                                <div class="col-sm-4 modal-cols" style="height: 120px;">
                                                                    <a href="{{route('admin.restaurants.menu.edit',$menuItem->menu_id)}}">
                                                                        <img src="{{asset('assets/admin/img/edit-2.png')}}">
                                                                        <h5>
                                                                            Edit Details
                                                                        </h5>
                                                                    </a>
                                                                </div>
                                                                <div class="col-sm-4" style="text-align: center;">
                                                                    <a href="#">
                                                                        <img src="{{asset('assets/admin/img/delete-2.png')}}">
                                                                        <h5>
                                                                            Delete Restaurants
                                                                        </h5>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="clearfix"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clearfix">

                                    </div>

                                    <div class="person">
                                        <span class="price">
                                            $ {{number_format($menuItem->item_price,2)}}
                                        </span>
                                        <p>
                                            {{$menuItem->item_details}}
                                        </p>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-md-12 text-center">
                <h3>No Item Found</h3>
            </div>
        @endforelse
    </div>
</div>
