<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BrandValidationRequest extends FormRequest
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
        $name = $this->brand ? $this->brand->name : '';
        return [
            'name' => [
                'required',
                'max:191',
                'regex:/(^[A-Za-z0-9 ]+$)+/', 
                Rule::unique('brands','name')->ignore($name),
            ]
        ];
    }
}
