<div class="order-table">
        @foreach($order->products as $product)
        <div class="order-table-row">
            <div>
                <div class="cart-table-img">
                    <img src="{{ asset($product->featured_image_link)}}" alt="{{$product->name}}">
                </div> 
            </div>
            <div class="cart-item-details">
                <div class="cart-table-details">
                    <a href="{{route('pages.shop.show', $product->slug )}}" class="product-name">
                       {{$product->name}}
                    </a>
                </div>
                <div>{{$product->brand->name}}</div>
            </div> 
            <div class="cart-item-price">
                <span><strong>Item Price</strong></span>
                <span>{{formatMoney($product->pivot->item_price)}}</span>
            </div>
            <div class="cart-item-qty">
                <span><strong>Quantity</strong></span>
                <span>{{$product->pivot->quantity}}</span>
            </div>
        </div>
        @endforeach
   </div>