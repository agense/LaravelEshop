<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class Setting extends Model
{
    /**
     * Remove guard for mass assignment
     */
    protected $guarded = [];
    
    /**
     * Company Settings
     */
    private static $companySettings = ['company_name', 'tax_payers_id','email_primary', 'email_secondary', 'phone_primary','phone_secondary', 'address'];

    /**
     * Company Settings
     */
    private static $siteSettings = ['site_name', 'currency', 'tax_rate', 'tax_included'];
    
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
        'tax_rate' => 0,
        'tax_included' => 0,
    ];
    /**
     * Default logo image
     */
    private $defaultLogo = 'logo-default.png';

    /**
     * Tax Type: Included/Not Included
     */
    private static $taxInclude = [
        0 => 'no',
        1 => 'yes',
    ];

    // MODEL METHODS
    /**
     * Return the $taxInclude property
     * @return Array
     */
    public static function taxInclusionOptions(){
        return array_flip(self::$taxInclude);
    }

    /**
     * Return tax settings
     * @return Array
     */
    public static function taxSettings(){
        return self::first(['tax_rate', 'tax_included']);
    }

    /**
     * Return the currency list
     * @return Array
     */
    public function currencyList(){
        return $this->currencies;
    }
    /**
     * Return site settings, either from DB or the default ones
     * @return Array
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
     * @return Array
     */
    public function currencyCodes(){
        $currencies =  collect($this->currencies)->pluck('code');
        return $currencies->toArray();
    }

    /**
     * Return selected site currency for display
     * @return String
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
     * @return String
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

    /**
     * Return the applications name
     * @return String
     */
    public static function appName(){
        $settings = self::settings();
        return $settings['site_name'];
    }

    /**
     * Return $companySettings properties
     * @return Array
     */
    public static function getCompanySettings()
    {
        return self::$companySettings;
    }

    /**
     * Return $siteSettings properties
     * @return Array
     */
    public static function getSiteSettings()
    {
        return self::$siteSettings;
    }

    /**
     * Check if logo image exists 
     * @return Bool
     */
    public function logoExists()
    {
        return ($this->logo !== null && file_exists(public_path('img/'.$this->logo)));
    }

    /**
     * Get the full path to the logo image
     * @return String
     */
    public function getLogoLink()
    {
        return 'img/'.$this->logo;
    }

}
