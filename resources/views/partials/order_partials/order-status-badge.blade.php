<div>
  @if($order->orderReady())
    <span class='badge status-badge badge-info'>{{ucwords($order->status)}}</span>
  @elseif($order->orderComplete())
      <span class='badge status-badge badge-success'>{{ucwords($order->status)}}</span>
  @else
        <span class='badge status-badge badge-warning'>{{ucwords($order->status)}}</span>
  @endif
</div>  
