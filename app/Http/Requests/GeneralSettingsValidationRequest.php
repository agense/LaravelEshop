<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Setting;

class GeneralSettingsValidationRequest extends FormRequest
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
        $settings = Setting::firstOrFail();
        $currencyCodes = $settings->currencyCodes();
        $taxOptions = Setting::taxInclusionOptions();
        return [
            'site_name' => ['required','max:191','regex:/(^[A-Za-z0-9 ]+$)+/'],
            'currency' => ['required', Rule::in($currencyCodes)],
            'tax_rate' => ['required', 'numeric', 'between:0,100'],
            'tax_included' => ['required',Rule::in($taxOptions)]
        ];
    }
}
