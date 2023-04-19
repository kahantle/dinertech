@extends('layouts.app')
@section('content')
<section id="wrapper">

    <style>
        .textColor {
            color: #514DC8;
        }

        .radio-toolbar input[type="radio"] {
            display: none;
        }

        .radio-toolbar label {
            display: inline-block;
            background-color: #f1f1f1;
            padding: 4px 11px;
            font-family: Arial;
            font-size: 18px;
            cursor: pointer;
            margin: 3px;
            color: black;
            border-radius: 11px;

        }

        .radio-toolbar .dynamic_date:checked+label {
            background-color: #f6f6f6;
            border: 2px solid #514DC8;
        }
    </style>

  @include('layouts.sidebar')
    <div id="navbar-wrapper">
        <nav class="navbar navbar-inverse">
            <div class="container-fluid">
                <div class="navbar-header">
                    <div class="profile-title-new">
                        <a href="#" class="navbar-brand" id="sidebar-toggle"><i class="fa fa-bars"></i></a>
                        <h2>Add Hours</h2>
                    </div>
                </div>
            </div>
        </nav>
    </div>

    <div class="error">
        @if($errors->all())
        <ul class="alert alert-danger">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
        </ul>
        @endif
    </div>

    <div class="dashboard orders content-wrapper">
        @include('common.flashMessage')
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="add-hours">
                        {{ Form::open(array('route' => array('add.hour.post'),'id'=>'hourForm','method'=>'POST','files'=>'true',   'class'=>'')) }}

                        {{-- Weekday Lists --}}
                        <div class="check-buttons">
                        @for ($i=0; $i<7; $i++)
                            @php
                                $day = \Carbon\Carbon::now()->startOfWeek(\Carbon\Carbon::MONDAY)->addDays($i)->isoFormat('dddd','D');
                            @endphp
                            <div class="form-check">
                            @if(in_array(strtolower($day),$restaurantHours))
                                <input type="checkbox" class="hours-disable" title="It's already selected for this resturant" disabled name="day[]" value="{{$day}}">
                                <label for="{{$day}}">{{$day}}</label>
                            @else
                                <input type="checkbox"  name="day[]" value="{{$day}}">
                                <label for="{{$day}}">{{$day}}</label>
                            @endif
                            </div>
                        @endfor
                        </div>

                        {{-- Date Range Selector Section --}}
                        <div class="time-buttons">
                            {{-- <div class="row">
                                <div class="col-xl-2 col-md-3 col-sm-4 col-5">
                                    <div class="form-group" style="display: inline-block">
                                        <input type="time" class="add-time opening_time" id="opening_hours" name="opening_hours[]" data-number="0"  placeholder="Selecting Open Hours">
                                        <span for="opening_hours" class="help-block"></span>
                                    </div>
                                </div>

                                <div class="col-xl-2 col-md-3 col-sm-4 col-5">
                                    <div class="form-group" style="display: inline-block">
                                        <input type="time" class="add-time closing_time" id="closing_hours" name="closing_hours[]" data-number="0" placeholder="Selecting Closeing Hours">
                                        <span for="closing_hours" class="error"></span>
                                    </div>
                                </div>

                                <div class="col-xl-2 col-md-3 col-sm-4 col-5 mt-3">
                                    <div class="form-group" style="display: inline-block">
                                    <select name="hour_type[]" id="hour_type" class="form-control">
                                        <option selected disabled>Select Type</option>
                                        <option value="Breakfast">Breakfast</option>
                                        <option value="Brunch">Brunch</option>
                                        <option value="Lunch">Lunch</option>
                                        <option value="Dinner">Dinner</option>
                                        <option value="Late Night">Late Night</option>
                                    </select>
                                    </div>
                                </div>

                                <div class="col-xl-2 col-md-2 col-sm-3 mt-3">
                                    <button class="btn btn-primary" id="add-more" type="button">Add More</button>
                                </div>
                                <input type="hidden" id="last_number" value="1" name="">
                            </div> --}}

                            {{-- Add Dynamic Date Range Section --}}
                            <div class="row">
                                <div class="col-xl-2 col-md-3 col-sm-3 col-3 ">
                                    <div class="form-group">
                                        <input class="form-control" type="time" id="multiple_opening_hours">
                                        <input class="form-control" type="hidden" id="opening_hours" name="opening_hours[]">
                                    </div>
                                </div>
                                <div class="col-xl-2 col-md-3 col-sm-3 col-3">
                                    <div class="form-group">
                                        <input class="form-control" type="time" id="multiple_closing_hours">
                                        <input class="form-control" type="hidden" id="closing_hours" name="closing_hours[]">
                                    </div>
                                </div>
                                <div class="col-xl-2 col-md-3 col-sm-3 col-3">
                                    <div class="form-group" style="display: inline-block">
                                        <select name="multiple_hour_type" id="multiple_hour_type" class="form-control">
                                            <option selected disabled>Select Type</option>
                                            <option value="Breakfast">Breakfast</option>
                                            <option value="Brunch">Brunch</option>
                                            <option value="Lunch">Lunch</option>
                                            <option value="Dinner">Dinner</option>
                                            <option value="Late Night">Late Night</option>
                                        </select>
                                    </div>
                                    <input type="hidden" name="hour_type[]" id="hour_type">
                                </div>
                                <input type="hidden" id="groupOfTime" name="groupOfTime">

                                <div class="col-xl-2 col-md-3 col-sm-3 col-3">
                                    <button class="btn btn-primary" id="add_localy" type="button">Add More</button>
                                </div>

                                <div class="col-xl-6 col-md-6 col-sm-6 col-6">
                                    <table class="table" id="appendTimeTb">
                                        <thead>
                                            <tr>
                                                <th scope="col">Date</th>
                                                <th scope="col">Type</th>
                                            </tr>
                                        </thead>

                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        {{-- Add Hour Button --}}
                        <div class="btn-custom text-center mt-5">
                            <hr>
                            <button class="btn-blue" id="submit_form"><span>Add Hours</span></button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Dates Ranges Start Modal -->
    <div class="modal fade bd-example-modal-lg" id="DaterangeSelectoreStart" tabindex="-1">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title textColor" id="DaterangeSelectore">Opening Timing Selection</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container row">
                        <div class="col-sm-10">
                            <div class="radio-toolbar">
                                <?php
                                    $timeArray = [
                                        '12:00','12:15','12:30','12:45','01:00','01:15','01:30','01:45','02:00','02:15',
                                        '02:30','02:45','03:00','03:15','03:30','03:45','04:00','04:15','04:30','04:45',
                                        '05:00','05:15','05:30','05:45','06:00','06:15','06:30','06:45','07:00','07:15',
                                        '07:30','07:45','08:00','08:15','08:30','08:45','09:00','09:15','09:30','09:45',
                                        '10:00','10:15','10:30','10:45','11:00','11:15','11:30','11:45'
                                    ];
                                ?>

                                @foreach ($timeArray as $time)
                                    <input class="dynamic_date" type="radio" id="time_range_start{{ $time }}" name="time_range_start" value="{{ $time }}">
                                    <label for="time_range_start{{ $time }}">{{ $time }}</label>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-sm-2 d-flex justify-content-center align-items-center">
                            <div class="radio-toolbar">
                                <input class="dynamic_date" type="radio" id="time_mode_am_s" name="time_mode_start" value="AM" checked>
                                <label for="time_mode_am_s">AM</label>

                                <input class="dynamic_date" type="radio" id="time_mode_pm_s" name="time_mode_start" value="PM">
                                <label for="time_mode_pm_s">PM</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="opening_hour_str_save">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Dates Ranges End Modal -->
    <div class="modal fade bd-example-modal-lg" id="DaterangeSelectoreEnd" tabindex="-1">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title textColor" id="DaterangeSelectore">Ending Timing Selection</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container row">
                        <div class="col-sm-10">
                            <div class="radio-toolbar">
                                <?php
                                    $timeArray = [
                                        '12:00','12:15','12:30','12:45','01:00','01:15','01:30','01:45','02:00','02:15',
                                        '02:30','02:45','03:00','03:15','03:30','03:45','04:00','04:15','04:30','04:45',
                                        '05:00','05:15','05:30','05:45','06:00','06:15','06:30','06:45','07:00','07:15',
                                        '07:30','07:45','08:00','08:15','08:30','08:45','09:00','09:15','09:30','09:45',
                                        '10:00','10:15','10:30','10:45','11:00','11:15','11:30','11:45'
                                    ];
                                ?>

                                @foreach ($timeArray as $time)
                                    <input class="dynamic_date" type="radio" id="time_range_end_{{ $time }}" name="time_range_end" value="{{ $time }}">
                                    <label for="time_range_end_{{ $time }}">{{ $time }}</label>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-sm-2 d-flex justify-content-center align-items-center">
                            <div class="radio-toolbar">
                                <input class="dynamic_date" type="radio" id="time_mode_am_e" name="time_mode_end" value="AM" checked>
                                <label for="time_mode_am_e">AM</label>

                                <input class="dynamic_date" type="radio" id="time_mode_pm_e" name="time_mode_end" value="PM">
                                <label for="time_mode_pm_e">PM</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <div>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="opening_hour_end_save">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>
