<aside id="sidebar-wrapper">
  <div class="logo text-center">
  <a href="{{route('dashboard')}}"><img src="{{ asset('images/logo.png') }}" class="img-fluid"></a>
  </div>
  
    <ul class="sidebar-nav">
      <li>
        <a href="{{route('profile')}}"><img src="{{ asset('images/person.png') }}" class="img-fluid"><span>Chief,Alex Thoma</span></a>
      </li>
      <li class="{{ Request::is('/') ? 'active' : '' }}">
        <a href="{{route('dashboard')}}"><img src="{{ asset('images/order-icon.png') }}" class="img-fluid"><span>recent orders</span></a>
      </li>
      <li class="{{ Request::is('/order') ? 'active' : '' }}">
        <a href="{{route('order')}}"><img src="{{ asset('images/promotion-icon.png') }}" class="img-fluid"><span>orders</span></a>
      </li>
      <li>
        <a href="#"><img src="{{ asset('images/menu-icon.png') }}" class="img-fluid"><span>manage menu</span></a>
        <ul class="sub-menu">
          <li class="{{ Request::is('/menu') ? 'active' : '' }}">
              <a href="{{route('menu')}}"><img src="{{ asset('images/menu-icon.png') }}" class="img-fluid"><span>menu</span></a>
            </li>
            <li class="{{ Request::is('/category') ? 'active' : '' }}">
              <a href="{{route('category')}}"><img src="{{ asset('images/categories.png') }}" class="img-fluid"><span>categories</span></a>
            </li>
            <li class="{{ Request::is('/menu') ? 'active' : '' }}">
              <a href="{{route('modifier')}}"><img src="{{ asset('images/modify.png') }}" class="img-fluid"><span>Modifiers / add-ons</span></a>
            </li>
        </ul>
      </li>
      <li class="{{ Request::is('/promotions') ? 'active' : '' }}">
        <a href="{{route('promotion')}}"><img src="{{ asset('images/promotion-icon.png') }}" class="img-fluid"><span>promotions</span></a>
      </li>   
      <li>
        <a href="{{route('account')}}"><img src="{{ asset('images/account-icon.png') }}" class="img-fluid"><span>account</span></a>


      </li>
      <li class="{{ Request::is('/feedback') ? 'active' : '' }}">
              <a href="{{route('feedback.add')}}"><img src="{{ asset('images/feedback-icon.png') }}" class="img-fluid"><span>feedback</span></a>
          </li>
      
      <li class="{{ Request::is('/chat') ? 'active' : '' }}">
        <a href="{{route('chat')}}"><img src="{{ asset('images/chat-icon.png') }}" class="img-fluid"><span>chat</span></a>
      </li>
      @if (Auth::user()->role == 'RESTAURANT')
        <li>
          <a href="{{route('logout')}}"><img src="{{ asset('images/logout-icon.png') }}" class="img-fluid"><span>logout</span></a>
        </li>
      @endif
    </ul>
 
</aside>
