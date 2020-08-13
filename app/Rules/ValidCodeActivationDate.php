<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Carbon\Carbon;

class ValidCodeActivationDate implements Rule
{
    private $code;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($code = null)
    {
        $this->code = $code;
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
        $activationDay = new Carbon($value);
        $currentDay = Carbon::today();
        
        // If new code is being created, the activation date cannot be in the past
        if($this->code == null && $activationDay->gte($currentDay)){
            return true;
        }
        //If an existing code is being updated, and the activation date does not match the existing activation date, the new activation date cannot be in the past
        elseif($this->code !== null){
            if($activationDay->eq(new Carbon($this->code->activation_date)) || $activationDay->gte($currentDay)){
                return true;
            }
        }
        else{
            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The activation date cannot be in the past.';
    }
}
