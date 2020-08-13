@extends('layouts.app')

@section('content')
<!--Breadcrumbs-->
<div class="breadcrumbs">
    <div class="container-narrow">
    <a href="{{route('pages.landing')}}">Home</a>
    <span>></span>
    <a href="{{route('cart.index')}}">Cart</a>
</div>
</div> 
<!--End Breadcrumbs-->
<div class="cart-section container">
<div class="cart-holder">    
 <!--End Error Display-->
        @if($cart->count() > 0)
        <div class="side-split mb-4">  
                <a href="{{ route('pages.shop.index') }}" class="button button-dark">Continue Shopping</a> 
                <a href="{{route('cart.clear')}}" class="button button-dark">Clear Cart</a>
        </div>
        <h2>{{$cart->count()}} {{ $cart->count() == 1 ? 'item' : 'items'}} in shopping cart</h2> 
         <!--Cart table-->
         <div class="shadow-box mt-4">
            @include('partials.cart_partials.shopping-cart', ['totals' => $totals, 'cartView' => true])
        </div>
        <!--end of cart table-->

        <!--Cart Buttons-->
        <div class="cart-buttons mt-5">
            @if(auth()->user())
            <a href="{{ route('user.wishlist.index') }}" class="button button-black">Check Your Wishlist</a>
            <a href="{{ route('checkout.index') }}" class="button button-primary">Proceed To Checkout</a>
            @else
            <div></div>
            <div>
            <a href="{{ route('checkout.index') }}" class="button button-primary">Login & Checkout</a>
            <!--GUEST CHECKOUT LINK-->
            <a href="{{route('checkout.guest.index')}}" class="button button-dark">Checkout As A Guest</a>
            </div>
            @endif
        </div>
         <!--End Cart Buttons-->
         @else
            <div class="text-center my-5">
                <div class="no-items">
                    <i class="fi fi-shopping-bag mx-2"></i> Your Cart Is Empty
                </div>
                <p class="mt-3">Add some products to your cart now</p>
                @if(auth()->user())
                    <a href="{{ route('user.wishlist.index') }}" class="button button-black">Check Your Wishlist</a> 
                @endif
                <a href="{{ route('pages.shop.index') }}" class="button button-dark">Check Out Our Shop</a> 
            </div>
         @endif
    </div>
</div>
@endsection

@section('extra-footer')
<script type="text/javascript" src="{{ asset('js/scripts/cart.quantity.js') }}"></script>
@endsection