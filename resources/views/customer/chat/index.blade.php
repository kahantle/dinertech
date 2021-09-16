@extends('customer-layouts.app')

@section('css')
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.2/css/font-awesome.min.css">
@endsection

@section('content')

    {{-- <div class="container-fluid">
        <div class="add-address-banner">
            <div class="container">
                <h1>
                    Chat
                </h1>
                <a class="place-order export">Export</a>
                <div class="clearfix">
                </div>
            </div>
        </div>
    </div> --}}

    <div class="add-address-banner wd-dr-inner-blog">
        <div class="container">
           <div class="wd-dr-chat-left">
                <div class="wd-dr-chat-inner"> 
                    <h1>
                        Chat
                    </h1>
                </div>
                <div class="clearfix">
                </div>
                @empty(!$orderIds)
                    <div class="dots-menu btn-group">
                        <a data-toggle="dropdown" class="btn"><i class="fa fa-ellipsis-h"></i></a>
                        <!-- <span class="glyphicon glyphicon-option-vertical"> </span>-->
                        <ul class="dropdown-menu">
                            <li><a href="#">Mute Notification</a></li>
                            <li class="delete-row">
                            <a class="export">Export Chat</a>
                            </li>
                        </ul>
                    </div>
                @endempty
           </div>
        </div>
    </div>

    <div class="container list-address">
        <div class="jumbotron">
            <div class="row">
                @empty(!$orderIds)
                    <div id="frame">
                        <div id="sidepanel">
                            <div id="contacts">
                                <ul>
                                    @foreach ($orderIds as $key => $orderId)
                                        @if ($key == 0)
                                            @php
                                                $active = 'active';
                                            @endphp
                                        @else
                                            @php
                                                $active = '';
                                            @endphp
                                        @endif
                                        <li class="contact chat-{{$orderId['order_id']}} {{$active}}" data-order-id="{{$orderId['order_id']}}">
                                            <div class="wrap">

                                                <img src="{{(empty(Auth::user()->profile_image)) ? asset('assets/customer/images/Logo-Round.png') : route('display.image',[Config::get('constants.IMAGES.USER_IMAGE_PATH'),Auth::user()->profile_image])}}" alt="" />
                                                <div class="meta">
                                                    <p class="name">{{$orderId['order_id']}}</p><label>{{$orderId['message_date']}}</label>
                                                </div>
                                            </div>
                                        </li>        
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    
                        <div class="content">
                            <div class="messages">
                                
                            </div>
                            <div class="message-input">
                                <div class="wrap">
                                    <input type="text" placeholder="Input Message" />
                                    <button class="submit" alt="Submit"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
                                    <button class="submit micro" alt="Micro"><i class="fa fa-microphone" aria-hidden="true"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                @else  
                    <div class="text-center not_found">
                        <span>No Order Found</span>
                    </div>
                @endempty
            </div>
        </div>
    </div>
    
@endsection

@section('scripts')
    <script src="{{asset('assets/customer/js/chat/index.js')}}"></script>
    <script src="https://use.typekit.net/hoy3lrg.js"></script>
    
    {{-- <script src='//production-assets.codepen.io/assets/editor/live/console_runner-079c09a0e3b9ff743e39ee2d5637b9216b3545af0de366d4b9aad9dc87e26bfd.js'></script>
    <script src='//production-assets.codepen.io/assets/editor/live/events_runner-73716630c22bbc8cff4bd0f07b135f00a0bdc5d14629260c3ec49e5606f98fdd.js'></script>
    <script src='//production-assets.codepen.io/assets/editor/live/css_live_reload_init-2c0dc5167d60a5af3ee189d570b1835129687ea2a61bee3513dee3a50c115a77.js'></script>
    <script src='//production-assets.codepen.io/assets/common/stopExecutionOnTimeout-b2a7b3fe212eaa732349046d8416e00a9dec26eb7fd347590fbced3ab38af52e.js'></script> --}}
    <script src='https://code.jquery.com/jquery-2.2.4.min.js'></script>
    
    
@endsection