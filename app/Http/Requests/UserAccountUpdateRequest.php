<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserAccountUpdateRequest extends FormRequest
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
            'name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:users,email,'.auth()->id(), //ignore the current users email in checking the email uniqueness
            'password' => 'sometimes|nullable|string|min:6|confirmed',
            'phone' => 'sometimes|nullable|digits_between:5,10',
            'address' => 'sometimes|nullable|max:191|regex:/(^[A-Za-z0-9 .]+$)+/',
            'city' => 'sometimes|nullable|max:50|regex:/(^[A-Za-z ]+$)+/',
            'region' => 'sometimes|nullable|max:50|regex:/(^[A-Za-z ]+$)+/',
            'postalcode' => 'sometimes|nullable|digits_between:4,10',
        ];
    }
}
