<!-- HEADER STRAT -->
<nav class="sidebar-ar" id="sidebar">
    <div class="wd-sl-headerall">
        <div class="logo-img-ar">
            <img class="lazy" data-src="{{ asset('assets/customer/images/chat/logo.png') }}">
        </div>
        @auth
            <div class="wd-dr-sec-das">
                @if (Auth::user()->profile_image)
                    <img src="{{ route('display.image', [Config::get('constants.IMAGES.USER_IMAGE_PATH'), Auth::user()->profile_image]) }}"
                        class="img-fluid mb-3">
                @endif
                <h3 class="m-0">{{ \Auth::user()->full_name }}</h3>
                <p class="mt-1">My Profile </p>
            </div>
        @endauth
        <div class="nav-list-ar">
            <ul class="nav-list-ul">
                <li class="{{ Request::is('customer') ? 'active' : '' }}">
                    <a href="{{ route('customer.index') }}">
                        <i data-feather="grid"></i>
                        <span>Menu</span>
                    </a>
                </li>
                <li class="{{ Request::is('customer/orders*') ? 'active' : '' }}">
                    <a href="{{ route('customer.orders') }}">
                        <i data-feather="user-plus"></i>
                        <span>Orders</span>
                    </a>
                </li>
                <li class="{{ Request::is('customer/loyalty*') ? 'active' : '' }}">
                    <a href="">
                        <i data-feather="gift"></i>
                        <span>Loyalty</span>
                    </a>
                </li>
                <li class="{{ Request::is('customer/promotions*') ? 'active' : '' }}">
                    <a href="{{route('customer.promotions')}}">
                        <i data-feather="smartphone"></i>
                        <span>Promotions</span>
                    </a>
                </li>
                <li class="{{ Request::is('customer/restaurant/information') ? 'active' : '' }}">
                    <a href="{{ route('customer.restaurant.information') }}">
                        <i data-feather="alert-circle"></i>
                        <span>Information</span>
                    </a>
                </li>
                <li class="{{ Request::is('customer/cards/*') ? 'active' : '' }}">
                    <a href="{{ route('customer.cards.list') }}">
                        <i data-feather="archive"></i>
                        <span>Payment Methods</span>
                    </a>
                </li>
                <li class="{{ Request::is('customer/chats*') ? 'active' : '' }}">
                    <a href="{{ route('customer.chat.index') }}">
                        <i data-feather="message-square"></i>
                        <span>Chats</span>
                    </a>
                </li>
                <li class="{{ Request::is('customer/contact-us/*') ? 'active' : '' }}">
                    <a href="{{ route('customer.contact-us') }}">
                        <i data-feather="phone"></i>
                        <span>Contact Us</span>
                    </a>
                </li>
                <li class="{{ Request::is('customer/setting/*') ? 'active' : '' }}">
                    <a href="{{ route('customer.settings') }}">
                        <i data-feather="settings"></i>
                        <span>Account Settings</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- mobile responsive start -->
