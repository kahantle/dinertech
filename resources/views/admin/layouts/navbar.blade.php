<header class="header-container">
    <div class="header-wrapper">
        <div id="header-toolbar">
            <ul class="toolbar toolbar-left">
                <li>
                    <a id="sidebar-toggle" data-state="open" href="javascript:void(0)"><i class="material-icons">menu</i></a>
                </li>
            </ul>

            <div id="searchbox">
                <span class="search-icon"><i class="material-icons">search</i></span>
                <input id="search-input" placeholder="Search" type="text" data-i18n="[placeholder]headerToolbar.searchbox" />
            </div>

            <ul class="toolbar toolbar-right">
                
                <li>
                    <a href="javascript:void(0);"  type="button"  onclick="toggleFullScreen(document.body)" ><i class="material-icons">fullscreen</i></a>
                </li>
                <li id="user-profile" class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <div class="avatar">
                            <img src="{{asset('assets/admin/img/User-Icon-Gray.png')}}" class="img-circle img-responsive" />
                        </div>
                        <div class="user">
                            <span class="username">{{Auth::guard('admin')->user()->full_name}}</span>
                        </div>
                        <span class="expand-ico"><i class="material-icons">expand_more</i></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <li><a href="#"><i class="material-icons">person</i> <span data-i18n="userinfo.profile">Your Profile</span></a></li>
                        <li><a href="#"><i class="material-icons">settings</i> <span data-i18n="userinfo.settings">Settings</span></a></li>
                        <li class="divider-horizontal"></li>
                        <li><a href="#"><i class="material-icons">lock</i> <span data-i18n="userinfo.lock">Lock</span></a></li>
                        <li class="divider-horizontal"></li>
                        <li>
                            <a href="{{ route('admin.logout') }}" onclick="event.preventDefault();
                            document.getElementById('logoutAdmin').submit();"><i class="material-icons">exit_to_app</i> <span data-i18n="userinfo.logout">Log Out</span></a>
                            <form method="POST" action="{{ route('admin.logout') }}" id="logoutAdmin">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </li>
                <!-- /#user-profile -->
            </ul>
            <!-- /.navbar-right -->
        </div>
    </div>
    <!-- /#header-toolbar -->
</header>