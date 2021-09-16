<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
            "name"=>"required",
            'subject' => 'required',
            'description' =>'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Please enter name.',
            'subject.required' => 'Please enter subject.',
            'description.required' =>'Please enter description.'
        ];
    }
}
