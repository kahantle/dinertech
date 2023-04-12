@extends('layouts.app')
@section('content')

    <style>
        .stockBtn {
            -webkit-box-shadow: 0px 0px 22px -4px rgba(0,0,0,0.66);
            -moz-box-shadow: 0px 0px 22px -4px rgba(0,0,0,0.66);
            box-shadow: 0px 0px 22px -4px rgba(0,0,0,0.66);
            border-radius: 16px;
        }

        .textColor {
            color: #514DC8;
        }

        .blue-btn {
            position: relative;
            font-family: 'SFProDisplay-Regular';
            font-size: 20px;
            display: inline-block;
            overflow: hidden;
            padding: 12px 20px;
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

        .mainHover:hover {
            cursor: pointer;
        }

        .changeBtnc{
            background: #514DC8;
            color: white;
        }
    }
    </style>

    <section id="wrapper">
        @include('layouts.sidebar')
        @include('common.flashMessage')
        <div id="navbar-wrapper">
            <nav class="navbar navbar-inverse">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <div class="profile-title-new">
                            <a href="#" class="navbar-brand" id="sidebar-toggle"><i class="fa fa-bars"></i></a>
                            <h2>Menu</h2>
                        </div>
                        <div class="form-group">
                            <i class="fa fa-search" aria-hidden="true"></i>
                            <input type="text" name="item-name" id="searchText" class="form-control searchText"
                                value="{{ $params }}" placeholder="Search Menu">
                            <i class="fa fa-times searchTextBtn" aria-hidden="true"></i>
                        </div>
                        <div class="plus">
                            <a href="{{ route('add.menu') }}"><i class="fa fa-plus" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
        <div class="menu content-wrapper">
            <div class="container-fluid">
                @if ($menu)
                    <div class="row">
                        @foreach ($menu as $item)
                            <div class="col-xl-4 col-md-6 menu-md-blog">
                                <div class="menu-item">
                                    @if (!$item->item_img)
                                        <!-- <img src="{{ asset('assets/images/mi-3.png') }}" class="img-fluid"> -->
                                        <div class="menu-content menu-content-left">
                                            <div class="menu-title">
                                                <h4>{{ $item->item_name }} <span>{{ $item->category->category_name }}</span>
                                                </h4>&nbsp;

                                                <div class="menu-actions-ctm">
                                                    <a href="{{ route('edit.menu', $item->menu_id) }}" class=""
                                                        data-route="">
                                                        <p>Edit<i class="fa fa-pencil" aria-hidden="true"></i></p>
                                                    </a>

                                                    &nbsp;<a data-route="{{ route('delete.menu.post', [$item->menu_id]) }}"
                                                        class="delete " href="javaScript:void(0);">
                                                        <p>Delete<i class="fa fa-trash " aria-hidden="true"></i></p>
                                                    </a>
                                                </div>
                                            </div>
                                            <p>{{ $item->item_details }}</p>
                                            <div class="price">
                                                <p>${{ number_format($item->item_price, 2) }}</p>
                                                {{-- <a href="#0">Out Of Stock</a> --}}
                                            </div>
                                        </div>
                                    @else
                                        <div class="img">
                                            <img width="200" height="197"
                                                src="{{ route('display.image', [config('constants.IMAGES.MENU_IMAGE_PATH'), $item->item_img]) }}">
                                        </div>

                                        <div class="menu-content">
                                            <div class="menu-title">
                                                <h4>{{ $item->item_name }}
                                                    <span>{{ $item->category->category_name }}</span>
                                                </h4>&nbsp;

                                                <div class="menu-actions-ctm">
                                                    <a href="{{ route('edit.menu', $item->menu_id) }}" class=""
                                                        data-route="">
                                                        <p>Edit<i class="fa fa-pencil" aria-hidden="true"></i></p>
                                                    </a>

                                                    &nbsp;<a data-route="{{ route('delete.menu.post', [$item->menu_id]) }}"
                                                        class="delete " href="javaScript:void(0);">
                                                        <p>Delete<i class="fa fa-trash " aria-hidden="true"></i></p>
                                                    </a>
                                                </div>
                                            </div>
                                            <p>{{ $item->item_details }}</p>
                                            <div class="price">
                                                <p>${{ number_format($item->item_price, 2) }}</p>
                                                {{-- <a href="#0">Out Of Stock</a> --}}

                                                {{-- Out Off Stock Button --}}
                                                @if($item->out_of_stock_type === 'Available') 
                                                    <button type="button" class="btn btn-sm btn-white stockBtn stockBtnJs" onclick="OutOfStock({{ $item->menu_id }},'Available')">Out Of Stock ?</button>
                                                @elseif( $item->out_of_stock_type === 'Rest Of Day')
                                                    <button type="button" class="btn btn-sm btn-white changeBtnc stockBtn stockBtnJs" onclick="OutOfStock({{ $item->menu_id }}, 'Rest Of Day')">Rest Of Day</button>
                                                @elseif( $item->out_of_stock_type === 'Indefinitely')
                                                    <button type="button" class="btn btn-sm btn-white changeBtnc stockBtn stockBtnJs" onclick="OutOfStock({{ $item->menu_id }}, 'Indefinitely')">Indefinitely</button>
                                                @else   
                                                    <button type="button" class="btn btn-sm btn-white changeBtnc stockBtn stockBtnJs" onclick="OutOfStock({{ $item->menu_id }}, 'Custome',{{ json_encode($item->start_date.'+'.$item->end_date) }})">Custome Date</button>    
                                                @endif

                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="w-100 pagination-links"> {{ $menu->links() }}</div>
                @else
                    <p>No records found.</p>
                @endif
            </div>
        </div>
    </section>

    <!-- Out Of Stock Until Modal -->
    <div class="modal fade" id="outOfStockModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title textColor">Out of stock until</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="mainHover d-flex justify-content-between" onclick="SetOutOfStockValue('rest_of_day')">
                            Rest Of Day

                            <i class="fa fa-check d-none" id="display_rest_of_day" aria-hidden="true"></i>
                        </div>
                        <hr />

                        <div class="mainHover d-flex justify-content-between" onclick="SetOutOfStockValue('indefinitely')">
                            Indefinitely

                            <i class="fa fa-check d-none" id="display_indefinitely" aria-hidden="true"></i>
                        </div>
                        <hr />

                        <div class="mainHover" onclick="SetOutOfStockValue('custom_date')">
                            Custom Date
                            <br />
                            <p style="font-size: 12px;" id="custome_date"></p>
                        </div>

                        <input type="hidden" name="out_of_stock_until" id="out_of_stock_until">
                        <input type="hidden" name="menuId" id="menuId">
                        <div class="form-check mt-2" style="margin-left: 20px;">
                            <input class="form-check-input" type="checkbox" id="mark_as_available">
                            <label class="form-check-label h6" for="mark_as_available">
                                Mark as available
                            </label>
                        </div>

                        <div>
                            <span id="errorMsg" class="text-danger"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="saveOutOfStockBtn" class="blue-btn" >Select</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Out Of Stock Until Select Date Modal -->
    <div class="modal fade" id="customDateModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title textColor">Custom Date</h5>
                    <button type="button" onclick="removeOldData()" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="form-group">
                            <input class="form-control" type="datetime-local" id="stock_start_date" name="stock_start_date" value="">
                        </div>
                        <hr />
                        <div class="form-group">
                            <input class="form-control" type="datetime-local" id="stock_end_date" name="stock_end_date" value="">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="saveOutOfStockCustomBtn" class="blue-btn" >Select</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
    <script src="{{ asset('assets/js/menu.js') }}"></script>
