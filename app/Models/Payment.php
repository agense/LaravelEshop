<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\ProcessingHandlers;
use App\Models\User;
use App\Models\Admin;
use Carbon\Carbon;

class Payment extends Model
{
    use ProcessingHandlers;

    /**
     * Disable Timestamps
     */
    public $timestamps = false;

    // APPENDED PROPERTIES
    protected $appends = ['handler'];

    // MODEL PROPERTIES

    /**
     * Sets available payment statuses.
     */
    private static $paymentStatuses = ['paid', 'unpaid'];

    /**
     * Sets available payment options.
     * Additional options can be added
     */
    private static $paymentTypes = ['on_delivery'];

    /**
     * Sets available payment methods for non prepayed orders.
     */
    private static $onDeliveryPaymentMethods = ['cash'];


    // ACCESSORS AND MUTATORS
    
    // PAYMENT TYPE
    public function getPaymentTypeAttribute($value)
    {
        return formatToText($value);
    }

    // PAYMENT METHOD
    public function getPaymentMethodAttribute($value)
    {
        return formatToText($value);
    }

    //PAYMENT AMOUNT
    public function getAmountAttribute($value)
    {
        return convertIntToMoney($value);
    }

    public function setAmountAttribute($value)
    {
        $this->attributes['amount'] = $value*100;
    }
       
    //PAYMENT DATE
    public function getPaidAtAttribute($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y-m-d');
    }

    //PAYMENT HANDLER
    public function getHandlerAttribute()
    {
        if($this->handler_role !== null){
            return $this->getHandlerInfo();
        }
        return null;
    }

    // MODEL RELATIONS
    /**
     * Relationship with Order Model
    */
    public function order(){
        return $this->belongsTo('App\Models\Order');
    }

    // MODEL PROPERTY GETTERS
     /**
     * Return payment statuses
     */
    public static function paymentStatuses(){
        return self::$paymentStatuses;
    }
    /**
     * Return payment type options
     */
    public static function paymentOptions(){
        return self::$paymentTypes;
    }

    /**
     * Return payment methods for on delivery payment type
     */
    public static function paymentMethodsForUnpaidOrders(){
        return self::$onDeliveryPaymentMethods;
    }

    /**
     * Returns the name (snake_case) for the option to pay later
     */
    public static function getPaymentTypeForUnpaidOrders(){
        return self::$paymentTypes[0];
    }

}
