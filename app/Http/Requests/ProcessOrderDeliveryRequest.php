<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Rules\ValidDeliveryStatus;
use App\Models\Delivery;

class ProcessOrderDeliveryRequest extends FormRequest
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
            'delivery_status' =>  [
                'required',
                'string',
                Rule::in(Delivery::deliveryStatuses()),
                new ValidDeliveryStatus(request()->order),
            ],
        ];
    }
}
