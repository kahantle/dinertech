<aside id="sidebar-wrapper">
    <div class="logo text-center">
        <a href="{{ route('dashboard') }}"><img src="{{ asset('images/logo.png') }}" class="img-fluid"></a>
    </div>
    <ul class="sidebar-nav">
        <li>
            <a href="{{ route('profile') }}"><img src="{{ asset('images/person.png') }}" class="img-fluid">
                <span>{{ Auth::user()->restaurant->restaurant_name }}</span>
            </a>
        </li>
        <li class="{{ Request::is('/') ? 'active' : '' }}">
            <a href="{{ route('dashboard') }}"><img src="{{ asset('images/order-icon.png') }}"
                    class="img-fluid">
                <span>recent orders</span>
            </a>
        </li>
        <li class="{{ Request::is('order') ? 'active' : '' }}">
            <a href="{{ route('order') }}"><img src="{{ asset('images/promotion-icon.png') }}"
                    class="img-fluid">
                <span>orders</span>
            </a>
        </li>
        <div id="accordion-first">
            <div class="card">
                <div class="card-header" id="headingOne">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#manageMenu"
                            aria-expanded="false" aria-controls="manageMenu">
                            <img src="{{ asset('images/menu-icon.png') }}" class="img-fluid"><span>manage
                                menu <i class="fa fa-angle-down"></i></span>
                        </button>
                    </h5>
                </div>

                <div id="manageMenu" class="collapse @if (Request::is('menu') || Request::is('category') || Request::is('modifier')) show @endif" aria-labelledby="headingOne"
                    data-parent="#accordion">
                    <div class="card-body">
                        <ul class="sub-menu">
                            <li class="{{ Request::is('menu') ? 'active' : '' }}">
                                <a href="{{ route('menu') }}">
                                    <img src="{{ asset('images/menu-icon.png') }}" class="img-fluid">
                                    <span>menu</span>
                                </a>
                            </li>
                            <li class="{{ Request::is('category') ? 'active' : '' }}">
                                <a href="{{ route('category') }}">
                                    <img src="{{ asset('images/categories.png') }}" class="img-fluid">
                                    <span>categories</span>
                                </a>
                            </li>
                            <li class="{{ Request::is('modifier') ? 'active' : '' }}">
                                <a href="{{ route('modifier') }}">
                                    <img src="{{ asset('images/modify.png') }}" class="img-fluid">
                                    <span>Modifiers / add-ons</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div id="accordion-first">
            <div class="card">
                <div class="card-header" id="headingtwo">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#marketing"
                            aria-expanded="false" aria-controls="marketing">
                            <img src="{{ asset('images/goal.png') }}" class="img-fluid"><span>Marketing<i
                                    class="fa fa-angle-down"></i></span>
                        </button>
                    </h5>
                </div>

                <div id="marketing" class="collapse @if (Request::is('promotion') || Request::is('campaigns') || Request::is('loyalty/*')) show @endif" aria-labelledby="headingtwo"
                    data-parent="#accordion">
                    <div class="card-body">
                        <ul class="sub-menu">
                            <li class="{{ Request::is('promotion') ? 'active' : '' }}">
                                <a href="{{ route('promotion') }}">
                                    <img src="{{ asset('images/promotion-icon.png') }}" class="img-fluid">
                                    <span>promotions</span>
                                </a>
                            </li>
                            <li class="{{ Request::is('campaigns') ? 'active' : '' }}">
                                <a href="{{ route('campaigns') }}">
                                    <img src="{{ asset('images/email.png') }}" class="img-fluid">
                                    <span>email marketing</span>
                                </a>
                            </li>
                            <li class="{{ Request::is('loyalty/*') ? 'active' : '' }}">
                                <a href="{{ route('loyalty.index') }}">
                                    <img src="{{ asset('images/customer-loyalty.png') }}" class="img-fluid">
                                    <span>loyalty</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <li class="{{ Request::is('account') ? 'active' : '' }}">
            <a href="{{ route('account') }}">
                <img src="{{ asset('images/account-icon.png') }}" class="img-fluid">
                <span>account</span>
            </a>
        </li>
        <li class="{{ Request::is('feedback/*') ? 'active' : '' }}">
            <a href="{{ route('feedback.add') }}">
                <img src="{{ asset('images/feedback-icon.png') }}" class="img-fluid">
                <span>feedback</span>
            </a>
        </li>
        <li class="{{ Request::is('chat') ? 'active' : '' }}">
            <a href="{{ route('chat') }}">
                <img src="{{ asset('images/chat-icon.png') }}" class="img-fluid">
                <span>chat</span>
            </a>
        </li>
        <li>
            <a href="{{ route('logout') }}">
                <img src="{{ asset('images/logout-icon.png') }}" class="img-fluid">
                <span>logout</span>
            </a>
        </li>
    </ul>
</aside>
