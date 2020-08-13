<div class='orderer-info'>  
      <div class="order-details-section">
            <span>Account Id: </span><span>{{$order->user_id}}</span>
      </div>  
      <div class="order-details-section">
            <span>Name: </span><span>{{$order->billing_details['name']}}</span>
      </div> 
      <div class="order-details-section">
            <span>Email: </span><span>{{$order->billing_details['email']}}</span>
      </div>  
      <div class="order-details-section">
            <span>Phone: </span><span>{{$order->billing_details['phone']}}</span>
      </div>
      <hr/>  
</div>  