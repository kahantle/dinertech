<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoyaltyRequest extends FormRequest
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
            'no_of_order' => 'required|number',
            'point'       => 'required|number',
        ];
        
    }

    public function messages(){
        return [
            'no_of_order.required' => 'Please enter no of orders.',
            'point.required'       => 'Please enter point.',
            'no_of_order.number'   => 'Enter valid number.',
            'point.number'         => 'Enter valid number.',
        ];
    }
}
