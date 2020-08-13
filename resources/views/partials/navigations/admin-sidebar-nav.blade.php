 <!-- Brand Logo -->
 <div class="brand-section">
      @if($settings->logoExists())
     <div class="brand-image">
          <a href="{{url('/')}}" class="brand-link" target="_blank">
               <img src="{{url($settings->getLogoLink())}}" alt="brand image">
          </a>
     </div>
     @endif
 <h1 class="app-name">{{ $settings->site_name ?? config('app.name', 'Laravel Ecommerce') }}</h1>
 </div>
<div class="logged-in-user">
     <div class="user-image">
          <img src="{{url('/img/user-default.png')}}" class="rounded-circle" alt="">
     </div>
     <div>Welcome, {{ Auth::user()->name}}</div>
</div>
<ul class="admin-nav-links">
     <li class="nav-item">
          <a class="nav-link" href="{{route('admin.dashboard')}}"><i class="fi fi-dashboard"></i> Dashboard</a>
     </li>
     <li class="nav-item">
          <span class="d-flex justify-content-between align-items-center">
               <a class="nav-link" href="{{route('admin.orders.index')}}"><i class="fi fi-file-black"></i> Orders</a>
               <a data-toggle="collapse" href="#orderLinks" role="button" aria-expanded="false" aria-controls="orderLinks">
                    <i class="fas fa-chevron-down submenu-down"></i>
               </a>
          </span>
          <div class="sidebar-submenu collapse" id="orderLinks">
               <a class="nav-link" href="{{route('admin.orders.complete')}}">Complete Orders</a>
          </div>
     </li>
     <li class="nav-item">
          <span class="d-flex justify-content-between align-items-center">
               <a class="nav-link" href="{{route('admin.reviews.index')}}"><i class="fi fi-star-full"></i> Reviews</a>
               <a data-toggle="collapse" href="#reviewLinks" role="button" aria-expanded="false" aria-controls="reviewLinks"><i class="fas fa-chevron-down submenu-down"></i></a>
          </span>
          <div class="sidebar-submenu collapse" id="reviewLinks">
               <a class="nav-link" href="{{route('admin.reviews.deleted')}}">Deleted Reviews</a>
          </div>
     </li>
     <li class="nav-item">
          <span class="d-flex justify-content-between align-items-center">
               <a class="nav-link" href="{{route('admin.codes.index')}}"><i class="fas fa-gift"></i> Discount Codes</a>
               <a data-toggle="collapse" href="#codeLinks" role="button" aria-expanded="false" aria-controls="codeLinks"><i class="fas fa-chevron-down submenu-down"></i></a>
          </span>
          <div class="sidebar-submenu collapse" id="codeLinks">
               <a class="nav-link" href="{{route('admin.codes.expired')}}">Expired Codes</a>
               <a class="nav-link" href="{{route('admin.codes.deactivated')}}">Deactivated Codes</a>
          </div>
     </li>
     <li class="nav-item">
          <span class="d-flex justify-content-between align-items-center">
               <a class="nav-link d-inline" href="{{route('admin.products.index')}}"><i class="fi fi-shopping-bag"></i> Products</a>
               <a data-toggle="collapse" href="#productLinks" role="button" aria-expanded="false" aria-controls="productLinks"><i class="fas fa-chevron-down submenu-down"></i></a>
          </span>
          <div class="sidebar-submenu collapse" id="productLinks">
               <a class="nav-link" href="{{route('admin.products.create')}}">Add New</a>
               <a class="nav-link" href="{{route('admin.products.deleted')}}">Inactive Products</a>
          </div>
     </li>
     <li class="nav-item">
          <a class="nav-link" href="{{route('admin.features.index')}}"><i class="fab fa-buffer"></i> Product Features</a>
     </li>

     <!--Admin and Superadmin menu only--> 
     @can('isAdmin')
     <li class="nav-item">
          <a class="nav-link" href="{{route('admin.categories.index')}}"><i class="fi fi-four-squares"></i> Categories</a>
      </li>
      <li class="nav-item">
           <a class="nav-link" href="{{route('admin.brands.index')}}"><i class="fi fi-copyright"></i> Brands</a>
      </li>
     <li class="nav-item">
          <span class="d-flex justify-content-between align-items-center">
               <a class="nav-link" href="{{route('admin.pages.index')}}"><i class="fi fi-copy"></i> Pages</a>
               <a data-toggle="collapse" href="#pageLinks" role="button" aria-expanded="false" aria-controls="pageLinks"><i class="fas fa-chevron-down submenu-down"></i></a>
          </span>
          <div class="sidebar-submenu collapse" id="pageLinks">
               <a class="nav-link" href="{{route('admin.pages.create')}}">Add New</a>
          </div>
     </li>
     @endcan
     <!--Superadmin menu only--> 
     @can('isSuperadmin')
     <li class="nav-item">
          <span class="d-flex justify-content-between align-items-center">
               <a class="nav-link" href="{{route('admin.administrators.index')}}"><i class="fas fa-user"></i> Administrators</a>
          </span>
     </li>
     <li class="nav-item">
          <span class="d-flex justify-content-between align-items-center">
               <a class="nav-link" href="{{route('admin.settings.edit')}}"><i class="fi fi-setting-line"></i> Settings</a>
               <a data-toggle="collapse" href="#settingsLinks" role="button" aria-expanded="false" aria-controls="settingsLinks"><i class="fas fa-chevron-down submenu-down"></i></a>
          </span>
          <div class="sidebar-submenu collapse" id="settingsLinks">
               <a class="nav-link" href="{{route('admin.settings.slides.index')}}">Slider Settings</a>
          </div>
     </li>
     @endcan
     <!--End Superadmin menu only--> 
</ul>
