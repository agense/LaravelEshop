<div class="featured-section section-gray">
    <div class="container">
        <h2 class="subheading">Suggested Products</h2>
        <div class="suggested-items">
            @foreach($suggestedProducts as $product)
                <div class="product">
                        <div class="product-img">
                        <a href="{{route('shop.show', $product->slug)}}">
                        <img src="{{ asset('/img/products/'.$product->featured_image)}}" alt="product">
                        </a>
                        </div>
                        <div class="product-copy">
                        <a href="{{route('shop.show', $product->slug)}}">
                            <div class="product-name">{{$product->brand->name}} | {{$product->name}}</div>
                        </a>
                        <div class="product-price">{{$product->displayPrice()}}</div>
                        </div>
                    </div>
            @endforeach
        </div>
    </div>
</div>
 