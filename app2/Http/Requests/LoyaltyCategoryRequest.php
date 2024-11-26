<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoyaltyCategoryRequest extends FormRequest
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
            'point'       => 'required|number',
            'categories.*'  => 'required',
        ];
    }

    public function messages(){
        return [
            'point.required'       => 'Please enter point.',
            'point.number'         => 'Enter valid number.',
            'categories.*.required' => 'Please select category.'
        ];
    }
}
