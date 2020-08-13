<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Base64ImageValidation implements Rule
{
    private $extensions = ['jpeg', 'jpg', 'png'];

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if(is_string($value) && preg_match('/data:image/', $value)){  
         
            $mimetype  = mime_content_type ($value);
            $ext = explode('/', $mimetype)[1];

            if(in_array($ext, $this->extensions)){
                return true;
            }else{
                return false;
            }
        }
        return false;
    }

    /**
     * Get the validation error message.
     * @return string
     */
    public function message()
    {
        return 'The image format is invalid.';
    }
}
