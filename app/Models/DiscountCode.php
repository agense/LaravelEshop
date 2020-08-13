<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Carbon\Carbon;

class DiscountCode extends Model
{
    use SoftDeletes;

    /**
     * Disable guerded
     */
    protected $guarded = [];

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
    /**
     * Available Discount Types
     * */
    private static $discountTypes = [
        'fixed', 
        'percent'
    ];

    /**
     * Dates
     */
    protected $dates = ['activation_date', 'expiration_date'];

    protected $appends = ['active', 'discount'];

    // ACCESSORS
    public function getActivationDateAttribute($date){
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y-m-d');
    }

    public function getExpirationDateAttribute($date){
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y-m-d');
    }

    public function getActiveAttribute($value){
        if($this->activeCode()) return true;
        return false;
    }
    
    public function getDiscountAttribute(){
        return self::formatDiscount();
    }

    //PROPERTY GETTERS
    /**
     * Return Available Discount Types
     */
    public static function getTypes(){
        return self::$discountTypes;
    }

    //QUERY SCOPES
    public function scopeActive($query){
        return $query->where('activation_date', '<', now())->where('expiration_date', '>', now());
    }
    public function scopeFuture($query){
        return $query->where('expiration_date', '>', now())->where('activation_date', '>', now());
    }

    public function scopeActiveAndFuture($query){
        return $query->where('expiration_date', '>', now());
    }

    public function scopeExpired($query){
        return $query->where('expiration_date', '<=', now());
    }

    public function scopePublic($query){
        return $query->where('public', 1);
    }

    public function scopeOrderByActivationDate($query){
        return $query->orderBy('activation_date', 'ASC');
    }

    public function scopeOrderByExpirationDate($query){
        return $query->orderBy('expiration_date', 'DESC');
    }

    // MODEL METHODS
    /**
    * Display discount value based on the code type
    * @return string formatted discount amount 
    */
    public function formatDiscount(){
        if($this->type == "percent"){
            return $this->value."%";
        }elseif($this->type == "fixed"){
            $currency = Setting::displayCurrency();
            return $currency.$this->value;
        }else{
            return false;
        }
    }
    /**
    * Verify if a discount code is active
    * @return Bool
    */
    public function activeCode(){
        if($this->deleted_at == null && $this->activation_date < now() && $this->expiration_date > now()){
            return true;
        }
        return false;
    }

}
