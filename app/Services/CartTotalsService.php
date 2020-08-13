<?php
namespace App\Services;
use Session;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Models\DiscountCode;
use App\Models\Setting;

class CartTotalsService
{
    private $discountCode;
    private $initialSubtotal;
    private $discount;
    private $subtotal;
    private $totalBeforeTax;
    private $taxrate;
    private $total;
    private $tax;
    private $taxIncluded;

    public function __construct()
    {
        $this->taxrate = Setting::taxSettings()->tax_rate / 100;
        $this->taxIncluded = boolval(Setting::taxSettings()->tax_included);
        $this->setTotals();
    }

     /**
     * Returns cart totals as array 
     * @return Function
     */
    public function getTotals()
    {
        $this->setTotals();
        return $this->formatTotals();
    }

    /**
     * Returns discount details as array
     * @return Array
     */
    public function discountDetails()
    {
        if(!$this->discountExists()) return false; 
        return [
            'code' => $this->discountCode->code,
            'discount_amount' => $this->discount,
            'discount_display' => $this->discountCode->formatDiscount(),
        ];
    }

    /**
     * Checks if a discount exists
     * @return Bool
     */
    public function discountExists()
    {
        if($this->discountCode instanceof DiscountCode) return true;
        return false;
    }

    /**
     * Sets all class properties
     * @return Void
     */
    private function setTotals()
    {
        $this->setInitialSubtotal();
        $this->setDiscount();
        $this->setSubtotal();
        $this->setTax();
        $this->setTotal();
    }

    /**
     * Sets discount based on applied discount code
     * @return Void
     */
    private function setDiscount()
    {
        if (Session::has('discount_code')){
            $this->discountCode = DiscountCode::where('code', Session()->get('discount_code')['code'])->first();
        }
        $this->discount = $this->discountExists() ? $this->calculateDiscount() : 0;
    }

    /**
     * Calculates discount based on applied discount code
     * @return Float
     */
    private function calculateDiscount()
    {
        if($this->discountCode->type == "fixed"){
            //If discount is higher than the product value, set product value to 0
            if($this->discountCode->value >  $this->initialSubtotal){
                return $this->initialSubtotal;
            }else{
                return $this->discountCode->value;
            }
        }elseif($this->discountCode->type == "percent"){
            return round(
                (($this->discountCode->value / 100) * $this->initialSubtotal), 2
            );
        }else{
            return 0;
        }
    }

    /**
     * Sets Subtotal Before Discount Code Discount
     * @return Void
     */
    private function setInitialSubtotal()
    {
        $this->initialSubtotal = Cart::instance('default')->subtotal();
    }

    /**
     * Sets Subtotal After the Discount Code Discount
     * @return Void
     */
    private function setSubtotal()
    {
        $this->subtotal = $this->initialSubtotal - $this->discount;
    }

    /**
     * Sets Tax Based On Type
     * @return Void
     */
    private function setTax()
    {
        if($this->taxIncluded){
            $this->tax = $this->calculateTaxIncluded();
            $this->setTotalBeforeTax();
        }else{
            $this->tax = $this->calculateTaxAddOn();
        } 
    }

     /**
     * Sets total before tax 
     * @return Void
     */
    private function setTotalBeforeTax()
    {
        if($this->taxIncluded){
            $this->totalBeforeTax = $this->subtotal - $this->tax;
        }else{
            $this->totalBeforeTax = $this->subtotal;
        }    
    }

    /**
     * Sets Total after discounts and taxes
     * @return Void
     */
    private function setTotal()
    {
        if($this->taxIncluded){
            $this->total = $this->subtotal;
        }else{
            $this->total = $this->subtotal + $this->tax;
        }    
    }

    /**
     * Calculates tax rate for included taxes 
     * @return Float 
     */
    private function calculateTaxIncluded()
    {
        return round(($this->subtotal / (100 + $this->taxrate*100))*($this->taxrate*100), 2);
    }

    /**
     * Calculates tax rate for not included taxes 
     * @return Float 
     */
    private function calculateTaxAddOn()
    {
        return round($this->subtotal * $this->taxrate, 2);
    }
    
    /**
     * Formats the return of cart totals based on tax type
     * @return Array
     */
    private function formatTotals()
    {
        $totals = array();
        $totals['initialSubtotal'] = $this->initialSubtotal;
        $totals['discount'] = $this->discount;
        $totals['subtotal'] = $this->subtotal;
        if($this->taxIncluded){
            $totals['total_before_tax'] = $this->totalBeforeTax;
        }
        $totals['tax'] = $this->tax;
        $totals['total'] = $this->total;
        $totals['tax_rate'] = $this->taxrate*100;
        $totals['tax_included'] = $this->taxIncluded;
        return $totals;
    }
}