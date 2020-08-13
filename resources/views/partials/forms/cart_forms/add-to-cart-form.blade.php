<form action="{{route('cart.store')}}" method="POST">
    {{ csrf_field() }}
    <input type="hidden" name="id" value="{{$product->id}}">
    <input type="hidden" name="name" value="{{$product->name}}">
    <input type="hidden" name="price" value="{{$product->price}}">
    <button type="submit" class="button btn-black btn-full-narrow">Add To Cart</button>
</form>