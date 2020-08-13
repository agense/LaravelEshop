<form action="{{route('user.wishlist.moveToCart', $item->id)}}" method="POST">
    {{ csrf_field() }}
    <button type="submit" class="cart-options">Move to Cart</button>
</form>