<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Str;

class ValidOrderStatus implements Rule
{
    private $order;
    private $issue;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($order)
    {
        $this->order = $order;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if($value == "complete"){
            if(!$this->order->orderPaid()){
                $this->issue = "Order cannot be completed before the payment is processed";
                return false;
            }elseif(!$this->order->orderDelivered()){
                $this->issue = "Order cannot be completed before it is delivered";
                return false;
            }else{
                return true;
            } 
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->issue;
    }
}
