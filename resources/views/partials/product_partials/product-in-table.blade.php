<div class="cart-table-img">
    <img src="{{asset($item->model->featured_image_link)}}" alt="product" class="checkout-table-img">
</div>
<div class="checkout-item-details">
    <div class="checkout-table-item">
        <a href="{{route('pages.shop.show', $item->model->slug )}}" class="cart-table-title">{{$item->model->name}}</a>
    </div>
    <div class="checkout-table-description">{{$item->model->brand->name}}</div>
</div>