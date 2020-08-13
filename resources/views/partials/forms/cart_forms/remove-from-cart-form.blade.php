<form action="{{ route('cart.destroy', $item->rowId) }}" method="POST">
    {{ csrf_field() }}
    {{ method_field('DELETE') }}<!--Change method from post to delete-->
    <button type="submit" class="cart-options">Remove From Cart</button>
</form>
