<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProcessOrderRequest extends FormRequest
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
        return [
            'order_status' => 'required|integer|between:0,2',
            'delivered' => 'required|integer|between:0,1',
            'paid' => 'nullable|integer|between:0,1',
            'payment_type' => [
                'required_if:paid,==,1',
                'string',
                Rule::in(['cash', 'card']),
            ],
            'payment_date' => 'nullable|required_if:paid,==,1|date|before_or_equal:now'
        ];
    }
}
