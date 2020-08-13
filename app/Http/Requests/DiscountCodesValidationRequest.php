<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\ValidDiscountCodeValue;
use Illuminate\Validation\Rule;
use App\Rules\ValidCodeActivationDate;
use App\Models\DiscountCode;

class DiscountCodesValidationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $unique = $this->route('code') == null ? 'unique:discount_codes' : 'unique:discount_codes,code,'.$this->route('code')->id;
        return [
            'code' => [
                'required',
                'max:50',
                'min:4',
                'regex:/(^[A-Za-z0-9 ]+$)+/',
                $unique,
            ],
            'type' => [
                'required', 
                Rule::in(DiscountCode::getTypes())
            ],
            'value' => [
                'required',
                'numeric',
                'min:0',
                new ValidDiscountCodeValue(),
            ],
            'activation_date' => [
                'required',
                'date',
                new ValidCodeActivationDate($this->route('code')),
            ],
            'expiration_date' => 'required|date|after:activation_date',
            'public' => 'required|numeric|between:0,1',
        ];
    }

/**
 * Get the error messages for the defined validation rules.
 * @return array
 */
public function messages()
{
    return [
        'code.unique' => 'This code already exists. The codes must be unique. ',
    ];
}
}
