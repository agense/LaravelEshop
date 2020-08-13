<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Setting;

class CompanySettingsValidationRequest extends FormRequest
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
        return [
            'company_name' => 'nullable|max:191|regex:/(^[A-Za-z0-9 ]+$)+/',
            'tax_payers_id' => 'nullable|min:6|max:20|regex:/(^[A-Za-z0-9]+$)+/',
            'email_primary' => 'nullable|max:191|email',
            'email_secondary' => 'nullable|max:191|email',
            'phone_primary' => 'nullable|min:8|max:15|regex:/^[0-9()+\\s-]*$/',
            'phone_secondary' => 'nullable|min:8|max:15|regex:/^[0-9()+\\s-]*$/',
            'address' => 'nullable|max:191|regex:/^[a-zA-Z0-9,.\\s-]*$/',
        ];
    }
}
