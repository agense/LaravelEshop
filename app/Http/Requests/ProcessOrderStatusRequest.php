<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Rules\ValidOrderStatus;
use App\Models\Order;

class ProcessOrderStatusRequest extends FormRequest
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
            'order_status' => [
                'required',
                'string',
                Rule::in(Order::orderStatuses()),
                new ValidOrderStatus(request()->order),
            ],
        ];
    }
}
