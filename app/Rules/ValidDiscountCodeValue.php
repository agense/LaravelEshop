<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidDiscountCodeValue implements Rule
{

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if( (request()->type == "percent") && $value >= 100){
            return false;
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
        return 'The discount cannot be equal to or exceed 100%';
    }
}
