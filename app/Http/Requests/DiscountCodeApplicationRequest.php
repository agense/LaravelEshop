<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DiscountCodeApplicationRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'code' => [
                'required',
                'string',
                Rule::exists('discount_codes')->where(function ($query) {
                    $query->where('code', $this->code)
                    ->where('deleted_at', null)
                    ->where('activation_date', '<=', now())
                    ->where(function($q) {
                        $q->where('expiration_date', '>', now())
                        ->orWhere('expiration_date', null);
                    });
                }),
            ]
        ];
    }

/**
 * Get the error messages for the defined validation rules.
 * @return array
 */
public function messages()
{
    return [
        'code.exists' => 'This discount code does not exist.',
    ];
}
}
