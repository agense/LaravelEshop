<h1>{{ config('app.name', 'Laravel Ecommerce') }}</h1>
<div class="logged-in-user">
          Welcome, {{ Auth::user()->name }}
</div>
<ul>
     <li class="nav-item">
          <a class="nav-link" href="{{route('admin.dashboard')}}"><i class="fi fi-dashboard"></i> Dashboard</a>
     </li>
     <li class="nav-item">
         <a class="nav-link" href="{{route('categories.index')}}"><i class="fi fi-four-squares"></i> Categories</a>
     </li>
     <li class="nav-item">
          <a class="nav-link" href="{{route('brands.index')}}"><i class="fi fi-copyright"></i> Brands</a>
     </li>

     <li class="nav-item">
     <span class="d-flex justify-content-between align-items-center">
          <a class="nav-link d-inline" href="{{route('products.index')}}"><i class="fi fi-shopping-bag"></i> Products</a>
          <a data-toggle="collapse" href="#productLinks" role="button" aria-expanded="false" aria-controls="productLinks"><i class="fas fa-chevron-down submenu-down"></i></a>
     </span>
          <div class="sidebar-submenu collapse" id="productLinks">
               <a class="nav-link" href="{{route('products.create')}}">Add New</a>
               <a class="nav-link" href="{{route('admin.products.deleted')}}">Deleted Products</a>
          </div>
     </li>

     <li class="nav-item">
          <span class="d-flex justify-content-between align-items-center">
               <a class="nav-link" href="{{route('admin.reviews')}}"><i class="fi fi-star-full"></i> Reviews</a>
               <a data-toggle="collapse" href="#reviewLinks" role="button" aria-expanded="false" aria-controls="reviewLinks"><i class="fas fa-chevron-down submenu-down"></i></a>
          </span>
          @can('isAdmin')
               <div class="sidebar-submenu collapse" id="reviewLinks">
                    <a class="nav-link" href="{{route('admin.reviews.deleted')}}">Deleted Reviews</a>
               </div>
          @endcan
     </li>

     <li class="nav-item">
          <a class="nav-link" href="{{route('admin.orders.index')}}"><i class="fi fi-file-black"></i> Orders</a>
     </li>

     <li class="nav-item">
          <span class="d-flex justify-content-between align-items-center">
               <a class="nav-link" href="{{route('coupons.index')}}"><i class="fi fi-tags"></i> Discount Cards</a>
               <a data-toggle="collapse" href="#cardLinks" role="button" aria-expanded="false" aria-controls="cardLinks"><i class="fas fa-chevron-down submenu-down"></i></a>
          </span>
          @can('isAdmin')
               <div class="sidebar-submenu collapse" id="cardLinks">
                    <a class="nav-link" href="{{route('coupons.create')}}">Add New</a>
               </div>
          @endcan
     </li>

     <li class="nav-item">
          <span class="d-flex justify-content-between align-items-center">
               <a class="nav-link" href="{{route('pages.index')}}"><i class="fi fi-copy"></i> Pages</a>
               <a data-toggle="collapse" href="#pageLinks" role="button" aria-expanded="false" aria-controls="pageLinks"><i class="fas fa-chevron-down submenu-down"></i></a>
          </span>
          @can('isAdmin')
               <div class="sidebar-submenu collapse" id="pageLinks">
                    <a class="nav-link" href="{{route('pages.create')}}">Add New</a>
               </div>
          @endcan
     </li>

     @can('isSuperadmin')
     <li class="nav-item">
          <span class="d-flex justify-content-between align-items-center">
               <a class="nav-link" href="{{route('administrators.index')}}"><i class="fas fa-user"></i> Administrators</a>
               <a data-toggle="collapse" href="#adminLinks" role="button" aria-expanded="false" aria-controls="adminLinks"><i class="fas fa-chevron-down submenu-down"></i></a>
          </span>
          <div class="sidebar-submenu collapse" id="adminLinks">
               <a class="nav-link" href="{{route('administrators.create')}}">Add New</a>
          </div>
     </li>

     <li class="nav-item">
          <a class="nav-link" href="{{route('admin.settings.edit')}}"><i class="fi fi-setting-line"></i> Settings</a>
     </li>
     @endcan

</ul>
