<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    /**
     * Currency selection list
     */
    private $currencies = [
        [ 'name' => 'Euro', 'code'=> 'EUR', 'symbol' => '€' ],
        [ 'name' => 'US Dollar', 'code'=> 'USD', 'symbol' => '$' ],
        [ 'name' => 'UK Pound', 'code'=> 'GBP', 'symbol' => '£' ],
    ];

    /**
     * Site default settings
     */
    private $defaultSettings = [
        'site_name' => 'Laravel Ecommerce',
        'currency' => 'EUR',
    ];

    /**
     * Return the currency list
     */
    public function currencyList(){
        return $this->currencies;
    }

    /**
     * Return site settings, either from DB or the default ones
     */
    public static function settings(){
        $settings = self::first() ? self::first() : new self();
        if($settings){
            return $settings;
        }else{
            return $settings->defaultSettings;
        }
    } 

    /**
     * Return currency codes for select lists
     */
    public function currencyCodes(){
        $currencies =  collect($this->currencies)->pluck('code');
        return $currencies->toArray();
    }

    /**
     * Return selected site currency for display
     */
    public static function displayCurrency(){
        $setting = self::first();
        $currency = "";
        foreach($setting->currencies as $key =>$val){
          if($setting->currency == $val['code']){
                $currency = $val['symbol'];
          }
        }
        return $currency;
    }

    /**
     * Return the primary website contact email, used for email forms
     */
    public static function appEmail(){
        $setting = self::first();
        if($setting->email_primary){
            return $setting->email_primary;
        }elseif($setting->email_secondary){
            return $setting->email_secondary;
        }else{
            return false;
        }
    }
}
