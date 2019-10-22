<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * Set the attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 'user_id', 'order_nr', 'order_status', 'billing_email', 'billing_name', 'billing_address', 'billing_city', 
    'billing_region', 'billing_postalcode', 'billing_phone', 'billing_name_on_card', 'coupon_discount_amount', 
    'coupon_discount_code', 'billing_subtotal', 'billing_tax', 'billing_total', 'paid', 'payment_type',
    'payment_gateway', 'payment_date', 'delivered', 'error'];

    /** Payment Gateaway */
    private $paymentGateway = null;

    /** Order Statuses */
    private $orderStatuses = [
        "Received" => 0,
        "Ready" => 1,
        "Completed" => 2
    ];

    /** Order Payment Statuses */
    private $orderPaymentStatuses = [
        "Unpaid" => 0,
        "Paid" => 1
    ];

    /** Order Delivery Statuses */
    private $orderDeliveryStatuses = [
        "In Process" => 0,
        "Delivered" => 1,
    ];

    /**
     * Relationship with User model
    */
    public function user(){
        return $this->belongsTo('App\User');
    }
    /**
     * Relationship with Product model
    */
    public function products(){
        return $this->belongsToMany('App\Product')->withPivot('item_price','quantity');
    }
    /**
     * Return Payment Gateway
    */
    public static function paymentGateway(){
        $order = new self();
        return $order->paymentGateway;
    }
    /**
     * Return order statuses
     */
    public function orderStatuses(){
        return $this->orderStatuses;
    }

    /**
     * Return order payment statuses
     */
    public function orderPaymentStatuses(){
        return $this->orderPaymentStatuses;
    }

    /**
     * Return order delivery statuses
     */
    public function orderDeliveryStatuses(){
        return $this->orderDeliveryStatuses;
    }

}