@endsection

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" type="text/javascript"></script>
<script>
    $(document).ready(function() {

        $('#mark_as_available').change(function() {
            if(this.checked) {
                $("#display_rest_of_day").addClass("d-none");
                $("#display_indefinitely").addClass("d-none");
                $("#out_of_stock_until").val('Available');
            }else{
                $("#out_of_stock_until").val('');
            }
        });

        $('#saveOutOfStockBtn').click(function name() {
            var selectedType =  $('#out_of_stock_until').val();
            var menuId = $('#menuId').val();

            if (!selectedType) {
                $('#errorMsg').html('Must be select out of stock until');
            }else {
                $('#errorMsg').html('');
                OutOfStockDynamic(selectedType,menuId);                
            }
        });

        $('#saveOutOfStockCustomBtn').click(function name() {
            var selectedType =  $('#out_of_stock_until').val();
            var menuId = $('#menuId').val();
            var stock_start_date = $('#stock_start_date').val();
            var stock_end_date = $('#stock_end_date').val();

            OutOfStockDynamic(selectedType,menuId,stock_start_date,stock_end_date);            
        });
    });

    function OutOfStockDynamic(type,menuId,start=null,end=null){
        var url = '{{route('store.stock.until')}}';
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url : url,
            type : 'POST',
            data : {
                'selectedType' : type,
                'menuId' : menuId,
                'start' : start,
                'end' : end,
            },
            dataType:'json',
            success : function(data) {
                if (data.type) {
                    console.log(data.modalclose);
                    $('#'+data.modalclose).modal('hide');
                    location.reload(); 
                }
            },
        });
    }

    function removeOldData(){
        $('#out_of_stock_until').val('');
    }

    function OutOfStock(id,type,data=null) {
                
        $('#menuId').val(id);
        if(data) {
            var c_date = data.split('+');
            var c_start_date = moment(c_date['0']).format('MM-DD-YYYY HH:mm A');
            var c_end_date = moment(c_date['1']).format('MM-DD-YYYY HH:mm A');
            console.log(c_start_date);
            console.log(c_end_date);

            var dates = 'From : '+c_start_date+' To '+c_end_date+'';
            $('#custome_date').text(dates);
        }
        $('#outOfStockModal').modal('show');
    }

    function SetOutOfStockValue(tag) {
        if (tag === 'rest_of_day') {
            $("#display_indefinitely").addClass('d-none');
            $("#display_rest_of_day").removeClass("d-none");

            $("#out_of_stock_until").val(tag);
        } else if (tag === 'indefinitely') {
            $("#display_rest_of_day").addClass('d-none');
            $("#display_indefinitely").removeClass("d-none");
            $("#out_of_stock_until").val(tag);
        } else {
            $("#display_indefinitely").addClass("d-none");
            $("#display_rest_of_day").addClass("d-none");
            $("#out_of_stock_until").val(tag);

            $('#outOfStockModal').modal('hide');
            $('#customDateModal').modal('show');
        }
    }
</script>
