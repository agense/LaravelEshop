<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Order Received Email</title>
</head>
<body>
<div style="width:80%; margin:5rem auto; font-family:'Raleway', sans-serif; color:#535353;; font-size:0.9rem">   
    <div style="text-align:center; margin-bottom:1rem">
        <div style="margin-bottom:1rem; font-size:1.2rem"><strong>Thank You For Your Order!</strong></div>
        <div style="margin-bottom:0.5rem;"><strong>Order Nr.: {{$order->order_nr}} </strong></div>
        <div><strong>Order Date: {{$order->created_at}}</strong></div>
    </div>
        <!--products-->    
        <div style="margin-top:2rem">
            <div style="font-weight: 400;font-size: 1rem; color: #efefef; margin-bottom: 1rem; text-transform:uppercase; text-align:left; background: #212121; padding: 1rem 2rem;margin-top: 4rem;">Order Products</div>
            <div>
                @foreach($order->products as $product)
                    <div style="display:flex; align-items:center">
                        <div style="width:200px; margin:0">
                            <img src="{{ asset($product->featured_image_link)}}" alt="{{$product->name}}" style="width:100%; height:100px; object-fit:contain">
                        </div>
                        <div style="width:calc(100% - 200px); margin:0; display:flex; justify-content:space-between">
                            <div style="text-align:left; margin-left:1rem">
                                <div><a href="{{route('pages.shop.show', $product->slug )}}" style="text-decoration:none; font-weight: 400;font-size: 1rem; color: #989898!important; margin-bottom: 1rem; text-transform:uppercase; text-align:left">{{$product->name}}</a></div>
                                <div style="margin-top: 0.5rem">{{$product->brand}}</div>
                            </div>
                            <div style="text-align:center">
                                <span>Item Price: </span><br>
                                <span>{{formatMoney($product->pivot->item_price)}}</span>
                            </div>
                            <div style="text-align:center; margin-right:2rem">
                                <span>Quantity: </span><br>
                                <span>{{$product->pivot->quantity}}</span>
                            </div>
                        </div> 
                    </div>
                @endforeach
            </div>
            <!--totals -->
            <div style="width:100%;padding: 0.5rem 0;border-bottom:1px solid #efefef;"></div>
            <div style="padding: 1rem;float:right;">
                <h3 style="font-weight: 400;font-size: 1rem; color: #989898; text-transform:uppercase; text-align:left">Order Totals</h3>
                @include('partials.order_partials.order-totals-for-email')
                <div></div>
            </div>
            <!--end Totals-->
        </div>
        <div style="clear:both; display:block; padding-top:3rem; padding-bottom:1rem; text-align:center">
            <div style="padding-bottom:1rem"><strong>Your order is being processed. We will inform you by email once the order is ready.</strong></div>
           <div><strong> You can also check your order status here:</strong></div>
            <a href="{{route('user.orders.show', $order->id)}}" style="display:block;width:10rem; margin:1.5rem auto;text-decoration:none;color:#fff!important;background: #3bb79c;padding: 0.75rem 2.5rem; font-size: 0.95rem;text-transform: uppercase;">My Order</a>
        </div>
        <!--end products-->
</div>
</body>
</html>    
