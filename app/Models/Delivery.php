<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ProcessingHandlers;

class Delivery extends Model
{
    use ProcessingHandlers;

    protected $guarded = [];

    // APPENDED PROPERTIES
    protected $appends = ['handler'];

    /**
     * Available Delivery Options
     * Additional values can be added.
     */
    private static $deliveryTypes = ['in_store_pickup'];

    /**
     * Available delivery statuses
     * Additional values can be added.
     */
    private static $deliveryStatuses = ['in_process', "delivered"];

    // ACCESSORS & MUTATORS
    //Delivery Date
    public function getDeliveredAtAttribute($date)
    { 
        if($date !== null){
            return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y-m-d');
        }
        return $date;
    }

    //transform delivery_status field for display
    public function getDeliveryStatusAttribute($value)
    {
        return formatToText($value);
    }

    //transform delivery_type field for display
    public function getDeliveryTypeAttribute($value)
    {
        return formatToText($value);
    }

    // delivery handler
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
     * Return order delivery statuses
     */
    public static function deliveryStatuses(){
        return self::$deliveryStatuses;
    }

    /**
     * Return order delivery types
     */
    public static function deliveryOptions(){
        return self::$deliveryTypes;
    }

}
