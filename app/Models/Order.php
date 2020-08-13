<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\Payment;
use App\Models\Delivery;
use Illuminate\Support\Str;

class Order extends Model
{
    /**
     * Set the attributes that are mass assignable.
     * @var array
     */
    protected $guarded = [];
   
    //CASTS
    protected $casts = [
        'billing_details' => 'array',
    ];

    // MODEL PROPERTIES
    private static $orderStatuses = ['ready','complete'];

    private static $activeStatuses = ['new', 'ready'];

    private static $defaultOrder = 'created_at:DESC';

    // APPENDED PROPERTIES
    protected $appends = ['payment_status', 'payment_type'];

    
    // MODEL RELATIONS
    /**
     * Relationship with User model
    */
    public function user(){
        return $this->belongsTo('App\Models\User');
    }
    /**
     * Relationship with Product model
    */
    public function products(){
        return $this->belongsToMany('App\Models\Product')->withPivot('item_price','quantity', 'user_id');
    }
    /**
     * Relationship with Payment model
    */
    public function payment(){
        return $this->hasOne('App\Models\Payment');
    }

    /**
     * Relationship with Delivery model
    */
    public function delivery(){
        return $this->hasOne('App\Models\Delivery');
    }


    //ACCESSORS AND MUTATORS

    //Payment Status
    public function getPaymentStatusAttribute()
    {
        if($this->payment instanceof Payment){ 
            return "Paid";
        }else{
            return "Unpaid";
        }
    }
   //Payment Type
    public function getPaymentTypeAttribute()
    {
        if($this->payment instanceof Payment){ 
            return $this->payment->payment_type;
        }else{
            return formatToText(Payment::getPaymentTypeForUnpaidOrders());
        }
    }
   
    //Created At Date
    public function getCreatedAtAttribute($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y-m-d');
    }

    //Completed At Date
    public function getCompletedAtAttribute($date)
    { 
        if($date !== null){
            return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y-m-d');
        }
        return $date;
    }

    //Order Ready At Date
    public function getReadyAtAttribute($date)
    { 
        if($date !== null){
            return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y-m-d');
        }
        return $date;
    }

    //BILLING SUBTOTAL
    //transform billing_subtotal field (convert integer to monatary value)
    public function getBillingSubtotalAttribute($value)
    {
        return convertIntToMoney($value);
    }

    //set billing_subtotal attribute for DB (convert monetary value to integer) 
    public function setBillingSubtotalAttribute($value)
    {
        $this->attributes['billing_subtotal'] = $value*100;
    }

    //BILLING TAX
    //transform billing_tax field (convert integer to monatary value)
    public function getBillingTaxAttribute($value)
    {
        return convertIntToMoney($value);
    }

    //set billing_tax attribute for DB (convert monetary value to integer) 
    public function setBillingTaxAttribute($value)
    {
        $this->attributes['billing_tax'] = $value*100;
    }

    //BILLING TOTAL
    //transform billing_total field (convert integer to monatary value)
    public function getBillingTotalAttribute($value)
    {
        return convertIntToMoney($value);
    }
    
    //set billing_total attribute for DB (convert monetary value to integer) 
    public function setBillingTotalAttribute($value)
    {
        $this->attributes['billing_total'] = $value*100;
    }
    
    //CARD DISCOUNT
    //transform card_discount field (convert integer to monatary value)
    public function getCardDiscountAttribute($value)
    {
        return convertIntToMoney($value);
    }

    //set billing_card_discount attribute for DB (convert monetary value to integer) 
    public function setCardDiscountAttribute($value)
    {
        $this->attributes['card_discount'] = $value*100;
    }

    
    // GETTERS OF CLASS PROPERTIES
    /**
     * Return order statuses
     */
    public static function orderStatuses(){
        return self::$orderStatuses;
    }

    /**
     * Return active order statuses
     */
     public static function activeStatuses(){
        return self::$activeStatuses;
    }


    // QUERY SCOPES
    public function scopeWithOrderedProducts($query){
        return $query->with(['products' => function($query){
            $query->withTrashed();
          }]);
    }

    public function scopeFindByOrderNumber($query, $orderNr){
        return $query->where('order_nr', $orderNr);
    }

    //Payment status based
    public function scopePaidOrders($query){
        return $query->whereHas('payment');
    }

    public function scopeUnpaidOrders($query){
        return $query->DoesntHave('payment');
    }

    //Order status based
    public function scopeCompleteOrders($query){
        return $query->where('status', 'complete')->orderBy('completed_at', 'DESC');
    }

    public function scopeActiveOrders($query){
        return $query->where('status', '!=' ,'complete');
        
    }

    public function scopeNewOrders($query){
        return $query->where('status', 'new');
    }

    public function scopeReadyOrders($query){
        return $query->where('status', 'ready');
    }

    public function scopeDefaultSort($query){
        $sorter = explode(':', self::$defaultOrder);
        return $query->orderBy($sorter[0], isset($sorter[1]) ? $sorter[1] : 'asc');
    }

    //MODEL METHODS

    /**
     * Returns if order payment status is paid or unpaid
     *  @return Bool
     */
    public function orderPaid(){
        if($this->payment instanceof Payment) return true;
        return false;
    }

    /**
     * Returns if order status is ready
     *  @return Bool
     */
    public function orderReady(){
        if($this->status == "ready") return true;
        return false;
    }

    /**
     * Returns if order status is complete
     *  @return Bool
     */
    public function orderComplete(){
        if($this->status == "complete") return true;
        return false;
    }

    /**
     * Returns if order status is delivered
     *  @return Bool
     */
    public function orderDelivered(){
        if(strtolower($this->delivery->delivery_status) == "delivered"){ 
            return true;
        }
        return false;
    }

    /**
     *  Eager load products (active and deactivated) associated with order 
     * @return void
     */
    public function loadProducts(){
        $this->load(['products' => function($query){ 
            $query->withTrashed();
        }]);
    }

    /**
     * Checks if authenticated user is owner of specific order
     * @return Bool
     */
    public function isOwner(){
        return auth()->id() == $this->user_id;
    }

}
