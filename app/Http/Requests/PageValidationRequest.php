<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Page;

class PageValidationRequest extends FormRequest
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
        $unique = $this->page == null ? 'unique:pages' : 'unique:pages,title,'.$this->page->id;
        return [
            'title' => [
                'required',
                'max:191',
                'regex:/(^[A-Za-z0-9 ]+$)+/', 
                $unique,
            ],
            'type' => ['required', Rule::in(Page::getTypes())],
            'content' => 'required'
        ];
    }
}
