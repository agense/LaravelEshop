<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Rules\ValidBrand;
use App\Rules\ValidFeatureAssignment;
use App\Models\Feature;

class ProductRequest extends FormRequest
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
        $unique = $this->product == null ? 'unique:products' : 'unique:products,name,'.$this->product->id;
      
        $validationRules = [
            'name' => [
                'required',
                'max:191',
                'regex:/(^[A-Za-z0-9 ]+$)+/',
                 $unique
            ],
            'categories' => 'required',
            'categories.*' => 'integer|exists:categories,id',
            'price' => 'required|numeric|min:0|not_in:0',
            'availability' => 'required|integer|min:0',
            'featured' => [
                'required',
                'integer',
                 Rule::in(['0', '1'])
            ],
            'description' => 'nullable|max:5000',
            'featured_image' => 'nullable|image|max:1999',
            'brand_id' => ['required','integer', new ValidBrand],
            'images.*' => 'nullable|image|max:1999',
        ];

        //Dynamic Feature Validation
        $featureList = Feature::getList();
        foreach($featureList as $feature){
            $validationRules[$feature->slug] = ['sometimes','nullable', new ValidFeatureAssignment($feature)];
        }
        return $validationRules;
    }

    /**
     * Get the error messages for the defined validation rules.
     * @return array
     */
    public function messages()
    {
        $messages = [
            'categories.required' => 'The category is required.',
            'categories.*' => 'One or more of the selected categories is incorrect.',
        ];
        return $messages;
    }
}
