<div class="col-md-3 my-4 user-sidebar">
    <div class="py-4">
        <div class="sidebar-head d-flex justify-content-between align-items-center">
        <h1 class="mini-header mb-2">MANAGE ACCOUNT</h1>
        <span id="user-account-sidebar-toggler"><i class="fas fa-chevron-down"></i></span>
        </div>
        <div id="user-account-sidebar">
        <ul>
            <li class="{{ Request::is('user/account') ? 'active' : '' }}">
                <a href="{{route('user.account.index')}}"><i class="fi fi-id-proof-black"></i> Dashboard</a>
            </li>
            <li class="{{ Request::is('user/account/edit') ? 'active' : '' }}">
                <a href="{{route('user.account.edit')}}"><i class="far fa-address-card"></i> Account Details</a>
            </li>
            <li class="{{ Request::is('user/orders') ? 'active' : '' }}">
                <a href="{{route('user.orders.index')}}"><i class="fi fi-shopping-bag-option"></i> Orders</a>
            </li>
            <li class="{{ Request::is('user/reviews') ? 'active' : '' }}">
                <a href="{{route('user.reviews.index')}}"><i class="fi fi-star-full"></i> Review Products</a>
            </li>   
            <li class="{{ Request::is('user/wishlist') ? 'active' : '' }}">
                <a href="{{route('user.wishlist.index')}}"><i class="fi fi-heart-line"></i> Wishlist</a>
            </li> 
        </ul>
        </div>
    </div>    
</div>