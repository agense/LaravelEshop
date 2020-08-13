<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Product;

class CartQuantityUpdateRequest extends FormRequest
{
    private $available;

    public function __construct(){
        $product = Product::find(request()->product);
        $this->available = $product->availability;

    }
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
            'quantity' => 'required|numeric|between:1,'.$this->available,
        ];
    }

/**
 * Get the error messages for the defined validation rules.
 * @return array
 */
public function messages()
{
    return [
        'quantity.between' => "Sorry, there are only $this->available items available.",
    ];
}
}
