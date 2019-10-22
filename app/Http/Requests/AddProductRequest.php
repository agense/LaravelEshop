<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Rules\ValidBrand;

class AddProductRequest extends FormRequest
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
            'name' => 'required|max:191|regex:/(^[A-Za-z0-9 ]+$)+/|unique:products',
            'categories.*' => 'required|integer|exists:categories,id',
            'price' => 'required|integer|min:0',
            'availability' => 'required|integer|min:0',
            'featured' => [
                'required',
                'integer',
                 Rule::in(['0', '1'])
            ],
            'description' => 'nullable|string|max:191',
            'details' => 'nullable|string|max:1000',
            'featured_image' => 'nullable|image|max:1999',
            'images.*' => 'nullable|image|max:1999',
            'brand' => ['required','integer', new ValidBrand],
        ];
    }
}
