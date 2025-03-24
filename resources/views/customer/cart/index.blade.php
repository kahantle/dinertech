@extends('customer-layouts.app')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('assets/customer/css/promotion_page.css')}}">
    <style>
        .orer-btn {
            width: 100%;
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-bottom: 10px;
        }

        .orer-btn h3 {
            width: 100%;
            display: flex;
            justify-content: space-between;
        }

        .btn-current-event {
            flex: 1; /* Each button takes equal width */
            padding: 12px 20px;
            border-radius: 50px;
            border: none;
            font-size: 12px;
            font-weight: 500;
            font-family: 'Poppins', sans-serif; /* Keeps consistency */
            font-weight: bold;
            cursor: pointer;
        }

        .btn-current-event.active {
            background-color: blue;
            color: white;
        }

        .btn-current-event:not(.active) {
            background-color: white;
            color: #6F70C2; /* Adjusted color */
            border: 2px solid #E5E7EB; /* Light border for unselected */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .btn-current-event:first-child {
            margin-right: 10px; /* Adds space only between buttons */
        }

        /* Order history css */
        .tabcontent{
            position: relative;  
            background: white;
            padding: 5px 5px;
            border-radius: 12px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            width: 100%;  /* Ensures it takes full width */
            margin-bottom: 15px;    
            display: flex;
            flex-direction: column;
            align-items: center; /* Centers children */
        }
        .tabcontent .order-border1{
            background: white;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0px 2px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 10px;
            position: relative;
            width: 100%; /* Restrict width */
            box-sizing: border-box; /* Ensures padding doesn't increase width */
        }
        /* Fix Bootstrap .row behavior */
        .row1 {
            display: flex;
            flex-direction: column; /* Ensures items stay stacked */
            align-items: center; /* Centers children */
            width: 100%;
        }

        /* --- */
        /* Container */
        .order-card {
            background-color: white;
            box-shadow: 0px 2px 8px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            display: flex;
            flex-direction: column;
            gap: 4px;
            padding: 10px;
            font-family: "Poppins", sans-serif;
            width: 100%; /* Adjust width */
        }

        /* Header */
        .order-header {
            display: flex;
            justify-content: space-between;
            font-size: 14px;
            color: #666;
        }

        .order-payment a {
            color: #007bff;
            text-decoration: none;
            font-weight: 500;
        }

        /* Body */
        .order-body {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .order-number {
            color: #6F70C2;
            text-decoration: none;
            font-weight: bold;
            font-size: 14px;
            font-family: 'Poppins', sans-serif;
        }

        .order-price {
            font-weight: bold;
            font-size: 16px;
        }

        /* Footer */
        .order-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .order-status {
            font-family: 'Poppins', sans-serif; /* Keeps consistency */
            display: flex;
            align-items: center;
            color: #438F00;
            font-weight: bold;
            font-size: 12px;
        }

        .status-dot {
            width: 8px;
            height: 8px;
            background-color: #4caf50;
            border-radius: 50%;
            display: inline-block;
            margin-right: 5px;
        }
        .status-dot-danger {
            width: 8px;
            height: 8px;
            background-color: #FC0000;
            border-radius: 50%;
            display: inline-block;
            margin-right: 5px;
        }

        .order-details {
            font-family: 'Poppins', sans-serif; /* Keeps consistency */
            font-size: 12px;
            font-weight: bold;
            color: #007bff;
            text-decoration: none;
        }

        /* Responsive */
        @media (max-width: 480px) {
            .order-card {
                max-width: 100%;
            }
            .order-body, .order-footer {
                flex-direction: row;
                align-items: flex-start;
            }
        }
.wrp-ar-nav-body{
	margin-top: -10px !important;
}
    </style>
@endsection

@section('content')
    <section class="dash-body-ar wd-dr-dash-inner">
        <div class="wrp-ar-nav-body">
            @include('customer-layouts.navbar')
            <div id="chatdesk" class="chart-board ">
                <div class="row">
                    @include('customer.messages')
                    @include('customer-layouts.right-sidebar')
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    
    <script src="{{ asset('/assets/js/firebase.js') }}"></script>
    
@endsection
