  <div>
    @if(!isset($partialView) || $partialView != true)
    <div class="order-details-section">
      <strong>Payment Status: </strong><span>{{$order->payment_status }}</span>
    </div>
    <div class="order-details-section">
      <strong>Payment Type: </strong><span>{{$order->payment_type}}</span>
    </div>
    @endif
    @if($order->orderPaid())
      <div class="order-details-section">
        <strong>Payment Method: </strong><span>{{$order->payment->payment_method}}</span>
      </div>
      <div class="order-details-section">
        <strong>Payment Date: </strong><span>{{$order->payment->paid_at}}</span>
      </div>
      <div class="order-details-section">
        <strong>Payment Amount: </strong><span>{{formatMoney($order->payment->amount)}}</span>
      </div>
      <div class="order-details-section">
        <strong>Processed By: </strong><span>{{$order->payment->getHandlerInfo()}}</span>
      </div>
    @endif
  </div>