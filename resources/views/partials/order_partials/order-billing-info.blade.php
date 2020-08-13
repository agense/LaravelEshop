      <div>  
       <div class='billing-name'>
          {{ucfirst($order->billing_details['name'])}}
        </div>  
        <div>
          {{ucfirst($order->billing_details['address'])}}
        </div> 
        <div>
          <span>{{ucfirst($order->billing_details['city'])}},</span>
          <span>{{ucfirst($order->billing_details['region'])}},</span>
          <span>{{$order->billing_details['postalcode']}}</span>
        </div>  
      </div>  