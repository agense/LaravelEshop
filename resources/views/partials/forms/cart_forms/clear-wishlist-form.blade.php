<form action="{{route('user.wishlist.clear')}}" method="POST">
    {{ csrf_field() }}
    {{ method_field('DELETE') }}
    <button type="submit" class="btn-sm btn-dark-sm">Clear Wishlist</button>
</form>