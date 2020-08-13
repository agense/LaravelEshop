    <nav class="navbar navbar-expand-lg navbar-light bg-light admin-nav" id="admin-nav">
    <div class="container">
    <button class="navbar-toggler" type="button">
      <span class="navbar-toggler-icon" id="sidenav-toggler"></span>
    </button>
    <div class="page-title">@yield('title')</div>
    <div>
      <!-- Right Side Of Navbar -->
      <ul class="nav navbar-nav navbar-right">
            <!-- Authentication Links -->
            @guest
                <li class="nav-item"><a href="{{ route('admin.login') }}" class="nav-link">Login</a></li>
            @else
            <li class="nav-item logout-link">
                    <a href="{{ route('logout') }}" class="nav-link submenu-link" 
                        onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                        <i class="fas fa-power-off"></i>&nbsp;Logout
                    </a>
                    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </li>
            @endguest
        </ul>
    </div>
  </div>
  </nav>