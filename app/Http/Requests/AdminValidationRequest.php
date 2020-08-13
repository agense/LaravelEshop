<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Admin;

class AdminValidationRequest extends FormRequest
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
        $required = request()->isMethod('post') ? 'required': 'nullable';
        $unique = $this->administrator == null ? 'unique:admins' : 'unique:admins,email,'.$this->administrator->id;

        return [
            'name' => 'required|string|max:191|regex:/(^[A-Za-z0-9 ]+$)+/',
            'email' => [
                'required',
                'string',
                'email',
                'max:191',
                $unique
            ],
            'password' => [
                $required,
                'string',
                'min:6',
                'confirmed'
            ], 
            'role' => Rule::in(Admin::adminRoles()),
        ];
    }
}
