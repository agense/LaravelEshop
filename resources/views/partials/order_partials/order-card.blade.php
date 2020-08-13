<div class="card border-secondary mb-3">
    @if($order->orderComplete())
    <div class="card-header side-split order-header order-complete">
    @else
    <div class="card-header side-split order-header">  
    @endif    
      <div>
          <span class="text-uppercase">Order Date: {{$order->created_at}} |</span> 
          <span>Order# {{$order->order_nr}}</span>
     </div>
      <div>
        @include('partials.order_partials.order-status-badge')
      </div>
    </div>
    <div class="card-body">
      <div class="side-split align-items-center">
          <div class="order-product-list">
            @foreach($order->products as $product)
            <div class="d-flex justify-content-between align-items-center mb-2">
                <div class="cart-item-details simple-flex">
                    <div class="table-img">
                        <img src="{{ asset($product->featured_image_link)}}" alt="{{$product->name}}">
                    </div> 
                    <div class="ml-2">
                        <a href="{{route('pages.shop.show', $product->slug )}}" class="details-text">
                        {{$product->name}}
                        </a><br/>
                        <span>{{$product->brand->name}}</span>
                    </div>
                </div>
                <div><span class="bordered-qty">{{$product->pivot->quantity}}</span></div>
            </div>
            @endforeach
          </div>
          <div class="order-summary">
                @include('partials.order_partials.order-summary')
          </div>
      </div>
    </div>
</div>