<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Brand;

class ValidBrand implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
