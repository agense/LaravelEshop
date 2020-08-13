<div class='order-totals'>
  @if($order->card_discount != null)
        <div class="order-details-section">
            <span>Subtotal:</span><span>{{formatMoney( $order->subtotal_before_discount)}}</span>
        </div>  
        <div class="order-details-section">
            <span>Code Discount: </span><span>{{formatMoney($order->card_discount)}}</span>
        </div>  
  @else
    <div class="order-details-section">
      <span>Subtotal: </span><span>{{formatMoney($order->billing_subtotal)}}</span>
    </div>  
  @endif
      <div class="order-details-section">
        <span>Tax: </span><span>{{formatMoney($order->billing_tax)}}</span>
      </div>  
      <div class="order-details-section">
        <span><strong>ORDER TOTAL:</strong></span>
        <span><strong>{{formatMoney($order->billing_total)}}</strong></span>
      </div>  
</div>  