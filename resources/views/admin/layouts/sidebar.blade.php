<aside id="left-content" data-toggle="open" data-default="open" data-size="">
    <header class="header-container">
        <div class="header-wrapper">
            <div id="header-brand">
                <div class="logo padding-left-2">
                    <img src="{{asset('assets/admin/img/Logo.png')}}"> </div>
            </div>
        </div>
    </header>
    <div id="sidebar-wrapper">
        <div id="userbox">
            <div id="useravatar" style="display: inline-block;">
                <div class="avatar-thumbnail">
                    <img src="{{asset('assets/admin/img/User-Icon.png')}}" class="img-circle" />
                </div>
            </div>

            <div id="userinfo" style="display: inline-block;">
                <div class="btn-group">
                    <button type="button" class="btn btn-default-bright btn-flat dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{Auth::guard('admin')->user()->full_name}} <i class="material-icons">arrow_drop_down</i>
                        </button>
                    <ul class="dropdown-menu">
                        <li><a href="#"><i class="material-icons">person</i> <span data-i18n="userinfo.profile">Your Profile</span></a></li>
                        <li><a href="#"><i class="material-icons">settings</i> <span data-i18n="userinfo.settings">Settings</span></a></li>
                        <li class="divider-horizontal"></li>
                        <li><a href="#"><i class="material-icons">lock</i> <span data-i18n="userinfo.lock">Lock</span></a></li>
                        <li class="divider-horizontal"></li>
                        <li>
                            <a href="{{ route('admin.logout') }}"
                            onclick="event.preventDefault();
                            document.getElementById('logoutForm').submit();">
                                <i class="material-icons">exit_to_app</i> <span data-i18n="userinfo.logout">Log Out</span>
                            </a>
                            <form method="POST" action="{{ route('admin.logout') }}" id="logoutForm">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- END: #userbox -->
        <nav id="sidebar">
            <ul>
                <li class="{{ Request::is('admin/dashboard') ? 'active' : '' }}">
                    <a href="{{route('admin.index')}}">
                        <span class="menu-item-ico"><img src="{{asset('assets/admin/images/SideMenuIcon/Dashboard-small.png')}}"></span>
                        <span class="menu-item-name" data-i18n="nav.dashboard">Dashboard</span>
                        {{-- <span class="menu-item-submenu-arrow"><i class="fa fa-angle-right"></i></span> --}}
                    </a>
                </li>
                <li class="{{ (Request::is('admin/users') || Request::is('admin/users/*')) ? 'active' : '' }}">
                    <a href="{{route('admin.users.index')}}">
                        <span class="menu-item-ico"><img src="{{asset('assets/admin/images/SideMenuIcon/User-small.png')}}"></span>
                        <span class="menu-item-name" data-i18n="nav.components.components">Users</span>
                    </a>
                </li>
                <li class="{{ (Request::is('admin/restaurants') || Request::is('admin/restaurants/*')) ? 'active' : '' }}">
                    <a href="{{route('admin.restaurants.index')}}">
                        <span class="menu-item-ico"><img src="{{asset('assets/admin/images/SideMenuIcon/Res-small.png')}}"></span>
                        <span class="menu-item-name" data-i18n="nav.forms.forms">Restaurants</span>
                        <!--<span class="label label-primary" data-i18n="nav.general.new">New</span>-->
                    </a>
                </li>
                <li class="{{ (Request::is('admin/paymentInfo')) ? 'active' : '' }}">
                    <a href="{{route('admin.paymentInfo.index')}}">
                        <span class="menu-item-ico"><img src="{{asset('assets/admin/images/SideMenuIcon/Payment-small.png')}}"></span>
                        <span class="menu-item-name" data-i18n="nav.charts.charts">Payment Info</span>
                    </a>
                </li>
                <li class="nav-main-heading">
                    <span class="sidebar-mini-hide" data-i18n="nav.premadePages.premadePages">Pages & Apps</span>
                </li>
                <li>
                    <a href="#">
                        <span class="menu-item-ico"><img src="{{asset('assets/admin/images/SideMenuIcon/Setting-small.png')}}"></span>
                        <span class="menu-item-name" data-i18n="nav.calendar">Setting</span>
                    </a>
                </li>
                <li class="{{ (Request::is('admin/feedbacks')) ? 'active' : '' }}">
                    <a href="{{route('admin.feedback.index')}}">
                        <span class="menu-item-ico"><img src="{{asset('assets/admin/images/SideMenuIcon/Feedback-small.png')}}"></span>
                        <span class="menu-item-name" data-i18n="nav.premadePages.pages">Feedback</span>
                    </a>
                </li>  
            </ul>
        </nav>
        <!-- END: nav#sidebar -->
    </div>
</aside>