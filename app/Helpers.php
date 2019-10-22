<?php
use App\Setting;

/**
 * Return formatted price for display
 * @param integer price
 * @return string formatted price
 */
function displayPrice($price){
    $currency = Setting::displayCurrency();
    return $currency .' '.number_format($price/100, 2);
}

/**
 * Return product Availability for display
 * @param integer availabiity
 * @return html
 */
function displayAvailability($availability){
   if($availability > 3){
     return '<span class="badge badge-success">In Stock</span>';
   }elseif($availability <= 3 && $availability > 0){
    $itm = $availability == 1 ? ' item ' : ' items ';
    return '<span class="badge badge-warning">Only '.$availability.$itm.' left</span>';
   }else{
    return '<span class="badge badge-danger">Sold Out</span>';
   }
}

/**
 * Return formatted date for display
 * @param string date
 * @return string date
 */
function formatDate($date){
  return date( 'Y-m-d', strtotime($date));
}

/**
 * Return formatted date for saving in the DB
 * @param date as timestamp or string 
 * @return string date
 */
function formatDateForDB($date){
  if(is_int($date)){
    return date( 'Y-m-d h:i:s', $date);
  }else{
    return date( 'Y-m-d h:i:s', strtotime($date));
  }
}

//ORDER DISPLAY HELPERS

/**
 * Return order status for display
 * @param Order object
 * @return html
 */
function orderStatus($order){
  if($order->order_status === 0){
      return "<span class='badge status-badge badge-warning'>Received</span>";
  }elseif($order->order_status === 1){
      return "<span class='badge status-badge badge-info'>Ready</span>";
  }elseif($order->order_status == 2){
      return "<span class='badge status-badge badge-success'>Completed</span>";
  }else{
      return "<span class='badge status-badge badge-danger'>Undefined</span>";
  }
}

/**
 * Return order payment status for display
 * @param Order object
 * @return string order payment status value
 */
function orderPaymentStatus($order){
  if(in_array($order->payment_status, $order->orderPaymentStatuses())){
    return key($order->orderPaymentStatuses());
  }
}
      
/**
 * Return order delivery status for display
 * @param Order object
 * @return string order delivery status value
 */
function orderDeliveryStatus($order){
  if(in_array($order->delivered, $order->orderDeliveryStatuses())){
    return key($order->orderDeliveryStatuses());
  }
}

/**
 * Return order details for display
 * @param Order object
 * @return html
 */
function displayOrderMainInfo($order){
  $display = "<div class='order-info'>";
  $display .= "<div><span>Order Id:</span><span> ".$order->id."<span></div>";
  $display .= "<div><span>Order Nr: </span><span> ".$order->order_nr."<span></div>";
  $display .= "<div><span>Order Date: </span><span> ".formatDate($order->created_at)."<span></div><br/>";
  $display .= "<div><span>Order Status: </span><span> ".orderStatus($order)."<span></div>";
  $display .= "<div><span>Payement Status: </span><span> ".orderPaymentStatus($order)."<span></div>";
  $display .= "<div><span>Delivery Status: </span><span> ".orderDeliveryStatus($order)."<span></div>";
  $display .= "</div>";
  return $display;
}

/**
 * Return order billing details for display
 * @param Order object
 * @return html
 */
function displayBillingInfo($order){
  $display = "<div>";
  $display .= "<div class='billing-name'>$order->billing_name</div>";
  $display .= "<div>$order->billing_address</br>";
  $display .= "$order->billing_city, $order->billing_region, $order->billing_postalcode</div>";
  $display .= "</div>";
  return $display;
}

/**
 * Return customers details for order display
 * @param Order object
 * @return html
 */
function displayOrderersInfo($order){
  $display = "<div class='orderer-info'>";
  $display .= "<div><span>Order Account Id: </span><span>$order->user_id</span></div>";
  $display .= "<div><span>Orderers Email: </span><span>$order->billing_email</span></div>";
  $display .= "<div><span>Orderers Phone: </span><span>$order->billing_phone</span></div><hr/>";
  $display .= "</div>";
  $display .= "<span><strong>BILLING ADDRESS</strong></span>";
  $display .= displayBillingInfo($order);
  return $display;
}

