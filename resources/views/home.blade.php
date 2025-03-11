<!doctype html>
<html class="no-js" lang="zxx">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{ config('app.name', 'Dinertech') }}</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="manifest" href="site.webmanifest">
    <link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('css/slicknav.css') }}">
    <link rel="stylesheet" href="{{ asset('css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/fontawesome-all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

        {{--  --}}
    <!-- Include Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <!-- Include Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

</head>
<body>
    <div id="preloader-active">
        <div class="preloader d-flex align-items-center justify-content-center">
            <div class="preloader-inner position-relative">
                <div class="preloader-circle"></div>
                <div class="preloader-img pere-text">
                    <img src="{{ asset('img/logo.png') }}" alt="">
                </div>
            </div>
        </div>
    </div>
    <header>
        <div class="header-area header-transparrent ">
            <div class="main-header header-sticky">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-xl-2 col-lg-2 col-md-2">
                            <div class="logo">
                                <a href="{{route('home')}}"><img src="{{ asset('img/logo.png') }}" alt=""></a>
                            </div>
                        </div>
                        <div class="col-xl-10 col-lg-10 col-md-10">
                            <div class="main-menu f-right d-none d-lg-block">
                                <nav>
                                    <ul id="navigation">
                                        <li><a href="#home"> Home</a></li>
                                        <li><a href="#about">About</a></li>
                                        <li><a href="#getintouch">Get In Touch</a></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="mobile_menu d-block d-lg-none"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Header End -->
    </header>
    
    <main>
    
        <!-- Slider Area Start-->
        <div class="slider-area " id="home">
            <div class="slider-active">
                <div class="single-slider slider-height slider-padding sky-blue d-flex align-items-center">
                    <div class="container">
                        <div class="row d-flex align-items-center">
                            <div class="col-lg-6 col-md-9 ">
                                <div class="hero__caption">
                                    <h1 data-animation="fadeInUp" data-delay=".6s">Empowering </br> Restaurateurs</h1>
                                    <p data-animation="fadeInUp" data-delay=".8s">with an easy-to-use mobile ordering
                                        platform </p>
                                    <!-- Slider btn -->
                                </div>
                            </div>
    
                        </div>
                    </div>
                    <div class="hero-img">
                        <img src="{{ asset('img/screen1.png') }}" alt="">
                    </div>
                </div>
                <!--  -->
            </div>
        </div>
        <!-- Slider Area End -->
        <!-- Best Features Start -->
        <section class="best-features-area section-padd4" id="about">
            <div class="container">
                <div class="row justify-content-end">
                    <div class="row m-0 mb-custom2">
                        <div class="col-lg-12 col-md-12">
                            <div class="section-tittle">
                                <h2>Who are we?</h2>
                                <p>
                                    DinerTech is fresh-to-market technology for restaurant operators, from a restaurant
                                    operator. In early 2020 all restaurant owners fell into the same uncertain boat
                                    following the spread of Covid-19. As a result, we're taking a simple approach to give
                                    restaurant operators an easy-to-use platform to add revenue to their bottom line. Unlike
                                    many other products on the market, DinerTech realizes many restaurant owners aren't
                                    trying to spend hundreds to thousands of dollars every month on a platform with many
                                    items they will never use. DinerTech brings a user-friendly mobile ordering platform to
                                    restaurant operators while offering customers the appeal of having their own branded
                                    mobile app and website ordering platform.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12 col-lg-12 best-features-area-content">
                        <!-- Section caption -->
                        <div class="row align-items-center mb-custom">
                            <div class="col-xl-6 col-lg-6 col-md-6 mb-20 order1">
                                <div class="features-info">
                                    <h3>What's included? </h3>
                                    <ul>
                                        <li>Update your orders, menus and settings directly from your restaurant app</li>
                                        <li>Manage your pickup and delivery orders in real-time while controlling order
                                            volume and timing</li>
                                        <li>86 menu items with ease using in-app inventory controls</li>
                                        <li>Increase your seamless ordering experience to customers with in-app
                                            notifications when their order is ready for pickup</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 mb-20 order2">
                                <div class="features-shpae d-none d-lg-block">
                                    <img src="{{ asset('img/recent-orders.png') }}" alt="">
                                </div>
                            </div>
                        </div>
    
                        <div class="row align-items-center mb-custom">
                            <div class="col-xl-6 col-lg-6 col-md-6 mb-20 order2">
                                <div class="features-shpae d-none d-lg-block">
                                    <img src="{{ asset('img/add-menu.png') }}" alt="">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 mb-20 order1">
                                <div class="features-info">
                                    <ul>
                                        <li>Accept more orders using less labor and keep your staff off the phone(s)</li>
                                        <li>Unlimited menu items and modifiers</li>
                                        <li>Give customers the ability to save their favorites for easy reordering</li>
                                        <li>Accept orders 24 hours a day with the ‘Order Ahead’ feature</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
    
                        <div class="row align-items-center mb-custom">
                            <div class="col-xl-6 col-lg-6 col-md-6 mb-20 order1">
                                <div class="features-info">
                                    <ul>
                                        <li>Questions for your customers? Send them a message about their order directly
                                            from the app</li>
                                        <li>Sales reports and monitoring tools right at your fingertips</li>
                                        <li>Seamless branding across web and mobile platforms</li>
                                        <li>Unlimited promotions and coupons included in every account</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 mb-20 order2">
                                <div class="features-shpae d-none d-lg-block">
                                    <img src="{{ asset('img/dashboard.png') }}" alt="">
                                </div>
                            </div>
                        </div>
    
                    </div>
    
                </div>
            </div>
    
        </section>
        <!-- Best Features End -->
        <!-- Services Area Start -->
        <section class="service-area sky-blue">
            <div class="container">
                <!-- Section Tittle -->
                <div class="row d-flex justify-content-center">
                    <div class="col-lg-12">
                        <div class="section-tittle text-center">
                            <h2>contactless payment options </br> reduces labor costs </h2>
                        </div>
                    </div>
                </div>
                <!-- Section caption -->
                <div class="row">
                    <div class="col-xl-4 col-lg-4 col-md-6">
                        <div class="services-caption text-center mb-30">
                            <div class="service-icon-bx">
                                <!-- <span class="flaticon-businessman"></span> -->
                                <div class="service-icon">
                                    <img src="{{ asset('img/stripe-icon.png') }}">
                                </div>
                            </div>
                            <div class="service-cap">
                                <h4><a href="#">Seamless payments with Stripe </a></h4>
                                <p>Secure, mobile focused payment processing with Stripe gives you an easy-to-manage payment
                                    processing system with the piece of mind and security for your customers.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-6">
                        <div class="services-caption active text-center mb-30">
                            <div class="service-icon-bx">
                                <!-- <span class="flaticon-pay"></span> -->
                                <div class="service-icon">
                                    <img src="{{ asset('img/silhouette-icon.png') }}">
                                </div>
                            </div>
                            <div class="service-cap">
                                <h4><a href="#">Integrated payments equals less Labor </a></h4>
                                <p>Reduce your labor costs by incorporating our Stripe integrated payments. When you no
                                    longer need to process customer payments at your Location, you can eliminate the
                                    additional employees needed to run your new takeout model.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-6">
                        <div class="services-caption text-center mb-30">
                            <div class="service-icon-bx">
                                <!-- <span class="flaticon-plane"></span> -->
                                <div class="service-icon">
                                    <img src="{{ asset('img/dollor-icon.png') }}">
                                </div>
                            </div>
                            <div class="service-cap">
                                <h4><a href="#">A new world of takeout with new ways to pay </a></h4>
                                <p>Promote your new DinerTech powered app with contactless payments as a safe option for
                                    your customers and put their minds at ease when it comes to ordering from your location.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Services Area End -->
        <!-- Applic App Start -->
        <div class="applic-apps">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <!-- slider Heading -->
                    <div class="col-xl-4 col-lg-4 col-md-8">
                        <div class="single-cases-info mb-30">
                            <h3>Get started with a </br> FREE Tablet</h3>
                            <p>We want to help you kick start your new mobile ordering platform so were giving you a FREE
                                Tablet when you complete your DinerTech registration with payments. Click the link below to
                                register instantly. </p>
                            <div class="get-started-btn text-center">
                                <a data-animation="fadeInLeft" data-delay="1.0s" href="#" class="btn radius-btn"
                                    tabindex="0" style="animation-delay: 1s;">Claim My Tablet</a>
                            </div>
                        </div>
                    </div>
                    <!-- OwL -->
                    <div class="col-xl-8 col-lg-8 col-md-col-md-7">
                        <div class="app-active owl-carousel">
                            <div class="single-cases-img">
                                <img src="{{ asset('img/screen3.png') }}" alt="">
                            </div>
                            <div class="single-cases-img">
                                <img src="{{ asset('img/screen5.png') }}" alt="">
                            </div>
                            <div class="single-cases-img">
                                <img src="{{ asset('img/screen6.png') }}" alt="">
                            </div>
                            <div class="single-cases-img">
                                <img src="{{ asset('img/screen3.png') }}" alt="">
                            </div>
                            <div class="single-cases-img">
                                <img src="{{ asset('img/screen5.png') }}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
    
        <div class="applic-apps customer-apps">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <!-- slider Heading -->
    
                    <!-- OwL -->
                    <div class="col-xl-8 col-lg-8 col-md-col-md-7 order2">
                        <div class="customer-app owl-carousel">
                            <div class="single-cases-img">
                                <img src="{{ asset('img/customer-screen6.png') }}" alt="">
                            </div>
                            <div class="single-cases-img">
                                <img src="{{ asset('img/customer-screen8.png') }}" alt="">
                            </div>
                            <div class="single-cases-img">
                                <img src="{{ asset('img/customer-screen7.png') }}" alt="">
                            </div>
                            <div class="single-cases-img">
                                <img src="{{ asset('img/customer-screen3.png') }}" alt="">
                            </div>
                            <div class="single-cases-img">
                                <img src="{{ asset('img/customer-screen4.png') }}" alt="">
                            </div>
                        </div>
                    </div>
    
                    <div class="col-xl-4 col-lg-4 col-md-8 order1">
                        <div class="single-cases-info mb-30">
                            <h3>What we're working on</h3>
                            <div class="row m-0">
                                <div class="col-xl-12 col-lg-12 col-md-12">
                                    <div class="features-info">
                                        <div class="row what-working">
                                            <div class="col-xl-12 col-lg-12 col-md-12 pl-0">
                                                <div class="single-features">
                                                    <div class="features-icon">
                                                        <i class="fa fa-truck"></i>
                                                    </div>
                                                    <div class="features-caption">
                                                        <h3>Custom Delivery app and functionality</h3>
                                                        <p>We want to get it right for all restaurants, so we need just a
                                                            little more time preparing it for you.</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-12 col-lg-12 col-md-12 pl-0">
                                                <div class="single-features">
                                                    <div class="features-icon">
                                                        <i class="fa fa-star"></i>
                                                    </div>
                                                    <div class="features-caption">
                                                        <h3>Rating System</h3>
                                                        <p>Want to know what your customers think of their experience? How
                                                            about what they think of the food? In-app ratings give you a
                                                            tailored view to better enhance your dining experience for all
                                                            customers.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
    
                                </div>
                            </div>
                        </div>
                    </div>
    
                </div>
            </div>
        </div>
        <!-- Applic App End -->
    
    
        <!-- Our Customer Start -->
    
        <!-- Our Customer End -->
        <!-- Available App  Start-->
        <div class="available-app-area">
            <div class="container">
                <div class="row d-flex justify-content-between">
                    <div class="col-xl-5 col-lg-6">
                        <div class="app-caption">
                            <div class="section-tittle section-tittle3">
                                <h2>DinerTech... Available on </br>all platforms</h2>
                                <div class="app-btn">
                                    <a href="#" class="app-btn1"><img src="{{ asset('img/app_btn1.png') }}" alt=""></a>
                                    <a href="#" class="app-btn2"><img src="{{ asset('img/app_btn2.png') }}" alt=""></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6">
                        <!-- <div class="app-img">
                        </div> -->
                    </div>
                </div>
            </div>
            <div class="app-img-right">
                <img src="{{ asset('img/screen7.png') }}" alt="">
            </div>
            <!-- Shape -->
    
        </div>
        <!-- Available App End-->
        <!-- Say Something Start -->
        <div class="say-something-aera pt-50 pb-50 fix" id="getintouch">
            <div class="container">
                <div class="row justify-content-between align-items-center">
                    <div class="col-xl-5  col-lg-5">
                        <div class="say-something-cap">
                            <h2>Get In Touch</h2>
                            <p><i class="fa fa-map-marker"></i>3715 West Cass Street Tampa, FL 33609</p>
                            <p><a href="tel:888-718-0800"><i class="fa fa-phone"></i><span
                                        class="media-body align-self-center">888-718-0800</span></a></p>
                            <p><a href="mailto:info@dinertech.io "><i class="fa fa-envelope"></i><span
                                        class="media-body align-self-center">info@dinertech.io </span></a></p>
                            <div class="sicon">
                                <a href="#"><i class="fa fa-facebook"></i></a>
                                <a href="#"><i class="fa fa-twitter"></i></a>
                                <a href="#"><i class="fa fa-instagram"></i></a>
                            </div>
                        </div>
                        <!-- <div class="say-btn">
                            <a href="#" class="btn radius-btn">Contact Us</a>
                        </div> -->
                    </div>
                    <div class="col-xl-6 col-lg-6">
                        <div class="say-something-form">
                            <h2>Contact Us</h2>
                            <form name="get_in_touch" id="get_in_touch" method="post" action="">
                                <div class="col-lg-12 form-group">
                                    <input type="text" name="your_name" id="your_name" placeholder="Your Name">
                                </div>
                                <div class="col-lg-12 form-group">
                                    <input type="text" name="your_email" id="your_email" placeholder="Your Email">
                                </div>
                                <div class="col-lg-12 form-group">
                                    <input type="tel" name="your_phone" id="your_phone" placeholder="Your Phone">
                                </div>
                                <div class="col-lg-12 form-group">
                                    <textarea class="form-control" name="your_message" id="your_message" rows="5"
                                        placeholder="Message"></textarea>
                                </div>
                                <div class="col-lg-12 form-group say-btn btn-submit">
                                    <!-- <a href="#" class="btn radius-btn">Contact Us</a> -->
                                    <input type="submit" name="submit_btn" id="submit_btn" value="Submit">
                                </div>
                                <div id="form_messages"></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- shape -->
            <div class="say-shape">
                <img src="{{ asset('img/say-shape-left.png') }}" alt="" class="say-shape1 rotateme d-none d-xl-block">
            </div>
        </div>
        <!-- Say Something End -->
    
    </main>
    <footer>


    <!-- JS here -->

    <!-- All JS Custom Plugins Link Here here -->
    <script src="{{ asset('js/modernizr-3.5.0.min.js') }}"></script>

    <!-- Jquery, Popper, Bootstrap -->
    <script src="{{ asset('js/jquery-1.12.4.min.js') }}"></script>

    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <!-- Jquery Mobile Menu -->
    <script src="{{ asset('js/jquery.slicknav.min.js') }}"></script>

    <!-- Jquery Slick , Owl-Carousel Plugins -->
    <script src="{{ asset('js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('js/slick.min.js') }}"></script>

    <!-- One Page, Animated-HeadLin -->
    <script src="{{ asset('js/wow.min.js') }}"></script>
    <!-- <script src="./assets/js/animated.headline.js"></script> -->


    <!-- Scrollup, nice-select, sticky -->
    <script src="{{ asset('js/jquery.scrollUp.min.js') }}"></script>
    <script src="{{ asset('js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('js/jquery.sticky.js') }}"></script>



    <!-- Jquery Plugins, main Jquery -->

    <script src="{{ asset('js//main.js') }}"></script>
    <script src="{{ asset('js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('js/contact.js') }}"></script>

</body>

</html>