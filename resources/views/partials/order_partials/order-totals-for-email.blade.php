<div> 
    @if($order->card_discount != null)
       <div><span style='display:inline-block; width:200px; padding-bottom:0.25rem'>Subtotal: </span><span> {{formatMoney($order->subtotal_before_discount) }}</span></div> 
       <div><span style='display:inline-block; width:200px; padding-bottom:1rem'>Code Discount: </span><span> {{formatMoney($order->card_discount) }}</span></div> 
    @else 
    <div><span style='display:inline-block; width:200px; padding-bottom:0.25rem'>Subtotal: </span><span> {{formatMoney($order->billing_subtotal) }}</span></div> 
    @endif
     <div><span style='display:inline-block; width:200px; padding-bottom:0.5rem'>Tax: </span><span> {{formatMoney($order->billing_tax) }}</span></div> 
     <div><span style='display:inline-block; width:200px;'>
        <strong>ORDER TOTAL: </strong></span>
        <span><strong>{{formatMoney($order->billing_total) }}</strong></span>
    </div> 
</div> 
