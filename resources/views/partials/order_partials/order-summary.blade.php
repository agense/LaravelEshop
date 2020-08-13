<h2 class="mini-header">Order Summary</h2> 
<div>Total: {{formatMoney($order->billing_total)}}</div>
<div>Payment: {{$order->payment_status}}</div>
<div>Delivery: {{$order->delivery->delivery_status}}</div>
<div><a href="{{route('user.orders.show', $order->id)}}" class="mt-3 btn-sm btn-dark-border-sm opn-create">
    Order Details <i class="fas fa-chevron-right ml-1"></i></a>
</div>