@endsection
{{-- @section('scripts')
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
{!! JsValidator::formRequest('App\Http\Requests\HourRequest','#hourForm'); !!}
<script src="{{asset('/assets/js/add-hours.js')}}"></script>
@endsection --}}

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" type="text/javascript"></script>
<script>
    $(document).ready(function() {

        var dynamicTime = [];
        AppendTimeTable();

        /* Append Times */
        function AppendTimeTable() {
            $('#appendTimeTb tbody').empty();
            var timeStoreData = localStorage.getItem('timeStoreData');
            var loopData = jQuery.parseJSON( timeStoreData ) ?? [];
            $.each(loopData, function(key, element) {
                $('#appendTimeTb').append('<tr><td>'+element.start+' - '+element.end+'</td><td>'+element.type+'</td><td><button class="btn btn-danger btn-sm ArraySlice" data-id="'+key+'">Delete</button></td></tr>');
            });
        }

        /* Time Convert Function */
        const convertTime12to24 = (time12h) => {
            const [time, modifier] = time12h.split(' ');

            let [hours, minutes] = time.split(':');

            if (hours === '12') {
                hours = '00';
            }

            if (modifier === 'PM') {
                hours = parseInt(hours, 10) + 12;
            }

            return `${hours}:${minutes}`;
        }

        function onTimeChange(time) {
            var timeSplit = time.split(':'),
                hours,
                minutes,
                meridian;
            hours = timeSplit[0];
            minutes = timeSplit[1];
            if (hours > 12) {
                meridian = 'PM';
                hours -= 12;
            } else if (hours < 12) {
                meridian = 'AM';
                if (hours == 0) {
                hours = 12;
                }
            } else {
                meridian = 'PM';
            }
            return hours + ':' + minutes + ' ' + meridian;
        }

        $('#multiple_opening_hours').click(function() { return false; });
        $('#multiple_closing_hours').click(function() { return false; });

        $('#multiple_opening_hours').click(function() {
            $('#DaterangeSelectoreStart').modal('show');
        });

        $('#multiple_closing_hours').click(function() {
            $('#DaterangeSelectoreEnd').modal('show');
        });

        $('#opening_hour_str_save').click(function() {
            var time_range_start = $('input[name="time_range_start"]:checked').val();
            var time_mode_start = $('input[name="time_mode_start"]:checked').val();
            var time = time_range_start+' '+time_mode_start;
            var d_time = convertTime12to24(time);
            $("#multiple_opening_hours").val(d_time);
            $('#DaterangeSelectoreStart').modal('hide');
        });

        $('#opening_hour_end_save').click(function() {
            var time_range_end = $('input[name="time_range_end"]:checked').val();
            var time_mode_end = $('input[name="time_mode_end"]:checked').val();
            var time = time_range_end+' '+time_mode_end;
            var d_time = convertTime12to24(time);
            $("#multiple_closing_hours").val(d_time);
            $('#DaterangeSelectoreEnd').modal('hide');
        });

        $('#add_localy').click(function() {
            var multiple_opening_hours = $('#multiple_opening_hours').val();
            var multiple_closing_hours = $('#multiple_closing_hours').val();

            var start = onTimeChange(multiple_opening_hours);
            var end = onTimeChange(multiple_closing_hours);
            var multiple_hour_type = $('#multiple_hour_type').val();

            var array = {"start": start, "end": end, "type": multiple_hour_type};
            dynamicTime.push(array);
            localStorage.setItem('timeStoreData', JSON.stringify(dynamicTime));
            $('#multiple_opening_hours').val('');
            $('#multiple_closing_hours').val('');
            var tt = JSON.stringify(dynamicTime);
            $('#groupOfTime').val(tt);
            $('#multiple_hour_type option:first').prop('selected',true);
            AppendTimeTable();
        });

        $('.ArraySlice').click(function () {
            var id = $(this).attr("data-id");
            var timeStoreData = localStorage.getItem('timeStoreData');
            var loopData = jQuery.parseJSON( timeStoreData ) ?? [];
            loopData.splice(id,1);
            localStorage.setItem('timeStoreData', JSON.stringify(loopData));
            AppendTimeTable();
        })
    });
</script>
