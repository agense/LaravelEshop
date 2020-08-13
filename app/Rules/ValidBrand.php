<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Brand;

class ValidBrand implements Rule
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
        $brands = Brand::all()->pluck('id')->toArray();
        return in_array($value,  $brands);
        
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The brand is invalid.';
    }
}
