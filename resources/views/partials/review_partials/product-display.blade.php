<div class="card-header">
    <div class="d-flex align-items-center justify-content-center">
    <div class="cart-table-img mr-4">
        <img src="{{ asset($product->featured_image_link)}}" alt="{{$product->name}}">
    </div> 
    <div class="cart-item-details">
        <div class="cart-table-details">
            <a href="{{route('pages.shop.show', $product->slug )}}" class="product-name">{{$product->name}}</a>
        </div>
        <div>{{$product->brand->name}}</div>
    </div>
    </div> 
</div>