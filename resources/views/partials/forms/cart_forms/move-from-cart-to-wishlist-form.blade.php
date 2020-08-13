<form action="{{ route('user.wishlist.moveFromCart', $item->rowId) }}" method="POST">
    {{ csrf_field() }}
    <button type="submit" class="cart-options" data-toggle="tooltip" data-placement="bottom" title="You need to be logged in to save items in the wishlist.">Move To Wishlist</button>
</form>