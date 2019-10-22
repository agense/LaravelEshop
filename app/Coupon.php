<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    /**
     * Coupon Types
     * */
    private $couponTypes = ['fixed', 'percent'];

    /**
     * Return Coupon Types
     */
    public static function getTypes(){
        $coupon = new Self();
        return $coupon->couponTypes;
    }

    /**
     * Return Coupon By Its Code
     * @param string coupon code
     * @return coupon object
     */
    public static function findByCode($code){
        return self::where('code', $code)->first();
    }

    /**
     * Calculate and return the discount from the total amount
     * @param float amount
     * @return integer the discount amount from passed value
     */
    public function discount($total){
        if($this->type == "fixed"){
            return $this->value;
        }elseif($this->type == "percent"){
            return round(($this->percent_off / 100) * $total);
        }else{
            return 0;
        }
    }

    /**
    * Display discount value based on the coupon code or the Coupon class instance
    * @param string coupon code
    * @return string formatted discount amount 
    */
    public function displayDiscount($code = null){
        if($code){
            $card = self::findByCode($code);
        }elseif($this instanceof Coupon){
            $card = $this;
        }else{
            return "Not Found";
        }
        if($card->type == "percent"){
            return $card->percent_off."%";
        }elseif($card->type == "fixed"){
            $currency = Setting::displayCurrency();
            return $currency.$card->value;
        }else{
            return "";
        }
    }
    /**
    * Display discount value based on the Coupon class instance
    * @return integer discount value
    */
    public function displayValue(){
        if($this->type == "percent"){
            return $this->percent_off;
        }elseif($this->type == "fixed"){
            return $this->value;
        }else{
            return "";
        }
    }
}
