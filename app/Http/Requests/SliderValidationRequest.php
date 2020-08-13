<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Rules\Base64ImageValidation;

class SliderValidationRequest extends FormRequest
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
        $requiredForCreate = request()->isMethod('put') ? null : 'required';
        return [
            'title' => 'required|max:191|regex:/^[a-zA-Z0-9,.?!\\s-]*$/',
            'subtitle' => 'nullable|max:191|regex:/^[a-zA-Z0-9,.?!\\s-]*$/',
            'link_text' => 'required_with:link|nullable|max:191|regex:/(^[A-Za-z ]+$)+/',
            'link' => 'required_with:link_text|nullable|max:191|url',
            'image' => [
                $requiredForCreate,
                new Base64ImageValidation()
            ]
        ];
    }
}