<div class="wd-dr-right-toogle">
    <button class="sidebar-toggle">
        <i class="fas fa-align-left"></i>
    </button>
    <div class="wd-dr-res-img">
        <img class="lazy" data-src="{{ asset('assets/customer/images/chat/logo.png') }}">
    </div>
    <div class="wd-sl-resright">
        <!-- <button class="wd-sl-serchtoggle" id="show-hidden-menu30"><i class="fas fa-ellipsis-h"></i></button> -->
        <div class="top-nav-ar hidden-menu30" style="display: none;">
            <div class="inncol-ar-list">
                <ul>
                    <li class="search-container">
                        <form action="" class="search-form">
                            <input type="text" placeholder="" name="search">
                            <button class="search-btn" type="submit">
                                <svg width="15" height="16" viewBox="0 0 15 16" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path opacity="0.7"
                                        d="M6.89766 0.919067C10.2493 0.919067 12.9766 3.65042 12.9766 7.00202C12.9766 8.49615 12.4325 9.86382 11.5348 10.9236L14.8246 14.2134C14.8728 14.2601 14.9113 14.3159 14.9377 14.3775C14.9642 14.4392 14.978 14.5056 14.9785 14.5727C14.979 14.6398 14.9661 14.7063 14.9405 14.7684C14.915 14.8304 14.8773 14.8868 14.8297 14.9341C14.7821 14.9814 14.7256 15.0188 14.6634 15.044C14.6012 15.0692 14.5346 15.0817 14.4675 15.0809C14.4004 15.08 14.3341 15.0658 14.2726 15.039C14.211 15.0123 14.1554 14.9735 14.1091 14.925L10.8212 11.6371C9.76126 12.5357 8.39252 13.081 6.89766 13.081C3.54606 13.081 0.818675 10.3536 0.818675 7.00202C0.818675 3.65042 3.54606 0.919067 6.89766 0.919067ZM6.89766 1.98057C4.1181 1.98057 1.87619 4.22246 1.87619 7.00202C1.87619 9.78158 4.1181 12.0225 6.89766 12.0225C9.67722 12.0225 11.9191 9.78158 11.9191 7.00202C11.9191 4.22246 9.67722 1.98057 6.89766 1.98057Z"
                                        fill="#67748E"></path>
                                </svg>
                            </button>
                        </form>
                    </li>
                    <li class="wd-svg-position">
                        <a href="#">
                            <svg width="27" height="31" viewBox="0 0 27 31" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M13.125 0.760254C6.91185 0.760254 1.87506 5.79705 1.87506 12.0103V18.7336L0.549226 20.0594C0.0129758 20.5957 -0.147431 21.4021 0.142782 22.1028C0.432994 22.8035 1.11669 23.2603 1.87506 23.2603H24.375C25.1334 23.2603 25.8171 22.8035 26.1073 22.1028C26.3976 21.4021 26.2371 20.5957 25.7008 20.0594L24.375 18.7336V12.0103C24.375 5.79705 19.3382 0.760254 13.125 0.760254Z"
                                    fill="white"></path>
                                <path
                                    d="M13.125 30.7603C10.0184 30.7603 7.5 28.2419 7.5 25.1353H18.75C18.75 28.2419 16.2317 30.7603 13.125 30.7603Z"
                                    fill="white"></path>
                            </svg>
                        </a>
                        <span class="cart-count badge-circle">4</span>
                    </li>
                    <li>
                        <a href="#">
                            <svg width="30" height="31" viewBox="0 0 30 31" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M17.7922 2.95576C17.0816 0.0284179 12.9184 0.0284179 12.2077 2.95576C11.7486 4.84679 9.58209 5.74421 7.9203 4.73167C5.34783 3.16422 2.40397 6.10809 3.97141 8.68055C4.98395 10.3423 4.08654 12.5089 2.19551 12.968C-0.731836 13.6786 -0.731836 17.8419 2.19551 18.5525C4.08654 19.0117 4.98395 21.1783 3.97141 22.8399C2.40397 25.4124 5.34783 28.3563 7.92031 26.7888C9.58209 25.7763 11.7486 26.6737 12.2077 28.5648C12.9184 31.4921 17.0816 31.4921 17.7922 28.5648C18.2514 26.6737 20.418 25.7763 22.0796 26.7888C24.6521 28.3563 27.5961 25.4124 26.0286 22.8399C25.0161 21.1783 25.9134 19.0117 27.8046 18.5525C30.7318 17.8419 30.7318 13.6786 27.8046 12.968C25.9134 12.5089 25.0161 10.3423 26.0286 8.68055C27.5961 6.10809 24.6521 3.16422 22.0796 4.73167C20.418 5.74421 18.2514 4.84679 17.7922 2.95576ZM15 21.3853C18.1067 21.3853 20.625 18.8669 20.625 15.7603C20.625 12.6537 18.1067 10.1353 15 10.1353C11.8934 10.1353 9.375 12.6537 9.375 15.7603C9.375 18.8669 11.8934 21.3853 15 21.3853Z"
                                    fill="white"></path>
                            </svg>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<aside class="sidebar">
    <div class="inner-res">
        <div class="sidebar-header">
            <button class="close-btn"><i class="fas fa-times"></i></button>
        </div>
        <div class="nav-list-ar">
            <ul class="nav-list-ul">
                <li class="{{ Request::is('customer') ? 'active' : '' }}">
                    <a href="{{ route('customer.index') }}">
                        <i data-feather="grid"></i>
                        <span>Menu</span>
                    </a>
                </li>
                <li class="{{ Request::is('customer/orders*') ? 'active' : '' }}">
                    <a href="{{ route('customer.orders') }}">
                        <i data-feather="user-plus"></i>
                        <span>Orders</span>
                    </a>
                </li>
                <li class="{{ Request::is('customer/restaurant/information') ? 'active' : '' }}">
                    <a href="{{ route('customer.restaurant.information') }}">
                        <i data-feather="alert-circle"></i>
                        <span>Information</span>
                    </a>
                </li>
                <li class="{{ Request::is('customer/cards/*') ? 'active' : '' }}">
                    <a href="{{ route('customer.cards.list') }}">
                        <i data-feather="archive"></i>
                        <span>Payment Methods</span>
                    </a>
                </li>
                <li class="{{ Request::is('customer/chats*') ? 'active' : '' }}">
                    <a href="{{ route('customer.chat.index') }}">
                        <i data-feather="message-square"></i>
                        <span>Chats</span>
                    </a>
                </li>
            </ul>
            <ul class="nav-list-ul mt-4">
                <li>
                    <form method="POST" action="{{ route('customer.logout') }}">
                        @csrf
                        <a href="{{ route('customer.logout') }}"
                            onclick="event.preventDefault();this.closest('form').submit();" alt="Logout">
                            <i data-feather="log-out"></i>
                            <span>Logout</span>
                        </a>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</aside>
<!-- mobile responsive sidebar -->
<!-- HEADER END -->
