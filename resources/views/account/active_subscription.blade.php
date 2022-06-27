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
                        <a href="{{url()->previous()}}" class="navbar-brand sub-inner-left"><i class="fa fa-chevron-left"></i></a>
                        <h2>Select Subscription</h2>
                    </div>
                </div>
            </div>
        </nav>
    </div>

    <div class="acoount content-wrapper">
        <div class="three-card">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-4 col-lg-4">
                        <div class="card-plate-one">
                            <h1 class="text-center">Delivery</h1>
                            <div class="one-img">
                                <img src="{{asset('assets/images/ic_delivery.png')}}" alt="">
                            </div>
                            <div class="inner-body">
                                <h1 class="text-center"><sup>$</sup>500 <span>/Month</span></h1>
                                <p><i class="fa fa-check-circle" aria-hidden="true"></i> An app is fast, easy
                                    and comfortable to use. There are no misunderstandings or</p>
                                <p><i class="fa fa-check-circle" aria-hidden="true"></i> An app is fast, easy
                                    and comfortable to use. There are no
                                    misunderstandings or</p>
                            </div>
                            <button type="button" data-toggle="modal"
                                data-target="#oneModalCenter">ACTIVE</button>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-4">
                        <div class="card-plate-two">
                            <h1 class="text-center">Email Marketing</h1>
                            <div class="two-img">
                                <img src="{{asset('assets/images/ic_email_marketing.png')}}" alt="">
                            </div>
                            <div class="inner-body">
                                <h1 class="text-center"><sup>$</sup>40 <span>/Month</span></h1>
                                <p><i class="fa fa-check-circle" aria-hidden="true"></i> An app is fast, easy
                                    and comfortable to use. There are no misunderstandings or</p>
                                <p><i class="fa fa-check-circle" aria-hidden="true"></i> An app is fast, easy
                                    and comfortable to use. There are no
                                    misunderstandings or</p>
                            </div>
                            <button type="button" data-toggle="modal"
                                data-target="#twoModalCenter">ACTIVE</button>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 col-lg-4">
                        <div class="card-plate-three">
                            <h1 class="text-center">Loyalty</h1>
                            <div class="three-img">
                                <img src="{{asset('assets/images/ic_loyalty.png')}}" alt="">
                            </div>
                            <div class="inner-body">
                                <h1 class="text-center"><sup>$</sup>29 <span>/Month</span></h1>
                                <p><i class="fa fa-check-circle" aria-hidden="true"></i> An app is fast, easy
                                    and comfortable to use. There are no misunderstandings or</p>
                                <p><i class="fa fa-check-circle" aria-hidden="true"></i> An app is fast, easy
                                    and comfortable to use. There are no
                                    misunderstandings or</p>
                            </div>
                            <button type="button" data-toggle="modal"
                                data-target="#threeModalCenter">ACTIVE</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')

@endsection