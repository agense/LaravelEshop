<div class="col-md-3 my-4 user-sidebar">
        <div class="sidebar-head d-flex justify-content-between align-items-center">
        <h1 class="mini-header">MANAGE ACCOUNT</h1>
        <span id="user-account-sidebar-toggler"><i class="fas fa-chevron-down"></i></span>
        </div>
        <div id="user-account-sidebar">
        <ul>
            <li><a href="{{route('userAccount.index')}}"><i class="fi fi-id-proof-black"></i>My Account</a></li>
            <li><a href="{{route('userAccount.edit')}}"><i class="fi fi-file-black"></i> Update Account</a></li>
            <li><a href="{{route('user.orders')}}"><i class="fi fi-shopping-bag-option"></i> My Orders</a></li>
            <li><a href="{{route('user.reviews')}}"><i class="fi fi-star-full"></i> Review Products</a></li>   
            <li><a href="{{route('user.wishlist')}}"><i class="fi fi-heart-line"></i> My Wishlist</a></li> 
        </ul>
        </div>
</div>