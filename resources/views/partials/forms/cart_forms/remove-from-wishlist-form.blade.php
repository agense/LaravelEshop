<form action="{{route('user.wishlist.remove', $item->id)}}" method="POST">
    {{ csrf_field() }}
    {{ method_field('DELETE') }}
    <button type="submit" class="cart-options">Remove</button>
</form>