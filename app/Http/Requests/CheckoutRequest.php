<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Delivery;
use App\Models\Payment;

class CheckoutRequest extends FormRequest
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
        // if user who is checking out is authenticated, check email validity, else check if its unique in db
        $emailValidation = auth()->user() ? 'required|email|unique:users,email,'.auth()->id() : 'required|email|unique:users';
        return [
            'email' => $emailValidation,
            'name' => 'required|string|max:191',
            'address' => 'required|max:191|regex:/(^[A-Za-z0-9 .]+$)+/',
            'city' => 'required|max:50|regex:/(^[A-Za-z ]+$)+/',
            'region' => 'required|max:50|regex:/(^[A-Za-z ]+$)+/',
            'postalcode' => 'required|digits_between:4,10',
            'phone' => 'required|digits_between:5,10',
            'delivery_type' => [
                'required',
                Rule::in(Delivery::deliveryOptions())
            ],
            'payment_type' => [
                'required',
                Rule::in(Payment::paymentOptions())
            ],
        ];
    }

    //Customize the message
    public function messages(){
        return [
            'email.unique' => 'This email account is already taken. If you are already registered, please login to continue. Otherwise please use another email address.'
        ];
    }
}
