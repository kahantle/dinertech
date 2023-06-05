<div class="top-nav-ar">
    <div class="col-md-6 col-sm-5 col-lg-5 col-xs-6">
        @isset($search)
            <div class="input-group search-form">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">
                        <i class="fa fa-search" aria-hidden="true"></i>
                    </span>
                </div>
                <input type="text" class="form-control" placeholder="Search" aria-label="Search" aria-describedby="Search"
                    id="searchMenu">
            </div>
        @endisset
    </div>


    @auth
        <div class="col-md-6 col-sm-7 col-lg-7 col-xs-6">
            <div class="inncol-ar-list">
                <ul>
                    {{-- <li class="wd-svg-position">
                        <a href="#">
                            <svg width="27" height="31" viewBox="0 0 27 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M13.125 0.760254C6.91185 0.760254 1.87506 5.79705 1.87506 12.0103V18.7336L0.549226 20.0594C0.0129758 20.5957 -0.147431 21.4021 0.142782 22.1028C0.432994 22.8035 1.11669 23.2603 1.87506 23.2603H24.375C25.1334 23.2603 25.8171 22.8035 26.1073 22.1028C26.3976 21.4021 26.2371 20.5957 25.7008 20.0594L24.375 18.7336V12.0103C24.375 5.79705 19.3382 0.760254 13.125 0.760254Z"
                                    fill="white" />
                                <path
                                    d="M13.125 30.7603C10.0184 30.7603 7.5 28.2419 7.5 25.1353H18.75C18.75 28.2419 16.2317 30.7603 13.125 30.7603Z"
                                    fill="white" />
                            </svg>
                        </a>
                        <span class="cart-count badge-circle">4</span>
                    </li> --}}
                    <li>
                        <a href="{{ route('customer.settings') }}">
                            <svg width="30" height="31" viewBox="0 0 30 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M17.7922 2.95576C17.0816 0.0284179 12.9184 0.0284179 12.2077 2.95576C11.7486 4.84679 9.58209 5.74421 7.9203 4.73167C5.34783 3.16422 2.40397 6.10809 3.97141 8.68055C4.98395 10.3423 4.08654 12.5089 2.19551 12.968C-0.731836 13.6786 -0.731836 17.8419 2.19551 18.5525C4.08654 19.0117 4.98395 21.1783 3.97141 22.8399C2.40397 25.4124 5.34783 28.3563 7.92031 26.7888C9.58209 25.7763 11.7486 26.6737 12.2077 28.5648C12.9184 31.4921 17.0816 31.4921 17.7922 28.5648C18.2514 26.6737 20.418 25.7763 22.0796 26.7888C24.6521 28.3563 27.5961 25.4124 26.0286 22.8399C25.0161 21.1783 25.9134 19.0117 27.8046 18.5525C30.7318 17.8419 30.7318 13.6786 27.8046 12.968C25.9134 12.5089 25.0161 10.3423 26.0286 8.68055C27.5961 6.10809 24.6521 3.16422 22.0796 4.73167C20.418 5.74421 18.2514 4.84679 17.7922 2.95576ZM15 21.3853C18.1067 21.3853 20.625 18.8669 20.625 15.7603C20.625 12.6537 18.1067 10.1353 15 10.1353C11.8934 10.1353 9.375 12.6537 9.375 15.7603C9.375 18.8669 11.8934 21.3853 15 21.3853Z"
                                    fill="white" />
                            </svg>
                        </a>
                    </li>
                    <li class="mr-0">
                        <div class="dropdown">
                            <button id="myBtn" class="dropbtn">
                                @if (Auth::user()->profile_image)
                                    <img src="{{ route('display.image', [Config::get('constants.IMAGES.USER_IMAGE_PATH'), Auth::user()->profile_image]) }}"
                                        class="img-fluid user-profile-img">
                                @endif
                                {{ \Auth::user()->full_name }}<i class="fas fa-angle-down"></i>
                            </button>
                            <div id="myDropdown" class="dropdown-content">
                                <a href="{{ route('customer.profile') }}">Profile</a>
                                <a href="{{ route('customer.feedback.index') }}">Send Feedback</a>
                                <form method="POST" action="{{ route('customer.logout') }}">
                                    @csrf
                                    <a href="{{ route('customer.logout') }}"
                                        onclick="event.preventDefault();this.closest('form').submit();"
                                        alt="Logout">Logout</a>
                                </form>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    @endauth
</div>
