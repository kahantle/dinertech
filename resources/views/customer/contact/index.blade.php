@extends('customer-layouts.app')

@section('content')
	<div class="add-address-banner wd-dr-inner-blog">
        <div class="container">
           <div class="wd-dr-chat-left">
            <div class="wd-dr-chat-inner"> 
                <h1>
                    Contact Us
                </h1>
            </div>
            <div class="clearfix"></div>
           </div>
        </div>
    </div>

    <div class="container list-address">
        <div class="jumbotron">
        	
	            <div class="row map-row">
	                <div class="col-md-6">
	                    <div class="">
	                       <!--  <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3691.6172143702306!2d70.79012931432048!3d22.292485448813327!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3959cb725b62dcd5%3A0x12a67431f975754!2sDotpitch%20Technologies!5e0!3m2!1sen!2sin!4v1615270241545!5m2!1sen!2sin"
	                            width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy"></iframe> -->
	                       <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3691.5500449191477!2d70.78865851534584!3d22.295028148719386!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3959ca19b942ac15%3A0x43959c45a1d3f88a!2sThe%20Imperial%20Palace!5e0!3m2!1sen!2sin!4v1628151306221!5m2!1sen!2sin"  width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
	                    </div>
	                </div>
	                <div class="col-md-6 map-contact">
	                    <div class="media">
	                        <div class="media-left">
	                            <a href="#" alt="Map">
	                                <img class="media-object" src="{{asset('assets/customer/images/map-black.png')}}" alt="...">
	                            </a>
	                        </div>
	                        <div class="media-body">
	                            <p>
	                                {{$address->restaurant_address}}
	                            </p>
	                        </div>
	                    </div>
	                    <div class="media">
	                        <div class="media-left">
	                            <a href="#" alt="Mail">
	                                <img class="media-object" src="{{asset('assets/customer/images/mail.png')}}" alt="...">
	                            </a>
	                        </div>
	                        <div class="media-body">
	                            <p>
	                                <a href="mailto:{{$address->restaurant_email}}">{{$address->restaurant_email}}</a>
	                            </p>
	                        </div>
	                    </div>
	                    <div class="media">
	                        <div class="media-left">
	                            <a href="#" alt="Phone">
	                                <img class="media-object" src="{{asset('assets/customer/images/phone.png')}}" alt="...">
	                            </a>
	                        </div>
	                        <div class="media-body">
	                            <p>
	                                +91 - {{$address->restaurant_mobile_number}}
	                            </p>
	                        </div>
	                    </div>
	                </div>
	            </div>
        </div>
    </div>
@endsection