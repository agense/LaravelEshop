<form action="{{route('user.wishlist.add', $product->id)}}" method="POST">
    {{ csrf_field() }}
    <button type="submit" class="button-gray text-uppercase btn-full-narrow"><i class="fi fi-heart-line mr-1"></i> Add To Wishlist</button>
</form>