/**
 * Return order totals for display
 * @param Order object
 * @return html
 */
function displayOrderTotals($order){
  $display = "<div class='order-totals'>";
 
  if($order->coupon_discount_code != null){
    $totalBeforeDiscount = 0;
    foreach($order->products as $product){
      $itemTotal = $product->pivot->item_price * $product->pivot->quantity;
      $totalBeforeDiscount .= $itemTotal;
    }
    $display .= "<hr/><div><span>Subtotal Before Discount: </span><span>".displayPrice($totalBeforeDiscount)."</span></div>";
    $display .= "<div><span>Coupon Discount: </span><span>".displayPrice($order->coupon_discount_amount)."</span></div>";
    $display .= "<div><span>Coupon Discount Code: </span><span>". $order->coupon_discount_code."</span></div><hr/>";
  }
  $display .= "<div><span>Subtotal: </span><span>".displayPrice($order->billing_subtotal)."</span></div>";
  $display .= "<div><span>Tax: </span><span>".displayPrice($order->billing_tax)."</span></div>";
  $display .= "<div><span><strong>ORDER TOTAL: </strong></span><span><strong>"
  . displayPrice($order->billing_total)."</strong></span></div>";
  $display .= "</div>";
  return $display;
}

/**
 * Return order totals for display in emails
 * @param Order object
 * @return html
 */
function displayOrderTotalsForMail($order){
  $display = "<div>";
 
  if($order->coupon_discount_code != null){
    $totalBeforeDiscount = 0;
    foreach($order->products as $product){
      $itemTotal = $product->pivot->item_price * $product->pivot->quantity;
      $totalBeforeDiscount .= $itemTotal;
    }
    $display .= "<div><span style='display:inline-block; width:200px; padding-bottom:0.25rem'>Subtotal Before Discount: </span><span>".displayPrice($totalBeforeDiscount)."</span></div>";
    $display .= "<div><span style='display:inline-block; width:200px; padding-bottom:1rem'>Coupon Discount: </span><span>".displayPrice($order->coupon_discount_amount)."</span></div>";
  }
  $display .= "<div><span style='display:inline-block; width:200px; padding-bottom:0.25rem'>Subtotal: </span><span>".displayPrice($order->billing_subtotal)."</span></div>";
  $display .= "<div><span style='display:inline-block; width:200px; padding-bottom:0.5rem'>Tax: </span><span>".displayPrice($order->billing_tax)."</span></div>";
  $display .= "<div><span style='display:inline-block; width:200px;'><strong>ORDER TOTAL: </strong></span><span><strong>"
  . displayPrice($order->billing_total)."</strong></span></div>";
  $display .= "</div>";
  return $display;
}

/**
 * Return order payment details for display
 * @param Order object
 * @return html
 */
function displayPaymentDetails($order){
  $display = "<div class='order-payment-details'>";
  $display .= "<div><span>Payment Status: </span><span>".orderPaymentStatus($order)."</span></div>";
  $display .= "<div><span>Payment Type: </span><span>".ucwords($order->payment_type)."</span></div>";
  if($order->paid == 1){
    if($order->payment_gateway !== null){
      $display .= "<div><span>Payment Gateway: </span><span>".ucwords($order->payment_gateway)."</span></div>";
    }
    $display .= "<div><span>Payment Date: </span><span>".formatDate($order->payment_date)."</span></div>";
  }
  $display .= "</div>";
  return $display;
}

/**
 * Return product star rating for display
 * @param integer $rating
 * @return html
 */
function displayStars($rating){
  $stars = '<span class="star-rating">';
  for($i = 1; $i <= $rating; $i++){
    $stars.= '<span><i class="fi fi-star-full"></i></span>';
  }
  $stars .= '</span>';
  return $stars;
}

/**
 * Return active category for the menu display
 */
function setActiveCategory($category, $output = "active"){
  return request()->category == $category ? $output : '';
}