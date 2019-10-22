
<nav class="navbar navbar-expand-lg navbar-dark bg-primary navbat-top">
        <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'Laravel') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarColor01">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item dropdown">
                <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">Shop</a>
                <ul class="dropdown-menu submenu">
                    <li class="nav-item"><a class="nav-link" href="{{route('shop.index')}}">All Products</a></li>
                    @foreach($categoryList as $name => $value )
                    <li class="nav-item"><a href="{{ route('shop.index', ['category' => $value]) }}" class="nav-link">{{$name}}</a></li>
                    @endforeach 
                </ul>
            </li>
            <li class="nav-item">
                    <a class="nav-link" href="{{route('contact.show')}}">Need Help ?</a>
            </li>
          </ul>
          <!-- Right Side Of Navbar -->
          <ul class="nav navbar-nav navbar-right mr-2">
                <!-- Authentication Links -->
                @guest
                    <li class="nav-item dropdown">
                        <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true" v-pre>
                                <span class="mr-1"><i class="far fa-user"></i></span> Login <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu user-dropdown">
                            <li class="nav-item dropdown"><a href="{{ route('login') }}" class="nav-link"> Login</a></li>
                            <li class="nav-item"><a href="{{ route('register') }}" class="nav-link">New Account</a></li>
                        </ul>
                    </li>    
                @else
                    <li class="nav-item dropdown">
                        <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu user-dropdown">
                            <li class="nav-item">
                                <a href="{{route('userAccount.index')}}" class="nav-link submenu-link">My Account</a>
                            </li>
                            <li class="nav-item">
                                    <a href="{{route('user.orders')}}" class="nav-link submenu-link">My Orders</a>
                            </li>
                            <li class="nav-item"><a href="{{route('user.reviews')}}" class="nav-link submenu-link">My Reviews</a></li>
                            <li class="nav-item"><a href="{{route('user.wishlist')}}" class="nav-link submenu-link">My Wishlist</a></li>
                            <li class="nav-item">
                                <a href="{{ route('logout') }}" class="nav-link submenu-link" 
                                    onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                    Logout
                                </a>
                                <form id="logout-form" action="{{ route('user.logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </li>
                @endguest
                <li class="nav-item">
                    <a href="{{route('cart.index')}}" class="nav-link">
                        <span class="cart-icon"><i class="fi fi-shopping-bag"></i></span>
                        @if(Cart::instance('default')->count() > 0)
                            <span class="cart-count">{{ Cart::instance('default')->count() }}</span>
                        @endif
                    </a>
                </li>
            </ul>
        </div>
      </div>
      </nav>